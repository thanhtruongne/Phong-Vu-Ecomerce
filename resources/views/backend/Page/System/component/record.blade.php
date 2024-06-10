<select name="record" class="input-sm form-control input-s-sm inline">
    @foreach ($data as $key =>  $record)
        <option {{ request('record') == $key ? "selected" :  old('record') }} value="{{ $key }}">{{ $record }}</option>
    @endforeach
</select>