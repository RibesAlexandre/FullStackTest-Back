<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Rate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'rate_date'     => $this->rate_date,
            'rate_value'    => $this->rate_value,
            'currency_id'   => new Currency($this->currency)
        ];
    }
}
