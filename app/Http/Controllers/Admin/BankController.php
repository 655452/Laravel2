<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Bank;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\BankRequest;
use App\Http\Controllers\BackendController;

class BankController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Bank';

        $this->middleware(['permission:bank'])->only('index');
        $this->middleware(['permission:bank_create'])->only('create', 'store');
        $this->middleware(['permission:bank_edit'])->only('edit', 'update');
        $this->middleware(['permission:bank_show'])->only('show');
        $this->middleware(['permission:bank_delete'])->only('destroy');
    }

    public function index()
    {
        $restaurants=Restaurant::with('user')->latest()->get();
        $this->data['restaurants']     = $restaurants;
        return view('admin.bank.index', $this->data);
    }

    public function create()
    {
        $this->data['users'] = User::role([3, 4])->with('roles')->latest()->get();
        return view('admin.bank.create', $this->data);
    }


    public function store(BankRequest $request)
    {
        $bank                      = new Bank;
        $bank->user_id             = $request->user_id;
        $bank->bank_name           = $request->bank_name;
        $bank->bank_code           = $request->bank_code;
        $bank->recipient_name      = $request->recipient_name;
        $bank->account_number      = $request->account_number;
        $bank->mobile_agent_name   = $request->mobile_agent_name;
        $bank->mobile_agent_number = $request->mobile_agent_number;
        $bank->paypal_id           = $request->paypal_id;
        $bank->upi_id              = $request->upi_id;
        $bank->save();
        return redirect(route('admin.bank.index'))->withSuccess('The data inserted successfully.');
    }


    public function edit($id)
    {
        $this->data['users'] = User::role([3, 4])->with('roles')->latest()->get();
        $this->data['bank'] = Bank::findOrFail($id);
        return view('admin.bank.edit', $this->data);
    }


    public function update(BankRequest $request, Bank $bank)
    {
        $bank->user_id             = $request->user_id;
        $bank->bank_name           = $request->bank_name;
        $bank->bank_code           = $request->bank_code;
        $bank->recipient_name      = $request->recipient_name;
        $bank->account_number      = $request->account_number;
        $bank->mobile_agent_name   = $request->mobile_agent_name;
        $bank->mobile_agent_number = $request->mobile_agent_number;
        $bank->paypal_id           = $request->paypal_id;
        $bank->upi_id              = $request->upi_id;
        $bank->save();
        return redirect(route('admin.bank.index'))->withSuccess('The data updated successfully.');
    }

    public function show(Bank $bank)
    {
        return view('admin.bank.show', compact('bank'));
    }

    public function destroy($id)
    {
        Bank::findOrFail($id)->delete();
        return redirect(route('admin.bank.index'))->withSuccess('The data deleted successfully.');
    }

    public function getBank(Request $request)
    {
        if (request()->ajax()) {


            $auth = auth();
                $banks = Bank::where(function($query) use($auth, $request) {
                    if($auth->user()->myrole != 1) {
                        return $query->where('user_id', $auth->user()->id);
                    } else {
                        if($request->user_id != 0) {
                            return $query->where('user_id', $request->user_id);
                        }
                    }
                })->latest()->get();

            $i = 0;
            return Datatables::of($banks)
                ->addColumn('action', function ($bank) {
                    $retAction = '';
                    if (auth()->user()->can('bank_edit')) {
                        $retAction .= '<a href="' . route('admin.bank.edit', $bank) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="far fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('bank_edit')) {
                        $retAction .= '<a href="' . route('admin.bank.show', $bank) . '" class="btn btn-sm btn-icon ml-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }
                    if (auth()->user()->can('bank_delete')) {
                        $retAction .= '<form  id="detete-'.$bank->id.'" class="float-left pl-2" action="' . route('admin.bank.destroy', $bank) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                        '<button type="button" data-id="'.$bank->id.'"
                        class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                        <i class="fa fa-trash"></i>
                        </button> </form>';
                    }
                    return $retAction;
                })
                ->editColumn('id', function ($bank) use (&$i) {
                    return ++$i;
                })

                ->editColumn('bank_name', function ($bank) {
                    return $bank->bank_name;
                })

                ->editColumn('account_number', function ($bank) {
                    return $bank->account_number;
                })

                ->editColumn('mobile_agent_name', function ($bank) {
                    return $bank->mobile_agent_name;
                })

                ->escapeColumns([])
                ->make(true);
        }
    }
}
