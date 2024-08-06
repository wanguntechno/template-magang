@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@if(have_permission('dashboard_view'))
<h1 class='text-light'>Dashboard</h1>
@endif
@stop

@section('content')

@if(have_permission('dashboard_view'))

<div class="row">

</div>

@endif
@stop

@section('css')
@stop

@section('js')
<script
    {{--  <script src="{{ asset('js/page/page-dashboard-report.js') }}" type="module"></script>  --}}
@stop
