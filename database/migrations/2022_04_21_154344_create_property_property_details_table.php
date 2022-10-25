<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Property;
use App\Models\PropertyDetail;

class CreatePropertyPropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_property_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Property::class)->references('id')->on('properties')->onDelete('cascade');
            $table->foreignIdFor(PropertyDetail::class)->references('id')->on('property_details')->onDelete('cascade');
            $table->date('detail_start_date')->default('1000-01-01');
            $table->date('detail_end_date')->nullable();
            $table->unsignedDecimal('quantity', 16,4);
            $table->timestamps();
            //$table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            //$table->foreign('property_detail_id')->references('id')->on('property_details')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_property_detail');
    }
}
