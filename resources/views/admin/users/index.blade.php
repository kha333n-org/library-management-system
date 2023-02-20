@extends('adminlte::page')

@section('title', 'Users List')

@section('content_header')
    <h1 class="m-0 text-dark">Users List</h1>
@stop

@section('content')

    {!! $dataTable->table( ['class' => 'table table-striped table-bordered', 'style' => 'width:100%'],
        true) !!}

@stop

@section('js')
    {!! $dataTable->scripts() !!}
@stop
