<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_questions', function (Blueprint $table) {
            $table->id();
            $table->enum('visitor_type', ['MAHASISWA_AKTIF', 'CALON_MAHASISWA']);
            $table->string('nim')->nullable();
            $table->string('name');
            $table->tinyInteger('level')->nullable(); // Tingkat 1, 2, 3, 4
            $table->string('whatsapp')->nullable();
            $table->text('question');
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_questions');
    }
}
