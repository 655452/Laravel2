<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\DeliveryHistoryStatus;
use App\Enums\OrderStatus;
use App\Enums\OrderTypeStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DeliveryboyOrderResource;
use App\Http\Resources\v1\NotificationOrderResource;
use App\Http\Resources\v1\OrderApiResource;
use App\Http\Services\OrderService;
use App\Models\DeliveryBoyAccount;
use App\Models\DeliveryStatusHistories;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationOrderController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        if (auth()->user()->myrole != 4) {
            return response()->json([
                'status'  => 401,
                'message' => 'You don\'t have any permission to accept order.',
            ], 401);
        }

        $deliveryStatusHistoriesArray = DeliveryStatusHistories::where([
            'user_id' => auth()->user()->id,
            'status'  => DeliveryHistoryStatus::CANCEL,
        ])->get()->pluck('order_id')->toArray();

        $orders = Order::where(['delivery_boy_id' => null,'order_type' => OrderTypeStatus::DELIVERY,])->whereIn('status', [OrderStatus::ACCEPT, OrderStatus::PROCESS])->latest()->whereNotIn('id', $deliveryStatusHistoriesArray)->get();


        $i = 1;
        if (!blank($orders)) {
            $orderArray = [];
            foreach ($orders as $order) {
                if ($this->getLimitAmount() < $order->total) {
                    continue;
                }

                $orderArray[$i]          = $order;
                $orderArray[$i]['setID'] = $order->order_code;
                $i++;
            }

            return response()->json([
                'status' => 200,
                'data'   => NotificationOrderResource::collection($orderArray),
            ], 200);
        }

        return response()->json([
            'status'  => 401,
            'message' => 'The order not found.',
        ], 401);

    }

    public function orderAccept(Request $request, $id)
    {
        if (auth()->user()->myrole != 4) {
            return response()->json([
                'status'  => 401,
                'message' => 'You don\'t have any permission to accept order.',
            ], 401);
        }

        $order = Order::where(['id' => $id, 'delivery_boy_id' => null])->first();
        if (blank($order)) {
            return response()->json([
                'status'  => 401,
                'message' => 'The order not found.',
            ], 401);
        }

        $validator = ['status' => ['required', 'numeric']];
        $validator = Validator::make($request->all(), $validator);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $message = 'Order cancel successful';
        if ($request->status == DeliveryHistoryStatus::ACCEPT) {
            $order->delivery_boy_id = auth()->user()->id;
            $order->save();
            $message = 'Order accept successfully';
            $order   = Order::where(['id' => $id])->with('items')->first();
        }

        $deliveryStatusHistories = DeliveryStatusHistories::where(['order_id' => $order->id, 'user_id' => auth()->user()->id])->first();
        if (blank($deliveryStatusHistories)) {
            DeliveryStatusHistories::create([
                'order_id' => $order->id,
                'user_id'  => auth()->user()->id,
                'status'   => $request->status,
            ]);
        }

        return response()->json([
            'status'  => 200,
            'message' => $message,
            'data'    => new OrderApiResource($order),
        ], 200);
    }

    public function OrderProductReceive(Request $request, $id)
    {
        if (auth()->user()->myrole != 4) {
            return response()->json([
                'status'  => 401,
                'message' => 'You don\'t have any permission to accept order.',
            ], 401);
        }

        $order = Order::where(['id' => $id, 'delivery_boy_id' => auth()->user()->id, 'product_received' => 10])->with('items')->first();
        if (blank($order)) {
            return response()->json([
                'status'  => 401,
                'message' => 'The order not found.',
            ], 401);
        }

        $validator = ['product_receive_status' => ['required', 'numeric']];
        $validator = Validator::make($request->all(), $validator);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $productReceive = app(OrderService::class)->productReceive($id, $request->product_receive_status);
        if($productReceive->status) {
            return response()->json([
                'status'  => 200,
                'message' => 'You have received the product. carefully check your delivery product',
                'data'    => new OrderApiResource($order)
            ], 200);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => $productReceive->message
            ], 401);
        }
    }

    public function orderStatus( Request $request, $id )
    {
        if ( auth()->user()->myrole != 4 ) {
            return response()->json([
                'status'  => 401,
                'message' => 'You don\'t have any permission to accept order.',
            ], 401);
        }

        $order = Order::where([
            'id'              => $id,
            'delivery_boy_id' => auth()->user()->id
        ])->with('items')->first();
        if ( !blank($order) ) {
            $validator = [
                'status' => [
                    'required',
                    'numeric'
                ]
            ];
            $validator = Validator::make($request->all(), $validator);
            if ( $validator->fails() ) {
                return response()->json([
                    'status'  => 422,
                    'message' => $validator->errors(),
                ], 422);
            }
            $orderService = app(OrderService::class)->orderUpdate($id, $request->status);
            if ( $orderService->status ) {
                return response()->json([
                    'status'  => 200,
                    'message' => 'The order successfully updated',
                    'data'    => new OrderApiResource($order),
                ], 200);
            }
            return response()->json([
                'status'  => 401,
                'message' => $orderService->message,
            ], 401);
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'The order not found.',
            ], 401);
        }
    }

    public function show($id)
    {

        try{
            $response = Order::where(['id' => $id,'order_type' =>OrderTypeStatus::DELIVERY])->latest()->with('items', 'items.menuItem', 'items.variation', 'invoice.transactions')->first();
            if($response == null){
                return $this->successResponse(['status'=> 200, 'message' => 'No available orders']);
            }
            $order= new OrderApiResource($response);
            return $this->successResponse(['status'=> 200, 'data' => $order]);
        } catch (\Exception $e){
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }


    }

    public function history()
    {
        $orders = Order::where(['delivery_boy_id' => auth()->user()->id,'order_type' =>OrderTypeStatus::DELIVERY])->latest()->get();
        if (!blank($orders)) {
            return response()->json([
                'status' => 200,
                'data'   => DeliveryboyOrderResource::collection($orders),
            ], 200);
        }
        return response()->json([
            'status'  => 401,
            'message' => 'The data not found',
        ], 401);
    }

    public function getLimitAmount()
    {
        $userLimitAmount    = (auth()->user()->deposit->limit_amount > 0) ? auth()->user()->deposit->limit_amount : setting('delivery_boy_order_amount_limit');
        $deliveryBoyBalance = (DeliveryBoyAccount::where('user_id', auth()->user()->id)->first())->balance ?? 0;
        $acceptOrder        = Order::where(['delivery_boy_id' => auth()->id(),'order_type' =>OrderTypeStatus::DELIVERY])->where('status', '!=', OrderStatus::COMPLETED)->sum('total');
        $deliveryBoyBalance = $deliveryBoyBalance + $acceptOrder;

        return $this->notZero(($userLimitAmount - $deliveryBoyBalance));
    }

    public function notZero($amount)
    {
        if ($amount <= 0) {
            return 0;
        }
        return $amount;
    }

}
