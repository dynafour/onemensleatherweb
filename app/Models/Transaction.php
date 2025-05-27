<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\location;

class Transaction extends Model
{
    protected $table = 'transactions'; // Nama tabel

    protected $primaryKey = 'id_transaction'; // Primary key
    protected $fillable = ['id_product','id_location', 'tanggal_transaksi','tanggal_pengiriman','code','code_product','category','name','qty','price','pelanggan','alamat','sisa_stock','created_by','created_at','updated_at'];

    // Relasi: Transaksi milik satu produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'id_product', 'id_product');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'id_location','id_location');
    }
}
