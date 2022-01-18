<?php

namespace App\Http\Requests\V1\ChargeStation;

use Illuminate\Foundation\Http\FormRequest;

class RateCalculatorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rate'               => ['required', 'array'],
            'rate.energy'        => ['required', 'numeric'],
            'rate.time'          => ['required', 'numeric'],
            'rate.transaction'   => ['required', 'numeric'],
            'cdr'                => ['required', 'array'],
            'cdr.meterStart'     => ['required', 'numeric'],
            'cdr.timestampStart' => ['required', 'date', 'date_format:Y-m-d\TH:i:s\Z'],
            'cdr.meterStop'      => ['required', 'numeric', 'gte:cdr.meterStart'],
            'cdr.timestampStop'  => ['required', 'date', 'date_format:Y-m-d\TH:i:s\Z'],
        ];
    }
}
