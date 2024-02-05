@extends('base')
@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js" integrity="sha256-7NQm0bhvDJKosL8d+6ZgSi2LxZCIcA/TD087GLEBO9M=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endpush
@include('nav')
@section('content')
    @include('modals.task.task')
    <div class="card card-table">
        <div class="card-header">
            <div class="form-group row">
                <button id="add" type="button" class="btn btn-primary col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <ion-icon name="create-outline"></ion-icon>
                </button>
                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                    <input type="text" class="form-control form-control-sm" placeholder="Search" name="search">
                </div>
            </div>

            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input id="to-do" class="form-check-input" type="checkbox" name="task_status_ids" value="1" checked>
                    <label for="to-do" class="form-check-label" >TO-DO</label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="in-progress" class="form-check-input" type="checkbox" name="task_status_ids" value="2" checked>
                    <label for="in-progress" class="form-check-label">IN-PROGRESS</label>
                </div>
                <div class="form-check form-check-inline">
                    <input id="done" class="form-check-input" type="checkbox" name="task_status_ids" value="3" checked>
                    <label for="done" class="form-check-label" >DONE</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="myTable" class="display"></table>
        </div>
    </div>
@endsection
