@extends('adminlte::page')

@section('title', 'Tenant')

@section('content_header')
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class='card-header'>
                @if ($breadcrumb) {!! $breadcrumb !!} @endif
                @if (have_permission('tenant_create'))
                <a href="{{ route('tenant.create') }}" class="btn btn-primary btn-md float-right"><i class="fas fa-plus"></i></a>
                @endif
            </div>
            <br>
            <div class="card-body">
                @include('tenant.filter')
                <br>
                <table id="datatable" class="table table-md table-hover dt-responsive nowrap" width="100%">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/page/page-tenant.js') }}" type="module"></script>
@stop
