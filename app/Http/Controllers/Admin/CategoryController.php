<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Enums\UserRole;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\CategoryStatus;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\BackendController;

class CategoryController extends BackendController
{


    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Categories';

        $this->middleware(['permission:category'])->only('index');
        $this->middleware(['permission:category_create'])->only('create', 'store');
        $this->middleware(['permission:category_edit'])->only('edit', 'update');
        $this->middleware(['permission:category_delete'])->only('destroy');

    }

    public function index(Request $request)
    {
        return $this->getCategory($request);
    }


    public function create()
    {
        return view('admin.category.create');
    }


    public function store(CategoryRequest $request)
    {
        $category              = new Category;
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->parent_id   = 0;
        $category->depth       = 0;
        $category->left        = 0;
        $category->right       = 0;
        $category->status      = $request->status ? $request->status : Status::INACTIVE;
        $category->save();

        //Store Image Media Libraty Spati
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }

        return redirect(route('admin.category.index'))->withSuccess('The data inserted successfully.');
    }


    public function edit($id)
    {
        $this->data['category'] = Category::owner()->findOrFail($id);
        return view('admin.category.edit', $this->data);
    }


    public function update(CategoryRequest $request, $id)
    {
        $category              = Category::owner()->findOrFail($id);
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->parent_id   = 0;
        $category->depth       = 0;
        $category->left        = 0;
        $category->right       = 0;
        $category->save();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $category->media()->delete($id);
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }

        return redirect(route('admin.category.index'))->withSuccess('The data updated successfully.');
    }


    public function destroy($id)
    {
        Category::owner()->findOrFail($id)->delete();
        return redirect(route('admin.category.index'))->withSuccess('The data deleted successfully.');
    }

    private function getCategory($request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            
            if(!auth()->user()->myrole == UserRole::ADMIN ){
                $queryArray['status'] = Status::ACTIVE;
            }

            if ((int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            if ((int) $request->requested) {
                $queryArray['requested'] = $request->requested;
            }

            $categories = Category::where($queryArray)->descending()->get();

            $i = 0;
            return Datatables::of($categories)
                ->addColumn('image', function ($category) {
                    return '<img alt="' . $category->name . '" src="' . $category->image . '" class="rounded-circle mr-1 avatar-item mb-0">';
                })
                ->addColumn('action', function ($category) {
                    $retAction = '';

                    if ($category->action_button) {
                        if (auth()->user()->can('category_edit')) {
                            $retAction .= '<a href="' . route('admin.category.edit', $category) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="far fa-edit"></i></a>';
                        }

                        if (auth()->user()->can('category_delete')) {
                            $retAction .= '<form id="detete-'.$category->id.'" class="float-left pl-2" action="' . route('admin.category.destroy', $category) . '"
                            method="POST">' . method_field('DELETE') . csrf_field() .
                            '<button type="button" data-id="'.$category->id.'"
                             class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                             <i class="fa fa-trash"></i>
                             </button></form>';
                        }
                    }
                    return $retAction;
                })
                ->editColumn('id', function ($category) use (&$i) {
                    return ++$i;
                })
                ->editColumn('status', function ($category) {
                    return trans('statuses.' . $category->status) ?? trans('statuses.' . CategoryStatus::INACTIVE);
                })
                ->editColumn('created_by', function ($category) {
                    return optional($category->creator)->name;
                })
                ->rawColumns(['image', 'action'])

                ->escapeColumns([])
                ->make(true);

        }
        return view('admin.category.index');
    }
}
