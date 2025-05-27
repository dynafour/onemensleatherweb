<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories'; // Nama tabel

    protected $primaryKey = 'id_category'; // Primary key

    protected $fillable = ['name','image','status','reason','blocked_date','blocked_by','created_by','created_at','updated_at','deleted','deleted_by','deleted_at'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'id_category', 'id_category');
    }

    
}
