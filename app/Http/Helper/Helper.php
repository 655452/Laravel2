<?php

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

if (!function_exists('getCountry')) {
    function getCountry(Request $request){
        $ip = $request->ip();
        $ip ='103.72.212.130';
        $response = Http::get("http://ip-api.com/json/{$ip}");
        if ($response->successful()) {
            $location = $response->json();
            $country = $location['country'] ?? 'Unknown';
            return $country;
        } else {
            return 'Unknown';
        }
    }
}

if (!function_exists('pluck')) {
    function pluck($array, $value, $key = null)
    {
        $returnArray = [];
        if (count($array)) {
            foreach ($array as $item) {
                if ($key != null) {
                    $returnArray[$item->$key] = strtolower($value) == 'obj' ? $item : $item->$value;
                } else {
                    if ($value == 'obj') {
                        $returnArray[] = $item;
                    } else {
                        $returnArray[] = $item->$value;
                    }
                }
            }
        }

        return $returnArray;
    }
}


if (!function_exists('getCurrentVersion')) {
     function getCurrentVersion()
     {
         $version = File::get(public_path() . '/version.txt');
         return $version;
     }
}

if (!function_exists('isJson')) {
    function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}


if (!function_exists('orderAddress')) {
    function orderAddress($string)
    {
        if(isJson($string)){
            $address = json_decode($string,true);
            return isset($address['apartment']) ? 'Apartment : '.$address['apartment'].','.$address['address'] : $address['address'];
        }
        return $string;
    }
}


if (!function_exists('currencyFormat')) {
    function currencyFormat($currency)
    {
        return Setting::get('currency_code') . number_format($currency, 2);
    }
}

if (!function_exists('currencyName')) {
    function currencyName($currency)
    {
        return Setting::get('currency_name') . ' ' . $currency;
    }
}

if (!function_exists('currencyFormatWithName')) {
    function currencyFormatWithName($currency)
    {
        return number_format($currency, 2) . ' ' . Setting::get('currency_name');
    }
}

if (!function_exists('transactionCurrencyFormat')) {
    function transactionCurrencyFormat($transaction)
    {
        $amount = '+ ' . $transaction->amount;
        if ($transaction->source_balance_id == auth()->user()->balance_id) {
            $amount = '- ' . $transaction->amount;
        }
        return $amount;
    }
}

if (!function_exists('settingLogo')) {
    function settingLogo()
    {
        return asset("images/" . setting('site_logo'));
    }
}

if (!function_exists('food_date_format')) {
    function food_date_format($date)
    {
        return \Carbon\Carbon::parse($date)->format('d M Y h:i A');
    }
}

if (!function_exists('food_date_format_with_day')) {
    function food_date_format_with_day($date)
    {
        return \Carbon\Carbon::parse($date)->format('l, d M Y h:i A');
    }
}

/**
 * Get domain (host without sub-domain)
 *
 * @param null $url
 * @return string
 */
function getDomain($url = null)
{
    if (!empty($url)) {
        $host = parse_url($url, PHP_URL_HOST);
    } else {
        $host = getHost();
    }

    $tmp = explode('.', $host);
    if (count($tmp) > 2) {
        $itemsToKeep = count($tmp) - 2;
        $tlds        = config('tlds');
        if (isset($tmp[$itemsToKeep]) && isset($tlds[$tmp[$itemsToKeep]])) {
            $itemsToKeep = $itemsToKeep - 1;
        }
        for ($i = 0; $i < $itemsToKeep; $i++) {
            \Illuminate\Support\Arr::forget($tmp, $i);
        }
        $domain = implode('.', $tmp);
    } else {
        $domain = @implode('.', $tmp);
    }

    return $domain;
}

/**
 * Get host (domain with sub-domain)
 *
 * @param null $url
 * @return array|mixed|string
 */
function getHost($url = null)
{
    if (!empty($url)) {
        $host = parse_url($url, PHP_URL_HOST);
    } else {
        $host = (trim(request()->server('HTTP_HOST')) != '') ? request()->server('HTTP_HOST') : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    }

    if ($host == '') {
        $host = parse_url(url()->current(), PHP_URL_HOST);
    }

    return $host;
}

function isValidJson($string)
{
    try {
        json_decode($string);
    } catch (\Exception $e) {
        return false;
    }

    return (json_last_error() == JSON_ERROR_NONE);
}

function generateUsername($email)
{
    $emails = explode('@', $email);
    return $emails[0] . mt_rand();
}

if (!function_exists('domain')) {
    function domain($input)
    {
        $input = trim($input, '/');
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }
        $urlParts = parse_url($input);

        $link = '';
        if (isset($urlParts['port'])) {
            $link .= ':' . $urlParts['port'];
        }

        if (isset($urlParts['path'])) {
            $link .= $urlParts['path'];
        }

        return preg_replace('/^www\./', '', ($urlParts['host'] . $link));
    }
}

if (!function_exists('add_http')) {
    function add_http($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }
}


