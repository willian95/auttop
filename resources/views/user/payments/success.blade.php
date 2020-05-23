@extends('layouts.login')

@section('content')

    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background-color:#c8d1df;">
            <div class="auth-box row no-gutters">
                <div class="col-lg-6 col-md-5 modal-bg-img" style="background-image: url('assets/img/car2.jpg');"></div>
                <div class="col-lg-6 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="wrapkit">
                        </div>
                        <h2 style="font-size: 25px" class="mt-3 text-center">Pago realizado existosamente</h2>
                        <a href="{{ url('/order/number/'.$order->client_link) }}">Volver a la página de tracking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
