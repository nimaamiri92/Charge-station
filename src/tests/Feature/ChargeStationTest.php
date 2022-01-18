<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class ChargeStationTest extends TestCase
{

    public function test_fail_if_energy_does_not_send()
    {
        $inputs = [
            'rate' => [
                'time'        => 2,
                'transaction' => 1,
            ],
            'cdr'  => [
                'meterStart'     => 1204307,
                'timestampStart' => '2021-04-05T10:04:00Z',
                'meterStop'      => 1215230,
                'timestampStop'  => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rate.energy');
    }

    public function test_fail_if_time_does_not_send()
    {
        $inputs = [
            'rate' => [
                'energy'      => 0.3,
                'transaction' => 1,
            ],
            'cdr'  => [
                'meterStart'     => 1204307,
                'timestampStart' => '2021-04-05T10:04:00Z',
                'meterStop'      => 1215230,
                'timestampStop'  => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rate.time');
    }

    public function test_fail_if_trancaction_does_not_send()
    {
        $inputs = [
            'rate' => [
                'energy' => 0.3,
                'time'   => 3,
            ],
            'cdr'  => [
                'meterStart'     => 1204307,
                'timestampStart' => '2021-04-05T10:04:00Z',
                'meterStop'      => 1215230,
                'timestampStop'  => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rate.transaction');
    }

    public function test_fail_if_meterStart_does_not_send()
    {
        $inputs = [
            'rate' => [
                'energy'      => 0.3,
                'time'        => 3,
                'transaction' => 1,
            ],
            'cdr'  => [
                'timestampStart' => '2021-04-05T10:04:00Z',
                'meterStop'      => 1215230,
                'timestampStop'  => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('cdr.meterStart');
    }

    public function test_fail_if_timestampStart_does_not_send()
    {
        $inputs = [
            'rate' => [
                'energy'      => 0.3,
                'time'        => 3,
                'transaction' => 1,
            ],
            'cdr'  => [
                'meterStart'    => 1204307,
                'meterStop'     => 1215230,
                'timestampStop' => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('cdr.timestampStart');
    }

    public function test_fail_if_meterStop_does_not_send()
    {
        $inputs = [
            'rate' => [
                'energy'      => 0.3,
                'time'        => 3,
                'transaction' => 1,
            ],
            'cdr'  => [
                'meterStart'     => 1204307,
                'timestampStart' => '2021-04-05T10:04:00Z',
                'timestampStop'  => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('cdr.meterStop');
    }

    public function test_fail_if_timestampStop_does_not_send()
    {
        $inputs = [
            'rate' => [
                'energy'      => 0.3,
                'time'        => 3,
                'transaction' => 1,
            ],
            'cdr'  => [
                'meterStart'     => 1204307,
                'timestampStart' => '2021-04-05T10:04:00Z',
                'meterStop'      => 1215230,
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('cdr.timestampStop');
    }

    public function test_correctness_of_calculation()
    {
        $inputs = [
            'rate' => [
                'energy'      => 0.3,
                'time'        => 2,
                'transaction' => 1,
            ],
            'cdr'  => [
                'meterStart'     => 1204307,
                'timestampStart' => '2021-04-05T10:04:00Z',
                'meterStop'      => 1215230,
                'timestampStop'  => '2021-04-05T11:27:00Z',
            ],
        ];

        $response = $this->json('post', '/rate', $inputs, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJson([
            'overall'    => 7.04,
            'components' => [
                'energy'      => 3.277,
                'time'        => 2.767,
                'transaction' => 1,
            ],
        ]);
    }
}
