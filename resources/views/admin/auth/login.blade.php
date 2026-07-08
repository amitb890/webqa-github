@extends('admin.layouts.auth')
@section('content')

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ route('admin.login') }}" class="h1"><b>Webqa</b> Admin</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ route('admin.store') }}" method="post">
          @csrf

        <div class="mb-3">
            <div class="input-group">
            <input type="text" id="username" name="username" class="form-control {{ $errors->has('username') ? 'invalid' : ''  }}" placeholder="Username" value="{{ old('username') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-user"></span>
                </div>
            </div>
            </div>
            @if ($errors->has('username'))
                <span class="feedback">{{ $errors->first('username') }}</span>   
            @endif
        </div>
        <div class="mb-3">
            <div class="input-group">
            <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'invalid' : ''  }}" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-lock"></span>
                </div>
            </div>
            </div>
            @if ($errors->has('password'))
                <span class="feedback">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="remember">
                <label for="remember">
                    Remember Me
                </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

@endsection
