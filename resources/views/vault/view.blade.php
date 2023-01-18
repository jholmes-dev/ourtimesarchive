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
                
                <div class="tab-pane fade show active" id="vaultInfo" role="tabpanel" aria-labelledby="vaultInfoTab">
                    <div class="tab-content-inner row justify-content-center">
                        
                        <div class="col-12 col-md-6">
                            <div class="info-group">
                                <h4>Vault Created</h4>
                                <p>{{ date('F j, Y', strtotime($vault->created_at)) }}</p>
                            </div>
                            <div class="info-group">
                                <h4>Last Unlock</h4>
                                <p>Not yet unlocked</p>
                            </div>
                            <div class="info-group">
                                <h4>Entries</h4>
                                <p>---</p>
                            </div>

                            <div class="info-group vault-member-list">
                                <h4>Vault Members</h4>

                                <table class="table">
                                    <tbody class="border-top">
                                        @foreach ($vault->users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td class="text-success text-end">Active</td>
                                        </tr>
                                        @endforeach
                                        @foreach ($vault->invites as $invite)
                                        <tr>
                                            <td>{{ $invite->to }}</td>
                                            @if ($invite->rejected)
                                            <td class="text-danger text-end">Invite Rejected</td>
                                            @else
                                            <td class="text-end">Invite Pending</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <h4>Update vault photo</h4>

                            <div class="vault-photo-upload">

                                <label for="imageUpload" id="imageUploadLabel" class="iul-holdheight">
                                    <i class="upload-icon bi bi-plus-circle"></i>
                                </label>

                                <form enctype="multipart/form-data" action="{{ route('vault.photo.update', $vault->id) }}" method="POST">
                                    @csrf
                                    <input type="file" data-max-size="20971000" name="vault_photo" accept="image/*" id="imageUpload" />

                                    <div class="text-end mt-4">
                                        <input type="submit" class="btn btn-primary" value="Save Photo">
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="tab-pane fade" id="entries" role="tabpanel" aria-labelledby="entriesTab">
                    Feature in progress

                    @foreach ($vault->entries as $entry)
                        <p>
                            {{ $entry->id }} <span class="float-end">{{ $entry->user->name }}</span>
                            @foreach ($entry->assets as $asset) 
                            <p class="m-0">{{ $asset->id }}</p>
                            @endforeach
                        </p>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="unlock" role="tabpanel" aria-labelledby="unlockTab">
                    Feature in progress
                </div>
                <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leaveTab">
                    
                    <p>Once you leave a vault <strong>you cannot return</strong>. All of your entries (both locked and unlocked), images, and any other data associated with the vault will be <strong>permanently deleted</strong>. If you are the last vault member, the vault will also be permanently deleted.</p>
                    <p>Please consider carefully before continuing, as <strong>this action cannot be undone</strong>.</p>

                    <div class="my-5 text-center">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#leaveModal">Leave Vault</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('vault.leave', $vault->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="leaveModalLabel">Leave Vault Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you'd like to leave <strong>{{ $vault->name }}</strong>?</p>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Nevermind</button>
                    <input type="submit" class="btn btn-danger" value="Yes, Leave Vault">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/single-image-upload.js') }}"></script>
@endsection