@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('content')
    
@stop

@if (session('success'))
    <script>
        alert('{{session('success')}}');
    </script>
@endif

@if (session('fail'))
    <script>
        alert('{{session('fail')}}');
    </script>
@endif