<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertisesTable extends Migration
{
    public function up()
    {
        Schema::create('expertises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('category')->default('other'); // dev, data, gov, other
            $table->timestamps();
        });

        Schema::create('lecturer_expertise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade');
            $table->foreignId('expertise_id')->constrained('expertises')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecturer_expertise');
        Schema::dropIfExists('expertises');
    }
}
