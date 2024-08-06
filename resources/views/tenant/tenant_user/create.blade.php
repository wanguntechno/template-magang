@extends('adminlte::page')

@section('title', 'Create Tenant User')

@section('content_header')
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class='card-header'>
                @if ($breadcrumb) {!! $breadcrumb !!} @endif
            </div>
            <form action="{{route('tenant.tenant-user.store', [$tenant->uuid])}}" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    @method('POST')
                    @csrf
                    @include('tenant.tenant_user.form')
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{route('tenant.tenant-user', [$tenant->uuid   ])}}" class="btn btn-default">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
@stop
