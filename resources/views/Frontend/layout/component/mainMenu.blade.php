@php
  
    $parent = implode('',$menus['parent']);
    $children = implode('',$menus['child']);
@endphp
<div class="css-16sn586 hidden" style="position: absolute; inset: 72px auto auto 109px; transform: translate(65px, 38px);" data-popper-reference-hidden="false" data-popper-escaped="false" data-popper-placement="bottom-start">
    <div class="css-xk1tic">
        <div class="css-1a4hakp">
           <div class="position-relative ">
                 <div class="css-1qagzjf">
                     <!-- render -->
                     {{-- <a class="css-1h3fn00" data-title="menu_laptop_id">
                        <div class="css-73wobg">
                           <div class="image_category">
                                 <div style="position: relative;display: inline-block;overflow: hidden;height: 100%;width: 100%;">
                                      <img class="h-100 w-100" src="https://res.cloudinary.com/dcbsaugq3/image/upload/v1716954858/cylqmrqyybgqjmswgbtb.webp"/>
                                 </div>
                           </div>
                           <div  class="css-13yxnyc" style="flex: 1 1 0%;">
                               Laptop
                           </div>
                        </div>
                     </a> --}}
                     {!! $parent !!}
                 </div>
                 </div>
   
                 <!-- Render category -->
                   <div class="css-j61855 hidden">
                          <!-- render -->
                          {{-- <div class="css-fej9ea">
                              <div class="" style="margin-bottom:1.5rem">
                                   <!-- render parent -->
                                   <div class="css-1h3fn00">
                                       <div class="css-18f5to7">
   
                                       </div>
                                   </div>
                                   <!-- render child -->
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                                    <a href="" class="css-1h3fn00">
                                        <div class="" style="color:#434657;margin-bottom: 4px">Apple</div>
                                    </a>
                              </div>
                          </div> --}}
                          {!! $children !!}
                    </div>
           </div>
        </div>
    </div>
   
   </div>