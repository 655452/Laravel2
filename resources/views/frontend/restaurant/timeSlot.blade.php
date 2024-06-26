@if (!blank($timeSlots))
<input type="hidden" id="TimeSlotId" name="time_slot">
@foreach ($timeSlots as $timeSlot)
<li class="enable time-slot " onclick="selected({{ $timeSlot['id'] }} ) " id="slot_{{ $timeSlot['id'] }}">
    <input type="radio" class="d-none" id="time-slot-{{ $timeSlot['id'] }}" name="time-sloat">
    <label for="time-slot-{{ $timeSlot['id'] }}">
        <p class="d-none time-slot-p">{{ $timeSlot['id'] }}</p>
        {{ date('h:i A', strtotime($timeSlot['start_time'])) }} -
        {{ date('h:i A', strtotime($timeSlot['end_time'])) }}
    </label>
</li>
@endforeach
@else
<li class="enable time-slot text-capitalize text-start test">
    <label for="time-slot-0">
        <p class="time-slot-p"> </p>
        {{ __('frontend.slot_not_available') }}
        <span>{{ __('frontend.select_another_date') }}</span>
    </label>
</li>
@endif
