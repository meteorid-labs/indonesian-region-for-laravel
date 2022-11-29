<?php

namespace Meteor\Region\Tests\Unit\Models;

use Meteor\Region\Models\Province;
use Meteor\Region\Tests\TestCase;

class ProvinceTest extends TestCase
{
    /** @test */
    public function it_can_get_all_cities()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $province = Province::first();

        $this->assertCount(23, $province->cities);

        $this->artisan('migrate:rollback');
    }

    /** @test */
    public function it_can_get_all_districts()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $province = Province::first();

        $this->assertCount(290, $province->districts);

        $this->artisan('migrate:rollback');
    }
}
