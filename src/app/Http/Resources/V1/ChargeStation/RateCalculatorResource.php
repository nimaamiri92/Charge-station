<?php

namespace App\Http\Resources\V1\ChargeStation;

use Illuminate\Http\Resources\Json\JsonResource;

class RateCalculatorResource extends JsonResource
{
    public static $wrap;

    public function toArray($request)
    {
        return [
            'overall'    => (float) number_format(array_sum($this->resource), 2),
            'components' => [
                'energy'      => (float) number_format($this->resource['energyPrice'], 3),
                'time'        => (float) number_format($this->resource['timePrice'], 3),
                'transaction' => (int) number_format($this->resource['defaultFee'], 3),
            ],
        ];
    }
}
