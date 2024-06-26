<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Services\PushNotificationService;
use App\Models\User;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\OrderApiResource;
use App\Http\Resources\v1\RestaurantOrderResource;


class RestaurantOrderController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $restaurant_id = auth()->user()->restaurant->id;

        $orders = Order::where(['restaurant_id' => $restaurant_id])->orderBy('id', 'desc')->get();

        if (!blank($orders)) {
            return response()->json([
                'status' => 200,
                'data'   => RestaurantOrderResource::collection($orders),
            ]);
        }
        return response()->json([
            'status'  => 404,
            'message' => 'The data not found',
        ]);
    }

    public function history()
    {
        $restaurant_id = auth()->user()->restaurant->id;

        $orders = Order::where(['restaurant_id' => $restaurant_id, 'status' => OrderStatus::COMPLETED,])->orderBy('id', 'desc')->get();

        if (!blank($orders)) {
            return response()->json([
                'status' => 200,
                'data'   => RestaurantOrderResource::collection($orders),
            ]);
        }
        return response()->json([
            'status'  => 404,
            'message' => 'The data not found',
        ]);
    }



    public function show($id)
    {
        $restaurant_id = auth()->user()->restaurant->id;
        try {
            $response = Order::where(['restaurant_id' => $restaurant_id, 'id' => $id])->latest()->with('items', 'items.menuItem', 'items.variation', 'invoice.transactions')->first();
            if ($response == null) {
                return $this->successResponse(['status' => 200, 'message' => 'No available orders']);
            }
            $order = new OrderApiResource($response);
            return $this->successResponse(['status' => 200, 'data' => $order]);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $restaurant_id = auth()->user()->restaurant->id;

        if (auth()->user()->myrole != 3) {
            return response()->json([
                'status'  => 401,
                'message' => 'You don\'t have any permission to update order.',
            ], 401);
        }

        $getOrder = Order::where(['id' => $id, 'restaurant_id' => $restaurant_id])->first();
        if (!blank($getOrder)) {
            $orderService = app(OrderService::class)->orderUpdate($id, $request->status);
            if ($orderService->status) {
                if ($request->status == OrderStatus::ACCEPT) {
                    $role  = Role::find(4);
                    $deliveryBoy    = User::role($role->name)->whereNotNull('device_token')->get();
                    $deliveryBoyWeb = User::role($role->name)->whereNotNull('web_token')->get();
                    if (!blank($deliveryBoy)) {
                        foreach ($deliveryBoy as $delivery) {
                            app(PushNotificationService::class)->sendNotificationOrderUpdate($getOrder, $delivery,'deliveryboy');
                        }
                    }
                    if (!blank($deliveryBoyWeb)) {
                        foreach ($deliveryBoyWeb as $deliveryweb) {
                            app(PushNotificationService::class)->sendNotificationOrderUpdate($getOrder, $deliveryweb,'deliveryboy');
                        }
                    }
                } else {
                    if (!blank($getOrder->delivery_boy_id)) {
                        app(PushNotificationService::class)->sendNotificationOrderUpdate($getOrder, $getOrder->delivery,'deliveryboy');

                    }
                }
                app(PushNotificationService::class)->sendNotificationOrderUpdate($getOrder, $getOrder->user,'customer');

                return response()->json([
                    'status'  => 200,
                    'message' => 'The order successfully updated',
                    'data'    => $orderService,
                ], 200);
            }
            return response()->json([
                'status'  => 401,
                'message' => $orderService->message,
            ], 401);
        } else {
            return response()->json([
                'status'  => 400,
                'message' => 'Bad Request',
            ], 400);
        }
    }
}
