<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\TimeSlotRequest;
use App\Models\Restaurant;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class TimeSlotController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Time Slots';

        $this->middleware(['permission:time-slots'])->only('index');
        $this->middleware(['permission:time-slots_create'])->only('create', 'store');
        $this->middleware(['permission:time-slots_edit'])->only('edit', 'update');
        $this->middleware(['permission:time-slots_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getTimeSlot($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.time-slot.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeSlotRequest $request)
    {
        $timeSlot             = new TimeSlot;
        $timeSlot->start_time = date('H:i:s', strtotime($request->start_time));
        $timeSlot->end_time   = date('H:i:s', strtotime($request->end_time));
        $timeSlot->restaurant_id     = $request->restaurant_id;
        $timeSlot->status     = $request->status;
        $timeSlot->save();

        return redirect(route('admin.time-slots.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['timeSlot'] = TimeSlot::findOrFail($id);
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.time-slot.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TimeSlotRequest $request, $id)
    {
        $timeSlot             = TimeSlot::findOrFail($id);
        $timeSlot->start_time = date('H:i:s', strtotime($request->start_time));
        $timeSlot->end_time   = date('H:i:s', strtotime($request->end_time));
        $timeSlot->restaurant_id     = $request->restaurant_id;
        $timeSlot->status     = $request->status;
        $timeSlot->save();
        return redirect(route('admin.time-slots.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimeSlot::findOrFail($id)->delete();
        return redirect(route('admin.time-slots.index'))->withSuccess('The Data Deleted Successfully');
    }

    private function getTimeSlot(Request $request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            $queryArray['status'] = Status::ACTIVE;
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            $timeSlots = [];
            if (auth()->user()->myrole == 3 && auth()->user()->restaurant){
                $queryArray['restaurant_id'] =auth()->user()->restaurant->id;
                $timeSlots = TimeSlot::where($queryArray)->descending()->select();
            }elseif(auth()->user()->myrole != 3){
                $timeSlots = TimeSlot::where($queryArray)->descending()->select();
            }

            $i = 0;
            return Datatables::of($timeSlots)
                ->addColumn('action', function ($timeSlot) {
                    $retAction = '';

                    if (auth()->user()->can('time-slots_edit')) {
                        $retAction .= '<a href="' . route('admin.time-slots.edit', $timeSlot) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('time-slots_delete')) {
                        $retAction .= '<form id="detete-'.$timeSlot->id.'" class="float-left pl-2" action="' . route('admin.time-slots.destroy', $timeSlot) . '" method="POST">' . method_field('DELETE') . csrf_field() . '
                        <button type="button" data-id="'.$timeSlot->id.'"
                        class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                        <i class="fa fa-trash"></i>
                        </button>
                        </form>';
                    }

                    return $retAction;
                })
                ->editColumn('id', function ($timeSlot) use (&$i) {
                    return ++$i;
                })
                ->editColumn('restaurant_id', function ($timeSlot) {
                    return Str::limit($timeSlot->restaurant->name ?? null, 30);
                })
                ->editColumn('start_time', function ($timeSlot) {
                    return date('h:i A', strtotime($timeSlot->start_time));
                })
                ->editColumn('end_time', function ($timeSlot) {
                    return date('h:i A', strtotime($timeSlot->end_time));
                })
                ->editColumn('status', function ($timeSlot) {
                    return trans('statuses.' . $timeSlot->status) ?? trans('statuses.' . Status::INACTIVE);
                })
                ->make(true);
        }
        return view('admin.time-slot.index', $this->data);
    }
}
