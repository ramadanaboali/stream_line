<?php

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}
if (!function_exists('general_setting')) {
    function general_setting($key)
    {
        return Setting::where('key', $key)->first()?->value;
    }
}

if (!function_exists('api_asset')) {
    function api_asset($id)
    {
        if (($asset = \App\Models\Media::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return "";
    }
}
if (!function_exists('getGovernment')) {
    function getGovernment($id = 0)
    {
        return $id == 0 ? '---' : (getGovernments()[$id] ?? '---');
    }
}
if (!function_exists('getGovernments')) {
    function getGovernments()
    {
        return [
            1 => 'القاهرة',
            2 => 'الجيزة',
            3 => 'الشرقية',
            4 => 'الدقهلية',
            5 => 'البحيرة',
            6 => 'المنيا',
            7 => 'القليوبية',
            8 => 'الإسكندرية',
            9 => 'الغربية',
            10 => 'سوهاج',
            11 => 'أسيوط',
            12 => 'المنوفية',
            13 => 'كفر الشيخ',
            14 => 'الفيوم',
            15 => 'قنا',
            16 => 'بني سويف',
            17 => 'أسوان',
            18 => 'دمياط',
            19 => 'الإسماعيلية',
            20 => 'الأقصر',
            21 => 'بورسعيد',
            22 => 'السويس',
            23 => 'مطروح',
            24 => 'شمال سيناء',
            25 => 'البحر الأحمر',
            26 => 'الوادي الجديد',
            27 => 'جنوب سيناء',
            28 => 'أطراف القاهرة والجيزة'
        ];
    }
}

if (!function_exists('multi_asset')) {
    function multi_asset($Ids)
    {
        $assets = Media::whereIn('id', $Ids)->get();

        if ((isset($assets))) {
            foreach ($assets as $key => $asset) {
                $files[$key]['name'] = $asset->file_original_name;
                $files[$key]['path'] = my_asset($asset->file_name);
                $files[$key]['ext'] = $asset->extension;
            }

            return $files;
        }

        return "";
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = \App\Models\Media::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return null;
    }
}

//return file uploaded via uploader
if (!function_exists('first_asset')) {
    function first_asset($str)
    {
        if (!empty($str)) {
            $numbers = array_filter(preg_split("/\D+/", $str));
            $first_num = reset($numbers);
            if (($asset = \App\Models\Media::find($first_num)) != null) {
                return my_asset($asset->file_name);
            }
        }
        return null;
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return $url = url('/') . \Illuminate\Support\Facades\Storage::url($path);
            return app('url')->asset('/' . $path, $secure);
        }
    }
}

if (!function_exists('upload')) {
    function upload($file, $disk = '', $folder = '', $path = '')
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if (isset($file)) {
            $extension = strtolower($file->getClientOriginalExtension());
            $name = explode('.', $file->getClientOriginalName());

            if (isset($type[$extension])) {
                if ($disk == 'spaces') {
                    $filePath = '/' . $folder;
                    $spaceImage = Storage::disk('spaces')->put($filePath, $file, 'public');
                    return $spaceImage;
                }

                $upload = \App\Models\Media::updateOrCreate([
                    'file_original_name' => $name[0],
                    'type' => $type[$extension],
                    'file_size' => $file->getSize(),
                    'user_id' => Auth::check() ? request()->user()->id : 0,
                ], [
                    'file_original_name' => $name[0],
                    'type' => $type[$extension],
                    'file_name' => $file->store('/public'),
                    'user_id' => Auth::check() ? request()->user()->id : 0,
                    'file_size' => $file->getSize(),
                    'extension' => $extension,
                ]);

                return $upload->id;
            }
        }
        return null;
    }
}

if (!function_exists('getSpaceUrl')) {
    function getSpaceUrl($img)
    {
        return 'https://' . env('DO_SPACES_BUCKET') . '/' . $img;
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        $setting = Cache::remember('setting-' . $key, 86400, function () use ($key) {
            return \App\Models\Setting::where('key', $key)->first();
        });

        return $setting == null || empty($setting) ? $default : $setting->value;
    }
}

