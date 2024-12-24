@extends('Frontend.layout.layout')
@section('title')
    Đăng nhập
@endsection

@section('content')
  <div class="container">
    <div class="row  justify-content-center">
        <div class="d-flex justify-content-center mt-4 bg-white" style="width: 500px;padding:30px;">
            <form class="w-100" id="form-login-fe"  method="POST">
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Email</label>
                    <input type="text" id="form2Example1" name="email" class="form-control" />
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example2">Mật khẩu</label>
                    <input type="password" name="password" id="form2Example2" class="form-control" />
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                  <div class="col">
                    <!-- Simple link -->
                    <a href="#!">Quên mật khẩu</a>
                  </div>
                </div>

                <!-- Submit button -->
                <button  type="submit" data-mdb-button-init data-mdb-ripple-init id="btn-login-submit" class="btn btn-primary btn-block mb-4">Đăng nhập</button>

                <!-- Register buttons -->
                <div class="text-center">
                  <p>Chưa có tài khoản <a href="#!">Đăng ký</a></p>
                  <p>or sign up with:</p>
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                  </button>

                  <button  type="button" id="btn-login-google" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-google"></i>
                  </button>

                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                  </button>

                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-github"></i>
                  </button>
                </div>
            </form>
        </div>

    </div>
  </div>
@endsection

@push('scripts')
   <script>
        $('#form-login-fe').submit(function(e){
           e.preventDefault();
            var formData = $(this).serialize();
            $('#btn-login-submit').html('<i class="fa fa-spinner fa-spin"></i>').attr("disabled", true);
            login(formData);
        })

        function login(formData){
            $.ajax({
                type: 'POST',
                url: '{{route('store.login')}}',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if(data?.status == 'error'){
                        $('#btn-login-submit').html('Đăng nhập').attr("disabled", false);
                        show_message(data?.message, data?.status);
                        return false;
                    } else {
                        show_message(data?.message,data?.status);
                        if(data?.redirect){
                            window.location.href = data?.redirect;
                        } else {
                            return false;
                        }
                    }
                    $('#btn-login-submit').html('Đăng nhập').attr("disabled", false);
                }
            }).fail(function(result) {
                $('#btn-login-submit').html('Đăng nhập').attr("disabled", false);
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });
        }

        $('#btn-login-google').on('click',function(){
            $.ajax({
                type: 'POST',
                url: '{{route('fe.login-sign-callback-google')}}',
                data: {},
                dataType: 'json',
                success: function(data) {
                    if(data){
                        window.location.href = data?.url;
                        return false;
                    }
                }
            }).fail(function(result) {
                show_message('Lỗi dữ liệu', 'error');
                return false;
            });
        })
   </script>

@endpush
