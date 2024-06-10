<select name="record" class="input-sm form-control input-s-sm inline">
    @foreach ($filter['record'] as $key =>  $record)
        <option {{ request('record') == $key ? "selected" :  old('record') }} value="{{ $key }}">{{ $record }}</option>
    @endforeach
</select>