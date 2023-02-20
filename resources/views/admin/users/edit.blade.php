@extends('adminlte::page')

@section('title', 'Users List')

@section('content_header')
    <h1 class="m-0 text-dark">Edit {{ $user->name }}</h1>
@stop

@section('content')

    <form action="{{ route('users.update', $user->id) }}" id="edit-user-form" class="needs-validation" novalidate
          method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}" autofocus>
            <div class="invalid-feedback">Please enter a name.</div>
            @error('name')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}"
                   disabled>
            <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" required>{{ $user->address }}</textarea>
            <div class="invalid-feedback">Please enter an address.</div>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" class="form-control" id="phone" name="phone_number" required
                   value="{{ $user->phone_number }}">
            <div class="invalid-feedback">Please enter a valid phone number.</div>
        </div>
        <div class="form-group">
            <label for="status">Active Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="">-- Select Status --</option>
                <option value="1" @if($user->is_active) selected @endif>Active</option>
                <option value="0" @if(!$user->is_active) selected @endif>Inactive</option>
            </select>
            <div class="invalid-feedback">Please select an active status.</div>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

@stop

@section('js')
    <script>
        // Front-end form validation using jQuery
        $(document).ready(function () {
            $('#edit-user-form').submit(function (event) {
                if (this.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                this.classList.add('was-validated');
            });
        });
    </script>
@stop



