<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Property;
use App\Models\Tenant;

class CreatePropertyTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_tenant', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Property::class)->references('id')->on('properties')->onDelete('cascade');
            $table->foreignIdFor(Tenant::class)->references('id')->on('tenants')->onDelete('cascade');
            $table->date('start_rent_date');
            $table->date('end_rent_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_tenant');
    }
}
