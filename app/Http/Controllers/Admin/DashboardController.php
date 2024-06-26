<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Enums\UserStatus;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Enums\RestaurantStatus;
use App\Enums\DeliveryHistoryStatus;
use App\Models\DeliveryStatusHistories;
use App\Http\Controllers\BackendController;
use Spatie\Permission\Models\Role;

class DashboardController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Dashboard';
        $this->middleware(['permission:dashboard'])->only('index');
    }

    public function index()
    {
        $this->data['months'] = [
            1 => 'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];


        $totalOrders      = Order::with('user')->orderBy('id', 'desc')->get();
        $ownerTotalOrders = [];
        $ownerTotalReservations = [];
        $ownerNotificationOrders = [];
        //owner
        if (auth()->user()->myrole == 3 && auth()->user()->restaurant) {
            $ownerTotalOrders = Order::with('user')->orderBy('id', 'desc')->where('restaurant_id', auth()->user()->restaurant->id)->get();
            $ownerTotalReservations = Reservation::orderBy('id', 'desc')->where('restaurant_id', auth()->user()->restaurant->id)->get();
            $ownerNotificationOrders = Order::with('user')->orderBy('id', 'desc')->where('restaurant_id', auth()->user()->restaurant->id)->where('status',OrderStatus::PENDING)->get();
        }

        //delivery boy

        $deliveryStatusHistoriesArray = DeliveryStatusHistories::where([
            'user_id' => auth()->user()->id,
            'status'  => DeliveryHistoryStatus::CANCEL,
        ])->get()->pluck('order_id')->toArray();

        $notificationOrders = Order::with('user')->where(['delivery_boy_id' => null])->whereIn('status', [OrderStatus::ACCEPT, OrderStatus::PROCESS])->latest()->whereNotIn('id', $deliveryStatusHistoriesArray)->get();


        $totalDaliveryOrders = Order::with('user')->where(['delivery_boy_id' => auth()->user()->id])->latest()->get();
        $role  = Role::find(2);
        $totalUsers = User::role($role->name)->where(['status' => UserStatus::ACTIVE])->latest()->get();
        $totalRestaurants = Restaurant::where(['status' => RestaurantStatus::ACTIVE])->get();
        $recentOrders     = Order::with('user')->orderBy('id', 'desc')->whereDate('created_at', date('Y-m-d'))->orderowner()->get();
        $yearlyOrders     = Order::with('user')->orderBy('id', 'desc')->where('status', '!=', OrderStatus::CANCEL)->whereYear('created_at', date('Y'))->orderowner()->get();
        $totalIncome      = 0;
        $totalOwnerIncome = 0;

        //total incone
        if (!blank($totalOrders)) {
            foreach ($totalOrders as $totalOrder) {
                if (OrderStatus::COMPLETED == $totalOrder->status) {
                    $totalIncome = $totalIncome + $totalOrder->paid_amount;
                }
            }
        }





        $monthWiseTotalIncome    = [];
        $monthDayWiseTotalIncome = [];
        $monthWiseTotalOrder     = [];
        $monthDayWiseTotalOrder  = [];

        if (!blank($yearlyOrders)) {
            foreach ($yearlyOrders as $yearlyOrder) {
                $monthNumber = (int) date('m', strtotime($yearlyOrder->created_at));
                $dayNumber   = (int) date('d', strtotime($yearlyOrder->created_at));
                if (!isset($monthDayWiseTotalIncome[$monthNumber][$dayNumber])) {
                    $monthDayWiseTotalIncome[$monthNumber][$dayNumber] = 0;
                }
                $monthDayWiseTotalIncome[$monthNumber][$dayNumber] += $yearlyOrder->paid_amount;
                if (!isset($monthWiseTotalIncome[$monthNumber])) {
                    $monthWiseTotalIncome[$monthNumber] = 0;
                }
                if(auth()->user()->myrole == 4){
                    $monthWiseTotalIncome[$monthNumber] += $yearlyOrder->delivery_charge;
                }else{
                    $monthWiseTotalIncome[$monthNumber] += $yearlyOrder->paid_amount;
                }
                if (!isset($monthDayWiseTotalOrder[$monthNumber][$dayNumber])) {
                    $monthDayWiseTotalOrder[$monthNumber][$dayNumber] = 0;
                }
                $monthDayWiseTotalOrder[$monthNumber][$dayNumber] += 1;
                if (!isset($monthWiseTotalOrder[$monthNumber])) {
                    $monthWiseTotalOrder[$monthNumber] = 0;
                }
                $monthWiseTotalOrder[$monthNumber] += 1;
            }
        }
        $this->data['monthWiseTotalIncome']    = $monthWiseTotalIncome;
        $this->data['monthDayWiseTotalIncome'] = $monthDayWiseTotalIncome;
        $this->data['monthWiseTotalOrder']     = $monthWiseTotalOrder;
        $this->data['monthDayWiseTotalOrder']  = $monthDayWiseTotalOrder;
        $this->data['totalOrders']             = count($totalOrders);
        $this->data['totalUsers']              = count($totalUsers);
        $this->data['totalRestaurants']        = count($totalRestaurants);
        $this->data['notificationOrders']        = count($notificationOrders);
        $this->data['yearlyOrders']        = count($yearlyOrders);
        if(auth()->user()->myrole == 3){
            $this->data['ownerTotalOrders']        = count($ownerTotalOrders);
            $this->data['ownerNotificationOrders'] = count($ownerNotificationOrders);
            $this->data['ownerTotalReservations']  = count($ownerTotalReservations);
        }


        $this->data['totalDaliveryOrders']  = count($totalDaliveryOrders);

        $this->data['totalIncome']             = $totalIncome;
        $this->data['recentOrders']            = $recentOrders;
        $this->data['userCredit']            = currencyFormat(auth()->user()->balance->balance > 0 ? auth()->user()->balance->balance : 0 );


        return view('admin.dashboard.index', $this->data);
    }

    public function dayWiseIncomeOrder(Request $request)
    {
        $type          = $request->type;
        $monthID       = $request->monthID;
        $dayWiseData   = $request->dayWiseData;
        $showChartData = [];
        if ($type && $monthID) {
            $days        = date('t', mktime(0, 0, 0, $monthID, 1, date('Y')));
            $dayWiseData = json_decode($dayWiseData, true);
            for ($i = 1; $i <= $days; $i++) {
                $showChartData[$i] = isset($dayWiseData[$i]) ? $dayWiseData[$i] : 0;
            }
        } else {
            for ($i = 1; $i <= 31; $i++) {
                $showChartData[$i] = 0;
            }
        }
        echo json_encode($showChartData);
    }
}
