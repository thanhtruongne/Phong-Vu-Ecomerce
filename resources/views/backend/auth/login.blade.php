<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Login System</title>

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
                            <form action="{{ route('private-system.post.login') }}" method="POST">
                                @csrf
                                <div class="form-group mt-3 mb-3">
                                    <label for="exampleInputEmail1 " class="text-left form-label w-100">Email</label>
                                    <input type="text" class="form-control" value="{{ old('email') }}" name="email" id="exampleInputEmail1" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <div class="mt-3 text-left text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mt-3 mb-3">
                                    <label for="exampleInputPassword1" class="text-left form-label w-100">Mật khẩu</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                                    @if ($errors->has('password'))
                                        <div class="mt-3 text-left text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                                <button type="submit" class="w-100 mt-3 btn btn-success">Đăng nhập</button>
                                <hr />                 
                            </form>     
                      </div>
                    </div>
            </div>
        </div>
    </div>
    
</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>