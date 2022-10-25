<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Category;

class CreatePurchaseDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Supplier::class);
            $table->foreignIdFor(Category::class);
            $table->string('description')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->date('sell_date')->nullable();
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
        Schema::dropIfExists('purchase_documents');
    }
}
