<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function index()
    {
        return Currency::collection(\App\Models\Currency::all());
    }
}
