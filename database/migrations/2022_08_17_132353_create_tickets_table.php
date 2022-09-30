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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('device_manufacturer');
            $table->string('device_model');
            $table->uuid('customer_id')->nullable();
            $table->integer('center_id');
            $table->integer('total_service_cost')->nullable();
            $table->boolean('is_closed');
            $table->integer('pay_recieved_by')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->boolean('is_payment_due');
            $table->uuid('opened_by');
            $table->timestamp('opened_at');
            $table->uuid('closed_by')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->uuid('serviced_by')->nullable();
            $table->integer('issue_count');
            $table->integer('open_issue');
            $table->integer('closed_issue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
