<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Themesbrand" name="author" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        {{-- <link href="assets/libs/metrojs/release/MetroJs.Full/MetroJs.min.css" rel="stylesheet" type="text/css" /> --}}
        <link href="{{asset('css/MetroJs.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        {{-- <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
        <link href="{{asset('css/bootstrap.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Icons Css -->
        {{-- <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" /> --}}
        <link href="{{asset('css/icons.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- App Css-->
        {{-- <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" /> --}}
        <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Sweet Alert-->
        <link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Select2-->
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />

        <!-- style-->

        <link href="{{ asset('css/dropify.min.css') }}" rel="styleshet">

        <!-- Toastr-->
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

        @yield('page-specific-styles')

    </head>
    <style>
        body{
            left: 0;
            top: 0;
        }
        @media print{
            #noprint { display: none; }
        }
    </style>
    <body>
        <section>
            <div class="container">
                @yield('content')
            </div>
        </section>
        <footer>

        </footer>
    </body>
