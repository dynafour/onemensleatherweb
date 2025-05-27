<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\TransactionImport;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
     public function index()
    {
        $start= Carbon::now()->startOfMonth()->toDateString(); // Tanggal awal bulan
        $end = Carbon::now()->endOfMonth()->toDateString();

        $data['date']['start'] = $start;
        $data['date']['end'] = $end;
        return view('transaksi.index',$data);
    }


    public function report(Request $request)
    {
        $product = Product::where('status','Y')->where('deleted','N')->get();
        $data['product'] = $product;
        return view('transaksi.laporan',$data);
    }


    // DATATABLE
    public function getTransaction(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $transactions = Transaction::whereBetween('tanggal_transaksi', [$startDate, $endDate])->get();


        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('stok_tersedia', function ($row) {
                return ($row->total_stock ?? 0) - ($row->total_sold ?? 0);
            })->make(true);
    }

    // AJAX
    public function reportAjax(Request $request)
    {
        $tipe = $request->tipe;
        $periode = $request->periode;
        $id_product = $request->id_product;
        $tanggal = $request->tanggal;
        $start_month = $request->start_month;
        $end_month = $request->end_month;
        $year = $request->year;
        $datatable = $request->datatable;

        $header = [];
        if ($tipe == 1) {
            $title = 'Laporan Barang';
            $header = ['Kode','Nama Produk','Kategori','Pembuat','Total Stok','Terjual','Tersedia','Transaksi'];
        }
        if ($tipe == 2) {
            $product = Product::where('id_product',$id_product)->first();
            $title = 'Laporan Stok Produk '.$product->name;
            $header = ['Tanggal','Stok Masuk','Stok Keluar'];
        }
        if ($tipe == 3) {
            $title = 'Laporan transaksi';
            $header = ['Kode','Tanggal Transaksi','Tanggal Pengiriman','Alamat','Pelanggan','Produk','Jumlah','Harga'];
        }

        if ($periode == 1) {
            $filter = $fd = $tanggal;
        }
        if ($periode == 2) {
            if ($start_month != $end_month) {
                 $filter = getMonthById($start_month).' '.$year.' - '.getMonthById($end_month).' '.$year;
                 $fd = $start_month.' '.$year.' - '.$end_month.' '.$year;
            }else{
                 $filter = getMonthById($start_month).' '.$year;
                 $fd = $start_month.' '.$year;
            }

        }
        if ($periode == 3) {
            $filter = $fd = $year;
        }
        
        if ($datatable == true) {
            // Ambil parameter dari DataTables
            $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
            $length = isset($_POST['length']) ? (int)$_POST['length'] : 0;
            $orderColumn = isset($_POST['order'][0]['column']) ? (int)$_POST['order'][0]['column'] : 0;
            $orderDir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
            if ($tipe == 1) {
                $result = $this->reportProductData($periode,$fd,$search,$start,$length,$orderColumn,$orderDir);
            }
            if ($tipe == 2) {
                $result = $this->reportStockData($id_product,$periode,$fd,$start,$length,$orderColumn,$orderDir);
            }
            if ($tipe == 3) {
                $result = $this->reportTransactionData($periode,$fd,$search,$start,$length,$orderColumn,$orderDir);
            }
            
            $table = [
                "draw" => intval($_POST['draw']),
                "recordsTotal" => $result['count'],
                "recordsFiltered" => $result['count'],
                "data" => $result['result']
            ];

            return response()->json($table);
        }else{
            $set['title'] = $title;
            $set['filter'] = $filter;
            $set['header'] = $header;
            $set['search'] = true;
            if ($tipe == 2) {
                $set['search'] = false;
            }

            $html = view('transaksi.ajax.table',$set)->render(); 

            $data['status'] = true;
            $data['html'] = $html;
            return response()->json($data); // Return sebagai JSON
        }

        
    }



    public function reportProductData($tipe = 1, $filter = '', $search = '', $start = 0, $length = 0, $orderColumn = 0, $orderDir = 'asc')
    {
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

        // Filter tanggal
        $filter = ($filter == '') ? date('Y-m-01') . ' - ' . date('Y-m-t') : $filter;
        $startDate = null;
        $endDate = null;

        if ($tipe == 1) {
            $arr = explode('-', $filter);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($arr[0]))->format('Y-m-d');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($arr[1]))->format('Y-m-d');
        } elseif ($tipe == 2) {
            $arr = explode('-', $filter);
            $r1 = trim($arr[0]);
            $bt1 = explode(' ', $r1);
            $sd1 = $bt1[1] . '-' . $bt1[0] . '-01';
            $startDate = date('Y-m-d', strtotime($sd1));

            if (isset($arr[1])) {
                $r2 = trim($arr[1]);
                $bt2 = explode(' ', $r2);
                $sd2 = $bt2[1] . '-' . $bt2[0] . '-01';
                $endDate = date('Y-m-t', strtotime($sd2));
            } else {
                $endDate = date('Y-m-t', strtotime($startDate));
            }
        } elseif ($tipe == 3) {
            $tahun = $filter;
            $startDate = "$tahun-01-01";
            $endDate = "$tahun-12-31";
        }

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

        // Filter search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('products.id_product', 'like', '%' . $search . '%')
                ->orWhere('products.name', 'like', '%' . $search . '%')
                ->orWhere('creator.name', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $query->orderBy($columns[$orderColumn], $orderDir);

        // Pagination
        $totalRecords = $query->count();

        if ($start >0) {
            $query->skip($start);
        }
        
        if ($length > 0) {
            $query->take($length);
        }
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

        // Return JSON untuk DataTables
        $dataend['count'] = $totalRecords;
        $dataend['result'] = $result;
        return $dataend;
    }

    public function reportStockData($id_product, $tipe = 1, $filter = '', $start = 0, $length = 0, $orderColumn = 0, $orderDir = 'asc')
    {
        // Filter tanggal
        $filter = ($filter == '') ? date('Y-m-01') . ' - ' . date('Y-m-t') : $filter;
        $startDate = null;
        $endDate = null;

        if ($tipe == 1) {
            $arr = explode('-', $filter);
            $startDate = Carbon::createFromFormat('d/m/Y', trim($arr[0]))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', trim($arr[1]))->format('Y-m-d');
        } elseif ($tipe == 2) {
            $arr = explode('-', $filter);
            $bt1 = explode(' ', trim($arr[0]));
            $startDate = date('Y-m-d', strtotime($bt1[1] . '-' . $bt1[0] . '-01'));

            if (isset($arr[1])) {
                $bt2 = explode(' ', trim($arr[1]));
                $endDate = date('Y-m-t', strtotime($bt2[1] . '-' . $bt2[0] . '-01'));
            } else {
                $endDate = date('Y-m-t', strtotime($startDate));
            }
        } elseif ($tipe == 3) {
            $tahun = $filter;
            $startDate = "$tahun-01-01";
            $endDate = "$tahun-12-31";
        }

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

        $query = $stockIn->unionAll($stockOut);

        // Sorting
        $columns = ['tanggal', 'stok_masuk', 'stok_keluar'];
        $query->orderBy($columns[$orderColumn], $orderDir);

        // Pagination
        $totalData = $query->count();

        if ($start >0) {
            $query->skip($start);
        }
        
        if ($length > 0) {
            $query->take($length);
        }
        
        $results = $query->get();

        // Output Looping
        $output = [];
        foreach ($results as $row) {
            $output[] = [
                date('Y-m-d',strtotime($row->tanggal)),
                $row->stok_masuk,
                $row->stok_keluar,
            ];
        }

        // Return JSON untuk DataTables
        $dataend['count'] = $totalData;
        $dataend['result'] = $output;
        return $dataend;
    }


    public function reportTransactionData($tipe = 1, $filter = '', $search = '', $start = 0, $length = 10, $orderColumn = 0, $orderDir = 'asc')
    {
        // Filter tanggal
        $filter = ($filter == '') ? date('Y-m-01') . ' - ' . date('Y-m-t') : $filter;
        $startDate = null;
        $endDate = null;

        if ($tipe == 1) {
            $arr = explode('-', $filter);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($arr[0]))->format('Y-m-d');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($arr[1]))->format('Y-m-d');
        } elseif ($tipe == 2) {
            $arr = explode('-', $filter);
            $bt1 = explode(' ', trim($arr[0]));
            $startDate = date('Y-m-d', strtotime($bt1[1] . '-' . $bt1[0] . '-01'));

            if (isset($arr[1])) {
                $bt2 = explode(' ', trim($arr[1]));
                $endDate = date('Y-m-t', strtotime($bt2[1] . '-' . $bt2[0] . '-01'));
            } else {
                $endDate = date('Y-m-t', strtotime($startDate));
            }
        } elseif ($tipe == 3) {
            $tahun = $filter;
            $startDate = "$tahun-01-01";
            $endDate = "$tahun-12-31";
        }

        $columns = ['code', 'tanggal_transaksi', 'tanggal_pengiriman', 'alamat', 'pelanggan', 'name', 'qty', 'price'];

        $query = Transaction::query();

        // Filter by date range
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        // Searching
        if (!empty($search)) {
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        // Ordering
        $query->orderBy($columns[$orderColumn], $orderDir);

        // Clone untuk hitung total data
        $totalData = $query->count();

        // Pagination
        $results = $query->skip($start)->take($length)->get();

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

        $response = [
            'count' => $totalData,
            'result' => $data,
        ];

        return $response;
    }








    public function import(Request $request)
    {
        $data = ['required' => [], 'arrAccess' => []];

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($request->file('file')->getSize() <= 0) {
                $data['required'][] = ['req_file', "File tidak boleh kosong!"];
                $data['arrAccess'][] = false;
            } else {
                $data['arrAccess'][] = true;
            }
        } else {
            $data['required'][] = ['req_file', "Unggah file terlebih dahulu!"];
            $data['arrAccess'][] = false;
        }

        if (in_array(false, $data['arrAccess'])) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $extensions = ['zip', 'gd'];

        foreach ($extensions as $ext) {
            if(!extension_loaded($ext)){
                return response()->json([
                    'status' => false,
                    'alert' => ['message' => 'Extension '.$ext.' harus di aktifkan']
                ]);
            }
        }
        $file = $request->file('file');
        $data = Excel::toArray([], $file);
        $rows = $data[0];

        if (count($rows) < 2) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'File Excel kosong atau format tidak sesuai']
            ]);
        }

        $expectedHeaders = ['tanggal transaksi', 'tanggal pengiriman', 'kode transaksi', 'kode produk', 'kategori', 'nama produk', 'qty', 'harga', 'pelanggan', 'alamat'];
        $headers = array_map('strtolower', $rows[0]);

        if ($headers !== $expectedHeaders) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Format header tidak sesuai. Harusnya: </br>' . implode(', ', $expectedHeaders)]
            ]);
        }

        $products = Product::pluck('id_product', 'code');
        $locations = Location::pluck('id_location', 'name');
        $duplicate = Transaction::pluck('id_transaction', 'code');

        $transactions = [];
        $invalidProducts = 0;
        $invalidLocations = 0;
        $arr_stock = [];

        $table1 = []; //table tidak di insert
        $no1 = 0;
        $gagalImport = 0;
        $berhasilImport = 0;
        foreach (array_slice($rows, 1) as $index => $row) {
            $productCode = $row[3];
            $alamat = $row[9];
            $codeTransaksi = $row[2];
            
            $arr_dup[] = (isset($duplicate[$codeTransaksi])) ? true : false;
            $arr_dup[] = (!isset($products[$productCode])) ? true : false;
            $cc = (isset($duplicate[$codeTransaksi])) ? '<span class="text-danger">Kode transaksi sudah terdaftar</span>' : '<span class="text-warning">Kode produk tidak terdaftar</span>';
            if (!in_array(true,$arr_dup)) {
                $berhasilImport++;
                $productId = $products[$productCode] ?? null;
                $locationId = null;
                foreach ($locations as $name => $id) {
                    if (stripos($alamat, $name) !== false) {
                        $locationId = $id;
                        break;
                    }
                }
                if (!$locationId || empty($alamat)) {
                    $invalidLocations++;
                }

                $alasan = '';
                if (!$productId) {
                    $invalidProducts++;
                    $sts = 2;
                    $alasan .= 'Kode produk tidak ditemukan';
                    $num2 = $no2++;
                    $table2[$num2]['codetrx'] = $codeTransaksi;
                    $table2[$num2]['codeprd'] = $productCode;
                    $table2[$num2]['produk'] = $row[5];
                    $table2[$num2]['pelanggan'] = $row[8];
                    $table2[$num2]['alasan'] = '<span class="text-danger">Kode produk tidak ditemukan</span>';
                }else{
                    $sts = 1;
                }

                if (!$locationId && !empty($alamat)) {
                    $invalidLocations++;
                }

                $prefix = config('session.prefix');
                $id_user = session($prefix . '_id_user');

                $tanggal_transaksi = is_numeric($row[0]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0])->format('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($row[0]));
                $tanggal_pengiriman = is_numeric($row[1]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($row[1]));

                // Hitung stok tersedia
                $totalStock = Stock::where('id_product', $productId)->sum('jumlah');
                $totalTransaction = Transaction::where('id_product', $productId)->sum('qty');
                $stockTersedia = $totalStock - $totalTransaction;

                if (!isset($arr_stock[$productId])) {
                    $minusin = $row[6];
                }else{
                    $minusin = ($arr_stock[$productId] + $row[6]);
                }
                $transactions[] = [
                    'id_product' => $productId,
                    'id_location' => $locationId,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'tanggal_pengiriman' => $tanggal_pengiriman,
                    'code' => $row[2],
                    'code_product' => $row[3],
                    'category' => $row[4],
                    'name' => $row[5],
                    'qty' => $row[6],
                    'price' => $row[7],
                    'pelanggan' => $row[8],
                    'alamat' => $row[9],
                    'status' => $sts,
                    'alasan' => $alasan,
                    'sisa_stock' => $stockTersedia - $minusin,
                    'created_by' => $id_user
                ];
                if (!isset($arr_stock[$productId])) {
                    $arr_stock[$productId] = $row[6];
                }else{
                    $arr_stock[$productId] += $row[6];
                }
            }else{
                $gagalImport++;
                $num1 = $no1++;
                $table1[$num1]['codetrx'] = $codeTransaksi;
                $table1[$num1]['codeprd'] = $productCode;
                $table1[$num1]['produk'] = $row[5];
                $table1[$num1]['pelanggan'] = $row[8];
                $table1[$num1]['alasan'] = $cc;
            }
            
        }

        if (!empty($transactions)) {
            Transaction::insert($transactions);
        }

        $message = '<span class="text-success">'.$berhasilImport.' data </span> berhasil di import dan <span class="text-danger">'.$gagalImport.' Data gagal </span> di import</br>';
        if ($invalidLocations > 0) {
            $message .= '</br><table class="table table-bordered">';
            $message .= '<tr><th>'.$invalidLocations.' data dengan lokasi tidak terdaftar pada peta</th></tr>';
            $message .= '</table>';
        }
        if (!empty($table1)) {
            $message .= '</br><table class="table table-bordered">';
            $message .= '<tr><th colspan="5" class="bg-danger"><b class="text-dark">Data Gagal Import</b></th></tr>';
            $message .= '<tr>';
            $message .= '<th>Kode Trx</th>';
            $message .= '<th>Kode Produk</th>';
            $message .= '<th>Produk</th>';
            $message .= '<th>Pelanggan</th>';
            $message .= '<th>Alasan</th>';
            $message .= '</tr>';
            foreach ($table1 as $key) {
                $message .= '<tr>';
                $message .= '<td>'.$key['codetrx'].'</td>';
                $message .= '<td>'.$key['codeprd'].'</td>';
                $message .= '<td>'.$key['produk'].'</td>';
                $message .= '<td>'.$key['pelanggan'].'</td>';
                $message .= '<td>'.$key['alasan'].'</td>';
                $message .= '</tr>';
            }
            $message .= '</table>';
        }

        if (!empty($table1) || $invalidLocations > 0) {
            $width = '1000px';
        }else{
            $width = null;
        }

        return response()->json([
            'status' => true,
            'alert' => ['message' => $message,'width' => $width],
            'datatable' => 'transactionTable',
            'input' => ['all' => true],
            'modal' => ['id' => '#kt_modal_transaction', 'action' => 'hide']
        ]);
    }

}
