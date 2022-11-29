<?php

namespace Meteor\Region\Tests\Unit\Models;

use Meteor\Region\Models\Village;
use Meteor\Region\Tests\TestCase;

class VillageTest extends TestCase
{
    /** @test */
    public function it_can_get_all_villages()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $village = Village::first();

        $this->assertNotNull($village);

        $this->artisan('migrate:rollback');
    }

    /** @test */
    public function it_belong_to_district()
    {
        $this->artisan('migrate');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $village = Village::first();

        $this->assertEquals('11.01.01', $village->district->code);

        $this->artisan('migrate:rollback');
    }
}
