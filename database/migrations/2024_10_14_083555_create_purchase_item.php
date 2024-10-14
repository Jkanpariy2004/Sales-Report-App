<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_item', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id');
            $table->string('unit', 50);
            $table->string('quantity', 50);
            $table->string('item_name', 50);
            $table->string('item_details', 50);
            $table->string('cost', 50);
            $table->string('hsn_code', 50);
            $table->string('tax_type', 50);
            $table->string('tax', 50);
            $table->string('total', 50);
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
        Schema::dropIfExists('purchase_item');
    }
};
