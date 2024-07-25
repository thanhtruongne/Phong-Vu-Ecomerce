@extends('Frontend.layout.layout')
@section('title')

@endsection

@section('content')
  <div class="container">
    <div class="row  justify-content-center">
        <div class="d-flex justify-content-center mt-4 bg-white" style="width: 500px;padding:30px;">
            <form class="w-100" action="{{ route('store.login') }}" method="POST">
                @csrf
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Email address</label>
                    <input type="text" id="form2Example1" value="{{ old('email') }}" name="email" class="form-control" />
                    @if ($errors->has('email'))
                        <div class="mt-2">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    @endif
                </div>
              
                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example2">Mật khẩu</label>
                    <input type="password" name="password" value="{{ old('password') }}" id="form2Example2" class="form-control" />
                    @if ($errors->has('password'))
                        <div class="mt-2">
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>
                    @endif
                    
                </div>
              
                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">             
                  <div class="col">
                    <!-- Simple link -->
                    <a href="#!">Quên mật khẩu</a>
                  </div>
                </div>
              
                <!-- Submit button -->
                <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Đăng nhập</button>
              
                <!-- Register buttons -->
                <div class="text-center">
                  <p>Chưa có tài khoản <a href="#!">Đăng ký</a></p>
                  <p>or sign up with:</p>
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                  </button>
              
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
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