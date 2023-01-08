@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-5">
        <h2>New Entry</h2>
    </div>
</div>

<div class="container container-smwrap">

    <form method="POST" action="{{ route('entry.store') }}">
        @csrf
        <div class="row gy-3">

            <div class="col-12 col-md-9">

                <div class="mb-3 row" id="activeVaultWrapper">

                    <div class="col">
                        <p class="m-0">Posting to</p>
                        <h5 class="m-0 active-vault-name">@if (old('vault_name')){{ old('vault_name') }}@else{{ $vaults[0]->name }}@endif</h5>
                        <input class="active-vault-name-val" type="hidden" name="vault_name" value="@if (old('vault_name')){{ old('vault_name') }}@else{{ $vaults[0]->name }}@endif" />
                        <input class="active-vault-id-val" type="hidden" name="vault_id" value="@if (old('vault_id')){{ old('vault_id') }}@else{{ $vaults[0]->id }}@endif" />
                    </div>

                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="offcanvas" data-bs-target="#vaultSelect" aria-controls="vaultSelect">Change Vault</button>
                    </div>

                </div>

                <div class="entry-card card">
                    <div class="card-body">

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="entry_title" id="entryTitle" placeholder="Add a title (Optional)" @if (old('entry_title'))value="{{ old('entry_title') }}@endif" />
                                        <label for="entryTitle">Add a title</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="entry_date" id="entryDate" placeholder="Add a date" value="@if (old('entry_date')){{ old('entry_date') }}@else{{ date('Y-m-d', strtotime('now')) }}@endif" />
                                        <label for="entryTitle">Entry Date</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="entry_address" id="entryAddress" placeholder="Add a location (Optional)" @if (old('entry_address'))value="{{ old('entry_address') }}@endif" /> 
                                        <label for="entryAddress">Add a location</label> 
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <textarea name="entry_content" id="entryContent" class="form-control" placeholder="Add your memory">@if (old('entry_content')){{ old('entry_content') }}@endif</textarea>
                                        <label for="entryContent">Add your memory</label>
                                    </div>
                                </div>

                                <div class="col-12 image-upload-wrapper">
                                    <h5>Add your photos</h5>

                                    <input type="file" data-max-count="6" data-max-size="20971520" name="image-upload" accept="image/*" id="imageUpload" multiple />
                                    <label for="imageUpload" id="imageUploadButton" class="btn btn-primary">Upload Photos</label>

                                    <div id="uploadPreviews" class="row mt-4"></div>
                                </div>

                            </div>
                        

                    </div>
                </div> 
            </div>

            <div class="col-12 col-md-3">
                <div class="submit-card card">
                    <div class="card-body text-center">
                        <input type="submit" value="Save to Archive" class="btn btn-secondary w-100" />
                    </div>
                </div>
            </div> 

        </div>
    </form>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="vaultSelect" aria-labelledby="vaultSelect">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title">Select your vault</h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">

        <div class="row vault-select-vaults">
            @foreach ($vaults as $vault)
            <div class="vault-select-vault col-12 gy-4">
                <div class="vault-select-vault-inner">

                    <div class="col vault-name">
                        <h4>{{ $vault->name }}</h4>
                    </div>
                    <div class="col-auto vault-button">
                        <button class="btn btn-secondary vault-change" data-vault-id="{{ $vault->id }}" data-vault-name="{{ $vault->name }}">Select</button>
                    </div>

                </div>          
            </div>
            @endforeach    
        </div>

    </div>
</div>
@endsection

