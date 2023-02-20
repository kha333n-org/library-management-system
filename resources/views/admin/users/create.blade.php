@extends('adminlte::page')

@section('title', 'Create User')

@section('content')

    <form action="{{ route('users.store') }}" id="edit-user-form" class="needs-validation" novalidate
          method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            <div class="invalid-feedback">Please enter a name.</div>
            @error('name')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            <div class="invalid-feedback">Please enter a valid email address.</div>
            @error('email')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
            <div class="invalid-feedback">Please enter an address.</div>
            @error('address')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" class="form-control" id="phone" name="phone_number" value="{{ old('phone_number') }}"
                   required>
            <div class="invalid-feedback">Please enter a valid phone number.</div>
            @error('phone_number')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="status">Active Status:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="">-- Select Status --</option>
                <option value="1">Active</option>
                <option value="0">In-Active</option>
            </select>
            <div class="invalid-feedback">Please select an active status.</div>
            @error('status')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

@endsection


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
