<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Withdraw;
use App\Enums\paymentType;
use Illuminate\Http\Request;
use App\Models\RequestWithdraw;
use Yajra\Datatables\Datatables;
use App\Enums\RequestWithdrawStatus;
use App\Http\Requests\WithdrawRequest;
use App\Http\Services\TransactionService;
use App\Http\Controllers\BackendController;

class WithdrawController extends BackendController
{
    public $adminBalanceId = 1;

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Withdraw';

        $this->middleware(['permission:withdraw'])->only('index');
        $this->middleware(['permission:withdraw_create'])->only('create', 'store');
        $this->middleware(['permission:withdraw_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.withdraw.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {

        $this->data['requestWithdraw'] = (object)['user_id' => '', 'amount' => '', 'id' => null];
        if ($id) {
            $this->data['requestWithdraw'] = RequestWithdraw::where(['status' => RequestWithdrawStatus::ACCEPT])->find($id);
            if (blank($this->data['requestWithdraw'])) {
                $this->data['requestWithdraw'] = (object)['user_id' => '', 'amount' => '', 'id' => null];
            }
        }

        $this->data['users'] = User::with('roles')->role([3, 4])->latest()->get();
        return view('admin.withdraw.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WithdrawRequest $request)
    {

        $user = User::find($request->user_id);

        if (!blank($user)) {
            $response = app(TransactionService::class)->withdraw($user->balance_id, $this->adminBalanceId, $request->amount);

            if ($response->status) {
                $withdraw          = new Withdraw();
                $withdraw->request_withdraw_id = 0;
                if (!blank($request->request_withdraw_id)) {
                    if ((int) $request->request_withdraw_id) {
                        $requestWithdraw = RequestWithdraw::find($request->request_withdraw_id);
                        if (!blank($requestWithdraw)) {
                            $requestWithdraw->status = RequestWithdrawStatus::COMPLETED;
                            $requestWithdraw->save();
                            $withdraw->request_withdraw_id = $request->request_withdraw_id;
                        }
                    }
                }

                $withdraw->user_id      = $request->user_id;
                $withdraw->payment_type = $request->payment_type;
                $withdraw->date         = date('Y-m-d H:i:s');
                $withdraw->amount       = $request->amount;
                $withdraw->save();

                return redirect(route('admin.withdraw.index'))->withSuccess('The Data added Successfully');
            }
            return redirect(route('admin.withdraw.index'))->withError($response->message);
        }
        return redirect(route('admin.withdraw.index'))->withError('The User Does Not Found');
    }


    public function destroy($id)
    {
        $withdraw = Withdraw::find($id);
        if (!blank($withdraw)) {
            if ($withdraw->delete()) {
                $user = User::find($withdraw->user_id);
                if (!blank($user)) {
                    $response = app(TransactionService::class)->cashBack($this->adminBalanceId, $user->balance_id, $withdraw->amount, true);
                    if ($response->status) {
                        if ($withdraw->request_withdraw_id != 0) {
                            $requestWithdraw = RequestWithdraw::find($withdraw->request_withdraw_id);
                            if (!blank($requestWithdraw)) {
                                $requestWithdraw->status = RequestWithdrawStatus::ACCEPT;
                                $requestWithdraw->save();
                            }
                        }
                        return redirect(route('admin.withdraw.index'))->withSuccess('The Data Deleted Successfully');
                    } else {
                        return redirect(route('admin.withdraw.index'))->withError($response->message);
                    }
                } else {
                    return redirect(route('admin.withdraw.index'))->withError('The User Does Not Found');
                }
            } else {
                return redirect(route('admin.withdraw.index'))->withError('You cant\'t delete this data');
            }
        } else {
            return redirect(route('admin.withdraw.index'))->withError('You cant\'t delete this data');
        }
    }

    public function getWithdraw(Request $request)
    {
        if (auth()->user()->myrole == 1) {
            $withdraws = Withdraw::latest()->get();
        } else {
            $withdraws = Withdraw::where(['user_id' => auth()->user()->id])->get();
        }

        $i             = 1;
        $withdrawArray = [];
        if (!blank($withdraws)) {
            foreach ($withdraws as $withdraw) {
                $withdrawArray[$i]          = $withdraw;
                $withdrawArray[$i]['setID'] = $i;
                $i++;
            }
        }

        return Datatables::of($withdrawArray)->addColumn('action', function ($withdraw) {
            $retAction = '';
            if (auth()->user()->can('withdraw_delete') && auth()->user()->myrole == 1) {
                $retAction .= '<form  id="detete-'.$withdraw->id.'" class="float-left pl-2" action="' . route('admin.withdraw.destroy', $withdraw) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                '<button type="button" data-id="'.$withdraw->id.'"
                class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                <i class="fa fa-trash"></i>
                </button> </form>';
            }
            return $retAction;
        })
            ->editColumn('name', function ($withdraw) {
                return $withdraw->user->name;
            })
            ->editColumn('payment_type', function ($withdraw) {
                return trans('payment_type.' . $withdraw->payment_type) ?? trans('payment_type.' . $withdraw->payment_type);

            })
            ->editColumn('date', function ($withdraw) {
                return Carbon::parse($withdraw->date)->format('d M Y');
            })
            ->editColumn('amount', function ($withdraw) {
                return currencyFormat($withdraw->amount);
            })
            ->editColumn('id', function ($withdraw) {
                return $withdraw->setID;
            })
            ->make(true);
    }

    public function getUserInfo(Request $request)
    {

        if (request()->ajax()) {
            if ($request->user_id) {
                $user = User::find($request->user_id);
                if (!blank($user)) {
                    $this->data['user'] = $user;
                    return view('admin.withdraw.userInfo', $this->data);
                }
                return '';
            }
        }
        return '';
    }
}
