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
        Schema::create('slides', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('ordering')->nullable();
            $table->string('link')->nullable();

            $table->unsignedInteger('slider_id')->index();
            $table->foreign('slider_id')->references('id')->on('sliders')
                ->onUpdate('cascade');

            $table->json('extra_data')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
