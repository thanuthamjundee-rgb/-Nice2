<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.title-meta')
    @include('layouts.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    

<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                @yield('content')

            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

@include('layouts.vendor-scripts')
@yield('script')

</body>
</html>