<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Models\RequestWithdraw;
use Yajra\Datatables\Datatables;
use App\Enums\RequestWithdrawStatus;
use App\Http\Controllers\BackendController;
use App\Http\Requests\RequestWithdrawRequest;

class RequestWithdrawController extends BackendController
{
    public $permissionArray = [
        1,
        3,
        4
    ];

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Request Withdraw';
        $this->middleware([ 'permission:request-withdraw' ])->only('index');
        $this->middleware([ 'permission:request-withdraw_create' ])->only('create', 'store');
        $this->middleware([ 'permission:request-withdraw_edit' ])->only('edit', 'update');
        $this->middleware([ 'permission:request-withdraw_delete' ])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !in_array(auth()->user()->myrole, $this->permissionArray) ) {
            abort(403);
        }
        $queryArray = [];
        $status = false;
        if ( auth()->user()->myrole != 1 ) {
            $queryArray['user_id'] = auth()->id();
            $status = true;
        }
        $requestedAmount = RequestWithdraw::where($queryArray)->latest()->sum('amount');
        $withdrawAmount = Withdraw::where($queryArray)->latest()->sum('amount');
        $this->data['totalBalance']= auth()->user()->balance->balance;
        $this->data['requestedAmount']= $requestedAmount;
        $this->data['withdrawAmount']= $withdrawAmount;
        $this->data['status']= $status;

        return view('admin.request-withdraw.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['users'] = User::with('roles')->role([3, 4])->latest()->get();

        return view('admin.request-withdraw.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( RequestWithdrawRequest $request )
    {
        $parsedDate = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $requestWithdraw          = new RequestWithdraw;
        $requestWithdraw->user_id = $request->user_id;
        $requestWithdraw->amount  = $request->amount;
        $requestWithdraw->status  = RequestWithdrawStatus::PENDING;
        $requestWithdraw->date    = $parsedDate;
        $requestWithdraw->save();
        return redirect(route('admin.request-withdraw.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $this->data['users'] = User::with('roles')->role([3, 4])->latest()->get();
        $this->data['requestwithdraw'] = RequestWithdraw::where('status', RequestWithdrawStatus::PENDING)->findOrFail($id);
        return view('admin.request-withdraw.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( RequestWithdrawRequest $request, $id )
    { 
        $requestWithdraw = RequestWithdraw::where('status', RequestWithdrawStatus::PENDING)->findOrFail($id);
        if ( !blank($requestWithdraw) ) {
            $requestWithdraw->amount = $request->amount;
            $requestWithdraw->date   = $request->date;
            $requestWithdraw->user_id = $request->user_id;
            if ( auth()->user()->can('request-withdraw_edit') && auth()->user()->myrole == 1 ) {
                $requestWithdraw->status = $request->status;
            }
            $requestWithdraw->save();

        }


        return redirect(route('admin.request-withdraw.index'))->withSuccess('The Data Updated Successfully');
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
        $requestWithdraw = RequestWithdraw::where('status', RequestWithdrawStatus::PENDING)->findOrFail($id);
        if ( !blank($requestWithdraw) ) {
            $requestWithdraw->delete();
            return redirect(route('admin.request-withdraw.index'))->withSuccess('The Data Deleted Successfully');
        } else {
            return redirect(route('admin.request-withdraw.index'))->withError('You cant\'t delete this data');
        }
    }

    public function getRequestWithdraw( Request $request )
    {
        if ( request()->ajax() ) {
            $queryArray = [];
            if ( !empty($request->status) && (int)$request->status ) {
                $queryArray['status'] = $request->status;
            }
            if ( auth()->user()->myrole != 1 ) {
                $queryArray['user_id'] = auth()->id();
            }
            $requestWithdraws = RequestWithdraw::where($queryArray)->latest()->get();
            $i                    = 1;
            $requestWithdrawArray = [];
            if ( !blank($requestWithdraws) ) {
                foreach ( $requestWithdraws as $requestWithdraw ) {
                    $requestWithdrawArray[ $i ]           = $requestWithdraw;
                    $requestWithdrawArray[ $i ]['name']   = $requestWithdraw->user->name;
                    $requestWithdrawArray[ $i ]['amount'] = currencyFormat($requestWithdraw->amount);
                    $requestWithdrawArray[ $i ]['setID']  = $i;
                    $i++;
                }
            }
            return Datatables::of($requestWithdrawArray)->addColumn('action', function( $requestWithdraw ) {
                    $retAction = '';
                    if ( auth()->user()->can('withdraw_create') && $requestWithdraw->status == RequestWithdrawStatus::ACCEPT ) {
                        $retAction .= '<a href="' . route('admin.withdraw.create', $requestWithdraw) . '" class="btn btn-sm btn-icon float-left btn-success" data-toggle="tooltip" data-placement="top" title="Withdraw"><i class="fas fa-plus"></i></a>';
                    }
                    if ( $requestWithdraw->status == RequestWithdrawStatus::PENDING ) {
                        if ( auth()->user()->can('request-withdraw_edit') ) {
                            $retAction .= '<a href="' . route('admin.request-withdraw.edit', $requestWithdraw) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                        }
                        if ( auth()->user()->can('request-withdraw_delete') ) {
                            $retAction .= '<form id="detete-'.$requestWithdraw->id.'" class="float-left pl-2" action="' . route('admin.request-withdraw.destroy', $requestWithdraw) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                            '<button type="button" data-id="'.$requestWithdraw->id.'"
                            class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                            <i class="fa fa-trash"></i>
                            </button> </form>';
                        }
                    }
                    return $retAction;
                })->editColumn('status', function( $requestWithdraw ) {
                    return trans('request_withdraw_statuses.' . $requestWithdraw->status);
                })->editColumn('id', function( $requestWithdraw ) {
                    return $requestWithdraw->setID;
                })->editColumn('date', function( $requestWithdraw ) {
                    $requestWithdraw = \Carbon\Carbon::parse($requestWithdraw->date);
                    return $requestWithdraw->format('d M Y');
                })->make(true);
        }
    }

    public function getUserInfo(Request $request)
    {

        if (request()->ajax()) {
            if ($request->user_id) {
                $user = User::with('roles')->find($request->user_id);
                if (!blank($user)) {
                    $this->data['user'] = $user;
                    return view('admin.request-withdraw.userInfo', $this->data);
                }
                return '';
            }
        }
        return '';
    }
}
