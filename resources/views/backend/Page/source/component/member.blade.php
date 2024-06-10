@if (isset($filter['member']))
<select name="member" class="input-sm form-control input-s-sm inline">
    @foreach ($filter['member'] as $key =>  $record)
        <option {{ request('member') == $key ? "selected" :  old('member') }} value="{{ $key }}">{{ $record }}</option>
    @endforeach
</select>
@else
<select name="status" class="input-sm form-control input-s-sm inline">
    @foreach ($filter['status'] as $key =>  $record)
        <option {{ request('status') == $key ? "selected" :  old('status') }} value="{{ $key }}">{{ $record }}</option>
    @endforeach
</select>
@endif
