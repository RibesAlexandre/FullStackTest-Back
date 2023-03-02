<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Rate;

class ExchangeService
{
    /**
     * Retourne l'historique des conversions pour une date donnée en fonction des devises
     * et enregistre les résultats en BDD
     *
     * @param $date
     * @param $symbols
     * @param \App\Models\Currency|null $base
     * @return string
     */
    public function getHistorical($date = null, $symbols = [], Currency $base = null)
    {
        $date = $date ?? now()->format('Y-m-d');
        $endPointResponse = $this->endPpoint('historical/' . $date . '.json', [
            'symbols'   => $symbols,
            'base'      => $base->code ?? 'USD'
        ]);

        $endPointResponse = json_decode($endPointResponse);

        /**
         * Sauvegarde des taux en BDD
         */
        foreach( $endPointResponse->rates as $code => $rate ) {
            $checkIfRateExits = Rate::where('rate_date', $date)->whereHas('currency', function($query) use ($code) {
                $query->where('code', $code);
            })->where('base_id', $base->id)->first();

            if( $checkIfRateExits ) {
                $checkIfRateExits->update(['rate_value' => $rate]);
            } else {
                $currency = Currency::where('code', $code)->first();
                $currency->rates()->create([
                    'rate_date'     => $date,
                    'rate_value'    => $rate,
                    'base_id'       => $base->id
                ]);
            }
        }

        return $endPointResponse->rates;
    }

    /**
     * Retourne toutes les devises
     *
     * @param $symbols
     * @param \App\Models\Currency|null $base
     * @return string
     */
    public function getCurrencies($symbols = [], Currency $base = null)
    {
        return $this->endPpoint('currencies.json', [
            'symbols'   => $symbols,
            'base'      => $base->code ?? 'USD'
        ]);
    }

    /**
     * Retourne les dernières conversions
     *
     * @param $symbols
     * @param $base
     * @return string
     */
    public function getLatest($symbols = [], $base = 'USD')
    {
        return $this->endPpoint('latest.json', [
            'symbols'   => $symbols,
            'base'      => $base
        ]);
    }

    /**
     * Endpoint global pour la requête CURL
     *
     * @param string $endpoint
     * @param array $params
     * @return string
     */
    private function endPpoint(string $endpoint = 'historical', array $params = [])
    {
        $params['app_id'] = config('services.openexchange.app_id');
        $params['show_alternative'] = true;

        $url = "https://openexchangerates.org/api/$endpoint";
        $url .= '?' . http_build_query($params);

        $curl = curl_init();

        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "accept: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            return $response;
        } catch( \Exception $e ) {
            return $e->getMessage();
        }
    }
}