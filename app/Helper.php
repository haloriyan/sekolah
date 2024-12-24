<?php

use App\Models\Copywriting;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

function me($guard = 'admin') {
    return Auth::guard($guard)->user();
}
function copywriting($key) {
    return Copywriting::where('key', $key)->first();
}
function berita($limit = 5) {
    return News::orderBy('created_at', 'DESC')->take($limit)->get();
}
function generateMasonry($collection, $length = 4) {
    $columns = [];

    for ($i = 0; $i < $length; $i++) {
        $columns[] = [];
    }

    foreach ($collection as $index => $item) {
        $columnIndex = $index % $length; // Determine the current column index
        $columns[$columnIndex][] = $item;   // Add the item to the appropriate column
    }

    return $columns;
}
function logo($size = 46, $textSize = 'xl', $id = 'logo') {
    $logo = env('APP_LOGO');
    if ($logo == null) {
        return "<div id='{$id}' class='h-[{$size}px] w-[{$size}px] aspect-square bg-primary text-white text-{$textSize} rounded-lg object-cover flex items-center justify-center'><ion-icon name='school-outline'></ion-icon></div>";
    } else {
        $source = asset('images/' . env('APP_LOGO'));
        return "<img id='{$id}' src='{$source}' class='h-[{$size}px] w-[{$size}px] aspect-square rounded-lg object-cover'>";
    }
}
function Substring($text, $count) {
    $toReturn = substr($text, 0, $count);
    $rest = explode($toReturn, $text);
    if ($rest[1] != "") {
        $toReturn .= "...";
    }
    return $toReturn;
}

function RandomInt($length = 4) {
    $pattern = [0,1,2,3,4,5,6,7,8,9];
    $code = "";

    for ($i = 0; $i < $length; $i++) {
        $code .= $pattern[rand(0, count($pattern) - 1)];
    }

    return $code;
}

function like($needle, $haystack, $reversed = false) {
    if ($reversed) {
        $cond = strpos($needle, $haystack);
    } else {
        $cond = strpos($haystack, $needle);
    }
    return $cond === false ? false : true;
}

function changeConfig($name, $key, $value) {
    $filePath = config_path("$name.php");
    $config = include $filePath;
    $config[$key] = $value;
    $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";

    File::put($filePath, $content);
    return "ok";
}
function changeEnv($key, $newValue) {
    $path = base_path('.env');
    $oldValue = env($key);
    $newDelim = '';
    $oldDelim = '';

    if ($oldValue === $newValue) return;

    if (file_exists($path)) {
        if (like(' ', $newValue)) {
            $newDelim = '"';
        }
        if (like(' ', $oldValue)) {
            $oldDelim = '"';
        }

        $envContent = file_get_contents($path);
        $pattern = "/^" . preg_quote($key) . "=(.*)$/m";
        $replacement = $key . '=' . $newDelim . $newValue . $newDelim;

        if (preg_match($pattern, $envContent)) {
            // Replace the existing key
            $envContent = preg_replace(
                $pattern,
                $replacement,
                $envContent
            );
        } else {
            // Add the key if it doesn't exist
            $envContent .= PHP_EOL . $replacement;
        }

        file_put_contents($path, $envContent);
    }
}

function initial($name) {
    $names = explode(" ", $name);
    $toReturn = $names[0][0];
    if (count($names) > 1) {
        $toReturn .= $names[count($names) - 1][0];
    }

    return strtoupper($toReturn);
}

function currency_encode($angka, $currencyPrefix = '$', $thousandSeparator = ',', $zeroLabel = 'Gratis') {
    if ($angka == null) {
        return $zeroLabel;
    } else {
        return $currencyPrefix.' '.strrev(implode($thousandSeparator,str_split(strrev(strval($angka)),3)));
    }
}
function currency_decode($rupiah) {
    return intval(preg_replace("/,.*|[^0-9]/", '', $rupiah));
}
