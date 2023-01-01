@extends('layouts.app')

@section('content')
<div class="container vault-invite-guest">

    <x-full-logo/>

    <hr/>

    @if ($invite->isExpired())
        <h2 class="my-5 fst-italic text-muted">This invite has expired</h2>
    @else

    <h3>You've received a vault invite!</h3>

    <div class="vault-invite my-5">
        <div class="vault-invite-inner card">

            <div class="card-body">
                <h6>You've been invited to join</h6>
                <h4>{{ $invite->vault->name }}</h4>
                <p class="vault-invite-byline">by {{ $invite->fromUser->name }}</p>

                <p class="vault-invite-expires text-muted text-center">Expires in {{ $invite->expiresIn() }}</p>

            </div>

        </div>
    </div>

    <p>Login or register to accept your invitation</p>

    @endif

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
