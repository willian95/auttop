
@extends('layouts.user')


@section("content")

    
    @include('partials.user.navbar')
    <section  class="form" id="contact-section" >
        <div class="container pl50">
            <div class="">
        
            	<form action="" class="grid__form">
                    <div class="grid__form__item">
                        <div class="title-form">
                           <div>
                            <h2 style=" " class="">Orden de Trabajo</h2>
                           </div>                            
                        </div>

                        <div class="form__style">
                            <div class="form-group row">
        
                                <div class="col-md-6 ">
                                    <label >Rut</label>
                                    <input type="text" class="form-control" placeholder="Rut" v-model="rut" readonly>
                                </div>
       
                                <div class="col-md-6">
                                    <label >Nombre</label>
                                    <input type="text" class="form-control" placeholder="Nombre"  v-model="name" readonly>
                          
                                </div>
                            </div>
                            <div class="form__style">
                  
        
                                <div class="form-group row">
                                   
                                    <div class="col-md-12">
                                        <label >Dirección</label>
                                        <input type="text" class="form-control" placeholder="Dirección"  v-model="address" readonly>
                              
                                    </div>
                                </div>
                    
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-6 ">
                                    <label >Fono</label>
                                    <input type="text" class="form-control" placeholder="Fono"  v-model="telephone" id="telephone" @click="setNumber()" @keyup="checkNumber()" @keypress="isNumber($event)" readonly>
                          
                                </div>
                  
                                <div class="col-md-6 ">
                                    <label for="">Comuna</label>
                                    <input type="text" class="form-control" placeholder="Comuna"  v-model="location">
                          
                                </div>
                    
                            </div>
                
                            <div class="form-group row">
                               
        
                                <div class="col-md-6">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" placeholder="Correo"  v-model="email">
                          
                                </div>
                                <div class="col-md-6">
                                    <label for="">Patente</label>
                                    <input type="text" class="form-control" placeholder="Patente"  v-model="patent" readonly>
                          
                                </div>
                            </div> 
                        </div>
                    
               
                        <div class="form__style">
                            <div class="form-group row">

                                <div class="col-md-6 mb-6">
                                    <label for="">Marca</label>
                                    <input type="text" class="form-control" placeholder="Marca"  v-model="brand">
                          
                                </div>
                                <div class="col-md-6 ">
                                    <label for="">Año</label>
                                    <input type="number" class="form-control" placeholder="Año"  v-model="year">
                                </div>
        
                    
                            </div>
               
        
                            <div class="form-group row">
                                
                                <div class="col-md-6">
                                    <label for="">Modelo</label>
                                    <input type="text" class="form-control" placeholder="Modelo"  v-model="model">
                                </div>
                                <div class="col-md-6 ">
                                    <label for="">Color</label>
                                    <input type="text" class="form-control" placeholder="Color"  v-model="color">
                          
                                </div>
                            </div>
              
                            <div class="form-group row">
                                <div class="col-md-6 ">
                                    <label for="">Cantidad de combustible</label>
                                    <select v-model="gas_amount" class="form-control">
                                        <option value="" disabled>Cantidad de combustible</option>
                                        <option value="1">Vacío</option>
                                        <option value="2">Un cuarto</option>
                                        <option value="3">Medio tanque</option>
                                        <option value="4">Tres cuartos de tanque</option>
                                        <option value="5">Full</option>
                                    </select>    
                                </div>
                                <div class="col-md-6">
                                    <label for="">Kilometraje</label>
                                    <input type="text" class="form-control" placeholder="Kms"  v-model="kilometers" @keypress="isNumber($event)">
                                </div>
                            </div>
                        </div>
          
                        <div class="form__style">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="">Comentarios</label>
                                    <textarea class="form-control" id="" cols="30" rows="6" placeholder="Comentarios"  v-model="comments"></textarea>
                          
                                </div>
                    
                   
                            </div>
                       </div>
                    
                   </div>
                
                   <div class="grid__form__item">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <h3 class="">Servicios</h3>
                        </div>
                    </div>
                    <!---servico-->
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>servicio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(service, index) in services">
                                        <td v-cloak>@{{ index + 1 }}</td>
                                        <td v-cloak>@{{ service.service.name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div  class="col-md-6">
        
                            <button style="color: #fff;"class="btn__mec" type="button" @click="revision()">Enviar</button>
                        </div>
                    </div>

                </div>

                    
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script>
                
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    rut:'{{ $order->client->rut }}',
                    name:"{{ $order->client->name }}",
                    telephone:"{{ $order->client->telephone }}",
                    address:"{{ $order->client->address }}",
                    location:"{{ $order->client->location }}",
                    email:"{{ $order->client->email }}",
                    patent:"{{ strtoupper($order->car->patent) }}",
                    brand:"{{ $order->car->brand }}",
                    year:"{{ $order->car->year }}",
                    model:"{{ $order->car->model }}",
                    orderId:'{!! $order->id !!}',
                    color:"{{ $order->car->color }}",
                    kilometers:"",
                    gas_amount:"",
                    comments:"",
                    services:""
                }
            },
            methods:{

                setNumber(){
                    
                    if(this.telephone == ""){
                        this.telephone = "56"
                    }

                },
                checkNumber(){

                    if(this.telephone.substring(0, 2) != "56"){
                        this.telephone = "56"
                    }

                },
                isNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                getClient(){

                    axios.get("{{ url('/client/getClient/') }}"+"/"+this.rut).then(res => {

                        if(res.data.success == true){

                            if(res.data.data != null){
                                alert(res.data.msg)
                                this.name = res.data.data.name
                                this.telephone = res.data.data.telephone
                                this.address = res.data.data.address
                                this.location = res.data.data.location
                                this.email = res.data.data.email
                            }else{
                                alert("Cliente no encontrado")
                            }

                        }else{

                            alert(res.data.msg)

                        }

                    })

                },
                getCar(){

                    axios.get("{{ url('/car/getCar/') }}"+"/"+this.patent).then(res => {

                        if(res.data.success == true){

                            if(res.data.data != null){
                                alert(res.data.msg)
                                this.brand = res.data.data.brand
                                this.model = res.data.data.model
                                this.year = res.data.data.year
                                this.color = res.data.data.color
                            }else{
                                alert("Vehiculo no encontrado")
                            }

                        }else{

                            alert(res.data.msg)

                        }

                    })

                },
                revision(){

                    axios.post("{{ route('delivery.order.revision') }}", {rut: this.rut, name: this.name, telephone: this.telephone, address: this.address, location: this.location, email: this.email, patent: this.patent, brand: this.brand, year: this.year, model: this.model, color: this.color, kilometers: this.kilometers, gas_amount: this.gas_amount, comments: this.comments, services: this.services, orderId: this.orderId}).then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            window.location.href = "{{ route('delivery.index') }}"

                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                getServices(){
                    axios.get("{{ url('/mechanic/order/services/') }}"+"/"+this.orderId).then(res => {

                        if(res.data.success == true){

                            this.services = res.data.services

                        }else{

                            alert(res.data.msg)

                        }

                    })
                }

            },
            mounted(){
                this.getServices()
            }

        })

    </script>

@endpush