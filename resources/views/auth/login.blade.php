<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BTTD Online.</title>
  <link href="{{url('/icon/favfav.png')}}" rel="icon">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('adminlte/dist/css/AdminLTE.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('adminlte/plugins/iCheck/square/blue.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
</head>
<body class="hold-transition login-page" style="overflow-y: hidden;background:url({{url('icon/bgbg.jpg')}})">
    <div class="login-box" style="margin: 0% auto;width: 390px;">
        <div class="login-logo" style="margin-bottom: 0px;background: #d9e0e7;"><br>
        <img src="{{ url('icon/ksks.png')}}" width="30%" ><br><br>
        <div style="background: #4f5444;font-size:15px;color: #fff;">BTTD (Bukti Tanda Terima Dokumen)</div>
        </div>
            <!-- /.login-logo -->
            <div class="login-box-body" style="background: #d9e0e7;">
                <p class="login-box-msg">Sign in to start your session</p>
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        <div class="form-group has-feedback">
                            <input  id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                           
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            
                        </div>
                        <div class="form-group has-feedback">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            

                                 @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    &nbsp;
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                
                            </div>
                        </div>
                    </form>
        </div>
        <!-- /.login-box-body -->
        <div class="login-logo" style="margin-bottom: 0px;background: #d9e0e7;height:300px">
            <p style="background: #4f5444;font-size:15px;color: #fff;text-transform:uppercase">&nbsp;</p>
        </div>
    </div>
    <!-- /.login-box -->

    
    </body>

</html>
