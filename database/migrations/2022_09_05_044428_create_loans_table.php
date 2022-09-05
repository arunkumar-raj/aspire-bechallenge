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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedDecimal('amount', $precision = 8, $scale = 2);
            $table->unsignedInteger('scheduled_terms');
            $table->enum('loan_status', ['PENDING', 'APPROVED', 'PAID'])->default('PENDING');
            $table->unsignedDecimal('minimum_due', $precision = 8, $scale = 2)->nullable();
            $table->date('approved_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
