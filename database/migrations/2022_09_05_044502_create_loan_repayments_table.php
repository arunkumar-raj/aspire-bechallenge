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
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->date('due_date');
            $table->unsignedDecimal('due_amount', $precision = 8, $scale = 2);
            $table->date('paid_date')->nullable();
            $table->unsignedDecimal('paid_amount', $precision = 8, $scale = 2)->nullable();
            $table->enum('status', ['PENDING', 'PAID'])->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_repayments');
    }
};
