<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
 use Carbon\Carbon;

class Product extends Model
{
     protected $table = 'products'; // Nama tabel

    protected $primaryKey = 'id_product'; // Primary key


    protected $fillable = ['id_category', 'code','name','image','size','color','material','description','link','price','status','reason','blocked_date','blocked_by','created_by','created_at','updated_at','deleted','deleted_by','deleted_at'];

    // Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'id_category', 'id_category');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'create_by', 'id_user');
    }

    // Relasi ke Stock
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class,'id_product', 'id_product');
    }
    // Relasi ke Transaction
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class,'id_product', 'id_product');
    }

    // Mendapatkan total stok
    public function getTotalStockAttribute()
    {
        return $this->stocks()->sum('jumlah');
    }

    // Mendapatkan total yang terjual
    public function getTotalSoldAttribute()
    {
        return $this->transactions()->sum('qty');
    }

   

    public static function chartStockByFilter($month = 0, $year = 0)
    {
    if ($month < 1) {
        $month = date('m');
    }

    if ($year < 1) {
        $year = date('Y');
    }
    $year = (int)$year;
    $month = (int)$month;

    $product = new Product();

    // Ambil stok masuk sampai bulan dan tahun ini
    $totalStock = Stock::whereYear('created_at', '<=', $year)
        ->where(function($query) use ($month, $year) {
            $query->whereYear('created_at', '<', $year)
                    ->orWhereMonth('created_at', '<=', $month);
        })
        ->when($year >= date('Y'), function ($query) {
            return $query->whereDate('created_at', '<=', Carbon::now());
        })
        ->sum('jumlah');

    // Ambil stok keluar sampai bulan dan tahun ini
    $totalSold = Transaction::whereYear('tanggal_transaksi', '<=', $year)
        ->where(function($query) use ($month, $year) {
            $query->whereYear('tanggal_transaksi', '<', $year)
                    ->orWhereMonth('tanggal_transaksi', '<=', $month);
        })
        ->when($year >= date('Y'), function ($query) {
            return $query->whereDate('tanggal_transaksi', '<=', Carbon::now());
        })
        ->sum('qty');

    // Stok keluar hanya untuk bulan dan tahun ini saja
    $stockOutMonth = Transaction::whereYear('tanggal_transaksi', $year)
        ->whereMonth('tanggal_transaksi', $month)
        ->when($year >= date('Y'), function ($query) {
            return $query->whereDate('tanggal_transaksi', '<=', Carbon::now());
        })
        ->sum('qty');

    // Hitung stok real (total masuk - total keluar)
    $realStock = $totalStock - $totalSold;

    $data['out'] = ($stockOutMonth < 0 ) ? 0 : $stockOutMonth;
    $data['stay'] = ($realStock < 0) ? 0 : $realStock;

    return $data;
    }


}
