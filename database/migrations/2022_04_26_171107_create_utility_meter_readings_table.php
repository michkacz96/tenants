<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\UtilityMeter;

class CreateUtilityMeterReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UtilityMeter::class)->references('id')->on('utility_meters')->onDelete('cascade');
            $table->date('reading_date');
            $table->decimal('reading', 16, 4);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utility_meter_readings');
    }
}
