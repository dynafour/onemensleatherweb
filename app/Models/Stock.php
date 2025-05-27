<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'stocks'; // Nama tabel

    protected $primaryKey = 'id_stock'; // Primary key

    protected $fillable = ['id_product', 'jumlah','created_by','created_at','updated_at'];

    // Relasi: Stok milik satu produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'id_product', 'id_product');
    }
}
