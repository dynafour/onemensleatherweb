<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings'; // Nama tabel di database
    protected $primaryKey = 'id_setting'; // Primary key
    public $timestamps = false; // Kalau tabel `settings` tidak punya created_at & updated_at

    protected $fillable = [
        'id_setting', 'logo', 'landing_logo', 'icon', 'updated_at' // Sesuaikan dengan kolom yang ada di tabel settings
    ];
}
