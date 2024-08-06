@extends('adminlte::page')

@section('title', 'Edit Area')

@section('content_header')
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class='card-header'>
                @if ($breadcrumb) {!! $breadcrumb !!} @endif
            </div>
            <form action="{{route('area.update',[$area->uuid])}}" method="POST" enctype="multipart/form-data">
                <div class='card-body'>
                    @method('PUT')
                    @csrf
                    @include('area.form')
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{route('area')}}" class="btn btn-default">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        </>
    </div>
    @stop

    @section('css')

    @stop

    @section('js')

    @stop
