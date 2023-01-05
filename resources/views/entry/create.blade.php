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

                <div class="mb-3">

                    <select class="form-select" name="vault_id">
                    @foreach ($vaults as $vault)
                        <option value="{{ $vault->id }}">{{ $vault->name }}</option>
                    @endforeach
                    </select>

                </div>

                <div class="entry-card card">
                    <div class="card-body">

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="entry_title" id="entryTitle" placeholder="Add a title (Optional)" />
                                        <label for="entryTitle">Add a title</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="entry_date" id="entryDate" placeholder="Add a date" value="{{ date('Y-m-d', strtotime('now')) }}" />
                                        <label for="entryTitle">Entry Date</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="entry_address" id="entryAddress" placeholder="Add a location (Optional)" /> 
                                        <label for="entryAddress">Add a location</label> 
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <textarea name="entry_content" id="entryContent" class="form-control" placeholder="Add your memory"></textarea>
                                        <label for="entryContent">Add your memory</label>
                                    </div>
                                </div>

                                <div class="col-12 image-upload-wrapper">
                                    <h5>Add your photos</h5>

                                    <input type="file" data-max="6" name="image-upload" accept="image/*" id="imageUpload" multiple />
                                    <label for="imageUpload" id="imageUploadButton" class="btn btn-primary">Upload Photos</label>

                                    <div id="uploadPreviews" class="row mt-4"></div>
                                </div>

                            </div>
                        

                    </div>
                </div> 
            </div>

            <div class="col-12 col-md-3">
                <div class="submit-card card">
                    <div class="card-body">
                        <input type="submit" value="Save to Archive" class="btn btn-secondary w-100" />
                    </div>
                </div>
            </div> 

        </div>
    </form>
</div>
@endsection

@section('js')
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiOjAGV6rEayPD81Ojv2-vFt8veYsHRWA&libraries=places&callback=initMap"></script>
<script type="module">
    
    const input = document.getElementById("entryAddress");
    const options = {
        fields: ["address_components", "geometry", "name"],
    };

    const autocomplete = new google.maps.places.Autocomplete(input, options);

    autocomplete.addListener('place_changed', function() {
        let place = autocomplete.getPlace();
        console.log(JSON.stringify(place));
    });

    $('#imageUpload').on('change', function(e) {

        let files = e.target.files,
            maxCount = $(this).attr('data-max');

        for (let i = 0; i < files.length; i++) 
        {
            if (!files[i].type.match('image.*')) {
                return false;
            }

            let reader = new FileReader();
            reader.onload = function (e) {
                $('#uploadPreviews').append(generateImageElement(e.target.result));
            }
            reader.readAsDataURL(files[i]);

        }

        $(this).val('');

    });

    $('body').on('click', ".image-upload-delete", function(e) {
        $(this).parent().remove();
    });


    /**
     * Generates an HTML element to show the preview of uploaded images
     * Returns the jQuery selector for direct insertion into the DOM
     * 
     * <div class="image-upload col-4">
     *     <div class="image-upload-preview"></div>
     *     <input type="hidden" value="" name="image[]" />
     *     <div class="image-upload-delete"><i class="bi bi-x-circle-fill"></i></div>
     * </div>
     * 
     * @param
     * @return jQuerySelector
     */
    function generateImageElement(imgData)
    {
        let containerElement = $('<div>').addClass('image-upload col-4');
        
        // The image container
        $('<div>').attr({
            'class': 'image-upload-preview my-2'
        }).css({
            'background-image': 'url(' + imgData + ')'
        }).appendTo(containerElement);

        // The hidden element containing the image data
        $('<input>').addClass('image-upload-data').attr({
            'type': 'hidden',
            'name': 'image[]',
            'value': imgData,
        }).appendTo(containerElement);

        // The `delete image` element
        $('<div>')
            .addClass('image-upload-delete')
            .html('<i class="bi bi-x-circle-fill"></i>')
            .appendTo(containerElement);

        return containerElement;
    }

</script>
@endsection