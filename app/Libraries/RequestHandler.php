<?php

namespace App\Libraries;



class RequestHandler
{

    public static function get_data($response)
    {
        $header      = explode(';', $response->getHeader('Content-Type')[0]);
        $contentType = $header[0];
        if ( $contentType == 'application/json' ) {
            $contents = $response->getBody()->getContents();
            $data     = json_decode($contents);
            if ( json_last_error() == JSON_ERROR_NONE ) {
                return $data;
            }
            return $contents;
        }

        return [ 'status' => false, 'message' => 'data not found'];
    }



}
