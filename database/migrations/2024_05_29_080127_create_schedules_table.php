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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                    ->constrained(table: 'devices')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('active');
            $table->string('days');
            $table->time('time', precision: 0);
            $table->integer('grams_per_feeding');
            $table->integer('servo_seconds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
