<?php

use App\Http\Enums\GenderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('code');
            $table->string('sub_title')->nullable();
            $table->string('short_description')->nullable();
            $table->string('redirect')->nullable();
            $table->mediumText('description')->nullable();
            $table->tinyInteger('gender')
                ->comment('male: ' . GenderEnum::MALE->value . '; female: ' . GenderEnum::FEMALE->value)
                ->index();
            $table->tinyInteger('status')->default(1)->index();

            $table->unsignedInteger('hospital_id')->index();
            $table->foreign('hospital_id')->references('id')->on('hospitals')
                ->onUpdate('cascade');

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
