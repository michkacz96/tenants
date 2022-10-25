<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Unit;
use App\Models\UtilityMeterType;

class CreateUtilityMeterTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_meter_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('type_name');
            $table->foreignIdFor(Unit::class)->references('id')->on('units')->onDelete('cascade');
        });

        /**
         * ID 100 - 199 water meters
         * ID 200 - 299 electricity meters
         * ID 300 - 399 Heat meters
         * ID 400 - 499 BTU meters
         * ID 500 - 599 Gas meters
         * 
         */
        $data = array(
            [
                'id' => '100',
                'type_name' => 'Cold Water Meter',
                'unit_id' => 8
            ],
            [
                'id' => '101',
                'type_name' => 'Hot Water Meter',
                'unit_id' => 8
            ],
            [
                'id' => '102',
                'type_name' => 'Plant water meter',
                'unit_id' => 8
            ],
            [
                'id' => '200',
                'type_name' => 'Electricity meter',
                'unit_id' => 4
            ],
            [
                'id' => '300',
                'type_name' => 'Heat meter',
                'unit_id' => 3
            ],
            [
                'id' => '500',
                'type_name' => 'Gas meter',
                'unit_id' => 8
            ]
        );
    
        foreach ($data as $datum){
            $util_meter = new UtilityMeterType();
            $util_meter->id =$datum['id'];
            $util_meter->type_name =$datum['type_name'];
            $util_meter->unit_id =$datum['unit_id'];
            $util_meter->save();
        }

}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utility_meter_types');
    }
}
