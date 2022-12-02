@extends('layouts.app')

@section('content')
<div class="container login-page">

    <div class="sm-wrapper login-form">

        <div class="lf-inner">

            <div class="logo-section mb-3">
                <div class="logo-image">
                    <img src="{{ Vite::asset('resources/images/logo-icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" />
                </div>
                <div class="logo-tagline mt-3">
                    <h3><span class="text-secondary"><u>OUR</u></span> TIMES ARCHIVE</h3>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
               
                <div class="form-floating mb-3">
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                    <label for="email">Email address</label>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <label for="password">Password</label>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="mb-0">

                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif

                </div>
            </form>

            <hr class="mt-5" />

            <div class="text-center">
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Register</a>
            </div>

        </div>

    </div>

</div>
@endsection
