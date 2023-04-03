@extends('layouts.app')

@section('content')
<div class="container">

    Todo: Write routes to make entry assets accessible but protected. Display info here using a JS class for control. Create it in a different file and use a module export/import.

    <input type="hidden" id="getEntriesUrl" value="{{ route('api.unlock.entries.get', $unlock->id) }}">
    <input type="hidden" id="unlockId" value="{{ $unlock->id }}">

</div>
@endsection

@section('js')
<script type="module" src="{{ Vite::asset('resources/js/unlock/unlock-page.js') }}"></script>
@endsection