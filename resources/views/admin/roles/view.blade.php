@extends('adminlte::page')

@section('title', 'View Role')

@section('content')

    @if(session()->has('message'))
        @if(session()->get('type') == 'success')
            <div class="alert alert-success alert-dismissible show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->get('type') == 'error')
            <div class="alert alert-danger alert-dismissible show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endif

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8">
                <h1>Role Details</h1>
            </div>
            <div class="col-md-4 mt-2 text-right">
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary" title="Edit">
                    <i class="material-icons">Edit</i>
                </a>
                <a href="#" class="btn btn-danger ml-2" title="Delete" id="delete-role">
                    <i class="material-icons">Delete</i>
                </a>
            </div>
        </div>
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

@section('js')
    <script>
        // Hide alert after 10 seconds
        $(document).ready(function () {
            setTimeout(function () {
                $('.alert').alert('close');
            }, 10000);
        });
    </script>

    <script>
        // SweetAlert2 popup for deleting user
        $('#delete-role').click(function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('roles.destroy', $role->id)  }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            if (response.type === 'success') {
                                Swal.fire({
                                    title: 'Role deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function () {
                                    window.location.href = '{{ route('roles.index') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error deleting role!',
                                    text: response.message,
                                    icon: 'error',
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                title: 'Error deleting role!',
                                text: xhr.responseText,
                                icon: 'error',
                                allowOutsideClick: false,
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });
        });
    </script>

@endsection
