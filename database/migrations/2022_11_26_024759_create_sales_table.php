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
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('created_at');
            $table->uuid('created_by');
            $table->double('amount');
            $table->integer('item_count');
            $table->uuid('customer_id');
            $table->uuid('center_id');
            $table->enum('payment_method', array(
                "CASH"   => "cash",
                "CHEQUE" => "cheque",
                "BANK_TRANSFER" => "bank_transfer",
                "ESEWA" => "esewa",
                "KHALTI" => "khalti",
                "FONE_PAY" => "fone_pay"
            ));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
