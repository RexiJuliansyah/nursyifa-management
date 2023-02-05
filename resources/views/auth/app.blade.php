<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Elmer I Fast build Admin dashboard for any platform</title>
	<meta name="description" content="Elmer is a Dashboard & Admin Site Responsive Template by hencework." />
	<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Elmer Admin, Elmeradmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
	<meta name="author" content="hencework"/>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- vector map CSS -->
    <link href="{{asset('admin')}}/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{asset('admin')}}/dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>

    <div class="wrapper pa-0">
        <header class="sp-header">
            <div class="sp-logo-wrap pull-left">
                <a href="index.html">
                    <img class="brand-img mr-10" src="{{asset('admin')}}/dist/img/logo.png" alt="brand" />
                    <span class="brand-text">Elmer</span>
                </a>
            </div>
            <div class="form-group mb-0 pull-right">
                <span class="inline-block pr-10">Don't have an account?</span>
                <a class="inline-block btn btn-primary btn-rounded btn-outline" href="signup.html">Sign Up</a>
            </div>
            <div class="clearfix"></div>
        </header>

        <!-- Content -->
        @yield('content')
        <!-- /Content -->

    </div>

    <!-- jQuery -->
    <script src="{{asset('admin')}}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{asset('admin')}}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{asset('admin')}}/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="{{asset('admin')}}/dist/js/jquery.slimscroll.js"></script>
	<script src="{{asset('admin')}}/dist/js/init.js"></script>
	
    <script type="text/javascript">
		$(document).ready(function() {
			setProgressLine()
		});
		
		function setProgressLine() {
			$('.preloader-it > .la-anim-1').removeClass("la-animate");
			$(".preloader-it").fadeIn();
			$('.preloader-it > .la-anim-1').addClass('la-animate');
			setTimeout(function(){
				$(".preloader-it").delay(400).fadeOut("slow");
			},100);
		}
	</script>
</body>