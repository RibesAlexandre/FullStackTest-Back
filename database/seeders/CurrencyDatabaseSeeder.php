<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'slug' => 'euro',
            ],
            [
                'name' => 'Dollar USD',
                'code' => 'USD',
                'slug' => 'dollar-usd',
            ],
            [
                'name' => 'Livre Sterling',
                'code' => 'GBP',
                'slug' => 'livre-sterling',
            ],
            [
                'name' => 'Yen Japonais',
                'code' => 'JPY',
                'slug' => 'yen-japonais',
            ]
        ];

        foreach( $currencies as $currency ) {
            \App\Models\Currency::updateOrCreate([
                'code' => $currency['code']
            ], [
                'name' => $currency['name'],
                'slug' => $currency['slug'],
            ]);
        }
    }
}
