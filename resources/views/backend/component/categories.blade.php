
<select name="categories" class="input-sm form-control input-s-sm inline">
    <option value="all">Tất cả</option>
    @if (!empty($categories) && isset($categories))
        @foreach ($categories as  $category)
            <option {{ request('categories') == $category->id ? "selected" :  old('categories') }} value="{{ $category->id }}">
                {{ str_repeat('|---', ($category->depth != 0 ? $category->depth : 0) ) }} {{ $category->name }}
            </option>
        @endforeach
    @endif

</select>

