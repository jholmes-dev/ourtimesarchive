@extends('layouts.app')

@section('content')
<div class="container container-maxwrap" id="unlock-view">

    <div class="entry-wrapper">
        <div class="entry-inner row gy-3 gy-lg-5">

            <div class="entry-content-wrapper col-12">

                <div class="entry-content-header">
                    <h6 id="entry-date">November 3rd, 2022</h6>
                    <h2 id="entry-title">Entry Title</h2>
                    <h5 id="entry-author" class="text-muted">Entry Author</h5>
                </div>

                <div id="entry-content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>  

            </div>


            <div id="entry-assets" class="col-12 col-lg-6">
                <div id="entry-assets-placeholder"></div>
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