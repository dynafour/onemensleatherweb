<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('id_stock');
            $table->unsignedBigInteger('id_product')->nullable();
            $table->string('jumlah', 200)->nullable();
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
                    ->onDelete('CASCADE');
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
