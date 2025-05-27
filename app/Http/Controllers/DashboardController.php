<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (isset($request->month) && $request->month != 'all' && is_numeric($request->month)) ? $request->month : 'all' ;
        $tahun = (isset($request->year) && is_numeric($request->year) && $request->year >= 2024 && $request->year <= date('Y')) ? $request->year : date('Y');
        $tanggalSekarang = date('Y-m-d'); // Tanggal sekarang
        

        $result = Transaction::when($bulan !== 'all', function ($query) use ($bulan) {
            return $query->whereMonth('tanggal_transaksi', $bulan);
        })
        ->whereYear('tanggal_transaksi', $tahun)
        ->when($tahun >= date('Y'), function ($query) {
            return $query->whereDate('tanggal_transaksi', '<=', Carbon::now());
        })
        ->orderBy('tanggal_transaksi', 'desc') // Sort dari terbaru ke terlama
        ->get();

        $last_transaction = [];
        $trend = [];
        if (!$result->isEmpty()) {
            // GET LAST TRANSACTION
            $last_transaction = $result->first();
            
            // GET TREN PRODUCT
            $arr = [];
            foreach ($result as $key) {
                if (!isset($arr[$key->id_product])) {
                    $arr[$key->id_product] = 0;
                }
                $arr[$key->id_product] += 1;
            }   

            $maxValue = max($arr);
            $maxKeys = array_keys($arr, $maxValue);
            $keys = $maxKeys[0];
            $trend = $result->firstWhere('id_product', $keys);
        }
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        
        // GRAFIK BATANG 
        $bar = [];
        $base_bar = [];
        if ($bulan != 'all') {
            $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
            if ($tahun >= date('Y')) {
                $limit = date('d');
            }else{
                $limit = $jumlahHari;
            }
            for ($i=1; $i <= $limit ; $i++) { 
                $base_bar[$i] = 0;
            }
            if ($result) {
                foreach ($result as $key) {
                    $tanggal = Carbon::parse($key->tanggal_transaksi);
                    $day = $tanggal->day;
                    if (isset($base_bar[$day])) {
                        $base_bar[$day] += 1;
                    }
                    
                }
            }
            if ($base_bar) {
                $no = 0;
                foreach ($base_bar as $day => $val) {
                    $num = $no++;
                    $bar[$num]['category'] = $day.' '.getMonthById($bulan);
                    $bar[$num]['value'] = $val;
                }
            }
        }else{
            if ($tahun >= date('Y')) {
                $limit = date('m');
            }else{
                $limit = 12;
            }
            for ($i=1; $i <= $limit ; $i++) { 
                $base_bar[$i] = 0;
            }
            if ($result) {
                foreach ($result as $key) {
                    $tanggal = Carbon::parse($key->tanggal_transaksi);
                    $bulan = $tanggal->month;
                    $base_bar[$bulan] += 1;
                }
            }

            if ($base_bar) {
                $no = 0;
                foreach ($base_bar as $bln => $val) {
                    $num = $no++;
                    $bar[$num]['category'] = getMonthById($bln);
                    $bar[$num]['value'] = $val;
                }
            }
        }

        // GRAFIK PIE
        $base_pie = Product::chartStockByFilter($bulan, $tahun);
        $pie[0]['category'] = 'Terjual';
        $pie[0]['value'] = $base_pie['out'];
        $pie[1]['category'] = 'Tersedia';
        $pie[1]['value'] = $base_pie['stay'];

        // TOP SALE
        $limit = 5;
        $topsale = Product::whereHas('transactions', function ($query) use ($bulan, $tahun,$tanggalSekarang) {
            $query->whereYear('tanggal_transaksi', $tahun)
                ->whereMonth('tanggal_transaksi', $bulan);

            if ($tahun >= date('Y')) {
                $query->whereDate('tanggal_transaksi', '<=', $tanggalSekarang);
            }
        })
        ->withSum(['transactions as total_sold' => function ($query) use ($bulan, $tahun) {
            $query->whereYear('tanggal_transaksi', $tahun)
                ->whereMonth('tanggal_transaksi', $bulan);
        }], 'qty')
        ->orderByDesc('total_sold')
        ->take($limit)
        ->get();
        
        $donut = [];
        if ($topsale) {
            $no = 0;
           foreach ($topsale as $key) {
                $num = $no++;
                $donut[$num]['category'] = $key->name;
                $donut[$num]['value'] = $key->total_sold;
           }
        }

        //MAP

        $base_map = Location::whereIn('id_location', function ($query) use ($tahun, $bulan, $tanggalSekarang) {
                    $query->select('id_location')
                        ->from('transactions')
                        ->whereYear('tanggal_transaksi', $tahun)
                        ->whereMonth('tanggal_transaksi', $bulan)
                        ->when($tahun >= date('Y'), function ($q) use ($tanggalSekarang) {
                            $q->whereDate('tanggal_transaksi', '<=', $tanggalSekarang);
                        })
                        ->distinct(); // Ambil lokasi unik di sini
                })
                ->get();
        $map = [];
        if ($base_map) {
            $no = 0;
           foreach ($base_map as $key) {
                $num = $no++;
                $map[$num]['title'] = $key->name;
                $map[$num]['latitude'] = $key->lat;
                $map[$num]['longitude'] = $key->long; 
           }
        }
        

        // ROW
        // $base_row = Category::withCount(['products as total_transactions' => function ($query) use ($tahun, $bulan, $tanggalSekarang) {
        //     $query->whereHas('transactions', function ($subQuery) use ($tahun, $bulan, $tanggalSekarang) {
        //         $subQuery->whereYear('tanggal_transaksi', $tahun)
        //             ->whereMonth('tanggal_transaksi', $bulan);

        //         if ($tahun >= date('Y')) {
        //             $subQuery->whereDate('tanggal_transaksi', '<=', $tanggalSekarang);
        //         }
        //     });
        // }])->get();

        $base_row = Category::withCount(['products as total_transactions' => function ($query) use ($tahun,$bulan, $tanggalSekarang) {
            $query->join('transactions', 'products.id_product', '=', 'transactions.id_product')
                ->whereYear('transactions.tanggal_transaksi', $tahun)
                ->whereMonth('transactions.tanggal_transaksi', $bulan);

            // Jika tahun adalah tahun ini, tambahkan filter tanggal maksimal hari ini
            if ($tahun >= date('Y')) {
                $query->whereDate('transactions.tanggal_transaksi', '<=', $tanggalSekarang);
            }
        }])->orderByDesc('total_transactions')->get();

        $grow = [];
        if ($base_row) {
            $no = 0;
            foreach ($base_row as $key) {
                $num = $no++;
                $grow[$num]['category'] = $key->name;
                $grow[$num]['value'] = $key->total_transactions;
            }
        }


        
        $data['last_transaction'] = $last_transaction;
        $data['trend'] = $trend;
        $data['pie'] = json_encode($pie);
        $data['bar'] = json_encode($bar);
        $data['donut'] = json_encode($donut);
        $data['map'] = json_encode($map);
        $data['grow'] = json_encode($grow);


        return view('dashboard.index',$data);
    }

    public function profile()
    {
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');
        $result = User::where('id_user', $id_user)->where('deleted','N')->first();

        $data['result'] = $result;
        return view('dashboard.profile',$data);
    }



    public function updateProfile(Request $request)
    {
        $arrVar = [
            'name' => 'Nama lengkap',
            'email' => 'Alamat email',
        ];

        $post = [];
        $arrAccess = [];
        $data = ['required' => []];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');
        $result = User::where('id_user', $id_user)->first();
        
        $password = $request->input('password');
        $new_password = $request->input('new_password');
        $repassword = $request->input('repassword');
        $name_image = $request->input('name_image');

        if ($result->email !== $post['email']) {
            if (User::where('email', $post['email'])->exists()) {
                return response()->json(['status' => false, 'alert' => ['message' => 'Alamat email sudah terdaftar!']]);
            }
        }

        if (!in_array(false, $arrAccess)) {
            $tujuan = public_path('data/user/');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($tujuan, $fileName);
                
                if ($result->image && file_exists($tujuan . $result->image)) {
                    unlink($tujuan . $result->image);
                }
                
                $post['image'] = $fileName;
                session([
                    "{$prefix}_image"  => $fileName
                ]);
            } elseif (!$name_image) {
                if ($result->image && file_exists($tujuan . $result->image)) {
                    unlink($tujuan . $result->image);
                }
                $post['image'] = null;
            }

            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                return response()->json(['status' => false, 'alert' => ['message' => 'Alamat email tidak valid!']]);
            }

            if ($password) {
                if (Hash::check($password, $result->password)) {
                    if (!$new_password || !$repassword) {
                        return response()->json(['status' => true, 'alert' => ['message' => 'Foto Profil berhasil diperbarui!']]);
                        //return response()->json(['status' => true, 'alert' => ['message' => 'Data berhasil dirubah'], 'reload' => true]);
                    }
                    if ($new_password !== $repassword) {
                        return response()->json(['status' => false, 'alert' => ['message' => 'Konfirmasi kata sandi tidak valid!']]);
                    }
                    $post['password'] = $new_password;
                } else {
                    return response()->json(['status' => false, 'alert' => ['message' => 'Kata sandi tidak valid!']]);
                }
            }

            $update = $result->update($post);
            if ($update) {
                session([
                    "{$prefix}_name"  => $post['name'],
                    "{$prefix}_email"  => $post['email']
                ]);
                return response()->json(['status' => true, 'alert' => ['message' => 'Data berhasil dirubah'], 'reload' => true]);
            } else {
                return response()->json(['status' => false, 'alert' => ['message' => 'Data gagal dirubah']]);
            }
        }

        return response()->json(['status' => false]);
    }

}
