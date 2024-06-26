<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class TransactionController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Transactions';

        $this->middleware(['permission:transaction'])->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['users'] = User::get();
        return view('admin.transaction.index', $this->data);
    }

    public function getTransaction( Request $request )
    {

        if ( request()->ajax() ) {
            if ( auth()->user()->myrole == 1 ) {
                if ( !blank($request->user_id) && !blank($request->from_date) ) {
                    $fromDate = date('Y-m-d H:i:s', strtotime($request->from_date . "00:00:00"));
                    $toDate   = date('Y-m-d H:i:s', strtotime($request->to_date . "23:59:59"));

                    if (strtotime($toDate) < strtotime($fromDate)) {
                        $toDate = date('Y-m-d') . " 23:59:59";
                    }

                    $userId = $request->user_id;
                    $transactions = Transaction::whereBetween('created_at', [
                        $fromDate,
                        $toDate
                    ])->where(function($query) use ($userId){
                        $query->orWhere('source_balance_id', $userId)
                            ->orWhere('destination_balance_id', $userId);
                    })->orderBy('id', 'DESC')->get();

                } elseif ( !blank($request->user_id) ) {
                    $transactions = Transaction::orWhere('source_balance_id', $request->user_id)->orWhere([ 'destination_balance_id' => $request->user_id ])->orderBy('id', 'DESC')->get();
                } elseif ( !blank($request->from_date) ) {
                    $fromDate = date('Y-m-d H:i:s', strtotime($request->from_date . "00:00:00"));
                    $toDate   = date('Y-m-d H:i:s', strtotime($request->to_date . "23:59:59"));

                    if (strtotime($toDate) < strtotime($fromDate)) {
                        $toDate = date('Y-m-d') . " 23:59:59";
                    }

                    $transactions = Transaction::whereBetween('created_at', [
                        $fromDate,
                        $toDate
                    ])->orderBy('id', 'DESC')->get();
                } else {
                    $transactions = Transaction::orderBy('id', 'DESC')->get();
                }
            } else {
                $transactions = Transaction::orWhere('source_balance_id', auth()->user()->balance_id)->orWhere([ 'destination_balance_id' => auth()->user()->balance_id ])->orderBy('id', 'DESC')->get();
            }

            $i     = 0;
            return Datatables::of($transactions)
                ->editColumn('id', function () use (&$i) {
                    return ++$i;
                })
                ->editColumn('from_user', function ($transaction) {
                    return $this->generateName($transaction, 'source');
                })
                ->editColumn('to_user', function ($transaction) {
                    return $this->generateName($transaction, 'destination');
                })
                ->editColumn('type', function ($transaction) {
                    return trans('transaction_types.'. $transaction->type);
                })
                ->editColumn('date', function ($transaction) {
                    return  food_date_format_with_day($transaction->created_at);
                })
                ->editColumn('amount', function ($transaction) {
                    return $this->generateAmount($transaction);
                })->escapeColumns([])
            ->make(true);

        }
    }

    private function generateAmount($transaction)
    {
        if (auth()->user()->myrole != 1) {
            if($transaction->source_balance_id == auth()->user()->balance_id) {
                return '- '.currencyFormat($transaction->amount);
            }
            return '+ '.currencyFormat($transaction->amount);
        }
        return currencyFormat($transaction->amount);
    }

    private function generateName($transaction, $type)
    {
        if($type == 'source') {
            return isset($transaction->sourceUser) ? $transaction->sourceUser->name : '';
        }
        return isset($transaction->destinationUser) ? $transaction->destinationUser->name : '';
    }

    private function showTransactionItem($transaction)
    {
        if (isset(auth()->user()->roles)) {
            $roleID = auth()->user()->myrole ?? 0;

            if ($roleID == 3) {
                $shopID = auth()->user()->shop->id ?? 0;
                $transactionShopID = $transaction->meta['shop_id'];
                if ($transactionShopID == $shopID) {
                    return false;
                }
                return true;
            } else {
                if (($transaction->source_balance_id == null && ($transaction->destination_balance_id == auth()->user()->balance_id)) || ($transaction->source_balance_id == auth()->user()->balance_id)) {
                    return false;
                }
                return true;
            }
        }
    }
}
