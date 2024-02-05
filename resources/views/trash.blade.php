@extends('base')
@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/trash.js') }}"></script>
@endpush
@include('nav')
@section('content')
    @include('modals.trash.trash')
    <div class="card card-table">
        <div class="card-body">
            <table id="myTable" class="display"></table>
        </div>
    </div>
@endsection
