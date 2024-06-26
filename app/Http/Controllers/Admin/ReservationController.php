<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Services\PushNotificationService;
use App\Models\TimeSlot;
use App\Notifications\ReservationCreated;
use App\Notifications\ReservationUpdate;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\Status;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use App\Http\Requests\ReservationRequest;
use App\Http\Services\ReservationService;
use App\Http\Controllers\BackendController;

class ReservationController extends BackendController
{

    /**
     * Category Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Reservations';

        $this->middleware(['permission:reservation'])->only('index');
        $this->middleware(['permission:reservation_create'])->only('create', 'store');
        $this->middleware(['permission:reservation_edit'])->only('edit', 'update');
        $this->middleware(['permission:reservation_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getReservation($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
         $role  = Role::find(2);
        $this->data['users'] = User::role($role->name)->latest()->get();
        return view('admin.reservation.create', $this->data);
    }

    /**
     * @param Reservation(equest $request
     * @return mixed
     */
    public function store(ReservationRequest $request)
    {

        $reservationService    = new ReservationService();
        $table = $reservationService->CheckReservation(true,$request->reservation_date,$request->guest,$request->restaurant_id);
        $tableArray = collect($table)->sortBy('capacity')->toArray();

        $reservation = new Reservation;
        $reservation->first_name = $request->first_name;
        $reservation->last_name = $request->last_name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->restaurant_id =$request->restaurant_id;
        $reservation->table_id = array_key_last($tableArray);
        $reservation->time_slot_id = $request->time_slot;
        $reservation->guest_number = $request->guest;
        $reservation->user_id = $request->user_id;
        $reservation->status = ReservationStatus::PENDING;
        $reservation->save();

        try {
            app(PushNotificationService::class)->sendNotificationReservation($reservation,$reservation->restaurant->user,'store');
        } catch (\Exception $exception) {
            //
        }

        return redirect(route('admin.reservation.index'))->withSuccess('The data inserted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['reservation'] = Reservation::findOrFail($id);
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        $role  = Role::find(2);
        $this->data['users'] = User::role($role->name)->latest()->get();
        $this->data['timeSlots'] = TimeSlot::find($this->data['reservation']->time_slot_id);
        return view('admin.reservation.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationUpdateRequest $request, $id)
    {
        $reservation              = Reservation::findOrFail($id);
        $reservationService    = new ReservationService();
        $table = $reservationService->CheckReservation(true,$request->reservation_date,$request->guest,$request->restaurant_id);
        $tableArray = collect($table)->sortBy('capacity')->toArray();

        $reservation->first_name = $request->first_name;
        $reservation->last_name = $request->last_name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->restaurant_id =$request->restaurant_id;
        $reservation->table_id = array_key_last($tableArray)??$reservation->table_id ;
        $reservation->time_slot_id = $request->time_slot;
        $reservation->guest_number = $request->guest;
        $reservation->user_id = $request->user_id;
        $reservation->save();

        return redirect(route('admin.reservation.index'))->withSuccess('The data updated successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('admin.reservation.show', compact('reservation'));
    }

    public function status($id,$status)
    {
        $reservation              = Reservation::findOrFail($id);
        if(!blank($reservation)){
            $reservation->status = $status;
            $reservation->save();

            try {
                app(PushNotificationService::class)->sendNotificationReservation($reservation,$reservation->user,'update');
            } catch (\Exception $exception) {
                //
            }
        }
        return redirect(route('admin.reservation.index'))->withSuccess('The data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();
        return redirect(route('admin.reservation.index'))->withSuccess('The data deleted successfully.');
    }

    private function getReservation($request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            if ((int) $request->requested) {
                $queryArray['requested'] = $request->requested;
            }
            $reservations = [];
            if (auth()->user()->myrole != 1 && auth()->user()->restaurant){
                $queryArray['restaurant_id'] =auth()->user()->restaurant->id;
                $reservations = Reservation::where($queryArray)->descending()->select();

            }elseif(auth()->user()->myrole != 3){
                $reservations = Reservation::where($queryArray)->descending()->select();
            }
            $i = 0;
            return Datatables::of($reservations)
                ->addColumn('action', function ($reservation) {
                    $retAction = '';

                        if (auth()->user()->can('reservation_edit')) {
                            $retAction .= '<a href="' . route('admin.reservation.edit', $reservation) . '" class="btn btn-sm btn-icon float-left btn-primary pr-2" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="far fa-edit"></i></a>';
                        }
                        if (auth()->user()->can('reservation_show')) {
                            $retAction .= '<a href="' . route('admin.reservation.show', $reservation) . '" class="ml-2 btn btn-sm btn-icon float-left btn-info " data-toggle="tooltip" data-placement="top" title="View" ><i class="far fa-eye"></i></a>';
                        }

                        if (auth()->user()->can('reservation_delete')) {
                            $retAction .= '<form id="detete-'.$reservation->id.'" class="float-left pl-2" action="' . route('admin.reservation.destroy', $reservation) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                            '<button type="button" data-id="'.$reservation->id.'"
                            class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                            <i class="fa fa-trash"></i>
                            </button>
                            </form>';
                        }

                    return $retAction;
                })
                ->editColumn('id', function ($reservation) use (&$i) {
                    return ++$i;
                })
                ->addColumn('name', function ($reservation) {
                    return $reservation->first_name.' '.$reservation->last_name;
                })

                ->editColumn('phone', function ($reservation) {
                    return $reservation->phone;
                })
                ->editColumn('created_at', function ($reservation) {
                    return Carbon::parse($reservation->reservation_date)->format('d M Y');
                })

                ->addColumn('table', function ($reservation) {
                    return optional($reservation->table)->name;
                })

                ->editColumn('status', function ($reservation) {
                    $drop = '';
                    $activeStatus = 'Change Status';
                    foreach (trans("reservation_status") as $key => $status) {
                        if ($reservation->status == $key) {
                            $activeStatus = $status;
                        }
                        $drop .= '<a class="dropdown-item border border-info rounded bg-dark text-light" href="' . route('admin.reservation.status', [$reservation->id, $key]).'">'.$status.'</a>';

                    }

                    return '<div class="dropdown">
                            <button class="dropdown_btn btn btn-outline-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                        . $activeStatus
                        . '</button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' . $drop . '</div></div>';

                        })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.reservation.index');
    }

    public function timeSlot(Request $request)
    {

        $reservationService    = new ReservationService();
        $timeSlots = $reservationService->CheckReservation(false,$request->date,$request->capacity,$request->restaurant);
        return view('admin.reservation.timeSlot', compact('timeSlots'));

    }

    public function user(Request $request)
    {
        $user = User::find($request->userID);
        return $user;

    }
}
