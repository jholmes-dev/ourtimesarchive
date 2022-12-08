@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="d-flex justify-content-between align-items-center">Your Vaults<a href="{{ route('vault.create') }}" class="btn btn-secondary">New Vault</a></h2>

    @if ($vaults->isEmpty())
    <div class="my-5 text-center">
        <h3>There doesn't seem to be anything here.<br/>Try creating your first vault</h3>
        <p><a href="{{ route('vault.create') }}" class="btn btn-primary btn-lg">Create a Vault</a></p>
    </div>
    @endif

</div>
@endsection
