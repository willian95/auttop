@extends('layouts.user')

@section('content')

<header class="header__main navbar-me container-fluid">
		<div class="logo">
			<a href="index.html">
       <img alt="Auttop" lass="img-navbar"  src="assets/img/logo-blanco.png" >
				</a>
				</div>
				<button class="responsive-menu-btn">
					<svg class="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
						<path d="M14.000002 15.99999c-3.3137 0-6 2.68619-6 6 0 3.31359 2.6863 6 6 6h71.999996c3.3137 0 6-2.68641 6-6 0-3.31381-2.6863-6-6-6zm0 28.00003c-3.3137 0-6 2.6862-6 6 0 3.3136 2.6863 6 6 6h71.999996c3.3137 0 6-2.6864 6-6 0-3.3138-2.6863-6-6-6zm0 28c-3.3137 0-6 2.6862-6 6 0 3.3136 2.6863 6 6 6h71.999996c3.3137 0 6-2.6864 6-6 0-3.3138-2.6863-6-6-6z"
						 style="text-indent:0;text-transform:none;block-progression:tb" overflow="visible" color="#000" />
					</svg>

					<svg class="close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 20">
						<path d="M14.7 1.3c-.4-.4-1-.4-1.4 0L8 6.6 2.7 1.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4L6.6 8l-5.3 5.3c-.4.4-.4 1 0 1.4.2.2.4.3.7.3s.5-.1.7-.3L8 9.4l5.3 5.3c.2.2.5.3.7.3s.5-.1.7-.3c.4-.4.4-1 0-1.4L9.4 8l5.3-5.3c.4-.4.4-1 0-1.4z"
						/>
					</svg>
				</button>
				<nav class="nav__menu">
					<div class="nav-item">
					<a href="index.html">Inicio</a>
					</div>
				</nav>
            </header>

            <section  class="form  info-serv" id="contact-section" >
                <div class="title-serv">
                            <div>
                              <h2 style=" text-align: center; font-weight: bold; font-size: 20px;    margin-bottom: 10%;    color: #2a497e;" class="">Seguimiento del servicio</h2>
                           </div>
                           <div class="logo-form">
                            <img style="width: 65px; height: 50px;"src="{{ asset('assets/img/logo.png') }}">
                           </div>
                         </div>
              <div id="accordion">

              @if($order->status_id >= 2)
              <div class="card">
                <div style="background-color: #ffc000;"class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Auto camino al taller
                    </button>
                  </h5>
                </div>
              </div>
              @endif
              @if($order->status_id >= 3)
              <div class="card">
                <div style="background-color: #92d050;" class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                     Auto en proceso
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    <div class="item-serv">
                    <div class="row">
                            <div class="col-12">
                                @if($order->status_id == 3)
                                  <table class="table">
                                      <thead>
                                          <tr>
                                        
                                              <th>servicio</th>
                                              <th>precio</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                         
                                            <tr v-for="(service, index) in services" v-if="service.type == 'aprobada'">
                                            
                                                <td>@{{ service.service.name }}</td>
                                                <td>@{{ service.price }}</td>
                                            </tr>
                                         
                                      </tbody>
                                  </table>

                                @elseif($order->status_id == 5)
                                  <table class="table">
                                    <thead>
                                        <tr>
                                      
                                            <th>servicio</th>
                                            <th>precio</th>
                                            <th>Tipo</th>
                                            <th>Observaciones</th>
                                            <th>Acción</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                          <tr v-for="(service, index) in services">
                                          
                                              <td>@{{ service.service.name }}</td>
                                              <td>@{{ service.price }}</td>
                                              <td>@{{ service.type }}</td>
                                              <td>@{{ service.observations }}</td>
                                              <td>
                                                <input v-if="service.type != 'aprobada'" type="checkbox" id="checkbox" @click="toggleCheck(service.id, service.price)">
                                              </td>
                                          </tr>

                                        

                                    </tbody>
                                </table>
                                Total: @{{ firstTotal + total }}


                                <p><button class="btn btn-success" @click="approvedServices()">Seleccionar</button></p>
                                @elseif($order->status_id >= 6)
                                  <table class="table">
                                    <thead>
                                        <tr>
                                      
                                            <th>servicio</th>
                                            <th>precio</th>
                                            <th>Tipo</th>
                                            <th>Observaciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach(App\ApprovedDiagnostic::with('diagnostic', 'diagnostic.service')->where('order_id', $order->id)->get() as $approved)
                                          <tr>
                                          
                                              <td>{{ $approved->diagnostic->service->name }}</td>
                                              <td>{{ $approved->diagnostic->price }}</td>
                                              <td>{{ $approved->diagnostic->type }}</td>
                                              <td>{{ $approved->diagnostic->observations }}</td>
                                              <td>
                                          </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @endif
                            </div>  
                        </div>
                  </div>
            
                  </div>
                </div>
              </div>
            @endif
            
            @if($order->status_id >= 6)
            <div class="card">
                <div style="background-color: rgba(216, 216, 0, 0.509);"class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Proceso de Pago
                    </button>

                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                  <div class="card-body">
                      
                    <div class="row">
                      <div class="col-12">
                          <table class="table">
                              <thead>
                                  <tr>
                                
                                      <th>servicio</th>
                                      <th>precio</th>
                                      <th>Tipo</th>
                                      <th>Observaciones</th>
                                      
                                  </tr>
                              </thead>
                              <tbody>
                                  @php
                                    $total = 0;
                                  @endphp
                                  @foreach(App\ApprovedDiagnostic::with('diagnostic', 'diagnostic.service')->where('order_id', $order->id)->get() as $approved)
                                    <tr>
                                    
                                        <td>{{ $approved->diagnostic->service->name }}</td>
                                        <td>{{ $approved->diagnostic->price }}</td>
                                        <td>{{ $approved->diagnostic->type }}</td>
                                        <td>{{ $approved->diagnostic->observations }}</td>
                                        @php $total = $total + $approved->diagnostic->price  @endphp
                                    </tr>
                                  @endforeach
                                  
                              </tbody>
                          </table>
                          <p>Total: {{ $total }}</p>
                          @if($order->status_id < 7)
                            <button class="btn btn-success"  @click="cartStore()">Pagar</button>
                          @endif
                      </div>
                    </div>
            
                  </div>
                </div>
              </div>
            @endif
            @if($order->status_id >= 7)
              <div class="card">
                <div style="background-color: #ffc000;"class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Auto en proceso de lavado
                    </button>
                  </h5>
                </div>
              </div>
            @endif
            
              <!--<div class="next"> 
            <a style="color: #fff;"class="btn-direction" href="pago.html">Siguiente</a></div>
            </div>-->
                </section>

            
            <div class="container form" id="contact-section">
                <div class="row">
                    <div class="col-12">
        
                      <form>
                      
                        <div class="title-form">
                            <div class="logo-form">
                                <img style="width: 50px; height: 50px;"src="{{ asset('assets/img/logo.png') }}" />
                            </div>
                        </div>
                        <div style="margin-bottom: 50px;">
                            <div class="form-group row">
        
                                <div class="col-md-6 mb-4">
                                    <label for="">Rut</label>
                                    <input type="text" class="form-control" placeholder="Rut" value="{{ $order->client->rut }}" name="rut" id="rut" readonly>
                                </div>
        
                                <div class="col-md-6">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Nombre" value="{{ $order->client->name }}" name="name" id="name" readonly>
                                </div>
                    
                            </div>
            
        
                            <div class="form-group row">
                                <div class="col-md-6 mb-4">
                                    <label for="">Teléfono</label>
                                    <input type="text" class="form-control" placeholder="Fono" value="{{ $order->client->telephone }}" name="telephone" id="telephone" readonly>
                                </div>
                
                                <div class="col-md-6">
                                    <label for="">Dirección</label>
                                    <input type="text" class="form-control" placeholder="Dirección" value="{{ $order->client->address }}" name="address" id="address" readonly>
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <div class="col-md-6 mb-4">
                                    <label for="">Comuna</label>
                                    <input type="text" class="form-control" placeholder="Comuna" value="{{ $order->client->location }}" name="location" id="location" readonly>
                                </div>
                    
        
                                <div class="col-md-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" placeholder="Correo" value="{{ $order->client->email }}" name="email" id="email" readonly>
                                </div>
                            </div> 
                        </div>
              
      
      
                        <div style="margin-bottom: 50px;">
                            <div class="form-group row">
                        
                                <div class="col-md-6">
                                    <label for="">Patente</label>
                                    <input type="text" class="form-control" placeholder="Patente" value="{{ $order->car->patent }}" name="patent" id="patent" readonly>
                                </div>
        
                                <div class="col-md-6 mb-4">
                                    <label for="">Marca</label>
                                    <input type="text" class="form-control" placeholder="Marca" value="{{ $order->car->brand }}" name="brand" id="brand" readonly>
                                </div>
                            </div>
                
        
                            <div class="form-group row">
                                <div class="col-md-6 mb-4">
                                    <label for="">Año</label>
                                    <input type="number" class="form-control" placeholder="Año" value="{{ $order->car->year }}" name="year" id="year" readonly>
                                </div>
        
                                <div class="col-md-6">
                                    <label for="">Modelo</label>
                                    <input type="text" class="form-control" placeholder="Modelo" value="{{ $order->car->model }}" name="model" id="model" readonly>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="col-md-6 mb-4">
                                    <label for="">Color</label>
                                    <input type="text" class="form-control" placeholder="Color" value="{{ $order->car->color }}" name="color" id="color" readonly>
                                </div>
                    
                                <div class="col-md-6">
                                    <label for="">Kilometros</label>
                                    <input type="text" class="form-control" placeholder="Kms" value="{{ $order->kilometers }}" name="kilometers" readonly>
                                </div>
                        
                            </div>
                        </div>
      
                        <div style="margin-bottom: 50px;">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="">Comentarios</label>
                                    <textarea class="form-control" id="" cols="30" rows="10" placeholder="Comentarios" name="comments" readonly >{{ $order->comments }}</textarea>
                                </div>
                            </div>
                
      
                        </div>
                      </form>
        
                    </div>
                </div>
        
            </div>


