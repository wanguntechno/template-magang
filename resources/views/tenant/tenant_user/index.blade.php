@extends('adminlte::page')

@section('title', 'Tenant User')

@section('content_header')
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class='card-header'>
                <input type="hidden" id="tenant-uuid" value="{{ $tenant['uuid'] }}">
                @if ($breadcrumb) {!! $breadcrumb !!} @endif
                @if (have_permission('tenant_user_create'))
                <a href="{{ route('tenant.tenant-user.create', [$tenant->uuid]) }}" class="btn btn-primary btn-md float-right"><i class="fas fa-plus"></i></a>
                @endif
            </div>
            <br>
            <div class="card-body">
                {{-- @include('user.filter') --}}
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
    <script src="{{ asset('js/page/page-tenant-user.js') }}" type="module"></script>
@stop
