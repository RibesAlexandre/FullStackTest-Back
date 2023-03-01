<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $fillable = ['name', 'slug', 'code'];

    /**
     * Taux de conversions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rate::class, 'currency_id')->orderBy('rate_date', 'ASC');
    }
}
