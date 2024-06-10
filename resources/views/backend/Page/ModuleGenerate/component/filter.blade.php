<div class="input-group m-r">
    <input type="text" name="search" value="{{ request('search' ?: old('search')) }}"  placeholder="Search" class="input-sm form-control"> 
<span class="input-group-btn">
<button type="submit" class="btn btn-sm btn-primary">{{ $filter['filter']['search_title'] ?: 'Tìm kiếm' }}</button> </span></div>