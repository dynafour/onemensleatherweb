<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ProductController extends Controller
{

    // LOAD VIEW
    public function index()
    {
        $category = $result = Category::where('deleted', 'N')->where('status','Y')->get();

        $data['category'] = $category;
        return view('manajemen.product',$data);
    }

    public function category()
    {
        return view('manajemen.categories');
    }

    public function comment()
    {
        return view('manajemen.comment');
    }


    // DATATABLE
    public function getProduct(Request $request)
    {
        $products = Product::with('category')
            ->select(['products.*'])
            ->where('products.deleted','N')
            ->withSum('stocks as total_stock', 'jumlah')  // Total stok masuk
            ->withSum('transactions as total_sold', 'qty') // Total stok terjual
            ->when($request->search['value'] ?? null, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category', function ($row) {
                return $row->category->name ?? '-';
            })
            ->addColumn('stok_tersedia', function ($row) {
                return ($row->total_stock ?? 0) - ($row->total_sold ?? 0);
            })
            ->addColumn('switch',function($row) {
                $status = '';
                if ($row->status == 'Y') {
                    $status = 'checked';
                }
                return '<div class="d-flex justify-content-center align-items-center">
                                                            <div class="form-check form-switch">
                                                                <input onchange="switching(this,event,'.$row->id_product.')" data-primary="id_product"  data-url="'.url('switch/products').'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$row->id_product.'" '.$status.'>
                                                            </div>
                                                        </div>';
            })
            ->addColumn('aksi', function ($row) {
                return '<div class="d-flex justify-content-center flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Edit data" onclick="ubah_data(this,'.$row->id_product.')" data-image="'.image_check($row->image,'product').'" data-bs-toggle="modal" data-bs-target="#kt_modal_product">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$row->id_product.',`products`,`id_product`)" data-datatable="productTable" title="Hapus Data" class="btn btn-icon btn-danger btn-sm me-1">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                            <button type="button" title="Detail Data" class="btn btn-icon btn-info btn-sm" onclick="detail_data(this,'.$row->id_product.')" data-image="'.image_check($row->image,'product').'" data-bs-toggle="modal" data-bs-target="#kt_modal_detail_product">
                                <i class="fa-solid fa-table-list fs-2"></i>
                            </button>
                        </div>';
            })
            ->rawColumns(['aksi','switch'])
            ->make(true);
    }


    public function getCategory(Request $request)
    {
        
        $result = Category::where('deleted', 'N')
            ->get();
        return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('image',function($row) {
                return '<a role="button" class="symbol symbol-150px"><span class="symbol-label" style="background-image:url('.image_check($row->image,'category').');"></span></a>';
            })
            ->addColumn('switch',function($row) {
                $status = '';
                if ($row->status == 'Y') {
                    $status = 'checked';
                }
                return '<div class="d-flex justify-content-center align-items-center">
                                                            <div class="form-check form-switch">
                                                                <input onchange="switching(this,event,'.$row->id_category.')" data-primary="id_category"  data-url="'.url('switch/categories').'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$row->id_category.'" '.$status.'>
                                                            </div>
                                                        </div>';
            })
            ->addColumn('aksi', function ($row) {
                return '<div class="d-flex justify-content-center flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Edit data" onclick="ubah_data(this,'.$row->id_category.')" data-image="'.image_check($row->image,'category').'" data-bs-toggle="modal" data-bs-target="#kt_modal_category">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$row->id_category.',`categories`,`id_category`)" data-datatable="categoryTable" title="Hapus Data" class="btn btn-icon btn-danger btn-sm">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';
            })
            ->rawColumns(['aksi','switch','image'])
            ->make(true);
    }

    public function getComment(Request $request)
    {
        
        $result = Comment::get();
        return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<div class="d-flex justify-content-center flex-shrink-0">
                            <button type="button" onclick="hapus_data(this,event,'.$row->id_comment.',`comments`,`id_comment`)" data-datatable="commentTable" title="Hapus Data" class="btn btn-icon btn-danger btn-sm">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }



    // FUNGSI
    // // PRODUCT
    public function insert_product(Request $request)
    {
        $arrVar = [
            'name' => 'Nama produk',
            'id_category' => 'kategori produk',
            'stock' => 'Stok awal',
            'color' => 'Warna produk',
            'size' => 'Ukuran produk',
            'description' => 'Deskripsi produk',
            'material' => 'Bahan produk',
            'link' => 'Link produk',
            'price' => 'Harga produk'
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
                if ($var == 'description') {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, "$label cannot be empty!"];
                        $data['arrAccess'][]  = false;
                    } else {
                        $post[$var] = $$var;
                        $data['arrAccess'][]  = true;
                    }
                } else {
                    if ($$var === '') {
                        $data['required'][] = ['req_' . $var, "$label cannot be empty!"];
                        $data['arrAccess'][]  = false;
                    } else {
                        if (!in_array($var,['stock'])) {
                            $post[$var] = trim($$var);
                        }
                        $data['arrAccess'][]  = true;
                    }
                }
            }
        }

        // CEK JUMLAH STOCK
        if ($stock <= 0) {
            $data['required'][] = ['req_stock', "Stok awal harus memiliki nilai lebih dari 0!"];
            $data['arrAccess'][] = false;
        }

        // Jika ada input yang kosong, return error
        if (in_array(false, $data['arrAccess'])) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $tujuan = public_path('data/product/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gambar tidak boleh kosong!']
            ]);
        }

        $lastProductId = Product::latest('id_product')->value('id_product');
        $nextId = $lastProductId ? $lastProductId + 1 : 1;
        $currentDate = Carbon::now()->format('YmdHis');
        $code = 'PRD' . str_pad($nextId, 4, '0', STR_PAD_LEFT) . $currentDate;
        

        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');
        $post['created_by'] = $id_user;
        $post['code'] = $code;

        // Insert ke database
        $insert = Product::create($post);

        if ($insert) {
            $in['id_product'] = $insert->id_product;
            $in['jumlah'] = $stock;
            $in['created_by'] = $id_user;
            
            $stock = Stock::create($in);
            $msg = '';
            if (!$stock) {
                $msg .= ' namun stok gagal ditambahkan';
            }
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Berhasil menambahkan produk'.$msg.'!'],
                'modal' => ['id' => '#kt_modal_product', 'action' => 'hide'],
                'datatable' => 'productTable'
            ]);
        }

        return response()->json([
            'status' => false,
            'alert' => ['message' => 'Gagal menambahkan data!'],
        ]);
    }

    public function update_product(Request $request)
    {

        $arrVar = [
            'id_product' => 'ID Product',
            'name' => 'Nama produk',
            'id_category' => 'kategori produk',
            'color' => 'Warna produk',
            'size' => 'Ukuran produk',
            'description' => 'Deskripsi produk',
            'material' => 'Bahan produk',
            'link' => 'Link produk',
            'price' => 'Harga produk'
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
                if ($var == 'description') {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, "$label cannot be empty!"];
                        $data['arrAccess'][]  = false;
                    } else {
                        $post[$var] = $$var;
                        $data['arrAccess'][]  = true;
                    }
                } else {
                    if ($$var === '') {
                        $data['required'][] = ['req_' . $var, "$label cannot be empty!"];
                        $data['arrAccess'][]  = false;
                    } else {
                        if (!in_array($var,['stock'])) {
                            $post[$var] = trim($$var);
                        }
                        $data['arrAccess'][]  = true;
                    }
                }
            }
        }

        // Jika ada input yang kosong, return error
        if (in_array(false, $data['arrAccess'])) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }
        // Cek apakah data ada
        $result = Product::where("id_product", $id_product)->first();
         $tujuan = public_path('data/product/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }
        $name_image = $request->input('name_image');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
            unlink($tujuan . $result->image);
        } else {
            if (!$name_image || !File::exists($tujuan.$result->image) || !$result->image) {
                return response()->json([
                    'status' => false,
                    'alert' => ['message' => 'Gambar tidak boleh kosong!']
                ]);
            }
           
        }
        
        if (!$result) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'message' => 'Data tidak ditemukan!'
                ]
            ]);
        }

        $post['updated_at'] = now();

        if ($post) {
            foreach ($post as $key => $value) {
                $result->$key = $value;
            }
            $update = $result->save();
        }

        if ($update) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Berhasil merubah produk!'],
                'modal' => ['id' => '#kt_modal_product', 'action' => 'hide'],
                'datatable' => 'productTable'
            ]);
        }

        return response()->json([
            'status' => false,
            'alert' => ['message' => 'Gagal merubah data!'],
        ]);
    }

    // // CATEGORY
    public function insert_category(Request $request)
    {
        $arrVar = [
            'name' => 'Nama kategori',
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
            return response()->json(['status' => false, 'required' => $data['required']]);
        }
        $tujuan = public_path('data/category/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gambar tidak boleh kosong!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');
        $post['created_by'] = $id_user;

        // Insert ke database
        $insert = Category::create($post);

        if ($insert) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Berhasil menambahkan kategori!'],
                'modal' => ['id' => '#kt_modal_category', 'action' => 'hide'],
                'datatable' => 'categoryTable'
            ]);
        }

        return response()->json([
            'status' => false,
            'alert' => ['message' => 'Gagal menambahkan data!'],
        ]);
    }

    public function update_category(Request $request)
    {
        $arrVar = [
            'id_category' => 'ID Category',
            'name' => 'Nama kategori'
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
            return response()->json(['status' => false, 'required' => $data['required']]);
        }
         $tujuan = public_path('data/category/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        
        // Cek apakah data ada
        $result = Category::where("id_category", $id_category)->first();
        $name_image = $request->input('name_image');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
            unlink($tujuan . $result->image);
        } else {
            if (!$name_image || !File::exists($tujuan.$result->image) || !$result->image) {
                return response()->json([
                    'status' => false,
                    'alert' => ['message' => 'Gambar tidak boleh kosong!']
                ]);
            }
           
        }

        if (!$result) {
            return response()->json([
                'status' => 500,
                'alert' => [
                    'icon' => 'warning',
                    'message' => 'Data tidak ditemukan!'
                ]
            ]);
        }

        $post['updated_at'] = now();

        if ($post) {
            foreach ($post as $key => $value) {
                $result->$key = $value;
            }
            $update = $result->save();
        }

        if ($update) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Berhasil merubah kategori!'],
                'modal' => ['id' => '#kt_modal_category', 'action' => 'hide'],
                'datatable' => 'categoryTable'
            ]);
        }

        return response()->json([
            'status' => false,
            'alert' => ['message' => 'Gagal merubah data!'],
        ]);
    }





    // AJAX
    // // PRODUCT
    public function detail_product(Request $request)
    {
        $id = $request->id;
        if (!$id) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'id tidak boleh kosong!'],
            ]);
        }
        // Cek apakah data ada
        $result = Product::where("id_product", $id)->first();
        if (!$result) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Data tidak valid!'],
            ]);
        }

        $stock = Stock::where('id_product', $id)->orderBy('created_at', 'DESC')->get();
        $table = '';
        if ($stock->isEmpty()) {
            $table .= '<tr id="no_value_table">';
            $table .= '<td colspan="2"><center>Tidak ada data stock</center></td>';
            $table .= '</tr>';
        }else{
            foreach ($stock as $key) {
                $table .= '<tr>';
                $table .= '<td>'.date('d M Y H:i',strtotime($key->created_at)).'</td>';
                $table .= '<td>'.number_format($key->jumlah,0,',','.').'</td>';
                $table .= '</tr>';
            }
        }
        $data['detail'] = $result;
        $data['table'] = $table;

        return response()->json($data);
    }

    public function stock_product(Request $request)
    {
        $arrVar = [
            'id_product' => 'ID Produk',
            'jumlah' => 'Stock',
        ];

        $data = ['required' => [], 'arrAccess' => []];
        $post = [];

        // Validasi input satu per satu (sesuai dengan logika CI3-mu)
        foreach ($arrVar as $var => $label) {
            $$var = $request->input($var);
            if (!$$var) {
                $return['status'] = false;
                $return['alert']['message'] = $label.' tidak boleh kosong!';
                return response()->json($return);
            } else {
                $post[$var] = trim($$var);
                $data['arrAccess'][] = true;
            }
        }

        // CEK JUMLAH STOCK
        if ($jumlah <= 0) {
            $return['status'] = false;
            $return['alert']['message'] = 'Stok harus memiliki nilai lebih dari 0!';
            return response()->json($return);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');
        $post['created_by'] = $id_user;

        // Insert ke database
        $insert = Stock::create($post);

        if ($insert) {
            $new = '';
            $new .= '<tr>';
            $new .= '<td>'.date('d M Y H:i').'</td>';
            $new .= '<td>'.$jumlah.'</td>';
            $new .= '</tr>';
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Berhasil menambahkan stok!'],
                'datatable' => 'productTable',
                'newrow' => $new
            ]);
        }

        return response()->json([
            'status' => false,
            'alert' => ['message' => 'Gagal menambahkan stok!'],
        ]);
    }
}
