@extends('adminlte::page')

@section('title', 'Users List')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Allocate Roles for {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.roles.update', $user) }}" method="POST" id="roles-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="select-all" name="select-all">
                        <label class="form-check-label" for="select-all">Select All</label>
                    </div>
                </div>
                <div class="row">
                    @foreach ($roles as $role)
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input role-checkbox" name="roles[]"
                                           value="{{ $role->id }}" {{ in_array($role->id, $userRoles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $role->name }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Update Roles</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            // Check/uncheck all checkboxes based on the value of the select all/unselect all checkboxes
            $('#select-all').click(function () {
                $('.role-checkbox').prop('checked', this.checked);
            });
        });
    </script>
@stop
