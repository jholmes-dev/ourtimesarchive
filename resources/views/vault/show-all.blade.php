@extends('layouts.app')

@section('content')
<div class="container">

    <div class="vaults-list mb-5">

        <h2 class="d-flex justify-content-between align-items-center">Your Vaults<a href="{{ route('vault.create') }}" class="btn btn-secondary">New Vault</a></h2>

        @if ($vaults->isEmpty())
        <div class="my-5 text-center">
            <h3>There doesn't seem to be anything here.<br/>Try creating your first vault</h3>
            <p><a href="{{ route('vault.create') }}" class="btn btn-primary btn-lg">Create a Vault</a></p>
        </div>
        @endif

        <div class="row gy-4 mt-4">

            @foreach ($vaults as $vault)
            <div class="vault col-12 col-md-6 col-lg-4">
                <div class="vault-inner card">



                    <div class="card-body text-center">
                        <h4>{{ $vault->name }}</h4>
                        <a href="" class="btn btn-primary"><i class="bi bi-plus"></i> New Entry</a>

                        <div class="vault-settings">
                            <a href="" class="text-muted"><i class="bi bi-gear-fill"></i></a>
                        </div>

                    </div>

                </div>
            </div>
            @endforeach

        </div>

    </div>

</div>
@endsection
