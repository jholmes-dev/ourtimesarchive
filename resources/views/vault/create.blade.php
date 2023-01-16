@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <h2>New Vault</h2>
</div>

<div class="container">

    <form enctype="multipart/form-data" id="createVaultForm" name="createVaultForm" method="POST" action="{{ route('vault.store') }}">
        @csrf

        <div class="row">

            <div class="col-12 col-lg-7">

                <h3>Enter vault information</h3>

                <div class="form-floating mb-5">
                    <input value="{{ old('vault_name') }}" type="text" name="vault_name" id="vault_name" class="form-control @error('vault_name') is-invalid @enderror" placeholder="Vault Name" required autofocus />
                    <label for="vault_name">Vault Name*</label>

                    @error('vault_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">

                    <h4>Vault Invitations (<span id="currentInviteCount">1</span>/9)</h4>
                    <p>Who would you like to invite to join this vault?<br/>You won't be able to add or remove people from your vault after it's created. (Why?)</p>

                    <div id="inviteList" class="mb-1">
                        <input type="email" name="invites[]" class="invite-field form-control mb-2" placeholder="Email Address" />
                    </div>

                    <div class="text-end">
                        <button id="addInvite" class="btn btn-outline-primary btn-sm">Add a field <i class="bi bi-person-plus"></i></button>
                    </div>

                </div>
            </div>

            <div class="col-12 col-lg-5">

                <h3>Choose a cover photo</h3>

                <div class="vault-photo-upload">

                    <label for="imageUpload" id="imageUploadLabel" class="iul-holdheight">
                        <i class="upload-icon bi bi-plus-circle"></i>
                    </label>

                    <input type="file" data-max-size="20971000" name="vault_photo" accept="image/*" id="imageUpload" />

                </div>

            </div>

            <div class="col-12 mt-5">
                <div>
                    <input type="submit" class="btn btn-lg btn-primary" value="Create Vault" />
                </div>
            </div>

        </div>

    </form>

</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/single-image-upload.js') }}"></script>
<script type="module">
    
    // Number of allowable invites
    const maxInvites = 9;

    @if (!empty(old('invites')))
        const oldInvites = {!! json_encode(old('invites')) !!};
        populateInviteFields(oldInvites);
    @endif

    $('#addInvite').click(function(e) {
        e.preventDefault();
        verifyInviteCount();
        $('#inviteList').append(createInviteElement());
        updateInviteCounter();
    });

    /**
     * Creates and returns a invite input field
     *
     */
    function createInviteElement(email = false) 
    {
        let parentElement = $('<input>').attr({
            'type': 'email',
            'name': 'invites[]',
            'class': 'invite-field form-control mb-2',
            'placeholder': 'Email Address'
        });

        if (email)
        {
            parentElement.attr('value', email);
        }

        return parentElement;
    }

    /**
     * Repopulates email fields in case of failure
     * 
     * @param Array invites : An array of email addresses to populate
     */
    function populateInviteFields(invites)
    {

        $('#inviteList').html('');

        for (let i = 0; i < invites.length; i++)
        {
            $('#inviteList').append(createInviteElement(invites[i]));
        }
        
        verifyInviteCount();
        updateInviteCounter();
    }

    /**
     * Updates the invite counter
     * 
     */
    function updateInviteCounter()
    {
        $('#currentInviteCount').html($('.invite-field').length);
    }

    /**
     * Verifies the count of invites, hiding the button as needed
     * 
     */
    function verifyInviteCount()
    {
        // Check if we're already at max invitees
        if ($('.invite-field').length >= maxInvites) 
        {
            return;
        
        // Hide the add button
        } else if ($('.invite-field').length == maxInvites - 1) 
        {
            $('#addInvite').css('display', 'none');
        }
    }
    

</script>
@endsection