@section('js')
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiOjAGV6rEayPD81Ojv2-vFt8veYsHRWA&libraries=places&callback=initMap"></script>
<script type="module">

    var vaultChangeOffcanvas = new bootstrap.Offcanvas(document.getElementById('vaultSelect'));
    const input = document.getElementById("entryAddress");
    const options = {
        fields: ["address_components", "geometry", "name"],
    };

    try {
        const autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.addListener('place_changed', function() {
            let place = autocomplete.getPlace();
            console.log(JSON.stringify(place));
        });
    } catch (e) {}    

    $('#imageUpload').on('change', function(e) {

        let files = e.target.files,
            maxSize = parseInt($(this).attr('data-max-size')),
            maxCount = parseInt($(this).attr('data-max-count')),
            curCount = $('.image-upload-data').length;

        for (let i = 0; i < files.length; i++) 
        {
            if (!files[i].type.match('image.*')) {
                displayToast('Only images are accepted for upload', 'exclamation-circle', 'danger');
                continue;
            }

            if (curCount >= maxCount) {
                displayToast('You can only upload up to ' + maxCount + ' images per entry', 'exclamation-circle', 'danger');
                break;
            }

            if (files[i].size > maxSize) {
                displayToast('Image exceeds size restriction of ' + Math.round(maxSize / 1024 / 1024) + 'Mb', 'exclamation-circle', 'danger');
                continue;
            }

            loadImageElement(files[i]);
            curCount++;

        }

        $(this).val('');

    });

    $('.vault-change').click(function() {
        vaultChange(
            $(this).attr('data-vault-id'),
            $(this).attr('data-vault-name')
        );
        vaultChangeOffcanvas.hide();
    });

    $('body').on('click', ".image-upload-delete", function(e) {
        $(this).parent().remove();
    });

    /**
     * Handles image insertion into the dom including loading handling
     * 
     * @param File image : JavaScript File containing image data
     */
    function loadImageElement(image)
    {
        let tempImage = generateImageElement('');
        $('#uploadPreviews').append(tempImage);

        let reader = new FileReader();
        reader.onload = function (e) {
            tempImage.after(generateImageElement(e.target.result));
            tempImage.remove();
        }
        reader.readAsDataURL(image);
    }

    /**
     * Generates an HTML element to show the preview of uploaded images
     * Returns the jQuery selector for direct insertion into the DOM
     * 
     * <div class="image-upload col-6 col-md-4">
     *     <div class="image-spinner-wrapper"><div class="spinner-border text-primary"></div></div>
     *     <div class="image-upload-preview"></div>
     *     <input type="hidden" value="" name="image[]" />
     *     <div class="image-upload-delete"><i class="bi bi-x-circle-fill"></i></div>
     * </div>
     * 
     * @param File imgData : JavaScript File containing image data
     * @return jQuerySelector
     */
    function generateImageElement(imgData)
    {
        let containerElement = $('<div>').addClass('image-upload col-6 col-md-4');
        
        // The image container
        $('<div>').attr({
            'class': 'image-upload-preview my-2'
        }).css({
            'background-image': 'url(' + imgData + ')'
        }).appendTo(containerElement);

        // The `loading` spinner for before the image loads
        $('<div>').addClass('image-spinner-wrapper').html(
            '<div class="spinner-border text-primary"></div>'
        ).appendTo(containerElement);

        // The hidden element containing the image data
        $('<input>').addClass('image-upload-data').attr({
            'type': 'hidden',
            'name': 'images[]',
            'value': imgData,
        }).appendTo(containerElement);

        // The `delete image` element
        $('<div>')
            .addClass('image-upload-delete')
            .html('<i class="bi bi-x-circle-fill"></i>')
            .appendTo(containerElement);

        return containerElement;
    }

    /**
     * Handles a vault change event fire
     *  
     * @param Integer vid : The vault ID
     * @param String name : The vault name
     */
    function vaultChange(vid, name)
    {
        $('.active-vault-name').each(function() {
            $(this).fadeOut(300, function() {
                $(this).html(name);
                $(this).fadeIn(300);
            });
        });
        $('.active-vault-name-val').each(function() {
            $(this).val(name);
        });
        $('.active-vault-id').each(function() {
            $(this).html(vid);
        });
        $('.active-vault-id-val').each(function() {
            $(this).val(vid);
        });

        displayToast('You are now posting to ' + name, 'check2-circle', 'success', true, 5000);

    }

</script>
@endsection