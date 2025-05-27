<?php

use Illuminate\Support\Facades\File;

if (!function_exists('image_check')) {
    function image_check($image = null, $path = null, $rename = null)
    {
        $defaultImage = $rename ? $rename : 'notfound';
        $path = $path ?? 'error';  // Default 'error' kalau $path kosong

        if (!$image) {
            $file = "default/{$defaultImage}.jpg";
        } else {
            $filePath = public_path("data/{$path}/{$image}"); // Path ke file

            if (File::exists($filePath)) {
                $file = "{$path}/{$image}";
            } else {
                $file = "default/{$defaultImage}.jpg";
            }
        }

        return asset("data/{$file}"); // URL lengkap untuk diakses
    }
}

if (!function_exists('ckeditor_check')) {
    function ckeditor_check($content = '')
    {
    // Hapus semua tag HTML
    $clean_content = strip_tags($content, '<p><br>'); // Biarkan <p> dan <br> untuk diproses lebih lanjut
    // Hapus tag <p><br></p> yang sering muncul sebagai konten kosong
    $clean_content = preg_replace('/<p>(&nbsp;|\s|<br>|<\/?p>)*<\/p>/i', '', $clean_content);
    // Hapus whitespace yang tersisa
    $clean_content = trim($clean_content);

    return $clean_content;
    }
}

if (!function_exists('short_text')) {
    function short_text($text, $batas = 5, $pengganti = '...', $link = '')
    {
        if (strlen($text) > $batas) {
            return substr($text, 0, $batas) . $pengganti;
        }
        return $text;
    }
}


if (!function_exists('get_role')) {
    function get_role($role = 99, $ambil = [])
    {
        $arr = [
            0 => 'role tidak di ketahui',
            1 => 'admin',
            2 => 'customer'
        ];

        if (isset($arr[$role])) {
            return $arr[$role];
        } else {
            if (is_array($ambil) && count($ambil) > 0) {
                $d = [];
                foreach ($ambil as $index) {
                    if (isset($arr[$index])) {
                        $d[$index] = $arr[$index];
                    }
                }
                return $d;
            } else {
                return $arr;
            }
        }
    }
}

if (!function_exists('phone_format')) {
    function phone_format($phoneNumber)
    {
        // Hapus karakter selain angka
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Pastikan nomor memiliki minimal 10 digit
        if (strlen($phoneNumber) >= 10) {
            return sprintf("(%s) %s-%s",
                substr($phoneNumber, 0, 4),
                substr($phoneNumber, 4, 4),
                substr($phoneNumber, 8, 6)
            );
        }

        return "Invalid phone number";
    }
}

if (!function_exists('set_submenu_active')) {
    function set_submenu_active($controller, $arrTarget = [], $c2 = '', $arrTarget2 = [], $class = 'active', $exc = '') {
        if ($controller && in_array($controller, $arrTarget)) {
            if ($c2) {
                return in_array($c2, $arrTarget2) ? $class : $exc;
            }
            return $exc;
        }
        return $exc;
    }
}


if (!function_exists('rupiah')) {
    function rupiah($angka, $format = "Rp. ") {
        return $format . number_format($angka, 0, ',', '.');
    }
}


if (!function_exists('base64url_encode')) {
    function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

if (!function_exists('base64url_decode')) {
    function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}


if (!function_exists('getMonthById')) {
    function getMonthById($id)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $months[$id] ?? 'Bulan tidak valid';
    }
}
