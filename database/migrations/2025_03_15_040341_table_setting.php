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
        Schema::create('settings', function (Blueprint $table) {
            $table->id('id_setting');
            $table->string('logo', 199)->unique()->nullable();
            $table->string('landing_logo', 199)->unique()->nullable();
            $table->string('icon', 199)->unique()->nullable();
            $table->integer('limit')->nullable();
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::table('settings')->insert([
            'id_setting' => 1,
            'logo' => 'default_logo.png',
            'landing_logo' => 'default_landing_logo.png',
            'icon' => 'default_icon.png',
            'limit' => 3,
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
