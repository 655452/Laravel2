<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductRequested;
use App\Enums\ProductStatus;
use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\RequestProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class RequestProductController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Request Products';
        $this->middleware([ 'permission:request-products' ])->only('index');
        $this->middleware([ 'permission:request-products_create' ])->only('create', 'store');
        $this->middleware([ 'permission:request-products_edit' ])->only('edit', 'update');
        $this->middleware([ 'permission:request-products_delete' ])->only('destroy');
        $this->middleware([ 'permission:request-products_show' ])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.request-product.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['categories'] = Category::where([ 'status' => Status::ACTIVE ])->get();
        return view('admin.request-product.create', $this->data);
    }

    /**
     * @param RequestProductRequest $request
     *
     * @return mixed
     */
    public function store( RequestProductRequest $request )
    {
        $product              = new Product;
        $product->name        = $request->get('name');
        $product->description = $request->get('description');
        $product->status      = Status::INACTIVE;
        $product->unit_price  = $request->get('unit_price');
        $product->requested   = ProductRequested::REQUESTED;
        $product->save();
        $product->categories()->sync($request->get('categories'));
        //Store Image
        if ( !blank($request->input('document')) ) {
            foreach ( $request->input('document', []) as $file ) {
                $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('products');
            }
        }
        return redirect()->route('admin.request-products.index')->withSuccess('The data inserted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show( $id )
    {
        $queryArray['requested']  = ProductRequested::REQUESTED;
        $queryArray['creator_id'] = auth()->id();
        $this->data['product']    = Product::where($queryArray)->findOrFail($id);
        return view('admin.request-product.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( $id )
    {
        $queryArray['status']             = Status::INACTIVE;
        $queryArray['requested']          = ProductRequested::REQUESTED;
        $queryArray['creator_id']         = auth()->id();
        $product                          = Product::where($queryArray)->findOrFail($id);
        $this->data['product']            = $product;
        $this->data['categories']         = Category::where([ 'status' => Status::ACTIVE ])->get();
        $this->data['product_categories'] = $product->categories()->pluck('id')->toArray();
        return view('admin.request-product.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RequestProductRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function update( RequestProductRequest $request, $id )
    {
        $queryArray['status']     = Status::INACTIVE;
        $queryArray['requested']  = ProductRequested::REQUESTED;
        $queryArray['creator_id'] = auth()->id();
        $product                  = Product::where($queryArray)->findOrFail($id);
        $product->name            = $request->get('name');
        $product->description     = $request->get('description');
        $product->unit_price      = $request->get('unit_price');
        $product->save();
        $product->categories()->sync($request->get('categories'));
        return redirect()->route('admin.request-products.index')->withSuccess('The data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $queryArray['status']     = Status::INACTIVE;
        $queryArray['requested']  = ProductRequested::REQUESTED;
        $queryArray['creator_id'] = auth()->id();
        Product::where($queryArray)->findOrFail($id)->delete();
        return redirect()->route('admin.request-products.index')->withSuccess('The data deleted successfully');
    }

    public function getRequestProduct( Request $request )
    {
        if ( request()->ajax() ) {
            $queryArray['requested']  = ProductRequested::REQUESTED;
            $queryArray['creator_id'] = auth()->id();
            $products                 = Product::with('categories')->where($queryArray)->latest()->get();
            $i                        = 1;
            $requestProductArray      = [];
            if ( !blank($products) ) {
                foreach ( $products as $product ) {
                    $requestProductArray[ $i ]          = $product;
                    $requestProductArray[ $i ]['setID'] = $i;
                    $i++;
                }
            }
            return Datatables::of($requestProductArray)->addColumn('action', function( $product ) {
                $retAction = '';
                if ( auth()->user()->can('request-products_show') ) {
                    $retAction .= '<a href="' . route('admin.request-products.show', $product) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }
                if ( $product->status == Status::INACTIVE ) {
                    if ( auth()->user()->can('request-products_edit') ) {
                        $retAction .= '<a href="' . route('admin.request-products.edit', $product) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }
                    if ( auth()->user()->can('request-products_delete') ) {
                        $retAction .= '<form id="detete-'.$product->id.'"  class="float-left pl-2" action="' . route('admin.request-products.destroy', $product) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                        '<button type="button" data-id="'.$product->id.'"
                        class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                        <i class="fa fa-trash"></i>
                        </button></form>';
                    }
                }
                return $retAction;
            })->editColumn('categories', function( $product ) {
                $categories = implode(', ', $product->categories()->pluck('name')->toArray());
                return Str::limit($categories, 30);
            })->editColumn('status', function( $product ) {
                return ($product->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
            })->editColumn('created_at', function( $product ) {
                return $product->created_at->diffForHumans();
            })->editColumn('id', function( $product ) {
                return $product->setID;
            })->rawColumns([
                'name',
                'action'
            ])->make(true);
        }
    }

    public function storeMedia( Request $request )
    {
        $path = storage_path('tmp/uploads');
        if ( !file_exists($path) ) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function updateMedia( Request $request, Product $product )
    {
        $path = storage_path('tmp/uploads');
        if ( !file_exists($path) ) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
        $product->addMedia($path . '/' . $name)->toMediaCollection('products');
        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteMedia( Request $request )
    {
        $path = storage_path('tmp/uploads/' . $request->filename);
        if ( file_exists($path) ) {
            unlink($path);
        }
    }

    public function getMedia( Request $request )
    {
        $product   = Product::where('status', ProductStatus::INACTIVE)->find($request->id);
        $addMedias = $product->getMedia('products');
        $retArr    = [];
        if ( count($addMedias) ) {
            $i = 0;
            foreach ( $addMedias as $addMedia ) {
                $i++;
                $retArr[ $i ]['name'] = $addMedia->file_name;
                $retArr[ $i ]['size'] = $addMedia->size;
                $retArr[ $i ]['url']  = asset($addMedia->getUrl());
            }
        }
        echo json_encode($retArr);
    }

    public function removeMedia( Request $request )
    {
        $product = Product::find($request->id);
        $product->deleteMedia($product, $request->media, $request->id);
        return $this->getMedia($request);
    }
}
