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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scnumber',15)->unique();
            $table->string('email',50)->unique();
            $table->string('mobile',25);
            $table->float('gpa');
            $table->string('special',5);
            $table->float('credits');
            $table->string('company',100);
            $table->string('c_address')->nullable();
            $table->string('hr_number',25)->nullable();
            $table->date('s_date')->nullable();
            $table->date('e_date')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('s_email',50)->nullable();
            $table->string('s_mobile',25)->nullable();
            $table->text('technologies')->nullable();
            $table->text('description')->nullable();
            $table->string('imgpath');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
