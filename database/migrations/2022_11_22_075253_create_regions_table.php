<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Meteor\Region\Base\Migration;

return new class extends Migration
{
    public function __construct(
        protected array $tables = [
            'regions' => [],
            'provinces' => [],
            'cities' => [
                'foreign_key' => 'province_code',
                'references' => 'provinces',
            ],
            'districts' => [
                'foreign_key' => 'city_code',
                'references' => 'cities',
            ],
            'villages' => [
                'foreign_key' => 'district_code',
                'references' => 'districts',
            ],
        ]
    ) {
        parent::__construct();

        $this->tables = collect($this->tables)
            ->mapWithKeys(function ($value, $key) {
                if (isset($value['references'])) {
                    $value['references'] = $this->prefix.$value['references'];
                }

                return [$key === 'regions' ? $key : $this->prefix.$key => $value];
            })
            ->toArray();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table => $options) {
            Schema::create($table, function (Blueprint $table) use ($options) {
                if (isset($options['foreign_key'])) {
                    $table->string($options['foreign_key'], 20);
                    $table->foreign($options['foreign_key'])->references('code')->on($options['references']);
                }

                $table->string($table->getTable() === 'regions' ? 'kode' : 'code', 20)->primary();
                $table->string($table->getTable() === 'regions' ? 'nama' : 'name', 100);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (array_reverse($this->tables) as $table => $options) {
            if (isset($options['foreign_key'])) {
                Schema::table($table, function (Blueprint $table) use ($options) {
                    if (DB::getDriverName() !== 'sqlite') {
                        $table->dropForeign("{$table->getTable()}_{$options['foreign_key']}_foreign");
                    }
                });
            }

            Schema::dropIfExists($table);
        }
    }
};
