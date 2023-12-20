<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('twilio_call_lists', function (Blueprint $table) {
            $table->id();
            $table->string('call_id')->nullable();
            $table->string('order_num')->nullable();
            $table->string('emp_num')->nullable();
            $table->string('phone_num')->nullable();
            $table->string('emp_resp')->nullable();
            $table->date('pick_time')->nullable();
            $table->integer('award_shift')->default(0);
            $table->integer('call_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twilio_call_lists');
    }
};
