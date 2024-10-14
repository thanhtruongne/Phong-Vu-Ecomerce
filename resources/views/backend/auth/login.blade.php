<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('backend2/plugins//fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    {{-- <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend2/css/adminlte.css')}}">

    <style>

.div-center {
  width: 400px;
  height: 400px;
  padding: 20px;
  background-color: #fff;
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  margin: auto;
  max-width: 100%;
  max-height: 100%;
  overflow: auto;
  padding: 1em 2em;
  border: 1px solid #000000;
  display: table;
}

div.content {
  display: table-cell;
  vertical-align: middle;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="text-center">
                <div class="back">
                    <div class="div-center">                
                      <div class="content">
                        <h3>Đăng nhập vào hệ thống</h3>
                        <hr />
                            <form id="form-ajax" method="POST">
                                <div class="form-group mt-3 mb-3">
                                    <label for="exampleInputEmail1 " class="text-left form-label w-100">Tài khoản</label>
                                    <input type="text" class="form-control" value="{{ old('username') }}" name="username" id="exampleInputEmail1" placeholder="Tài khoản">
                                  
                                </div>
                                <div class="form-group mt-3 mb-3">
                                    <label for="exampleInputPassword1" class="text-left form-label w-100">Mật khẩu</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <button type="submit" class="w-100 mt-3 btn btn-primary save-login">Đăng nhập</button>
                                <hr />                 
                            </form>     
                      </div>
                    </div>
            </div>
        </div>
    </div>
    
</body>

<script src="{{asset('backend2/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('backend2/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('backend2/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('backend2/js/adminlte.min.js')}}"></script>

  <script src="{{asset('backend2/js/backend2.js')}}"></script>

<script>
    $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
     $('body').on('keypress',function(e){
         if(e.keyCode == 13){
            login();
         }
     })
    $('.save-login').on('click',function(e){
         login();
    })

    function login(){
        var btn = $('.save-login'),
        btn_text = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'POST',
            url: '{{route('private-system.be.login')}}',
            data : {
                'username' : $('input[name="username"]').val(),
                'password' : $('input[name="password"]').val(),
            }
        }).done(function(data){
        console.log(data);
            btn.prop('disabled', false).html(btn_text);
            if(data){
                if(data.status == 'error'){
                    show_message(data?.message, data?.status);
                    return false;
                }
                else {
                show_message(data?.message, data?.status);
                window.location.href = data.redirect;
                }
            }
        }).fail(function(data) {
            btn.prop('disabled', false).html(btn_text);
            show_message('Lỗi hệ thống', 'error');
            return false;
        });
    }

    })
</script>

</html>