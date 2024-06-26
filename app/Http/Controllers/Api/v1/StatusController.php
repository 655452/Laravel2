<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 24/4/20
 * Time: 1:30 PM
 */

namespace App\Http\Controllers\Api\v1;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index($type, $flip = 0)
    {
        $returnArray = [];
        if ($type == 'order') {
            $returnArray = trans('order_status');
        }

        if ($type == 'status') {
            $returnArray = trans('statuses');
        }

        if ($type == 'currentstatus') {
            $returnArray = trans('current_statuses');
        }

        if ($type == 'product-receive') {
            $returnArray = trans('product_receive_status');
        }

        if ($type == 'delivery-history') {
            $returnArray = trans('delivery_history_status');
        }

        if (!blank($returnArray) && $flip == 0) {
            $i        = 0;
            $retArray = [];
            foreach ($returnArray as $key => $value) {
                $retArray[$i]['id']   = $key;
                $retArray[$i]['name'] = $value;
                $i++;
            }
            $returnArray = $retArray;
        }

        return response()->json([
            'status' => 200,
            'data'   => $returnArray,
        ], 200);
    }

    public function getOrderStatus( $id )
    {
        $order = Order::find($id);
        if(!blank($order)) {
            $myRole      = auth()->user()->myrole;
            $allowStatus = [];
            if ( $myRole == 2 ) {
                $allowStatus = [ OrderStatus::CANCEL ];
            } else if ( $myRole == 3 ) {
                if ( $order->status == OrderStatus::PENDING ) {
                    $allowStatus = [
                        OrderStatus::ACCEPT,
                        OrderStatus::REJECT
                    ];
                } elseif ( $order->status == OrderStatus::ACCEPT ) {
                    $allowStatus = [ OrderStatus::PROCESS ];
                } elseif ( $order->status == OrderStatus::REJECT ) {
                    $allowStatus = [ OrderStatus::REJECT ];
                }
            } else if ( $myRole == 4 ) {
                $allowStatus = [
                    OrderStatus::ON_THE_WAY,
                    OrderStatus::COMPLETED
                ];
            }

            $orderStatusArray = [];
            if ( !blank($allowStatus) ) {
                $i        = 0;
                foreach ( trans('order_status') as $key => $status ) {
                    if ( in_array($key, $allowStatus) ) {
                        $orderStatusArray[$i]['id']   = $key;
                        $orderStatusArray[$i]['name'] = $status;
                        $i++;
                    }
                }
            }

            $showStatus = true;
            if ( $myRole == 1 || $myRole == 4 ) {
                $showStatus = false;
            }

            $showReceive = false;
            if ( ($order->status == 15) && $myRole == 4 ) {
                $showStatus  = false;
                $showReceive = true;
            }

            if ( ($order->status == 17) && $myRole == 4 ) {
                $showStatus = true;
            }

            if ( ($order->status == 17) && $myRole == 3 ) {
                $showStatus = false;
            }

            $this->data['showStatus']       = $showStatus;
            $this->data['showReceive']      = $showReceive;
            $this->data['orderStatusArray'] = $orderStatusArray;

            return response()->json([
                'status' => 200,
                'data'   => $this->data,
            ], 200);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'The data not found',
            ], 401);
        }
    }
}
