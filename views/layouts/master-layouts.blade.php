<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.title-meta')
    @include('layouts.head')
</head>

<body data-layout="horizontal" data-topbar="colored">

    <div id="layout-wrapper">

        @include('layouts.horizontal')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')
        </div>

    </div>

    @include('layouts.right-sidebar')
    @include('layouts.vendor-scripts')

</body>
</html>
