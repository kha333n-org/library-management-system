@php use Illuminate\Support\Carbon; @endphp
@extends('adminlte::page')

@section('title', 'Users List')

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            User Details
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary float-right" title="Edit"><i
                    class="material-icons">Edit</i></a>
            <a href="#" class="btn btn-danger float-right mr-2" title="Edit"><i class="material-icons">Delete</i></a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Name:</h5>
                    <p>{{ $user->name }}</p>
                    <h5>Email:</h5>
                    <p>{{ $user->email }}</p>
                    <h5>Address:</h5>
                    <p>{{ $user->address }}</p>
                </div>
                <div class="col-sm-6">
                    <h5>Phone Number:</h5>
                    <p>{{ $user->phone_number }}</p>
                    <h5>Active Status:</h5>
                    <p>
                        @if($user->is_active)
                            <span class="badge badge-success">Active</span></p>
                    @else
                        <span class="badge badge-danger">In-Active</span></p>
                    @endif
                    <h5>Created At:</h5>
                    <p>{{ Carbon::parse($user->created_at)->diffForHumans() }}</p>
                    <h5>Updated At:</h5>
                    <p>{{ Carbon::parse($user->updated_at)->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

@stop
