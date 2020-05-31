<html>

    <head>
        <meta charset="utf-8">
        <title>Auttop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="icon" type="image/jpg" href="assets/img/logo-blanco.png" style="width: 30px; height: 30px;">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/media.css') }}">

        @stack('css')
  
    </head>

	<body>

        <div id="dev-app">
            @yield('content')
        </div>

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
     
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        @stack('scripts')

	</body>

</html>