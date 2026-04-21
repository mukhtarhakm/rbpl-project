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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->unsignedBigInteger('rkas_id')->nullable()->after('user_id');
            $table->integer('kegiatan_idx')->nullable()->after('rkas_id');

            $table->foreign('rkas_id')->references('id')->on('rkas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['rkas_id']);
            $table->dropColumn(['rkas_id', 'kegiatan_idx']);
        });
    }
};
