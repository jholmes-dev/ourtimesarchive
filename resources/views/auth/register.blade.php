@extends('layouts.app')

@section('content')
<div class="container register-page">

    <div class="sm-wrapper register-form">

        <div class="logo-section mb-3">
            <div class="logo-image">
                <img src="{{ Vite::asset('resources/images/logo-icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" />
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-floating mb-3">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Your Name" autofocus>
                <label for="name">Your Name*</label>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email@example.com">
                <label for="email">Email Address*</label>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="password">
                <label for="password">Password*</label>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                <label for="password">Confirm Password*</label>
            </div>

            <div class="mb-0 row align-items-center">

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-lg">
                        {{ __('Register') }}
                    </button>
                </div>

                <div class="col">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>

            </div>
        </form>

    </div>

</div>
@endsection
