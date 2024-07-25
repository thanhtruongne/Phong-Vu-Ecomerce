
@php
    $slider = json_decode($slider->item,true);

@endphp
<div style="flex: 1 1 0%;">
    <div class="css-1qt2w05">
       <div class="glide">
           <div class="glide__track" data-glide-el="track">
               <ul class="glide__slides">
                   @if (!empty($slider))
                       @foreach ($slider as $key =>  $slider_item)
                            <li class="glide__slide" >
                                <div style="height:566px" class="w-100 position-relative css-10ys7nl">
                                    <img src="{{ $slider_item['thumbnail'] }}" 
                                    alt="" style="width: 100%;height: 566px;object-fit: cover;">
                                </div>
                            </li>   
                       @endforeach
                   @endif
                  
                   {{-- <li class="glide__slide" >
                       <div style="height:566px" class="w-100 position-relative css-10ys7nl">
                           <img src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1716978936/nm6xhbgwydrjsajetmva.webp" 
                           alt="" style="width: 100%;height: 566px;object-fit: cover;">
                       </div>
                   </li>   
                   <li class="glide__slide" >
                       <div style="height:566px" class="w-100 position-relative css-10ys7nl">
                           <img src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1716978941/p5px22eynuyg6rxaxusn.webp" 
                           alt="" style="width: 100%;height: 566px;object-fit: cover;">
                       </div>
                   </li>   
                   <li class="glide__slide" >
                       <div style="height:566px" class="w-100 position-relative css-10ys7nl">
                           <img src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1716978947/ohzujeozzv1ruziphl83.webp" 
                           alt="" style="width: 100%;height: 566px;object-fit: cover;">
                       </div>
                   </li>   
                   <li class="glide__slide" >
                       <div style="height:566px" class="w-100 position-relative css-10ys7nl">
                           <img src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1716978954/pjlm9pdsrwhcojrfksr7.webp" 
                           alt="" style="width: 100%;height: 566px;object-fit: cover;">
                       </div>
                   </li>    --}}
               </ul>
           </div>

           <div class="glide__arrows" data-glide-el="controls">
               <button class="glide__arrow glide__arrow--left access_arrow_slide_left" data-glide-dir="<">
                     <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggb3BhY2l0eT0iMC4zIiBkPSJNMCAwSDI0QzM3LjI1NDggMCA0OCAxMC43NDUyIDQ4IDI0QzQ4IDM3LjI1NDggMzcuMjU0OCA0OCAyNCA0OEgwVjBaIiBmaWxsPSIjMUIxRDI5Ii8+CjxwYXRoIGQ9Ik0yNi41IDE4TDIwLjUgMjRMMjYuNSAzMCIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K" alt="">
               </button>
               <button class="glide__arrow glide__arrow--right access_arrow_slide_right" data-glide-dir=">">
                    <img src=" data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA0OCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggb3BhY2l0eT0iMC4zIiBkPSJNMCAyNEMwIDEwLjc0NTIgMTAuNzQ1MiAwIDI0IDBINDhWNDhIMjRDMTAuNzQ1MiA0OCAwIDM3LjI1NDggMCAyNFoiIGZpbGw9IiMxQjFEMjkiLz4KPHBhdGggZD0iTTIxLjUgMzBMMjcuNSAyNEwyMS41IDE4IiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=" alt="">
               </button>
           </div>

           <div class="glide__bullets" data-glide-el="controls[nav]">
               <button class="glide__bullet" data-glide-dir="=0"></button>
               <button class="glide__bullet" data-glide-dir="=1"></button>
               <button class="glide__bullet" data-glide-dir="=2"></button>
               <button class="glide__bullet" data-glide-dir="=3"></button>
               <button class="glide__bullet" data-glide-dir="=4"></button>
           </div>
       </div>         
    </div>
   
</div>

  