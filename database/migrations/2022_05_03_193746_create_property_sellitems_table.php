<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Property;
use App\Models\SellItem;
use App\Models\PropertyDetail;
use App\Models\Formula;

class CreatePropertySellitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_sell_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignIdFor(Property::class);
            $table->foreignIdFor(SellItem::class);
            $table->foreignIdFor(Formula::class);
            $table->decimal('price', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_sell_item');
    }
}
