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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedBigInteger('appointment_time_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('department_id');
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('last_updated_by');
            $table->softDeletes();
            $table->boolean('status')->default(1); // 1 forthcoming 0 closed git 
            $table->foreign('appointment_time_id')->references('id')->on('appointment_times')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
