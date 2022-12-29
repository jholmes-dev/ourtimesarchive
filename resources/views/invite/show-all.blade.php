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
                                <a href="" class="w-100 btn btn-primary">Accept</a>
                            </div>
                            <div class="col-5 col-xl-4">
                                <a href="" class="w-100 btn btn-secondary">Reject</a>
                            </div>
                        </div>

                        <p class="vault-invite-expires text-muted text-center">Expires in {{ date_diff(new DateTime($invite->expires), new DateTime())->days }} day(s)</p>

                    </div>

                </div>
            </div>
            @endforeach

        </div>

    </div>
    
</div>
@endsection
