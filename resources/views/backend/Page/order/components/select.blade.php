<div  style="width:50%;display:flex;justify-content:space-between" class="">
    @foreach (config('apps.order.filter_order') as $key =>  $item)
        <select  style="width: 23%;margin:0 4px" name="{{ $key }}" class="input-sm form-control input-s-sm inline select2">
            @foreach (config('apps.order.filter_order.'.$key.'') as $index =>  $val)
                <option {{ request($key) == $index ? "selected" :  old($key) }} value="{{ $index }}">{{ $val }}</option>
            @endforeach
        </select>
    @endforeach
</div>
