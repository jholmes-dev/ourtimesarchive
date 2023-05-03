@extends('layouts.app')

@section('content')
<div class="container container-maxwrap" id="unlock-view">

    <div class="entry-controlbar">
        <button id="prevEntry" class="btn btn-text text-primary"><i class="bi bi-arrow-left-circle-fill"></i></button>
        <button id="nextEntry" class="btn btn-text text-primary"><i class="bi bi-arrow-right-circle-fill"></i></button>
    </div>

    <div class="entry-wrapper">

        <div class="entry-loading text-primary text-center">
            <div class="spinner-border mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h5>Loading, please wait</h5>
        </div>

        <div id="entry-inner-wrapper" class="entry-inner row gy-3 gy-lg-5">

            <div class="entry-content-wrapper col-12">

                <div class="entry-content-header">
                    <h6 id="entry-date"></h6>
                    <h2 id="entry-title"></h2>
                    <h5 id="entry-author" class="text-muted"></h5>
                </div>

                <div id="entry-content"></div>  

            </div>


            <div id="entry-assets" class="col-12 col-lg-6">
                <div class="entry-assets-inner">
                    <button id="prevSlide" class="slide-control btn btn-text"><i class="bi bi-arrow-left-short"></i></button>
                    <button id="nextSlide" class="slide-control btn btn-text"><i class="bi bi-arrow-right-short"></i></button>

                    <div id="entry-assets-wrapper"></div>
                    <div id="entry-thumbnail-wrapper"></div>
                </div>
            </div>

            <div id="entry-map" class="col-12 col-lg-6">
                <div id="entry-assets-placeholder"></div>
            </div>


        </div>
    </div>

    <input type="hidden" id="getEntriesUrl" value="{{ route('api.unlock.entries.get', $unlock->id) }}">
    <input type="hidden" id="unlockId" value="{{ $unlock->id }}">

</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/unlock/unlock-page.js') }}"></script>
@endsection