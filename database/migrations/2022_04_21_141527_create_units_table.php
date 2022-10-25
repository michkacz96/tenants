<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Unit;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->string('name');
            $table->string('symbol');
            $table->string('HTML_entity');
            $table->integer('settings')->unsigned()->nullable();
        });

        $data = array(
            [
                'name' => 'blank',
                'symbol' => '',
                'entity' => ''
            ],
            [
                'name' => 'percent',
                'symbol' => '%',
                'entity' => '&#65285;'
            ],
            [
                'name' => 'gigajoule',
                'symbol' => 'GJ',
                'entity' => 'GJ'
            ],
            [
                'name' => 'kilowatt-hours',
                'symbol' => 'kWh',
                'entity' => 'kWh'
            ],
            [
                'name' => 'apartment',
                'symbol' => 'apt.',
                'entity' => 'apt.'
            ],
            [
                'name' => 'month',
                'symbol' => 'mth',
                'entity' => 'mth'
            ],
            [
                'name' => 'square-meter',
                'symbol' => 'm2',
                'entity' => '&#13217;'
            ],
            [
                'name' => 'cubic-meter',
                'symbol' => 'm3',
                'entity' => '&#13221;'
            ],
            [
                'name' => 'megawatt',
                'symbol' => 'MW',
                'entity' => 'MW'
            ],
            [
                'name' => 'people',
                'symbol' => 'ppl.',
                'entity' => 'ppl.'
            ],
            [
                'name' => 'piece',
                'symbol' => 'pcs.',
                'entity' => 'pcs.'
            ],
        );

        foreach ($data as $datum){
            $unit = new Unit();
            $unit->name =$datum['name'];
            $unit->symbol =$datum['symbol'];
            $unit->HTML_entity =$datum['entity'];
            $unit->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
