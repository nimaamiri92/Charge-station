<?php

namespace App\ValueObjects;

use Illuminate\Support\Carbon;

class ChargeStationValueObject
{
    private float $energyFee;

    private float $timeFee;

    private float $defaultFee;

    private string $startTime;

    private string $endTime;

    private string $energyMeterStart;

    private string $energyMeterStop;

    /**
     * @param float $energyFee
     * @param float $timeFee
     * @param float $defaultFee
     * @param string $startTime
     * @param string $endTime
     * @param string $energyMeterStart
     * @param string $energyMeterStop
     */
    public function __construct(
        float $energyFee,
        float $timeFee,
        float $defaultFee,
        string $startTime,
        string $endTime,
        string $energyMeterStart,
        string $energyMeterStop
    ) {
        $this->energyFee        = $energyFee;
        $this->timeFee          = $timeFee;
        $this->defaultFee       = $defaultFee;
        $this->startTime        = $startTime;
        $this->endTime          = $endTime;
        $this->energyMeterStart = $energyMeterStart;
        $this->energyMeterStop  = $energyMeterStop;
    }

    public static function fromRequest(array $data)
    {
        return new static(
            $data['rate']['energy'],
            $data['rate']['time'],
            $data['rate']['transaction'],
            $data['cdr']['timestampStart'],
            $data['cdr']['timestampStop'],
            $data['cdr']['meterStart'],
            $data['cdr']['meterStop'],
        );
    }

    /**
     * @return float
     */
    public function getEnergyFee(): float
    {
        return $this->energyFee;
    }

    /**
     * @return float
     */
    public function getTimeFee(): float
    {
        return $this->timeFee;
    }

    /**
     * @return float
     */
    public function getDefaultFee(): float
    {
        return $this->defaultFee;
    }

    /**
     * @return string
     */
    public function getStartTime(): Carbon
    {
        return Carbon::parse($this->startTime);
    }

    /**
     * @return string
     */
    public function getEndTime(): Carbon
    {
        return Carbon::parse($this->endTime);
    }

    /**
     * @return string
     */
    public function getEnergyMeterStart(): string
    {
        return $this->energyMeterStart;
    }

    /**
     * @return string
     */
    public function getEnergyMeterStop(): string
    {
        return $this->energyMeterStop;
    }

    /**
     * @return float
     */
    public function getUsedEnergyInKiloWatt(): float
    {
        return ($this->getEnergyMeterStop() - $this->getEnergyMeterStart()) / 1000;
    }

    /**
     * @return int
     */
    public function getUsedTimeInSeconds(): int
    {
        return $this->getEndTime()->diffInSeconds($this->getStartTime());
    }
}
