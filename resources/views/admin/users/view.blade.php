@php use Illuminate\Support\Carbon; @endphp
@extends('adminlte::page')

@section('title', 'View User')

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

    <div class="card shadow-sm">
        <div class="card-header">
            User Details
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary float-right" title="Edit">
                <i
                    class="material-icons">Edit</i></a>
            <a href="#" class="btn btn-danger float-right mr-2" title="Edit" id="delete-user">
                <i class="material-icons">Delete</i></a>
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
        $('#delete-user').click(function () {
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
                        url: '{{ route('users.destroy', $user->id)  }}',
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
                                allowOutsideClick: false,
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });
        });
    </script>

@stop
