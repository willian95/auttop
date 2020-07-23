@extends('layouts.user')

@section('content')
	@include('partials.user.navbar')
	<div class="container-fluid" style="padding-top: 60px;">

		<div class="row">

			<div class="col-md-6 order-lg-1 order-md-2 order-sm-2 order-2">

				<div class="form dash" id="contact-section">
					<div class="row">
						<div class="col-12">

							<form>
					
								<div class="title-form">
									<div class="logo-form">
									<h2>Datos</h2>
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

			</div>

			
			<div class="col-md-6 order-lg-2 order-md-1 order-sm-1 order-1">
				<!------seguimient-->
				<form>

					<section  class="info-serv" id="contact-section" >
						<div class="title-form ">
							<div>
								<h2  class="">Seguimiento del servicio</h2>
							</div>
							
						</div>
						<div id="accordion">

							@if($order->status_id >= 2)
								<div class="card">
									<h5 class="mb-0">
										<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
											<div class="card-header" id="headingOne" style="background: #fff;">
										
												Auto camino al taller
											</div>
										</button>
									</h5>
							
								</div>
							@endif
							@if($order->status_id >= 3)
								<div class="card">
									<h5 class="mb-0">
										<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" type="button">
											<div  class="card-header" id="headingTwo">
								
												Auto en proceso
											</div>
										</button>
									</h5>
							
									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
										<div class="card-body">
										<div class="item-serv">
											<div class="row">
												<div class="table-responsive">
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
																	
																		<td v-cloak>@{{ service.service.name }}</td>
																		<td v-cloak>@{{ service.price }}</td>
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
																	
																		<td v-cloak>@{{ service.service.name }}</td>
																		<td v-cloak>@{{ service.price }}</td>
																		<td v-cloak>@{{ service.type }}</td>
																		<td v-cloak>@{{ service.observations }}</td>
																		<td v-cloak>
																			<input style="transform: scale(2);" v-if="service.type != 'aprobada'" type="checkbox" id="checkbox" @click="toggleCheck(service.id, service.price)">
																		</td>
																	</tr>
									
																</tbody>
															</table>
															<div v-cloak>
																Total: @{{ firstTotal + total }}
															</div>
								
															<p><button class="btn btn-success" type="button" @click="approvedServices()">Seleccionar</button></p>
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
									<h5 class="mb-0">
										
										<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" type="button">
											<div  class="card-header" id="headingThree">
									
												Proceso de Pago
									
											</div>
										</button>
									</h5>
							
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
														<button class="btn btn-success" type="button"  @click="cartStore()">Pagar</button>
													@endif
												</div>
											</div>
								
										</div>
									</div>
								</div>
							@endif
							@if($order->status_id >= 7)
								<div class="card">
									<h5 class="mb-0">
										<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
											<div  class="card-header" id="headingOne">
										
												Auto en proceso de lavado
											</div>
										</button>
									</h5>
								
								</div>
							@endif
							@if($order->status_id >= 8)
								<div class="card">
									<h5 class="mb-0">
										<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
											<div  class="card-header" id="headingOne">
										
												Auto camino a tu lugar
											</div>
										</button>
									</h5>
								
								</div>
							@endif
							@if($order->status_id >= 9)
								<div class="card">
									<h5 class="mb-0">
										<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
											<div  class="card-header" id="headingOne">
										
												Proceso terminado
											</div>
										</button>
									</h5>
								
								</div>
							@endif

							<h4><strong>Delivery:</strong> {{ $order->user->name }}</h4>
							@if($order->mechanic)
								<h4><strong>Mecánico:</strong> {{ $order->mechanic->name }}</h4>
							@endif

						</div>

					</section>
				
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
					selectedServices:[],
					loading:false
				}
			},
			methods:{
				
				approvedServices(){
					
					if(this.loading == false){

						this.loading = true

						axios.post("{{ url('/order/diagnostics/approved') }}", {approveDiagnostics: this.selectedServices, orderId: this.orderId})
						.then(res => {
							this.loading = false
							if(res.data.success == true){
								alert(res.data.msg)
								window.location.reload()
							}else{
								alert(res.data.msg)
							}

						})

					}

				},
				cartStore(){

					if(this.loading == false){

						this.loading = true

						axios.post("{{ url('/cart/store') }}", {orderId: this.orderId})
						.then(res => {

							this.loading = false
							if(res.data.success == true){
							
								window.location.href="{{ url('/checkout') }}"+"/"+res.data.cartId
							
							}else{
								alert(res.data.msg)
							}

						})

					}

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