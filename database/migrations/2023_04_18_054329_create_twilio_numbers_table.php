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
        Schema::create('twilio_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('call_preference')->nullable();
            $table->integer('call_status')->default(0);
            $table->integer('call_completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twilio_numbers');
    }
};