@endsection

@push('scripts')

<script>
            
            const app = new Vue({
                el: '#dev-app',
                data(){
                    return{
                        services:[],
                        orderId:'{{ $order->id }}',
                        firstTotal:0,
                        total:0,
                        selectedServices:[]
                    }
                },
                methods:{
                    
                  approvedServices(){

                    axios.post("{{ url('/order/diagnostics/approved') }}", {approveDiagnostics: this.selectedServices, orderId: this.orderId})
                    .then(res => {

                      if(res.data.success == true){
                        alert(res.data.msg)
                        window.location.reload()
                      }else{
                        alert(res.data.msg)
                      }

                    })

                  },
                  cartStore(){

                    axios.post("{{ url('/cart/store') }}", {orderId: this.orderId})
                    .then(res => {

                      if(res.data.success == true){
                        
                        window.location.href="{{ url('/checkout') }}"+"/"+res.data.cartId
                        
                      }else{
                        alert(res.data.msg)
                      }

                    })

                  },
                  getServices(){
                    axios.get("{{ url('/mechanic/order/services/') }}"+"/"+this.orderId).then(res => {

                      if(res.data.success == true){

                        this.services = res.data.services
                        this.services.forEach((data, index) => {
                          
                          if(data.type == 'aprobada')
                          this.firstTotal = this.firstTotal + data.price

                        })


                      }else{

                          alert(res.data.msg)

                      }

                    })
                  },
                  toggleCheck(id, price){
                    this.total = 0;
                    if(this.selectedServices.length == 0){

                      this.selectedServices.push({"id": id, "price": price})

                    }else{
                      
                      var exists = false
                      this.selectedServices.forEach((data, index) => {
                        
                        if(data.id == id){
                          exists = true
                          this.selectedServices.splice(index, 1)
                        }

                      })

                      if(exists == false){
                        this.selectedServices.push({"id": id, "price": price})
                      }

                    }

                    this.selectedServices.forEach((data, index) => {

                      this.total = parseFloat(data.price) + parseFloat(this.total)

                    })

                  }
                    
    
                },
                mounted(){
                    this.getServices()
                }
    
            })
    
        </script>

@endpush