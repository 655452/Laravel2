<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->data['site_title'] = 'Home';
        if (!file_exists(storage_path('installed'))) {
            return redirect('/install');
        }
    }
}
