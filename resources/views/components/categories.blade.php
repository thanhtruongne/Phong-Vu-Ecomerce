@php
    $name = $attributes['name'] ?? 'category_parent_id';
@endphp
             
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('backend2/css/cusomTreeCategory.css')}}">
    <link rel="stylesheet" href="{{asset('backend2/css/treeSelect.min.css')}}">
    <script src="{{asset('backend2/js/treeSelect.min.js')}}"></script>
    <script>
        const options = @json($data);
        const domElement = document.querySelector('.treeselect_{{$name}}')
        const treeselect = new Treeselect({
            parentHtmlContainer: domElement,
            value: {{ is_array($value)? json_encode($value): $value}},
            options: options,
            placeholder: '-- Chọn danh mục --',
            isSingleSelect: {{$attributes['single']?$attributes['single']:true}},
        })

        treeselect.srcElement.addEventListener('input', (e) => {
           console.log('Selected value:', e.detail)
            $('#{{$name}}').val( e.detail );
        })
    </script>
    <div>
        <div class="treeselect treeselect_{{$name}}"></div>
        <input type="hidden" id="{{$name}}" name="{{$name}}" value="{{json_encode($value)}}">
    </div>
