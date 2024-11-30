@php
    $child = implode('',$menus['child']);
    $parent = implode('',$menus['parent']);
@endphp
<div class="css-16sn586 hidden position-absolute" id="data_class" style="top:-33px;right:0px">
    <div class="css-xk1tic">
        <div class="css-1a4hakp">
           <div class="position-relative ">
                <div class="css-1qagzjf">
                    {!! $parent !!}
                </div>
                <div class="css-j61855 hidden" style="padding: 16px 20px">
                    {!! $child !!}
                </div>
           </div>
        </div>
    </div>
   
</div>