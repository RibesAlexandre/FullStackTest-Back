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
        //  TODO: Mettre les devises en cache
        $currencies = Currency::pluck('code')->toArray();

        if( $date > now()->format('Y-m-d') ) {
            return response()->json(['error' => 'Date invalide'], 400);
        }

        if( !in_array($base, $currencies) ) {
            return response()->json(['error' => 'Base de conversion invalide'], 400);
        }

        //  A retirer si le plan le permet
        if( $base !== 'USD' ) {
            return response()->json(['error' => 'Le plan Exchange actuel ne permet d\'effectuer d\'autres conversions.'], 400);
        }

        //  TODO: Mettre les devises en cache
        $currencyBase = Currency::select('id', 'code')->where('code', $base)->first();

        if( !$currencyBase ) {
            return response()->json(['error' => 'Base de conversion introuvable'], 400);
        }

        Exchange::getHistorical($date, implode(',', $currencies), $currencyBase);
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
}
