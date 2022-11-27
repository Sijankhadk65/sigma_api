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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username');
            $table->string('password');
            $table->string('photo_uri');
            $table->enum('role', array(
                "ADMIN"   => 'admin',
                "CASHIER" => 'cashier',
            ));
            $table->string('fname');
            $table->string('lname');
            $table->uuid('center_id');
            $table->string('address');
            $table->string('email');
            $table->integer('contact_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
