@yield('css')
<!-- Bootstrap Css -->
<link href="{{ URL::asset('/assets/css/bootstrap.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('/assets/css/icons.css')}}" id="icons-style" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('/assets/css/app.css')}}" id="app-style" rel="stylesheet" type="text/css" />
<!-- /sweetalert-->
<link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

<meta name="csrf-token" content="{{ csrf_token() }}">