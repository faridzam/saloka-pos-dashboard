<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title', 'Home') &mdash; {{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  @stack('styles')
</head>

<body>
<div id="app">
  @yield('app')
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<!--
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/datatables.js" type="text/javascript"></script>
-->

    <!-- Datatables -->
    <script src="{{ asset('js/datatables.js') }}"></script>
    <link href="{{ asset('css/datatables.css')}}" rel="stylesheet" />

    <!-- swal -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <link href="{{ asset('css/sweetalert2.css')}}" rel="stylesheet" />
    
@stack('scripts')
</body>
</html>
