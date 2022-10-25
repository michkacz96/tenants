<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\SellDocument;
use App\Models\Unit;

class CreateSellDocumentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_document_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(SellDocument::class)->references('id')->on('sell_documents')->onDelete('cascade');
            $table->string('item_name');
            $table->decimal('quantity', 16,4);
            $table->foreignIdFor(Unit::class)->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('tax', 5, 2);
            $table->decimal('tax_amount', 32, 2);
            $table->decimal('amount', 32, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_document_details');
    }
}
