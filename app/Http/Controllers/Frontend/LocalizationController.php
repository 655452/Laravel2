<?php

namespace App\Http\Controllers\Frontend;
use App;
use App\Http\Controllers\FrontendController;
use Illuminate\Http\RedirectResponse;

class LocalizationController extends FrontendController
{
    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function index($locale)
    {
        session()->put('applocale', $locale);

        return redirect()->back();
    }
}
