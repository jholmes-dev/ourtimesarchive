@extends('layouts.app')

@section('content')
<div class="single-vault-page">
    <div class="container">
        
        <h2 class="m-0">Vault Settings</h2>
        <h4>{{ $vault->name }}</h4>

        <div class="vault-options-tabs mt-5">

            <ul class="nav nav-tabs" id="vaultOptions" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="vaultInfoTab" data-bs-toggle="tab" data-bs-target="#vaultInfo" type="button" role="tab" aria-controls="vaultInfo" aria-selected="true">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="entriesTab" data-bs-toggle="tab" data-bs-target="#entries" type="button" role="tab" aria-controls="entries" aria-selected="false">Unlocked Entries</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="unlockTab" data-bs-toggle="tab" data-bs-target="#unlock" type="button" role="tab" aria-controls="unlock" aria-selected="false">Initiate Unlock</button>
                </li>
                <li class="nav-item ms-auto" role="presentation">
                    <button class="nav-link text-danger" id="leaveTab" data-bs-toggle="tab" data-bs-target="#leave" type="button" role="tab" aria-controls="leave" aria-selected="false">Leave Vault</button>
                </li>
            </ul>

        </div>

    </div>
    <div class="container container-smwrap">
        <div class="vault-options-content my-5">
            <div class="tab-content" id="vaultOptionsContent">
                <x-vault-tabs.info
                    :vault="$vault" />
                <x-vault-tabs.entries
                    :vault="$vault" />
                <x-vault-tabs.unlock
                    :vault="$vault" />
                <x-vault-tabs.leave
                    :vault="$vault" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/single-image-upload.js') }}"></script>
@endsection