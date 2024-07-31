<div class="css-v6thbz">
    <div class="h-100 css-1k985bk">
        <div class="title css-1ew3940">Sắp xếp theo</div>
        @foreach (config('apps.sort.sort') as $sort)
            <div 
                data-type="{{ $sort['type'] }}"
                data-value="{{ $sort['value'] }}"
                class="bg-white  css-1w3mv8m checkbox_item_sort" 
                style="cursor: pointer;;border-radius: 4px;border:1px solid #e0e0e0;padding: 0.5rem;margin-right: 1rem;" >
                <div class="css-1lchwqw">{{ $sort['title'] }}</div>
            </div>
        @endforeach
    </div>
</div>