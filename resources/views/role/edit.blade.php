@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class='card-header'>
                @if ($breadcrumb) {!! $breadcrumb !!} @endif
            </div>
            <form action="{{route('role.update',[$role->uuid])}}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @method('PUT')
                    @csrf
                    @include('role.form')
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{route('role')}}" class="btn btn-default">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="submit-data">Simpan</button>
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
