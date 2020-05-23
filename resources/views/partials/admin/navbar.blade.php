<header class="header__main navbar-me container-fluid">
  <div class="logo">
    <a href="{{ url('/') }}">
      <img alt="Auttop" lass="img-navbar"  src="{{ asset('assets/img/logo-blanco.png') }}" >
    </a>
  </div>
  <button class="responsive-menu-btn">
    <svg class="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
      <path d="M14.000002 15.99999c-3.3137 0-6 2.68619-6 6 0 3.31359 2.6863 6 6 6h71.999996c3.3137 0 6-2.68641 6-6 0-3.31381-2.6863-6-6-6zm0 28.00003c-3.3137 0-6 2.6862-6 6 0 3.3136 2.6863 6 6 6h71.999996c3.3137 0 6-2.6864 6-6 0-3.3138-2.6863-6-6-6zm0 28c-3.3137 0-6 2.6862-6 6 0 3.3136 2.6863 6 6 6h71.999996c3.3137 0 6-2.6864 6-6 0-3.3138-2.6863-6-6-6z" style="text-indent:0;text-transform:none;block-progression:tb" overflow="visible" color="#000" />
    </svg>

    <svg class="close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 20">
      <path d="M14.7 1.3c-.4-.4-1-.4-1.4 0L8 6.6 2.7 1.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4L6.6 8l-5.3 5.3c-.4.4-.4 1 0 1.4.2.2.4.3.7.3s.5-.1.7-.3L8 9.4l5.3 5.3c.2.2.5.3.7.3s.5-.1.7-.3c.4-.4.4-1 0-1.4L9.4 8l5.3-5.3c.4-.4.4-1 0-1.4z" />
    </svg>
  </button>
  <nav class="nav__menu">
    <div class="nav-item">
      
        <a href="{{ route('admin.dashboard.index') }}" style="margin-right: 10px;">Inicio</a>
        <a href="{{ route('admin.category.index') }}" style="margin-right: 10px;">Categorías</a>
        <a href="{{ route('admin.email.index') }}" style="margin-right: 10px;">Email</a>
        <a href="{{ route('admin.service.index') }}" style="margin-right: 10px;">Servicios</a>
        <a href="{{ route('admin.mechanic.index') }}" style="margin-right: 10px;">Mecánicos</a>
        <a href="{{ route('admin.delivery.index') }}" style="margin-right: 10px;">Deliveries</a>
        <a href="{{ route('admin.client.index') }}" style="margin-right: 10px;">Clientes</a>
        <a href="{{ route('admin.car.index') }}" style="margin-right: 10px;">Vehiculos</a>
        <a href="{{ route('admin.order.index') }}">ODT</a>

    </div>
  </nav>
</header>