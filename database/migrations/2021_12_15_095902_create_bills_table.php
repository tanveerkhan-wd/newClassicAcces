<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->string('bill_no',250);
            $table->bigInteger('km_head');
            $table->float('service_amt',10,2)->default(0)->nullable();
            $table->float('sub_amt',10,2)->default(0);
            $table->float('discount',10,2)->default(0)->comment("in RS")->nullable();
            $table->float('total_amt',10,2)->default(0);
            $table->longText('notes')->nullable();
            $table->tinyInteger('payment_status')->comment("1= Pending, 2=Paid, 3=Cancel")->default(1);
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
