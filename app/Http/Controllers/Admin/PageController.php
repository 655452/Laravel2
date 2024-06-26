<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Enums\Status;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\FooterMenuSection;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\BackendController;

class PageController extends BackendController
{
    public $notDeleteArray = [1, 2, 3];

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Pages';

        $this->middleware(['permission:page'])->only('index');
        $this->middleware(['permission:page_create'])->only('create', 'store');
        $this->middleware(['permission:page_edit'])->only('edit', 'update');
        $this->middleware(['permission:page_delete'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.page.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['footer_menu_sections'] = FooterMenuSection::all();
        $this->data['templates']            = Template::all();
        return view('admin.page.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $page                         = new Page;
        $page->title                  = $request->title;
        $page->description            = $request->description;
        $page->footer_menu_section_id = $request->footer_menu_section_id;
        $page->template_id            = $request->template_id;
        $page->status                 = $request->status;
        $page->save();

        return redirect(route('admin.page.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['page']                 = Page::findOrFail($id);
        $this->data['footer_menu_sections'] = FooterMenuSection::all();
        $this->data['templates']            = Template::all();
        return view('admin.page.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {

        $page                         = Page::findOrFail($id);
        $page->title                  = $request->title;
        $page->description            = $request->description;
        $page->footer_menu_section_id = $request->footer_menu_section_id;
        $page->template_id            = $request->template_id;
        $page->status                 = $request->status;
        $page->save();

        return redirect(route('admin.page.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (in_array($id, $this->notDeleteArray)) {
            return redirect(route('admin.page.index'))->withError('This data does not have permission to delete');
        }
        Page::findOrFail($id)->delete();
        return redirect(route('admin.page.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getPage(Request $request)
    {
        if (request()->ajax()) {
            $pages = Page::with('footer_menu_section', 'template')->descending()->select();

            $i = 0;
            return Datatables::of($pages)
                ->addColumn('action', function ($page) {
                    $retAction = '';

                    if (auth()->user()->can('page_edit')) {
                        $retAction .= '<a href="' . route('admin.page.edit', $page) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('page_delete') && (!in_array($page->id, $this->notDeleteArray))) {
                        $retAction .= '<form id="detete-'.$page->id.'" class="float-left pl-2" action="' . route('admin.page.destroy', $page) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                         '<button type="button" data-id="'.$page->id.'"
                         class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                         <i class="fa fa-trash"></i>
                         </button></form>';
                    }

                    return $retAction;
                })
                ->editColumn('footer_menu_section_id', function ($page) {
                    return Str::limit($page->footer_menu_section->name ?? null, 30);
                })
                ->editColumn('template_id', function ($page) {
                    return ucfirst($page->template->name);
                })
                ->editColumn('status', function ($page) {
                    return $page->status == Status::ACTIVE ? trans('statuses.'.Status::ACTIVE) : trans('statuses.'.Status::INACTIVE) ;
                })

                ->editColumn('title', function ($page) {
                    return Str::limit(strip_tags($page->title), 40);
                })
                ->editColumn('id', function ($page) use (&$i) {
                    return ++$i;
                })
                ->make(true);
        }
    }
}
