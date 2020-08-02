<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logo.png') }}">
    <title>Login Auttop </title>
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/font-awesome.css') }}">
    <link href="{{ asset('assets/css/style-login.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-login.css') }}" rel="stylesheet">
    <link href="{{ asset('alertify/css/alertify.css') }}" rel="stylesheet">
    <link href="{{ asset('alertify/css/themes/bootstrap.css') }}" rel="stylesheet">

</head>
<body>
    
    <div id="dev-app">
        @yield('content')
    </div>

    <script src="{{ asset('alertify/alertify.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        alertify.set('notifier','position', 'top-right');
    </script>

    @stack('scripts')

</body>

</html>