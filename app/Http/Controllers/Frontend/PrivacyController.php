<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;

class PrivacyController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'privacy';
    }

    public function __invoke()
    {
        return view('frontend.privacy', $this->data);
    }
}
