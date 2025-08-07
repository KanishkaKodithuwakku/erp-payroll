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
        Schema::create('hr_cashadvance', function (Blueprint $table) {
            $table->id();
            $table->date('date_advance');
            $table->string('employee_id', 15);
            $table->double('amount');
            $table->timestamps();
            
            // Add foreign key constraint if employees table exists
            $table->foreign('employee_id')
                  ->references('employee_id')
                  ->on('hr_employees')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_cashadvance');
    }
};