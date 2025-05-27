<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function forgot(Request $request)
    {
        $token = $request->token;
        $data['view'] = false;

        if ($token) {
            $decoded = base64url_decode($token);
            $arr = explode('|', $decoded);
            if (count($arr) !== 3) return redirect()->route('forgot');

            [$email, $id_user, $expire] = $arr;

            if (strtotime($expire) < time()) {
                return redirect()->route('forgot');
            }

            $user = User::where('id_user', $id_user)->where('email', $email)->where('deleted', 'N')->where('status', 'Y')->first();
            if (!$user) return redirect()->route('forgot');

            $data['view'] = true;
            $data['email'] = $email;
            $data['user'] = $user;
        }

        return view('auth.forgot', $data);
    }

    public function loginProses(Request $request)
    {
        $email = strtolower($request->email);
        $password = $request->password;

        if (!$email || !$password) {
            return response()->json(['status' => 700, 'message' => 'Email dan kata sandi wajib diisi.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Format email tidak valid.']);
        }

        $user = User::where('email', $email)->where('deleted', 'N')->first();
        if (!$user) {
            return response()->json(['status' => 500, 'message' => 'Email tidak ditemukan.']);
        }

        if ($user->status == 'N') {
            $alasan = $user->reason ? ' Alasan: <b>"' . $user->reason . '"</b>' : '';
            return response()->json(['status' => 700, 'message' => 'Akun anda diblokir.' . $alasan]);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json(['status' => 500, 'message' => 'Kata sandi salah.']);
        }

        Auth::login($user);
        $prefix = config('session.prefix');

        Session::put([
            "{$prefix}_id_user" => $user->id_user,
            "{$prefix}_id_role" => $user->role,
            "{$prefix}_name" => $user->name,
            "{$prefix}_email" => $user->email,
            "{$prefix}_phone" => $user->phone,
            "{$prefix}_image" => $user->image,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil login. Selamat datang ' . $user->name,
            'redirect' => url('/dashboard')
        ]);
    }

    public function registerProses(Request $request)
    {
        if (!$request->isMethod('post')) return redirect()->route('login');

        $email = strtolower($request->email);
        $name = $request->name;
        $password = $request->password;
        $repassword = $request->repassword;
        $question = $request->question;
        $answer = $request->answer;

        $setting = app('setting');
        if (User::count() >= $setting->limit) {
            return response()->json(['status' => 500, 'message' => 'Pendaftaran sudah mencapai batas.']);
        }

        if (!$email || !$name || !$password || !$repassword || !$question || !$answer) {
            return response()->json(['status' => 500, 'message' => 'Semua field wajib diisi.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Format email tidak valid.']);
        }

        if ($password !== $repassword) {
            return response()->json(['status' => 500, 'message' => 'Konfirmasi password tidak cocok.']);
        }

        if (User::whereRaw('LOWER(name) = ?', [strtolower($name)])->where('deleted', 'N')->exists()) {
            return response()->json(['status' => 500, 'message' => 'Nama sudah digunakan.']);
        }

        if (User::whereRaw('LOWER(email) = ?', [$email])->where('deleted', 'N')->exists()) {
            return response()->json(['status' => 500, 'message' => 'Email sudah digunakan.']);
        }

        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password),
            'question' => $question,
            'answer' => $answer,
        ]);

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'Pendaftaran berhasil. Silakan login.',
                'redirect' => route('login'),
            ]);
        }

        return response()->json(['status' => 700, 'message' => 'Gagal mendaftar. Silakan coba lagi.']);
    }

    public function forgotProses(Request $request)
    {
        $email = strtolower($request->email);

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Email tidak valid.']);
        }

        $user = User::where('email', $email)->where('deleted', 'N')->first();
        if (!$user) {
            return response()->json(['status' => 500, 'message' => 'Email tidak ditemukan.']);
        }

        if ($user->status == 'N') {
            $alasan = $user->reason ? ' Alasan: <b>"' . $user->reason . '"</b>' : '';
            return response()->json(['status' => 700, 'message' => 'Akun diblokir.' . $alasan]);
        }

        $token = base64url_encode($user->email . '|' . $user->id_user . '|' . date('YmdHis', strtotime('+60 minutes')));

        return response()->json([
            'status' => 200,
            'message' => 'Link reset berhasil dikirim.',
            'redirect' => url('/forgot-password?token=' . $token)
        ]);
    }

    public function confirmProses(Request $request)
    {
        $id_user = $request->id_user;
        $answer = strtolower($request->answer);

        if (!$id_user || !$answer) {
            return response()->json(['status' => 700, 'message' => 'Data tidak lengkap.']);
        }

        $user = User::where('id_user', $id_user)->whereRaw('LOWER(answer) = ?', [$answer])->first();

        return $user
            ? response()->json(['status' => 200])
            : response()->json(['status' => 500, 'message' => 'Jawaban pemulihan salah.']);
    }

    public function ubahPassword(Request $request)
    {
        $password = $request->password;
        $repassword = $request->repassword;
        $id_user = $request->id_user;

        if (!$password || !$repassword || !$id_user) {
            return response()->json(['status' => false, 'alert' => ['message' => 'Semua field wajib diisi.']]);
        }

        if ($password !== $repassword) {
            return response()->json(['status' => false, 'alert' => ['message' => 'Konfirmasi kata sandi salah.']]);
        }

        $user = User::where('id_user', $id_user)->first();
        if (!$user) {
            return response()->json(['status' => false, 'alert' => ['message' => 'User tidak ditemukan.']]);
        }

        $user->password = Hash::make($password);
        $user->updated_at = now();
        $user->save();

        return response()->json([
            'status' => true,
            'alert' => ['message' => 'Berhasil mengganti kata sandi.'],
            'redirect' => url('/login')
        ]);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/login');
    }
}
