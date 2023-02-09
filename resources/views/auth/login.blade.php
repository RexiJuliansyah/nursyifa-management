@extends('auth.app')

@section('content')
    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page">
        <div class="container-fluid">
            <!-- Row -->
            <div class="table-struct full-width full-height">
                <div class="vertical-align-middle auth-form-wrap table-cell" style="padding: 50px 0">
                    <div class="auth-form no-float ml-auto mr-auto">
                        <div class="row panel panel-default" style="background-color: #fefefe">
                            <div class="col-sm-12 col-xs-12">
                                <div class="mb-10 text-center">
                                    <img class="brand-img mr-10" src="{{ asset('admin') }}/dist/img/logo.jpg" width="150px"
                                        height="150px" alt="brand" />
                                    <h6 class="nonecase-font txt-grey text-center">Log In to Your Account</h6>
                                </div>
                                <div class="form-wrap">
                                    @error('USERNAME')
                                        <div class="alert alert-danger alert-dismissable alert-style-1">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            <i class="zmdi zmdi-alert-circle-o"></i>Username atau Password tidak cocok.
                                        </div>
                                    @enderror
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label mb-10" for="USERNAME">Username</label>
                                            <input type="text"
                                                class="form-control @error('USERNAME') is-invalid @enderror" required
                                                id="USERNAME" name="USERNAME" placeholder="Username" autocomplete="off" />
                                        </div>
                                        <div class="form-group">
                                            <label class="pull-left control-label mb-10" for="password">Password</label>
                                            <input type="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password" name="password" required autocomplete="off">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary btn-rounded"
                                                style="background-color: #019645">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->
        </div>
    </div>
@endsection
