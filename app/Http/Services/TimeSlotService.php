<?php


namespace App\Http\Services;


use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotService
{
    public function allTimeSlots($request)
    {
        $queryArray=[];
        if (auth()->user()->restaurant){
            $queryArray['restaurant_id'] =auth()->user()->restaurant->id;
        }

        $this->data['timeSlots'] = TimeSlot::where($queryArray)->descending()->get();


        return $this->data['timeSlots'];
    }

    public function store(Request $request)
    {
        $timeSlot             = new TimeSlot;
        $timeSlot->start_time = date('H:i:s', strtotime($request->start_time));
        $timeSlot->end_time   = date('H:i:s', strtotime($request->end_time));
        $timeSlot->restaurant_id     = $request->restaurant_id;
        $timeSlot->status     = $request->status;
        $timeSlot->save();

        return $timeSlot;
    }


    public function update(Request $request, $timeSlot) : void
    {
        $timeSlot->start_time = date('H:i:s', strtotime($request->start_time));
        $timeSlot->end_time   = date('H:i:s', strtotime($request->end_time));
        $timeSlot->restaurant_id     = $request->restaurant_id;
        $timeSlot->status     = $request->status;
        $timeSlot->save();
    }

    public function delete($timeSlot)
    {
        $timeSlot->delete();
    }

}
