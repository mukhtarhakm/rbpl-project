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
        Schema::table('rkas', function (Blueprint $table) {
            $table->text('deskripsi')->after('jumlah_dana')->nullable();
            $table->json('kegiatan_list')->after('deskripsi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rkas', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'kegiatan_list']);
        });
    }
};
