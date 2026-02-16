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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('judul');
            $table->text('deskripsi');
            $table->bigInteger('jumlah_dana');
            $table->date('tanggal_dibutuhkan');

            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu');

            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
