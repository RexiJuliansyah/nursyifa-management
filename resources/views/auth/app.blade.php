<!DOCTYPE html>
<html translate="no" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="User login page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>PO | Nursyifa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('admin') }}/favicon.ico">
    <link rel="icon" href="{{ asset('admin') }}/favicon.ico" type="image/x-icon">
    <link href="{{ asset('admin') }}/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin') }}/dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>

    <div class="wrapper pa-0 ma-0">
        @yield('content')
    </div>

    <script src="{{ asset('admin') }}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('admin') }}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('admin') }}/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="{{ asset('admin') }}/dist/js/jquery.slimscroll.js"></script>
    <script src="{{ asset('admin') }}/dist/js/init.js"></script>

</body>
