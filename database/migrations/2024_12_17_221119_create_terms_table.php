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
        Schema::create('terms', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();

            $table->unsignedInteger('taxonomy_id')->index();
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')
                ->onUpdate('cascade');

            $table->string('title');
            $table->string('slug')->nullable()->index();
            $table->tinyInteger('is_main')->default(0)->index();
            $table->tinyInteger('is_filter')->default(1)->index();
            $table->tinyInteger('is_footer')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
