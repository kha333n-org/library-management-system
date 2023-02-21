@extends('adminlte::page')

@section('title', 'Roles List')

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


    <div class="mt-2 card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="m-0 text-dark">Roles List</h1>

            <a href="{{ route('roles.create') }}" class="btn btn-primary ml-auto" title="New Role">
                <i class="material-icons"></i> New Role
            </a>
        </div>

        {!! $dataTable->table(['class' => 'table table-striped table-bordered', 'style' => 'width:100%'], true) !!}
    </div>
@stop

@section('js')
    {!! $dataTable->scripts() !!}

    <script>
        // Hide alert after 10 seconds
        $(document).ready(function () {
            setTimeout(function () {
                $('.alert').alert('close');
            }, 10000);
        });
    </script>
@endsection
