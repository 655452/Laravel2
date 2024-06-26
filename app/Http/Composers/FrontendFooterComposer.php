<?php

namespace App\Http\Composers;

use App\Enums\Status;
use App\Models\Language;
use App\Models\Page;
use Illuminate\View\View;

class FrontendFooterComposer
{
    public function compose(View $view)
    {
        $view->with('footermenus', Page::where('status',Status::ACTIVE)->get());
        $view->with('language', Language::where('status', Status::ACTIVE)->get());

    }
}
