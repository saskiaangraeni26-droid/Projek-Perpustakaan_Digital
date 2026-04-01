<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('buku_id');
        $table->unsignedBigInteger('user_id');

        $table->string('nama');
        $table->string('nis');
        $table->string('telepon');

        $table->date('tgl_pinjam');
        $table->date('tgl_kembali');

        $table->text('catatan')->nullable();
        $table->string('status')->default('dipinjam');

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
        Schema::dropIfExists('peminjaman');
    }
};
