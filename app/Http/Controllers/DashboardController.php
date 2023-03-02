<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\ExchangeService;
use Illuminate\Http\Request;

//  Custom facade
use Exchange;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Liste des devises
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $currencies = Currency::orderBy('name', 'ASC')->get();
        return view('dashboard', compact('currencies'));
    }

    /**
     * Ajout d'une devise
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $code = strtoupper($request->code);
        $currencies = json_decode(Exchange::getCurrencies([$code]), true);

        if( array_key_exists($code, $currencies) ) {

            $checkIfCurrencyExists = Currency::where('code', $code)->first();
            if( $checkIfCurrencyExists ) {
                return redirect()->route('dashboard.index')->with('error', 'La devise est déjà présente');
            }

            $currency = new Currency();
            $currency->name = $currencies[$code];
            $currency->slug = Str::slug($code);
            $currency->code = $code;
            $currency->save();

            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('dashboard.index')->with('error', 'La devise n\'existe pas');
        }
    }

    /**
     * Suppression d'une devise
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $currency = Currency::findOrFail($id);
        if( $currency->code !== 'USD' ) {
            $currency->delete();
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('dashboard.index')->with('error', 'La devise USD ne peut pas être supprimée');
        }
    }

}
