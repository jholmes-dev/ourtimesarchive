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
                <p>{{ $vault->entries->count() }} <i class="bi bi-lock"></i> | -- <i class="bi bi-unlock"></i></p>
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

                <label for="imageUpload" id="imageUploadLabel" @if ($vault->vault_photo == null)class="iul-holdheight"@endif>
                    @if ($vault->vault_photo != null)
                        <div class="image-upload"><img class="image-upload-preview" src="{{ route('vault.photo.get', $vault->id) }}"></div>
                    @else 
                        <i class="upload-icon bi bi-plus-circle"></i>
                    @endif
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