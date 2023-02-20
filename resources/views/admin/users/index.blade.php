@extends('adminlte::page')

@section('title', 'Users List')

@section('content')
    <div class="mt-2 card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="m-0 text-dark">Users List</h1>

            <a href="{{ route('users.create') }}" class="btn btn-primary ml-auto" title="New User">
                <i class="material-icons"></i> New User
            </a>
        </div>

        {!! $dataTable->table(['class' => 'table table-striped table-bordered', 'style' => 'width:100%'], true) !!}
    </div>
@stop

@section('js')
    {!! $dataTable->scripts() !!}

    <script>
        // SweetAlert2 popup for deleting user
        $.fn.deleteUser = function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).data('id');
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ url('admin/users') }}/' + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            if (response.type === 'success') {
                                Swal.fire({
                                    title: 'User deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function () {
                                    window.location.href = '{{ route('users.index') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error deleting user!',
                                    text: response.message,
                                    icon: 'error',
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                title: 'Error deleting user!',
                                text: xhr.responseText,
                                icon: 'error',
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            });
                        }
                    });
                }
            });
        }
    </script>
@stop
