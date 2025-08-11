<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hr_employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 15)->unique();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->text('address');
            $table->date('birthdate');
            $table->string('contact_info', 100);
            $table->string('gender', 10);
            $table->foreignId('position_id')->constrained('hr_positions');
            $table->foreignId('schedule_id')->constrained('hr_schedules');
            $table->string('photo', 200)->nullable();
            $table->date('created_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_employees');
    }
};
