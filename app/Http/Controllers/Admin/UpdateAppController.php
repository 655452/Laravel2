<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;


class UpdateAppController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Update Log';

        // $this->middleware(['permission:update'])->only('index');
      
    }
    public function index(Request $request)
    {
        return view('admin.update.index');

    }
}
