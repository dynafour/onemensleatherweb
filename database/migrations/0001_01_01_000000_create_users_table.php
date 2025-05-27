<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahin ini
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // AUTO_INCREMENT
            // $table->integer('role')->default(1)->comment('1 = admin, 2 = kasir');
            $table->string('email', 199)->unique()->nullable();
            $table->string('name', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->string('password', 200)->nullable();
            $table->text('question')->nullable();
            $table->string('answer', 200)->nullable();
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->text('reason')->nullable();
            $table->dateTime('blocked_date')->nullable();
            $table->unsignedBigInteger('blocked_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('deleted', ['Y', 'N'])->default('N');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign('created_by')
                    ->references('id_user')->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('deleted_by')
                    ->references('id_user')->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
            $table->foreign('blocked_by')
                    ->references('id_user')->on('users')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
        });
        
        DB::table('users')->insert([
            [
                'name' => 'Admin 1',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('admin1'),
                'question' => 'Siapa aku?',
                'answer' => 'Admin 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin 2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('admin2'),
                'question' => 'Siapa aku?',
                'answer' => 'Admin 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin 3',
                'email' => 'admin3@gmail.com',
                'password' => Hash::make('admin3'),
                'question' => 'Siapa aku?',
                'answer' => 'Admin 3',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
