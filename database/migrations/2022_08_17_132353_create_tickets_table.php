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
            $table->increments('id');
            $table->integer('center_id');
            $table->integer('customer_id');
            $table->integer('total_service_cost');
            $table->boolean('is_closed');
            $table->boolean('is_delivered');
            $table->timestamp('delivered_at');
            $table->string('delivery_location');
            $table->boolean('is_payment_due');
            $table->integer('opened_by');
            $table->timestamp('opened_at');
            $table->timestamp('due_at');
            $table->integer('closed_by');
            $table->timestamp('closed_at');
            $table->integer('serviced_by');
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
