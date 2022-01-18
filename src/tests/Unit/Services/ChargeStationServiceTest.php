<?php

namespace Tests\Unit;

use App\Services\ChargeStation\ChargeStationService;
use App\ValueObjects\ChargeStationValueObject;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery;

class ChargeStationServiceTest extends MockeryTestCase
{
    /**
     * @var ChargeStationValueObject
     */
    private $chargeStationValueObject;

    /**
     * @var ChargeStationService
     */
    private $chargeStationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->chargeStationValueObject = Mockery::mock(ChargeStationValueObject::class);
        $this->chargeStationService     = app(ChargeStationService::class);
    }

    public function test_calculate_used_energy_price()
    {
        $this->chargeStationValueObject->shouldReceive('getUsedEnergyInKiloWatt')->andReturn(1.0456);
        $this->chargeStationValueObject->shouldReceive('getEnergyFee')->andReturn(2);

        $result = $this->chargeStationService->calculateUsedEnergyPrice(
            $this->chargeStationValueObject
        );

        $this->assertEquals(2.091, $result);
    }

    public function test_calculate_used_time_price()
    {
        $this->chargeStationValueObject->shouldReceive('getUsedTimeInSeconds')->andReturn(3965);
        $this->chargeStationValueObject->shouldReceive('getTimeFee')->andReturn(1.058);

        $result = $this->chargeStationService->calculateUsedTimePrice(
            $this->chargeStationValueObject
        );

        $this->assertEquals(1.165, $result);
    }
}
