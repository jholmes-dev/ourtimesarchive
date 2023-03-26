@extends('layouts.app')

@section('content')
<div class="container">

    <div class="unlock-header my-5 text-center">
        <h1>You're cracking open <em>{{ $unlock->vault->name }}</em></h1>
        <h6 class="text-primary text-end"><em>How exciting!</em></h6>

        <h5>Each vault member needs to authorize the unlock below</h5>
    </div>  

    <div class="unlock-cards row justify-content-center gy-5 g-4">
        @foreach ($unlock->unlockAuthorizations as $ua)
        <div class="unlock-auth uauth{{ $loop->iteration }} @if($ua->authorized_at !== NULL) uauth-success @endif col-12 col-md-6 col-lg-4">
            <div class="ua-inner bg-white rounded p-4 shadow-sm">
                <div class="unlock-success rounded"><i class="bi bi-unlock"></i></div>

                <div class="row align-items-center g-4">
                    <div class="ua-password col-12">
                        <input type="password" class="form-control auth-password passwordInput{{ $loop->iteration }}" placeholder="Enter your password">
                    </div>

                    <div class="ua-user col">
                        <h5 class="mb-0">{{ $ua->user->name }}</h5>
                        <input type="hidden" class="uidInput{{ $loop->iteration }}" value="{{ $ua->user->id }}">
                        <input type="hidden" class="uaidInput{{ $loop->iteration }}" value="{{ $ua->id }}">
                    </div>

                    <div class="ua-submit col-auto">
                        <button class="btn btn-primary submitAuthorization" authindex="{{ $loop->iteration }}">Authorize</button>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <input type="hidden" id="authUrl" value="{{ route('api.uauth.verify') }}">

</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/unlock/authorization.js') }}"></script>
@endsection