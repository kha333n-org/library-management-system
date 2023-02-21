@extends('adminlte::page')

@section('title', 'View Role')

@section('content')

    <div class="container">
        <h1>Role Details</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" disabled>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h3>Permissions:</h3>
                <ul>
                    @foreach($role->permissions as $permission)
                        <li>{{ $permission->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection

