<?php

namespace App\Http\Controllers\V1\ChargeStation;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ChargeStation\RateCalculatorRequest;
use App\Http\Resources\V1\ChargeStation\RateCalculatorResource;
use App\Services\ChargeStation\ChargeStationService;
use App\ValueObjects\ChargeStationValueObject;

class ChargeStationController extends Controller
{
    public function calculateUsedCharge(RateCalculatorRequest $request, ChargeStationService $chargeStationService)
    {
        return RateCalculatorResource::make(
            $chargeStationService->calculateRate(
                ChargeStationValueObject::fromRequest($request->validated())
            )
        );
    }
}
