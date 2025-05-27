<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\transaction;

class Location extends Model
{
      protected $table = 'locations'; // Nama tabel

    protected $primaryKey = 'id_location'; // Primary key


    protected $fillable = ['lat', 'long','name','created_at','updated_at'];

    public function transactions() {
        return $this->hasMany(Transaction::class, 'id_location','id_location');
    }
}
