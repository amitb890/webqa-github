@extends('layouts.guest')

@section("content")

<div class="container">
    <div class="row my-header">
        <div class="col">
        <a href="{{ route('welcome') }}"><img class="logo" src="{{ asset('images/logo.png') }}"></a>
        </div>
    </div>
    <div class="row">
        <div class="col d-none d-md-block"></div>
            <div class="col">
                <div class="card-custom">
                    <div class="card-body-custom">
                    @if($errors->has('email'))
                        <span class="feedback mb-2">{{ $errors->first('email') }}</span>
                    @endif
                    <h5 class="card-title-custom">Reset Your Password</h5>
                    <p class="let">Enter your new password</p>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-24">
                            <label for="password" class="form-label label-bold">Password</label>
                            <input type="password" class="form-control h-5 {{ $errors->has('password') ? 'invalid' : ''  }}" name="password" id="password">
                            @if ($errors->has('password'))
                                <span class="feedback">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="mb-24">
                            <label for="password_confirmation" class="form-label label-bold">Confirm Password</label>
                            <input type="password" class="form-control h-5 {{ $errors->has('password') ? 'invalid' : ''  }}" name="password_confirmation" id="password_confirmation">
                        </div>

                        <div class="d-grid gap-2 mb-28">
                            <button class="btn btn-primary h-5" type="submit">Update Password</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        <div class="col  d-none d-md-block"></div>
    </div>
</div>
@endsection