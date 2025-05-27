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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id_comment'); // AUTO_INCREMENT
            $table->string('email', 199)->unique()->nullable();
            $table->string('name', 200)->nullable();
            $table->string('subject', 200)->nullable();
            $table->text('description', 200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('created_by')
                    ->references('id_user')->on('users')
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
