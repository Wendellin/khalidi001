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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('to link up with users table');
            $table->string('slug');
            $table->string('street_address');
            $table->unsignedBigInteger('department_id');
            $table->date('dob');
            $table->boolean('gender'); // 0 Male 1 Female
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('created_by'); // created by. If updating own profile then patient id is the one who created
            $table->unsignedBigInteger('last_updated_by');
            $table->string('phone_no');
            $table->string('alt_phone_no');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
