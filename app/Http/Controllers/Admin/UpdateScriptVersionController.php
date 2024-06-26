<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Support;
use Froiden\Envato\Helpers\Reply;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;


class UpdateScriptVersionController extends \Froiden\Envato\Controllers\UpdateScriptVersionController
{
    public $tmp_backup_dir = null;


    /*
 * Download and Install Update.
 */
    public function update()
    {
            $lastVersionInfo = $this->getLastVersion();
            if ($lastVersionInfo['version'] <= $this->getCurrentVersion()) {
                return Reply::error("Your System IS ALREADY UPDATED to latest version !");
            }

            try {
                $this->tmp_backup_dir = base_path() . '/backup_' . date('Ymd');

                $lastVersionInfo = $this->getLastVersion();

                $update_name = $lastVersionInfo['archive'];

                $filename_tmp = config('froiden_envato.tmp_path') . '/' . $update_name;


                if (file_exists($filename_tmp)) {
                    File::delete($filename_tmp); //delete old file if exist
                }

                // Clear cache when update button is clicked
                $this->configClear();
                return Reply::successWithData('Starting Download...', ['description' => $lastVersionInfo['description']]);


                $status = $this->install($lastVersionInfo['version'], $update_path, $lastVersionInfo['archive']);

                if ($status) {
                    echo '<p>&raquo; SYSTEM Mantence Mode => OFF</p>';
                    echo '<p class="text-success">SYSTEM IS NOW UPDATED TO VERSION: ' . $lastVersionInfo['version'] . '</p>';
                    echo '<p style="font-weight: bold;">RELOAD YOUR BROWSER TO SEE CHANGES</p>';
                } else
                    throw new \Exception("Error during updating.");

            } catch (\Exception $e) {
                echo '<p>ERROR DURING UPDATE (!!check the update archive!!) --TRY to restore OLD status ........... ';

                $this->restore();

                echo '</p>';
            }

    }

    public function setCurrentVersion($last)
    {
        File::put(public_path() . '/version.txt', $last); //UPDATE $current_version to last version
    }

    public function getLastVersion()
    {
        $client = new Client();
        $res = $client->request('GET', config('froiden_envato.updater_file_path'), ['verify' => false]);
        $lastVersion = $res->getBody();

        $content = json_decode($lastVersion, true);
        return $content; //['version' => $v, 'archive' => 'RELEASE-$v.zip', 'description' => 'plain text...'];
    }

    public function backup($filename)
    {
        $backup_dir = $this->tmp_backup_dir;

        if (!is_dir($backup_dir)) File::makeDirectory($backup_dir, $mode = 0755, true, true);
        if (!is_dir($backup_dir . '/' . dirname($filename))) File::makeDirectory($backup_dir . '/' . dirname($filename), $mode = 0755, true, true);

        File::copy(base_path() . '/' . $filename, $backup_dir . '/' . $filename); //to backup folder
    }

    public function restore()
    {
        if (!isset($this->tmp_backup_dir))
            $this->tmp_backup_dir = base_path() . '/backup_' . date('Ymd');

        try {
            $backup_dir = $this->tmp_backup_dir;
            $backup_files = File::allFiles($backup_dir);

            foreach ($backup_files as $file) {
                $filename = (string)$file;
                $filename = substr($filename, (strlen($filename) - strlen($backup_dir) - 1) * (-1));
                echo $backup_dir . '/' . $filename . " => " . base_path() . '/' . $filename;
                File::copy($backup_dir . '/' . $filename, base_path() . '/' . $filename); //to respective folder
            }

        } catch (\Exception $e) {
            echo "Exception => " . $e->getMessage();
            echo "<BR>[ FAILED ]";
            echo "<BR> Backup folder is located in: <i>" . $backup_dir . "</i>.";
            echo "<BR> Remember to restore System UP-Status through shell command: <i>php artisan up</i>.";
            return false;
        }

        echo "[ RESTORED ]";
        return true;
    }
}
