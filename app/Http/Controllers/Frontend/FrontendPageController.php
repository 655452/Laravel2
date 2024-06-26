<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Status;
use App\Http\Controllers\FrontendController;
use App\Models\Page;

class FrontendPageController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = setting('site_name');
    }

    public function index($slug)
    {
        $page = Page::where(['slug'=> $slug,'status'=>Status::ACTIVE])->first();
        if (blank($page)) {
            abort(404);
        }

        $this->data['page'] = $page;

        $pageName = 'default';
        if ($page->template_id == 2) {
            $pageName = 'about';
        } else if ($page->template_id == 3) {
            $pageName = 'contact';
        }

        $pageName = 'frontend.page.' . $pageName;

        return view($pageName, $this->data);
    }
}
