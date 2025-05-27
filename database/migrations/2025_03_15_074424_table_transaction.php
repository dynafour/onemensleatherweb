<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transaction'); // AUTO_INCREMENT
            $table->unsignedBigInteger('id_product')->nullable();
            $table->unsignedBigInteger('id_location')->nullable();
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->dateTime('tanggal_pengiriman')->nullable();
            $table->string('code', 200)->nullable();
            $table->string('code_product', 200)->nullable();
            $table->string('category', 200)->nullable();
            $table->string('name', 200)->nullable();
            $table->integer('qty')->nullable();
            $table->double('price')->nullable();
            $table->string('pelanggan',200)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status', [1, 2])->default(1)->comment('1 = success, 2 = missing')->nullable();;
            $table->text('alasan')->nullable();
            $table->integer('sisa_stock')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('created_by')
                    ->references('id_user')->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('id_product')
                    ->references('id_product')->on('products')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('id_location')
                    ->references('id_location')->on('locations')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
