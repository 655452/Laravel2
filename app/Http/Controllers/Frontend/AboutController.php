<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;

class AboutController extends FrontendController
{
   

    public function aboutUs()
    {
        return view('frontend.page.aboutUs');
    }
}
