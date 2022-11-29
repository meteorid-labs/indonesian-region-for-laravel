<?php

namespace Meteor\Region\Tests\Unit\Models;

use Meteor\Region\Models\District;
use Meteor\Region\Tests\TestCase;

class DistrictTest extends TestCase
{
    /** @test */
    public function it_can_get_all_villages()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $district = District::first();

        $this->assertCount(7, $district->villages);

        $this->artisan('migrate:rollback');
    }

    /** @test */
    public function it_belong_to_city()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $district = District::first();

        $this->assertEquals('11.01', $district->city->code);

        $this->artisan('migrate:rollback');
    }
}
