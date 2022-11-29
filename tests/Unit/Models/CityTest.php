<?php

namespace Meteor\Region\Tests\Unit\Models;

use Meteor\Region\Models\City;
use Meteor\Region\Tests\TestCase;

class CityTest extends TestCase
{
    /** @test */
    public function it_can_get_all_districts()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $city = City::first();

        $this->assertCount(18, $city->districts);

        $this->artisan('migrate:rollback');
    }

    /** @test */
    public function it_can_get_all_villages()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $city = City::first();

        $this->assertCount(260, $city->villages);

        $this->artisan('migrate:rollback');
    }

    /** @test */
    public function it_belong_to_province()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $city = City::first();

        $this->assertEquals('11', $city->province->code);

        $this->artisan('migrate:rollback');
    }
}
