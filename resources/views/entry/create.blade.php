@extends('layouts.app')

@section('content')
<div class="container container-smwrap">

    <h2>New Entry</h2>

    <div class="my-5 entry-card card">
        <div class="card-body">

            <form>
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="entry_title" id="entryTitle" placeholder="Add a title (Optional)" />
                            <label for="entryTitle">Add a title (Optional)</label>
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
                            <label for="entryAddress">Add a location (Optional)</label> 
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="entry_content" id="entryContent" class="form-control" placeholder="Add your memory"></textarea>
                            <label for="entryContent">Add your memory</label>
                        </div>
                    </div>

                    <div class="col-12 image-upload-wrapper">
                        <h5>Add photos</h5>

                        <input type="file" data-max="10" name="image-upload " id="imageUpload" multiple />
                        <label for="imageUpload" id="imageUploadButton" class="btn btn-primary">Upload Images</label>

                        <div id="imageGallery"></div>
                    </div>

                </div>
            </form>

        </div>
    </div>  

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

    let imgArray;

    $('#imageUpload').on('change', function(e) {

        let files = e.target.files,
            maxCount = $(this).attr('data-max');

        for (let i = 0; i < files.length; i++) 
        {
            if (!files[i].type.match('image.*') || imgArray.length > maxCount) {
                return false;
            }

            imgArray.push(files[i]);

            let reader = new FileReader();
            reader.onload = function (e) {
                let html = '<div class="uploaded-image"><div style="background-image: url(' + e.target.result + ')" data-number="' + $(".uploaded-image-remove").length + '" data-file="' + files[i].name + '" class="uploaded-image-background"><div class="uploaded-image-remove"></div></div></div>';
                $('#imageGallery').append(html);
            }
            reader.readAsDataURL(files[i]);

        }

        e.target.files = imgArray;

    });

    $('body').on('click', ".uploaded-image-remove", function(e) {
        var file = $(this).parent().data("file");
        
        for (var i = 0; i < imgArray.length; i++) 
        {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }

        $(this).parent().parent().remove();
    });

</script>
@endsection