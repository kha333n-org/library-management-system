@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content')

    <form action="{{ route('roles.update', $role->id) }}" id="edit-user-form" class="needs-validation" novalidate
          method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Role Name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name') ? old('name') : $role->name }}" required autofocus>
            <div class="invalid-feedback">Please enter a name.</div>
            @error('name')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="permissions">Permissions</label>
            <div class="row">
                @foreach($permissions as $permission)
                    <div class="col-md-2">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" id="permission-{{ $permission->id }}"
                                   value="{{ $permission->id }}" class="form-check-input"
                                   @if($role->hasPermissionTo($permission)) checked @endif>
                            <label class="form-check-label"
                                   for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
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
