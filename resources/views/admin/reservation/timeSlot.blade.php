
<label for="timeSlot">{{ __('levels.timeSlot') }}</label> <span class="text-danger">*</span>
<select id="timeSlot" name="time_slot" class="form-control select2 {{ $errors->has('timeSlot') ? " is-invalid " : '' }}">
    @if(!blank($timeSlots))
        @foreach($timeSlots as $timeSlot)
            <option value="{{$timeSlot['id']}}">{{ date('h:i A', strtotime($timeSlot['start_time'])) }} - {{ date('h:i A', strtotime($timeSlot['end_time'])) }}</option>
        @endforeach
    @endif
</select>
@if ($errors->has('timeSlot'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('timeSlot') }}</strong>
    </div>
@endif

