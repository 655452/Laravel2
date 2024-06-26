<?php

namespace App\Http\Functions;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class EnvatoUpdate extends \Froiden\Envato\Functions\EnvatoUpdate {

     public static function updateVersionInfo()
    {
        $updateVersionInfo = [];
        try {
            $client = new Client();
            // Get Data from server for download files
            $res = $client->request('GET', config('froiden_envato.updater_file_path'), ['verify' => false]);
            $lastVersion = $res->getBody();
            $lastVersion = json_decode($lastVersion, true);
            if ($lastVersion['version'] > File::get('version.txt')) {
                $updateVersionInfo['lastVersion'] = $lastVersion['version'];
                $updateVersionInfo['updateInfo'] = $lastVersion['description'];
            }
            $updateVersionInfo['updateInfo'] = $lastVersion['description'];

        } catch (\Exception $e) {
        }

       try{
            // Get data of Logs
            $resLog = $client->request('GET', config('froiden_envato.versionLog'), ['verify' => false]);
            $lastVersionLog = json_decode($resLog->getBody(), true);
            foreach ($lastVersionLog as $item) {
                // Ignore duplicate of latest version
                $releaseDate = $item['release_date']?' (Release date: '. Carbon::parse($item['release_date'])->format('d M Y').')':'';
                if (version_compare($item['version'], $lastVersion['version']) == 0) {
                    $updateVersionInfo['updateInfo'] = '<strong class="version-update-heading">Version: ' . $item['version'] .$releaseDate. '</strong>' . $item['description'];
                    continue;
                };
                $updateVersionInfo['updateInfo'] .= '<strong class="version-update-heading">Version: ' . $item['version'] .$releaseDate. '</strong>' . $item['description'];
            }
        } catch (\Exception $e) {
        }

        $updateVersionInfo['appVersion'] = File::get('version.txt');
        $laravel = app();
        $updateVersionInfo['laravelVersion'] = $laravel::VERSION;
        return $updateVersionInfo;
    }


}
