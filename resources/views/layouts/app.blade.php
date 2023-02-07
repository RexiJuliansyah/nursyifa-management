<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>PO | Nursyifa</title>
	<!-- <meta name="description" content="Elmer is a Dashboard & Admin Site Responsive Template by hencework." />
	<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Elmer Admin, Elmeradmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
	<meta name="author" content="hencework"/> -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset('admin')}}/favicon.ico">
	<link rel="icon" href="{{asset('admin')}}/favicon.ico" type="image/x-icon">

	<!-- Data table CSS -->
	<link href="{{asset('admin')}}/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{asset('admin')}}/vendors/bower_components/datatables.net-responsive/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css"/>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
	
	
	<link href="{{asset('admin')}}/vendors/bower_components/jstree/dist/themes/default/style.css" rel="stylesheet">
	<!-- <link href="{{asset('admin')}}/vendors/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.css" rel="stylesheet" type="text/css"> -->
	<link href="{{asset('admin')}}/vendors/bower_components/toastr/toastr.min.css" rel="stylesheet" type="text/css">
	<link href="{{asset('admin')}}/vendors/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{asset('admin')}}/vendors/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
	<link href="{{asset('admin')}}/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
	<link href="{{asset('admin')}}/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
	<link href="{{asset('admin')}}/dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
    
    <div class="wrapper  theme-1-active pimary-color-blue">

        <!-- Top Menu Items -->
        @include('layouts.navbar')
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
        @include('layouts.sidebar')
		<!-- /Left Sidebar Menu -->

		<!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid">
				<!-- Title -->
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark">@yield('title')</h5>
					</div>
					<!-- Breadcrumb -->
					<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
                            @yield('breadcumb')
						</ol>
					</div>
					<!-- /Breadcrumb -->
				</div>
				<!-- /Title -->

                <!-- Content -->
                @yield('content')
                <!-- /Content -->
			
				<!-- Footer -->
				<footer class="footer container-fluid pl-30 pr-30">
					<div class="row">
						<div class="col-sm-12">
							<p>2023 &copy; all right reserved</p>
						</div>
					</div>
				</footer>
				<!-- /Footer -->
			</div>
		</div>
        <!-- /Main Content -->

    </div>

    <!-- jQuery -->

    <script src="{{asset('admin')}}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{asset('admin')}}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/bootstrap-validator/dist/validator.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/jstree/dist/jstree.js"></script>
	<!-- <script src="{{asset('admin')}}/vendors/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.js"></script> -->

	<script src="{{asset('admin')}}/vendors/bower_components/moment/min/moment-with-locales.min.js"></script>
	<script src="{{asset('admin')}}/dist/js/jquery.slimscroll.js"></script>
	<script src="{{asset('admin')}}/dist/js/jquery.filedownload.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
	<script src="{{asset('admin')}}/dist/js/dropdown-bootstrap-extended.js"></script>
	<script src="{{asset('admin')}}/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/switchery/dist/switchery.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/echarts/dist/echarts-en.min.js"></script>
	<script src="{{asset('admin')}}/vendors/echarts-liquidfill.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/toastr/toastr.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/iconpicker-master/dist/iconpicker.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="{{asset('admin')}}/vendors/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="{{asset('admin')}}/dist/js/init.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setProgressLine()

			toastr.options = {
				"debug": false,
				"positionClass": "toast-bottom-right",
				"onclick": null,
				"fadeIn": 300,
				"fadeOut": 1000,
				"timeOut": 3000,
				"extendedTimeOut": 1000
			}
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
	


	@yield('javascript');

</body>