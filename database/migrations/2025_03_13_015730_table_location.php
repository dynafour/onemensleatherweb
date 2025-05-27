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
        Schema::create('locations', function (Blueprint $table) {
            $table->id('id_location'); // AUTO_INCREMENT
            $table->string('lat', 200)->nullable();
            $table->string('long', 200)->nullable();
            $table->string('name', 200)->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        
        DB::table('locations')->insert([
            ['name' => 'Nanggroe Aceh Darussalam', 'lat' => 4.72669254555224, 'long' => 96.7091297204764],
            ['name' => 'Sumatera Utara', 'lat' => 2.16229328939484, 'long' => 99.7044908580592],
            ['name' => 'Sumatera Selatan', 'lat' => -3.34603550078379, 'long' => 103.654585471393],
            ['name' => 'Sumatera Barat', 'lat' => -0.764763375023459, 'long' => 101.006529033972],
            ['name' => 'Bengkulu', 'lat' => -3.52647800318946, 'long' => 102.156688014011],
            ['name' => 'Riau', 'lat' => 0.313928525839518, 'long' => 101.750909943193],
            ['name' => 'Kepulauan Riau', 'lat' => 3.94504828087065, 'long' => 107.852597193172],
            ['name' => 'Jambi', 'lat' => -1.49312199405877, 'long' => 102.4677089948],
            ['name' => 'Lampung', 'lat' => -4.53969551805958, 'long' => 105.450578895741],
            ['name' => 'Bangka Belitung', 'lat' => -2.73929951492872, 'long' => 106.428930477896],
            ['name' => 'Kalimantan Barat', 'lat' => -0.132232, 'long' => 111.096769],
            ['name' => 'Kalimantan Tengah', 'lat' => -1.681496, 'long' => 113.382354],
            ['name' => 'Kalimantan Selatan', 'lat' => -3.092641, 'long' => 115.283758],
            ['name' => 'Kalimantan Timur', 'lat' => 0.538659, 'long' => 116.419389],
            ['name' => 'Kalimantan Utara', 'lat' => 3.350987, 'long' => 116.487144],
            ['name' => 'Banten', 'lat' => -6.405817, 'long' => 106.064018],
            ['name' => 'DKI Jakarta', 'lat' => -6.208763, 'long' => 106.845599],
            ['name' => 'Jawa Barat', 'lat' => -6.889836, 'long' => 107.640471],
            ['name' => 'Jawa Tengah', 'lat' => -7.150975, 'long' => 110.140259],
            ['name' => 'DI Yogyakarta', 'lat' => -7.795580, 'long' => 110.369490],
            ['name' => 'Jawa Timur', 'lat' => -7.536064, 'long' => 112.238401],
            ['name' => 'Bali', 'lat' => -8.409518, 'long' => 115.188916],
            ['name' => 'Nusa Tenggara Barat', 'lat' => -8.652933, 'long' => 117.361647],
            ['name' => 'Nusa Tenggara Timur', 'lat' => -8.657381, 'long' => 121.079370],
            ['name' => 'Gorontalo', 'lat' => 0.543544, 'long' => 123.056885],
            ['name' => 'Sulawesi Barat', 'lat' => -2.844137, 'long' => 119.232078],
            ['name' => 'Sulawesi Selatan', 'lat' => -3.668799, 'long' => 119.974053],
            ['name' => 'Sulawesi Tengah', 'lat' => -1.430022, 'long' => 121.445617],
            ['name' => 'Sulawesi Tenggara', 'lat' => -4.146820, 'long' => 122.174605],
            ['name' => 'Sulawesi Utara', 'lat' => 1.416873, 'long' => 124.982795],
            ['name' => 'Maluku', 'lat' => -3.238462, 'long' => 130.145273],
            ['name' => 'Maluku Utara', 'lat' => 1.570999, 'long' => 127.808769],
            ['name' => 'Papua', 'lat' => -4.269928, 'long' => 138.080352],
            ['name' => 'Papua Barat', 'lat' => -1.336115, 'long' => 133.174716],
            ['name' => 'Papua Barat Daya', 'lat' => -0.859205, 'long' => 131.469700],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