if (!function_exists('randomFromNumbers')) {
    function randomFromNumbers($times, $numbersArr)
    {
        if (count($numbersArr) > 0) {
            $random = [];
            for ($i = 0; $i < $times; $i++) {
                if ($i + 1 > count($numbersArr) && count($numbersArr) > 3) {
                    break;
                }
                $randKey = array_rand($numbersArr);
                $randNumber = $numbersArr[$randKey];
                if (($key = array_search($randNumber, $numbersArr)) !== false) {
                    unset($numbersArr[$key]);
                }
                $random[] = $randNumber;
            }
            return $random;
        }
        return [];
    }
}

if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url)
    {
        $youtube_id = '';
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        $fullEmbedUrl = 'https://www.youtube.com/embed/' . $youtube_id;
        return $fullEmbedUrl;
    }
}

function strip_only($str, $tags, $stripContent = false)
{
    $content = '';
    if (!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if (end($tags) == '') {
            array_pop($tags);
        }
    }
    foreach ($tags as $tag) {
        if ($stripContent) {
            $content = '(.+</' . $tag . '[^>]*>|)';
        }
        $str = preg_replace('#</?' . $tag . '[^>]*>' . $content . '#is', '', $str);
    }
    return $str;
}

function number_category($number)
{
    if ($number <= 10) {
        return 'A';
    } elseif ($number <= 20) {
        return 'B';
    } elseif ($number <= 30) {
        return 'C';
    } elseif ($number <= 40) {
        return 'D';
    } elseif ($number <= 50) {
        return 'E';
    } elseif ($number <= 60) {
        return 'F';
    } elseif ($number <= 70) {
        return 'G';
    } elseif ($number <= 80) {
        return 'H';
    } elseif ($number <= 90) {
        return 'I';
    } elseif ($number <= 100) {
        return 'J';
    } elseif ($number <= 110) {
        return 'K';
    } elseif ($number <= 120) {
        return 'L';
    } elseif ($number <= 130) {
        return 'M';
    } elseif ($number <= 140) {
        return 'N';
    } elseif ($number <= 150) {
        return 'O';
    } elseif ($number <= 160) {
        return 'P';
    } elseif ($number <= 170) {
        return 'Q';
    } elseif ($number <= 180) {
        return 'R';
    } elseif ($number <= 190) {
        return 'S';
    } elseif ($number <= 200) {
        return 'T';
    } elseif ($number <= 210) {
        return 'U';
    } elseif ($number <= 220) {
        return 'V';
    } elseif ($number <= 230) {
        return 'W';
    } elseif ($number <= 240) {
        return 'X';
    } elseif ($number <= 250) {
        return 'Y';
    } elseif ($number <= 260) {
        return 'Z';
    }
    return '';
}

function encryptText($string, $encrypt = true)
{
    $secret_key = 'Cb9eGT2s#~';
    $secret_iv  = '3#t;fV._N[';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($encrypt) {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

if (!function_exists('apiResponse')) {
    function apiResponse($success = false, $data = null, $message = '', $errors = null, $code = 200, $version = 1)
    {
        $response = [
            'version' => $version,
            'success' => $success,
            'status'  => $code,
            'data'    => $data,
            'message' => $message,
            'errors'  => $errors,
        ];
        return response()->json($response, $code);
    }
}

if (!function_exists('welcomeMessage')) {
    function welcomeMessage()
    {
        $time = date("H");
        $timezone = date("e");
        if ($time < "12") {
            return __('admin.good_morning');
        } elseif ($time >= "12" && $time < "17") {
            return __('admin.good_afternoon');
        } else {
            if ($time >= "17" && $time < "19") {
                return __('admin.good_evening');
            } elseif ($time >= "19") {
                return __('admin.good_night');
            }
        }
        return "";
    }
}

if (!function_exists('convertArabicNumbers')) {
    function convertArabicNumbers($string)
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $num = range(0, 9);

        return str_replace($arabic, $num, $string);
    }
}
if (!function_exists('storeFile')) {
    function storeFile($file, $destination)
    {
        $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/'.$destination), $fileName);
        return $fileName;
    }
}

function generateUserUniqueCode(): ?string
{
    $code = mt_rand(1, 1000000);
    if (User::where('code', $code)->exists()) {
        generateUserUniqueCode();
    }
    return $code;
}

function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
