@extends('adminlte::master')

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
<div class="{{ $auth_type ?? 'login' }}-box">
    <h2>403 Access Denied</h2>
</div>
@stop

@section('adminlte_js')
@stack('js')
@yield('js')
@stop
