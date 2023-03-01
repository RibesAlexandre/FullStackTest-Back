<?php
namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ExchangeServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'exchange';
    }
}