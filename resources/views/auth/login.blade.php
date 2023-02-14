@extends('auth.app')

@section('content')
<div class="page-wrapper pa-0 ma-0 auth-page">
    <div class="container-fluid login-body full-width full-height">
        <div class="col-sm-6 col-sm-offset-3" >
            <div class="text-center mt-50 mb-20">
                <h2 style="font-family:Open Sans; font-size: 32px; font-weight: 800;">
                    <span class="login-app red" style="color:#019645">Management System</span>
                </h2>
                <h6 class="txt-grey">© Perusahaan Otobus Nursyifa</h6>
            </div>
            <div class="panel panel-default card-view" style="box-shadow: 0 3px 9px rgb(0 0 0 / 50%);" >
                <div class="panel-body pa-0 ma-0">
                    <div class="row" >
                        <div class="hidden-sm hidden-xs col-md-6 pr-0" style="padding-bottom: 15px;">
                            <img src="{{ asset('admin') }}/dist/img/logoN.png " class="img-responsive" alt="Logo">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="text-center">
                            <img src="{{ asset('admin') }}/dist/img/logoT.png" width="90%" height="80%" class="img-responsive ma-20 pa-10" alt="Logo">
                        </div>
                            <div class="panel panel-default card-view pa-10" >
                                <div class="panel-body ma-0 pa-0">
                                    <div class="text-center">
                                        <h6 class="nonecase-font txt-dark mb-10 mt-10" >Log In to Your Account</h6>
                                    </div>

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
                                            <div class="input-group">
                                                <input type="text" class="form-control @error('USERNAME') is-invalid @enderror" id="USERNAME" name="USERNAME" placeholder="Username" autocomplete="off"  required  />
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" autocomplete="off" required>
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            </div>
                                        </div>

                                        <div class="form-group text-right mt-20 mb-0">
                                            <button type="submit" class="btn btn-success btn-xs btn-icon left-icon" style="background-color:#019645">
                                                <i class="fa fa-key"></i> <span>Login</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="panel-footer" style="background-color:#019645">
                    <p class="text-left mt-0" style="font-size: 10px; font-weight: normal;"><small class="txt-light ">ponursyifa.com &copy; 2023</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
