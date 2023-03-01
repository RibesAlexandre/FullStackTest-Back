<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public $fillable = ['rate_date', 'rate_value', 'currency_id', 'base_id'];

    /**
     * Devise associée
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Base de la conversion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function base(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'base_id');
    }
}
