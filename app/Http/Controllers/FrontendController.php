<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class FrontendController extends Controller
{

    public function index()
    {
        // GET DATA
        $result = Product::with('category')
            ->select(['products.*'])
            ->where('products.deleted', 'N')
            ->where('products.status', 'Y')
            ->withSum('stocks as total_stock', 'jumlah')  // Total stok masuk
            ->withSum('transactions as total_sold', 'qty') // Total stok terjual
            ->having('total_stock', '>', 0) // filter berdasarkan total_stock
            ->orderByDesc('total_sold')     // urutkan berdasarkan total terjual
            ->limit(3)
            ->get();

        // SET DATA
        $data['result'] = $result;

        // SET VIEW
        return view('frontend.home',$data);
    }

    public function category()
    {
        // GET DATA
        $result = Category::where('status','Y')->where('deleted','N')->get();

        // SET DATA
        $data['result'] = $result;

        // SET VIEW
        return view('frontend.category',$data);
    }

    public function product($id_category = null, $start = null)
    {
        $detail = null;
        if ($id_category) {
            $detail = Category::find($id_category);
            if (!$detail) {
                return redirect()->route('list.category');
            }
        }

        $perPage = 9;
        $start = $start ?? 0;

        // Query dasar
        $baseQuery = Product::where('products.deleted', 'N')
            ->where('products.status', 'Y');

        if ($id_category) {
            $baseQuery->where('products.id_category', $id_category);
        }

        // Ambil semua ID produk yang stoknya > 0 (agar bisa dipakai di 2 query)
        $productIds = $baseQuery->withSum('stocks as total_stock', 'jumlah')
            ->having('total_stock', '>', 0)
            ->pluck('products.id_product');

        // Hitung total
        $total = $productIds->count();

        // Ambil data produk yang valid (paging)
        $result = Product::with('category')
            ->select(['products.*'])
            ->whereIn('products.id_product', $productIds)
            ->withSum('stocks as total_stock', 'jumlah')
            ->withSum('transactions as total_sold', 'qty')
            ->orderByDesc('products.created_at')
            ->skip($start)
            ->take($perPage)
            ->get();

        // Hitung halaman
        $currentPage = floor($start / $perPage) + 1;
        $totalPages = ceil($total / $perPage);

        // Kirim ke view
        return view('frontend.product', [
            'result' => $result,
            'detail' => $detail,
            'total' => $total,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'start' => $start,
            'id_category' => $id_category,
        ]);
    }



    public function about()
    {
        // SET VIEW
        return view('frontend.about');
    }

    public function contact()
    {
        // GET DATA
        $result = Comment::orderByDesc('created_at')->limit(3)->get();

        // SET DATA
        $data['result'] = $result;
        // SET VIEW
        return view('frontend.contact',$data);
    }

    public function detail_product($id_product = null)
    {
        // PARAMETER
        if (!$id_product) {
            return redirect()->route('list.main.product');
        }
        $result = Product::with('category')
            ->select(['products.*'])
            ->where('products.id_product', $id_product)
            ->withSum('stocks as total_stock', 'jumlah')
            ->withSum('transactions as total_sold', 'qty')
            ->first();
        if (!$result) {
            return redirect()->route('list.main.product');
        }


        // SET DATA
        $data['result'] = $result;


        // SET VIEW
        return view('frontend.detail_product',$data);
    }





    // FUNGSI (POST)
    public function insert_comment(Request $request)
    {
        $arrVar = [
            'name' => 'Nama',
            'subject' => 'Subjek',
            'email' => 'Alamat email',
            'description' => 'Deskripsi'
        ];

        $data = ['required' => [], 'arrAccess' => []];
        $post = [];

        // Validasi input satu per satu (sesuai dengan logika CI3-mu)
        foreach ($arrVar as $var => $label) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$label tidak boleh kosong!"];
                $data['arrAccess'][] = false;
            } else {
                $post[$var] = trim($$var);
                $data['arrAccess'][] = true;
            }
        }

        // Jika ada input yang kosong, return error
        if (in_array(false, $data['arrAccess'])) {
            sleep(1);
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sleep(1);
            return response()->json(['status' => false, 'alert' => ['message' => 'Alamat email tidak valid!']]);
        }

        // Insert ke database
        $insert = Comment::create($post);

        if ($insert) {
            sleep(1);
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Berhasil menambahkan komentar!'],
                'reload' => true
            ]);
        }

        return response()->json([
            'status' => false,
            'alert' => ['message' => 'Gagal menambahkan komentar!'],
        ]);
    }
}