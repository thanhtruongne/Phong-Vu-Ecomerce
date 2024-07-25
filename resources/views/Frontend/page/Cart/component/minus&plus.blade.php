<div class="teko-col teko-col-2 css-14k6732" style="text-center">
    <div class="d-flex flex-column align-items-center">
        <div class="css-1qgaj65" data-id="{{ $cart->rowId }}">
            {{-- minus --}}
            <button  class="css-1kcvffe minus click_change_quantity">
                <span class="css-1orfikq">
                    <svg fill="none" viewBox="0 0 24 24" size="16" class="css-cpb1o" color="disable" height="16" width="16" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 12C3.25 11.5858 3.58579 11.25 4 11.25H20C20.4142 11.25 20.75 11.5858 20.75 12C20.75 12.4142 20.4142 12.75 20 12.75H4C3.58579 12.75 3.25 12.4142 3.25 12Z" fill="#82869E"></path></svg>
                </span>
            </button>
            {{-- val --}}
            <div class="" style="flex: 1 1 0%;">
                <div class="css-1edkzvw" style="padding: 0px;border: none;background-color: transparent;">
                    <div class=""  style="position: relative;flex: 1 1 0%;padding: 0px 1px;">
                        <div class="h-100">
                            <input name="qualnity" class="qual_input w-100 h-100" value="{{ $cart->qty }}">
                        </div>
                    </div>
                </div>
            </div>
            {{-- plus --}}
            <button class="css-1i77det plus click_change_quantity">
                <span class="css-1orfikq">
                    <svg fill="none" viewBox="0 0 24 24" size="16" class="css-g427p8" color="textPrimary" height="16" width="16" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 4C12.75 3.58579 12.4142 3.25 12 3.25C11.5858 3.25 11.25 3.58579 11.25 4V11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H11.25V20C11.25 20.4142 11.5858 20.75 12 20.75C12.4142 20.75 12.75 20.4142 12.75 20V12.75H20C20.4142 12.75 20.75 12.4142 20.75 12C20.75 11.5858 20.4142 11.25 20 11.25H12.75V4Z" fill="#82869E"></path></svg>
                </span>
            </button>
        </div>
        <div class="css-3c7poi delete_cart_row" data-id="{{ $cart->rowId }}">Xóa</div>
    </div>
</div>