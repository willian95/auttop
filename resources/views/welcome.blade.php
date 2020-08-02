@extends('layouts.user')

@section('content')
    @include('partials.user.navbar')
    <section class="banner-home">

        <!-- BANNER HOME -->
        <div class="single-banner">
            <div class="item-banner" >
                <div class="mask-banner"></div>
            </div>
            <div class="item-banner2" >
                <div class="mask-banner"></div>
            </div>
        </div>
        <!-- END BANNER HOME -->
    </section>
    <section class="directionals">

        <div class="container text-banner-two">

            <div class="logos log">

                @if( strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "chrome") > -1 )
                    <img alt="Auttop" class="img-navbar"  src="{{ asset('assets/img/logo-blanco.png') }}">
                @elseif(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "chrome") > -1)
                    <img alt="Auttop" style="width: 100px;"  src="{{ asset('assets/img/logo-blanco.png') }}">
                @else
                    <img alt="Auttop" class="img-navbar"  src="{{ asset('assets/img/logo-blanco.png') }}">
                @endif
            </div>
            <h1 class="title-banner">Bienvenidos a Auttop</h1>
            <div class="btn-principal"> 
                <div class=" btn-one ">
                    <a class="btn-direction" href="{{ url('/login') }}">Entrar</a>
                </div>
            </div>
        </div>

    </section>
    <!--  <div class="main-footer__copy">
        <p>
            <a href="http://cmarketing.cl/">
                Contact Marketing 
            </a> Todos los derechos Reservados
        </p>
    </div>-->

@endsection