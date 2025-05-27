<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\Stock;
use App\Exports\DynamicExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function switch(Request $request, $db = 'user')
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $primary = $request->input('primary') ?? "id_{$db}";
        $reason = $request->input('reason', '');

        // Cek apakah tabel yang dimaksud ada di database
        if (!DB::getSchemaBuilder()->hasTable($db)) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'icon' => 'warning',
                    'message' => 'Tabel tidak ditemukan!'
                ]
            ]);
        }

        // Cek apakah data ada di tabel
        $res = DB::table($db)->where($primary, $id)->first();

        if (!$res) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'icon' => 'warning',
                    'message' => 'Data tidak ditemukan!'
                ]
            ]);
        }

        $prefix = config('session.prefix');
        $idhps = session($prefix.'_id_user');
        // Update status dan reason
        $update = DB::table($db)->where($primary, $id)->update([
            'status' => $action,
            'reason' => $action == 'N' ? $reason : '',
            'blocked_date' => now(),
            'blocked_by' => $idhps
        ]);

        if ($update) {
            $message = $action == 'Y' ? 'Berhasil membuka akses!' : 'Berhasil menutup akses!';
            if ($action == 'N' && $reason != '') {
                $message .= '</br><b>Dengan alasan : </b>"' . $reason . '"';
            }

            return response()->json([
                'status' => 200,
                'alert' => [
                    'icon' => 'success',
                    'message' => $message
                ]
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'icon' => 'warning',
                    'message' => $action == 'Y' ? 'Gagal membuka akses!' : 'Gagal menutup akses!'
                ]
            ]);
        }
    }

    public function hapusdata(Request $request)
    {
        $id = $request->input('id');
        $db = $request->input('db');
        $primary = $request->input('primary') ?? "id_{$db}";
        $reload = $request->input('reload', '');
        $permanent = $request->input('permanent', 0);

        // Cek apakah tabel yang dimaksud ada di database
        if (!DB::getSchemaBuilder()->hasTable($db)) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'message' => 'Tabel tidak ditemukan!'
                ]
            ]);
        }
        if (!$id || !$db) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'message' => 'Data request tidak valid!'
                ]
            ]);
        }

        // Cek apakah data ada di tabel
        $res = DB::table($db)->where($primary, $id)->first();

        if (!$res) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'message' => 'Data tidak ditemukan!'
                ]
            ]);
        }

        if ($permanent != 'none') {
            $aksi = DB::table($db)->where($primary, $id)->delete();
        }else{
            $prefix = config('session.prefix');
            $idhps = session($prefix.'_id_user');
             // Update status dan reason
            $aksi = DB::table($db)->where($primary, $id)->update([
                'deleted' => 'Y',
                'deleted_at' => now(),
                'deleted_by' => $idhps
            ]);
        }


        if ($aksi) {
            $data['status'] = 200;
            $data['alert']['message'] = 'Data berhasil dihapus!';
            return response()->json($data);
        } else {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'message' => 'Data gagal untuk dihapus!'
                ]
            ]);
        }
    }


    public function single(Request $request, $db = 'user',$primary = '')
    {
        $id = $request->input('id');
        $primary = $primary ?? "id_{$db}";

        // Cek apakah tabel yang dimaksud ada di database
        if (!DB::getSchemaBuilder()->hasTable($db)) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'message' => 'Tabel tidak ditemukan!'
                ]
            ]);
        }

        // Cek apakah data ada di tabel
        $res = DB::table($db)->where($primary, $id)->first();
        if ($res) {
            return response()->json($res);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function export(Request $request)
    {
        $tipe = $request->tipe;

        // Filter tanggal
        $filter = ($request->filter == '') ? date('Y-m-01') . ' - ' . date('Y-m-t') : $request->filter;
        $startDate = null;
        $endDate = null;

        if ($request->periode == 1) {
            $arr = explode('-', $request->tanggal);
            $startDate = date('Y-m-d', strtotime(trim($arr[0])));
            $endDate = date('Y-m-d', strtotime(trim($arr[1])));
        } elseif ($request->periode == 2) {
            $sm = $request->start_month;
            $em = $request->end_month;
            $year = $request->year;
            $startDate = date('Y-m-d', strtotime($year . '-' . $sm . '-01'));

            if (isset($em) && $em != '') {
                $endDate = date('Y-m-t', strtotime($year . '-' . $em . '-01'));
            } else {
                $endDate = date('Y-m-t', strtotime($startDate));
            }
        } elseif ($request->periode == 3) {
            $year = $request->year;
            $startDate = "$year-01-01";
            $endDate = "$year-12-31";
        }


        $filename = $request->filename.'.xlsx';

        $headings = [];
        $result = [];
        if ($tipe == 1) {
            $headings = ['Kode','Nama Produk','Kategori','Pembuat','Total Stok','Terjual','Tersedia','Transaksi'];
            // Map kolom DataTables ke field database
            $columns = [
                'products.id_product',    // Kode
                'products.name',          // Nama Produk
                'category.name',
                'creator.name',           // Pembuat (Alias creator)
                'total_stock',            // Total Stok
                'stock_out',              // Keluar (Stok Terjual)
                'tersedia',               // Tersedia (Total Stok - Stok Keluar)
                'transaksi'               // Transaksi
            ];


            // Query utama
            $query = Product::select(
                'products.code',
                'products.id_product',
                'products.name',
                'creator.name as creator_name',
                'category.name as category'
            )
            ->leftJoin('users as creator', 'products.created_by', '=', 'creator.id_user')
            ->leftJoin('categories as category', 'products.id_category', '=', 'category.id_category')
            ->withSum(['stocks as total_stock' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }
            }], 'jumlah')
            ->withSum(['transactions as stock_out' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
                }
            }], 'qty')
            ->withCount(['transactions as transaksi' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
                }
            }]);

            $data = $query->get();

            // Mapping data hasil query
            $result = [];
            foreach ($data as $item) {
                $total_stock = $item->total_stock ?? 0;
                $stock_out = abs($item->stock_out ?? 0);  // Stok keluar absolute

                // Stok tersedia dihitung dengan cek transaksi dan stok keluar
                $tersedia = ($total_stock - $stock_out > 0) ? $total_stock - $stock_out : 0;

                $result[] = [
                    $item->code,      // Kode
                    $item->name,      // Nama Produk
                    $item->category,
                    $item->creator_name,    // Pembuat
                    (int)$total_stock,      // Total Stok
                    (int)$stock_out,        // Keluar (Stok Terjual)
                    (int)$tersedia,         // Tersedia
                    (int)$item->transaksi   // Jumlah Transaksi
                ];
                
            }
        }

        if ($tipe == 2) {
            $id_product = $request->id_product;
            $stockIn = Stock::select(
                'created_at as tanggal',
                'jumlah as stok_masuk',
                DB::raw("0 as stok_keluar"),
            )
            ->where('id_product',$id_product)
            ->whereBetween('created_at', [$startDate, $endDate]);

            $stockOut = Transaction::select(
                'tanggal_transaksi as tanggal',
                DB::raw("0 as stok_masuk"),
                'qty as stok_keluar',
            )
            ->where('id_product',$id_product)
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate]);

            $query = $stockIn->unionAll($stockOut)->orderBy('tanggal', 'asc');

            // Sorting
            $columns = ['tanggal', 'stok_masuk', 'stok_keluar'];
            
            $results = $query->get();

            // Output Looping
            $result = [];
            foreach ($results as $row) {
                $result[] = [
                    date('Y-m-d',strtotime($row->tanggal)),
                    $row->stok_masuk,
                    $row->stok_keluar,
                ];
            }
            $headings = ['Tanggal','Stok Masuk','Stok Keluar'];
        }

        if ($tipe == 3) {
            $columns = ['code', 'tanggal_transaksi', 'tanggal_pengiriman', 'alamat', 'pelanggan', 'name', 'qty', 'price'];

            $query = Transaction::query();

            // Filter by date range
            if (!empty($startDate) && !empty($endDate)) {
                $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
            }
            // Pagination
            $results = $query->get();

            $data = [];
            foreach ($results as $row) {
                $data[] = [
                    $row->code,
                    date('Y-m-d',strtotime($row->tanggal_transaksi)),
                    date('Y-m-d',strtotime($row->tanggal_pengiriman)),
                    $row->alamat,
                    $row->pelanggan,
                    $row->name,
                    $row->qty,
                    'Rp. '.number_format($row->price,0,',','.'),
                ];
            }

            $result = $data;
            $headings = ['Kode', 'Tanggal Transaksi', 'Tanggal Pengiriman', 'Alamat', 'Pelanggan', 'Produk', 'Jumlah', 'Harga'];

        }
        return Excel::download(new DynamicExport($headings, $result), $filename);
    }
}
