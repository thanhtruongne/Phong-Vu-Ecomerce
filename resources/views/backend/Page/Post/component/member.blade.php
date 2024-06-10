
<select name="status" class="input-sm form-control input-s-sm inline">
    @foreach ($filter['status'] as $key =>  $record)
        <option {{ $key  == request('status') ? "selected" :  old('status') }} value="{{ $key }}">{{ $record }}</option>
    @endforeach
</select>
