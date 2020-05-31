
<div class="content__grid">
  
<header>
  <nav class="navbar navbar-expand-md fixed-top navbar-fixed-js">
    
    <div class="container d-block p-0">
      <div class="main-brand logo ">
        <a href="{{ url('/') }}">
          <img alt="Auttop" lass="img-navbar"  class="logo_admin" src="{{ asset('assets/img/logo-blanco.png') }}" >
        </a>
        <button class='navbar-toggler p-2 border-0 hamburger hamburger--elastic d-none-lg' data-toggle='offcanvas' type='button'>
          <span class='hamburger-box'>
            <span class='hamburger-inner'></span>
          </span>
        </button>
      </div>
      <div class="navbar-collapse offcanvas-collapse">
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard.index') }}" style="">  <img src="{{ asset('assets/img/iconos/bx-dashboard.svg') }}" alt="">Dashboard   </a>
          </li>

          @if(Auth::check() && Auth::user()->role_id == 1)
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.category.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-grid-alt.svg') }}" alt="">Categorías</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.email.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-envelope.svg') }}" alt="">Email</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.service.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-list-plus.svg') }}" alt="">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.mechanic.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-wrench.svg') }}" alt="">Mecánicos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.delivery.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-truck.svg') }}" alt="">Deliveries</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.client.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-group.svg') }}" alt="">Clientes</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.car.index') }}" style="margin-right: 10px;"> <img src="{{ asset('assets/img/iconos/bx-car.svg') }}" alt="">Vehiculos</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order.index') }}"> <img src="{{ asset('assets/img/iconos/bx-file.svg') }}" alt=""> ODT</a>
          </li>

        </ul>
     </div>
   </div>
 </nav>
</header>