<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Property;
use App\Models\Tenant;
use App\Models\User;

class CreateSellDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(Property::class)->references('id')->on('properties')->onDelete('cascade');
            $table->foreignIdFor(Tenant::class)->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignIdFor(User::class)->references('id')->on('users')->onDelete('cascade');
            $table->string('invoice_number')->nullable();
            $table->decimal('invoicing_year', 4, 0);
            $table->decimal('invoicing_month', 2, 0);
            $table->date('invoice_date');
            $table->date('sell_date');
            $table->date('due_date');
            $table->string('description')->nullable();
            $table->decimal('total_amount', 32, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_documents');
    }
}
