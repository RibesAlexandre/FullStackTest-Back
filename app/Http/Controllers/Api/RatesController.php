<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;

//  Custom Facade
use Exchange;

class RatesController extends Controller
{
    public function date($date, $base = 'USD')
    {
        if( $date > now()->format('Y-m-d') ) {
            return response()->json(['error' => 'Date invalide'], 400);
        }

        $currencyBase = Currency::select('id')->where('code', $base)->firstOrFail();


        //if( count($ratesData) < 1 ) {
            //  TODO: Mettre les devises en cache
            $currencies = Currency::pluck('code')->toArray();
            $exchangeRates = Exchange::getHistorical($date, implode(',', $currencies), $base);

            foreach( $exchangeRates as $code => $rate ) {
                $checkIfRateExits = Rate::where('rate_date', $date)->whereHas('currency', function($query) use ($code) {
                    $query->where('code', $code);
                })->where('base_id', $currencyBase->id)->first();

                if( $checkIfRateExits ) {
                    $checkIfRateExits->update(['rate_value' => $rate]);
                } else {
                    $currency = Currency::where('code', $code)->first();
                    $currency->rates()->create([
                        'rate_date'     => $date,
                        'rate_value'    => $rate,
                        'base_id'       => $currencyBase->id
                    ]);
                }
            }
        //}

        $ratesData = Rate::where('base_id', $currencyBase->id)->orderBy('rate_date', 'DESC')->get();
        $rates = [];

        foreach($ratesData as $rate) {
            if( !array_key_exists($rate->rate_date, $rates) ) {
                $rates[$rate->rate_date] = [];
            }

            if( array_key_exists($rate->rate_date, $rates) ) {
                $rates[$rate->rate_date][$rate->currency->code] = $rate->rate_value;
            }
        }

        return response()->json(['rates' => $rates]);
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $date = Carbon::parse($input['timestamp'])->format('Y-m-d');

        foreach( $input['rates'] as $code => $rate ) {
            $checkIfRateExits = Rate::where('rate_date', $date)->whereHas('currency', function($query) use ($code) {
                $query->where('code', $code);
            })->first();

            if( $checkIfRateExits ) {
                $checkIfRateExits->update(['rate_value' => $rate]);
            } else {
                $currency = Currency::where('code', $code)->first();
                $currency->rates()->create([
                    'rate_date'     => $date,
                    'rate_value'    => $rate
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
