<?php

namespace App\Services;

class ExchangeService
{
    public function getHistorical($date = null, $symbols = [], string $base = 'USD')
    {
        $date = $date ?? now()->format('Y-m-d');
        return $this->endPpoint('historical/' . $date . '.json', [
            'symbols'   => $symbols,
            'base'      => $base
        ]);
    }

    public function getCurrencies($symbols = [], $base = 'USD')
    {
        return $this->endPpoint('currencies.json', [
            'symbols'   => $symbols,
            'base'      => $base
        ]);
    }

    public function getLatest($symbols = [], $base = 'USD')
    {
        return $this->endPpoint('latest.json', [
            'symbols'   => $symbols,
            'base'      => $base
        ]);
    }

    private function endPpoint(string $endpoint = 'historical', array $params = [])
    {
        $params['app_id'] = config('services.openexchange.app_id');

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

            return json_decode($response)->rates;
        } catch( \Exception $e ) {
            return $e->getMessage();
        }
    }
}