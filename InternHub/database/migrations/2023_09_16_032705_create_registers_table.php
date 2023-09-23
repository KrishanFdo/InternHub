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
            $table->string('c_address');
            $table->string('hr_number',25);
            $table->date('s_date');
            $table->date('e_date');
            $table->string('supervisor');
            $table->string('s_email',50);
            $table->string('s_mobile',25);
            $table->text('technologies');
            $table->text('description');
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
