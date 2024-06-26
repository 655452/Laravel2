<?php

namespace App\Libraries;


class ComposerLibrary {
    private static function response($data)
    {
        return (object) $data;
    }
    public static function run($command)
    {
        $response['status'] = false;
        try {
            app()->make(\App\Composer::class)->run([$command]);
            $response['status'] = true;
        } catch ( \Exception $e ) {
            $response['message'] = 'composer run error';
        }
        return self::response($response);
    }
}

