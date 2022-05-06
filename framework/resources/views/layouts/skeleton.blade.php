<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title', 'Home') &mdash; {{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.0/apexcharts.js" integrity="sha512-MM/szA/VWoAf3/6BwunOUsfIbhhWPWp8x7afVPpX7f5JiuUhhn8UYD55Yt76CtfsSsjlE2n8nvWoTwhZF0W8Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.0/apexcharts.css" integrity="sha512-oixucAoxoh4Eqk2ypTmfiOyhgDc582OqLweiVM4jbF680XtGzwf/Y7yftFs1O8DNdTeNnTbpPGRkNLIW9AxPuQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  @stack('styles')

    <livewire:styles />
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

    <!-- livewire -->
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    <script src="{{ asset('vendor/livewire-charts/app.js') }}"></script>
z
@stack('scripts')
</body>
</html>
