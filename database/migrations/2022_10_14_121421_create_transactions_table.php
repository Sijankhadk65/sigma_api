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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('created_at');
            $table->uuid('created_by')->nullable();
            $table->timestamp('transaction_at');
            $table->enum('type', array(
                "CREDIT" => "credit",
                "DEBIT"  => "debit",
            ));
            $table->enum('source', array(
                "SERVICE"  => 'service',
                "CASH"     => 'cash',
                "HARDWARE" => 'hardware',
                "SALES"    => 'sales',
                "UTILITY"  => 'utility'
            ));
            $table->string('description')->nullable();
            $table->decimal('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
