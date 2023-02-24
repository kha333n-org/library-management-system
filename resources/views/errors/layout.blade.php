@extends('adminlte::page')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('code') Error Page</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning"> @yield('code')</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i>@yield('message')</h3>

                    <p>
                        Something gone wrong.<br>
                        Meanwhile, you may <a href="{{ url('/') }}">return to dashboard</a>
                        <br> or <a href="{{ url()->previous() }}">go back</a>.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>

@stop
