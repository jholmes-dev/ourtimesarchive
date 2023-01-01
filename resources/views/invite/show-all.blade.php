@extends('layouts.app')

@section('content')
<div class="container">

    <div class="invites-list mb-5">

        <h2>Vault Invites</h2>

        @if ($invites->isEmpty())
        <div class="my-5 text-center">
            <h3>Any invites you receive will show up here</h3>
        </div>
        @endif

        <div class="row gy-4 mt-4">

            @foreach ($invites as $invite)
            <div class="vault-invite col-12 col-md-6 col-lg-4">
                <div class="vault-invite-inner card">

                    <div class="card-body">
                        <h6>You've been invited to join</h6>
                        <h4>{{ $invite->vault->name }}</h4>
                        <p class="vault-invite-byline">by {{ $invite->fromUser->name }}<br/><span class="text-muted">{{ $invite->fromUser->email }}</span></p>

                        <div class="row justify-content-between">
                            <div class="col-7 col-xl-8">
                                <a href="{{ route('invite.accept', $invite->id) }}" onclick="event.preventDefault();document.getElementById('acceptInvite{{ $loop->iteration }}').submit();" class="w-100 btn btn-primary">Accept</a>

                                <form id="acceptInvite{{ $loop->iteration }}" action="{{ route('invite.accept', $invite->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                            <div class="col-5 col-xl-4">
                                <a href="{{ route('invite.reject', $invite->id) }}" onclick="event.preventDefault();document.getElementById('rejectInvite{{ $loop->iteration }}').submit();" class="w-100 btn btn-secondary">Reject</a>

                                <form id="rejectInvite{{ $loop->iteration }}" action="{{ route('invite.reject', $invite->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>

                        <p class="vault-invite-expires text-muted text-center">Expires in {{ $invite->expiresIn() }}</p>

                    </div>

                </div>
            </div>
            @endforeach

        </div>

    </div>
    
</div>
@endsection
