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
        Schema::create('sale', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name',50);
            $table->string('bill_no',50);
            $table->string('bill_date',50);
            $table->string('gst_no',50);
            $table->text('place');
            $table->string('state_code',50);
            $table->string('transport_no',50);
            $table->string('transport_gst_tin_no',50);
            $table->string('parcel',50);
            $table->string('grand_total',50);
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
        Schema::dropIfExists('sale');
    }
};
