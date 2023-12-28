@extends('layouts.mr')

@push('scripts')

@endpush

@push('head_scripts')
    @vite(['resources/js/app.ts'])
@endpush

@section('content')
    <div class="container-fluid">
        <div id="app"></div>
    </div>
@endsection
