<?php

namespace Meteor\Region\Tests\Unit\Console;

use Meteor\Region\Models\Province;
use Meteor\Region\Tests\TestCase;

class ImportRegionTest extends TestCase
{
    /** @test */
    public function it_can_import_region()
    {
        $this->artisan('migrate');

        $prefix = config('meteor.region.database.table_prefix');

        $this->artisan('region:import', [
            '--year' => 2022,
        ]);

        $this->assertDatabaseHas('regions', [
            'kode' => '11',
            'nama' => 'ACEH',
        ]);

        $this->assertDatabaseHas($prefix.'provinces', [
            'code' => '11',
            'name' => 'ACEH',
        ]);

        $this->assertDatabaseHas($prefix.'cities', [
            'code' => '11.01',
            'name' => 'KAB. ACEH SELATAN',
        ]);

        $this->assertDatabaseHas($prefix.'districts', [
            'code' => '11.01.01',
            'name' => 'Bakongan',
        ]);

        $province = Province::first();

        $this->assertCount(23, $province->cities);
        $this->assertCount(290, $province->districts);

        $this->artisan('migrate:rollback');
    }
}
