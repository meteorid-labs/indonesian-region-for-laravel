<?php

namespace Meteor\Region\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportRegion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'region:import {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import region data from sql';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year = $this->option('year');

        if (empty($year)) {
            $this->error('Please specify year');

            return Command::FAILURE;
        }

        $this->info('Importing region data from sql...');

        $this->newLine();

        $sqlFile = __DIR__."/../../database/sql/wilayah_{$year}.sql";
        $sql = file_get_contents($sqlFile);

        if (empty($sql)) {
            $this->error("SQL file for year {$year} is empty");

            return Command::FAILURE;
        }

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $prefix = config('meteor.region.database.table_prefix');
        $provinceTable = $prefix.'provinces';
        $cityTable = $prefix.'cities';
        $districtTable = $prefix.'districts';
        $villageTable = $prefix.'villages';

        DB::table($provinceTable)->truncate();
        DB::table($cityTable)->truncate();
        DB::table($districtTable)->truncate();
        DB::table($villageTable)->truncate();

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // import sql
        DB::unprepared($sql);

        $this->info('Preparing data for provinces, cities, districts, and villages...');
        $this->newLine();

        // provinces
        DB::statement(<<<SQL
            INSERT INTO {$provinceTable} (code, name)
            SELECT kode AS code, nama AS name FROM regions WHERE LENGTH(kode) = 2
        SQL);

        // cities
        DB::statement(<<<SQL
            INSERT INTO {$cityTable} (province_code, code, name)
            SELECT substring(kode, 1, 2) AS province_code, kode AS code, nama AS name FROM regions WHERE LENGTH(kode) = 5
        SQL);

        // districts
        DB::statement(<<<SQL
            INSERT INTO {$districtTable} (city_code, code, name)
            SELECT substring(kode, 1, 5) AS city_code, kode AS code, nama AS name FROM regions WHERE LENGTH(kode) = 8
        SQL);

        // villages
        DB::statement(<<<SQL
            INSERT INTO {$villageTable} (district_code, code, name)
            SELECT substring(kode, 1, 8) AS district_code, kode AS code, nama AS name FROM regions WHERE LENGTH(kode) = 13
        SQL);

        $this->info('Region data imported successfully.');

        return Command::SUCCESS;
    }
}
