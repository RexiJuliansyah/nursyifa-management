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
                                <h3 class="text-center txt-dark mb-10">Sign in to Admin Panel</h3>
                                <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
                            </div>
                            <div class="form-wrap">
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-10" for="USERNAME">Username</label>
                                        <input type="text" class="form-control" required="" id="USERNAME" name="USERNAME" placeholder="Username"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="pull-left control-label mb-10" for="password">Password</label>
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-rounded">sign in</button>
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
