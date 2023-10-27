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
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('s_id');
            $table->string('period');
            $table->text('projects');
            $table->text('tasks_completed');
            $table->text('technologies_learned');
            $table->text('technologies_used');
            $table->text('problems_encountered');
            $table->text('description');
            $table->timestamps();

            $table->foreign('s_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['s_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_reports', function (Blueprint $table) {
            $table->dropForeign(['s_id']);
            $table->bigInteger('id')->change();
        });

        Schema::dropIfExists('progress_reports');
    }
};
