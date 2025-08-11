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
        Schema::create('hr_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('date');
            $table->time('time_in');
            $table->integer('status')->default(1); // 1=Present, 2=Late, etc.
            $table->time('time_out')->nullable();
            $table->double('num_hr');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('employee_id')
                  ->references('id')
                  ->on('hr_employees')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_attendance');
    }
};