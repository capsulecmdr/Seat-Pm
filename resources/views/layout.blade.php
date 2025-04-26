@extends('web::layouts.app')

@section('page_header')
    <h1>
        SeAT-PM <small>Project Management</small>
    </h1>
@endsection

@section('content_wrapper')
    <div class="container-fluid">
        @yield('content')
    </div>
@endsection

@push('styles')
    <style>
        #gantt-target {
            overflow-x: auto;
            border: 1px solid #dee2e6;
            padding: 1rem;
            background: #fafafa;
        }
        .kanban-column {
            min-width: 250px;
            background-color: #f1f3f5;
            border-radius: 6px;
            padding: 10px;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .kanban-task {
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 8px;
            cursor: grab;
        }
        .kanban-hover {
            background-color: #e2e6ea !important;
        }
        .nav-tabs .nav-link {
            cursor: pointer;
        }
    </style>
@endpush