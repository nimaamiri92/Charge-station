<?php

namespace App\Services\ChargeStation;

use App\ValueObjects\ChargeStationValueObject;

class ChargeStationService
{
    private const ONE_HOUR_IN_SECONDS = 3600;

    private const PRECISION = 3;

    public function calculateRate(ChargeStationValueObject $chargeStationValueObject): array
    {
        return [
            'energyPrice' => $this->calculateUsedEnergyPrice($chargeStationValueObject),
            'timePrice'   => $this->calculateUsedTimePrice($chargeStationValueObject),
            'defaultFee'  => $chargeStationValueObject->getDefaultFee(),
        ];
    }

    public function calculateUsedEnergyPrice(ChargeStationValueObject $chargeStationDTO): float
    {
        return self::roundPrice($chargeStationDTO->getUsedEnergyInKiloWatt() * $chargeStationDTO->getEnergyFee());
    }

    public function calculateUsedTimePrice(ChargeStationValueObject $chargeStationValueObject): float
    {
        $timeFeePerSeconds = $chargeStationValueObject->getTimeFee() / self::ONE_HOUR_IN_SECONDS;

        return self::roundPrice($chargeStationValueObject->getUsedTimeInSeconds() * $timeFeePerSeconds);
    }

    private static function roundPrice(float $price): float
    {
        return round(
            $price,
            self::PRECISION,
            PHP_ROUND_HALF_UP
        );
    }
}
