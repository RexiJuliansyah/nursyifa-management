@extends('auth.app')

@section('content')
      <!-- Main Content -->
<div class="page-wrapper pa-0 ma-0 auth-page">
    <div class="container-fluid">
        <!-- Row -->
        <div class="table-struct full-width full-height">
            <div class="table-cell vertical-align-middle auth-form-wrap">
                <div class="auth-form ml-auto mr-auto no-float">
                    <div class="row panel panel-default pt-40">
                        <div class="col-sm-12 col-xs-12">
                            <div class="mb-30">
                                <h3 class="text-center txt-dark mb-10">Log In</h3>
                                <!-- <h6 class="text-center nonecase-font txt-grey">Login</h6> -->
                            </div>
                            <div class="form-wrap">
                                @error('USERNAME')
                                    <div class="alert alert-danger alert-dismissable alert-style-1">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="zmdi zmdi-alert-circle-o"></i>Username atau Password tidak cocok.
                                    </div>
                                @enderror
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-10" for="USERNAME">Username</label>
                                        <input type="text" class="form-control  @error('USERNAME') is-invalid @enderror" required id="USERNAME" name="USERNAME" placeholder="Username" autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="pull-left control-label mb-10" for="password">Password</label>
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="off">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-rounded">Login</button>
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
