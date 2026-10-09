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
        Schema::table('faq_questions', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('school_origin')->nullable();
            $table->enum('desired_prodi', [
                'SISTEM_INFORMASI',
                'AKUNTANSI',
                'INFORMATIKA',
                'ADMINISTRASI_BISNIS',
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faq_questions', function (Blueprint $table) {
            $table->dropColumn(['phone', 'school_origin', 'desired_prodi']);
        });
    }
};
?>
