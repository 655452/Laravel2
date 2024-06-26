<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Collection;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CollectionRequest;
use App\Http\Services\CollectionService;
use App\Http\Controllers\BackendController;

class CollectionController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Collections';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.collection.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $role = Role::find(4);
        $this->data['users'] = User::role($role->name)->get();
        return view('admin.collection.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( CollectionRequest $request ){
       
        $parsedDate = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $collectionService = app(CollectionService::class)->createCollection($request->user_id, $request->amount);
        if ( $collectionService->status ) {
            $collection                  = new Collection;
            $collection->user_id         = $request->user_id;
            $collection->date            = $parsedDate;
            $collection->amount          = $request->amount;
            $collection->delivery_charge = $collectionService->amount;
            $collection->save();
            return redirect(route('admin.collection.index'))->withSuccess('The Data Inserted Successfully');
        } else {
            return redirect(route('admin.collection.index'))->withError($collectionService->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collection = Collection::CollectionOwner()->find($id);

        if(!blank($collection)) {
            $collectionService = app(CollectionService::class)->deleteCollection($collection->user_id, $collection->amount, $collection->delivery_charge);
            if ( $collectionService->status ) {
                $collection->delete();
                return redirect(route('admin.collection.index'))->withSuccess('The Data Deleted Successfully');
            } else {
                return redirect(route('admin.collection.index'))->withErrors($collectionService->message);
            }
        } else {
            return redirect(route('admin.collection.index'))->withErrors('The collection not found');
        }
    }

    public function getCollection(Request $request)
    {
        if (request()->ajax()) {

            $collections = Collection::CollectionOwner()->latest()->get();

            $i               = 1;
            $collectionArray = [];
            if (!blank($collections)) {
                foreach ($collections as $collection) {
                    $collectionArray[$i]          = $collection;
                    $collectionArray[$i]['name']  = $collection->user->name ?? '';
                    $collectionArray[$i]['setID'] = $i;
                    $i++;
                }
            }
            return Datatables::of($collectionArray)
                ->addColumn('action', function ($collection) {
                    $retAction = '';

                    if (auth()->user()->can('collection_delete')) {
                        $retAction .= '<form id="detete-'.$collection->id.'" class="float-left pl-2" action="' . route('admin.collection.destroy', $collection) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                         '<button type="button" data-id="'.$collection->id.'"
                         class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                         <i class="fa fa-trash"></i>
                         </button></form>';
                    }
                    return $retAction;
                })
                ->editColumn('date', function ($collection) {
                    return Carbon::parse($collection->date)->format('d M Y');
                })
                ->editColumn('id', function ($collection) {
                    return $collection->setID;
                })
                ->make(true);
        }
    }

    public function getDeliveryBoy(Request $request)
    {

        if (request()->ajax()) {
            if ($request->user_id) {
                $user = User::find($request->user_id);
                if (!blank($user)) {
                    $this->data['user'] = $user;
                    return view('admin.collection.deliveryBoy', $this->data);
                }
                return '';
            }
        }
        return '';
    }

}
