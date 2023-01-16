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
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Unlocked Entries</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Initiate Unlock</button>
                </li>
                <li class="nav-item ms-auto" role="presentation">
                    <button class="nav-link text-danger" id="leave-tab" data-bs-toggle="tab" data-bs-target="#leave" type="button" role="tab" aria-controls="leave" aria-selected="false">Leave Vault</button>
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
                            <div class="vault-info-group">
                                <h4>Vault Created</h4>
                                <p>{{ date('F j, Y', strtotime($vault->created_at)) }}</p>
                            </div>
                            <div class="vault-info-group">
                                <h4>Last Unlock</h4>
                                <p>Not yet unlocked</p>
                            </div>
                            <div class="vault-info-group">
                                <h4>Entries</h4>
                                <p>---</p>
                            </div>

                            <div class="vault-info-group vault-member-list">
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

                                    <div class="text-center mt-4">
                                        <input type="submit" class="btn btn-primary" value="Update Vault Photo">
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/single-image-upload.js') }}"></script>
@endsection