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
        Schema::create('doctor_term', function (Blueprint $table) {
            $table->unsignedInteger('term_id')->index();
            $table->foreign('term_id')->references('id')->on('terms')
                ->onUpdate('cascade');

            $table->unsignedInteger('doctor_id')->index();
            $table->foreign('doctor_id')->references('id')->on('doctors')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_term');
    }
};
