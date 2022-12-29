@extends('layouts.app')

@section('content')
<div class="container vault-invite-guest">

    <x-full-logo/>

    <hr/>

    <h3>You've received a vault invite!</h3>

    <div class="vault-invite my-5">
        <div class="vault-invite-inner card">

            <div class="card-body">
                <h6>You've been invited to join</h6>
                <h4>{{ $invite->vault->name }}</h4>
                <p class="vault-invite-byline">by {{ $invite->fromUser->name }}</p>

                @php
                /*
                <div class="row justify-content-between">
                    <div class="col-7 col-xl-8">
                        <a href="" class="w-100 btn btn-primary">Accept</a>
                    </div>
                    <div class="col-5 col-xl-4">
                        <a href="" class="w-100 btn btn-secondary">Reject</a>
                    </div>
                </div>
                */
                @endphp

                <p class="vault-invite-expires text-muted text-center">Expires in {{ date_diff(new DateTime($invite->expires), new DateTime())->days }} day(s)</p>

            </div>

        </div>
    </div>

    <p>Login or register to accept your invitation</p>

    <div class="row login-register-wrapper">
        <div class="col-6">
            <a href="{{ route('login') }}" class="btn btn-lg btn-primary">Login</a>
        </div>
        <div class="col-6">
            <a href="{{ route('register') }}" class="btn btn-lg btn-secondary">Register</a>
        </div>
    </div>
    
</div>
@endsection
