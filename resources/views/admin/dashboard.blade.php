@extends('layouts.user')

@section("content")

    @include('partials.admin.navbar')
    <section  class="form  dash" id="contact-section" >
        <div class="top_title">
            <h3 class="">Panel de control</h3>
    
                <button class="btn btn-success mr-5" data-toggle="modal" data-target="#createODT">Crear Orden  <img src="{{ asset('assets/img/iconos/bx-list-plus.svg') }}" alt=""></button>
           
        </div>

       <div class="container m140" >
            <!-- <div class="row">
                <div class="col-12">
                    <p class="text-center">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createODT">Crear</button>
                    </p>
                </div>  --->
            
          <div class="row resgistros">
            <div class="col-4">
                <p class="text-center">{{ App\Car::count() }} <img src="{{ asset('assets/img/iconos/bx-car.svg') }}" alt=""> </p>
                <h5 class="text-center">Vehiculos registrados</h5>
            
            </div>
            <div class="col-4">
                <p class="text-center">{{ App\Client::count() }} <img src="{{ asset('assets/img/iconos/bx-user.svg') }}" alt=""></p>
                <h5 class="text-center">Clientes registrados</h5>
                
            </div>
            <div class="col-4">
                <p class="text-center">{{ App\Order::count() }} <img src="{{ asset('assets/img/iconos/bx-edit.svg') }}" alt=""></p>
                <h5 class="text-center">Ordenes registradas</h5>
                
            </div>
          </div>
          <div class="bg__tables">
            <div class="row">
                <div class="col-12">
                    <h3 class="">Últimas ordenes</h3>
                </div>
            </div>
            <div class="row over">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">rut</th>
                                <th scope="col">Vehiculo</th>
                                <th scope="col">Patente</th>
                                <th scope="col">Fecha de recepción</th>
                                <th scope="col">Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(order, index) in orders" v-cloak>
                                <th v-cloak>@{{ index + 1 }}</th>
                                <td v-cloak>@{{ order.client.name }}</td>
                                <td v-cloak>@{{ order.client.rut }}</td>
                                <td v-cloak>@{{ order.car.brand }} @{{ order.car.model }} @{{ order.car.year }}</td>
                                <td v-cloak>@{{ order.car.patent }}</td>
                                <td v-cloak>@{{ order.created_at.substring(0, 10) }}</td>
                                <td v-cloak>@{{ order.status.text }}</td>
                            
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    
    </section>
</div>
    <!-- modal -->

    <div class="modal fade" id="createODT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Orden de Trabajo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
    
                        <div class="col-lg-5  col-md-10 mb-4">
                            <input type="text" class="form-control" placeholder="Rut" v-model="rut">
                        </div>

                        <div>
                            <button class="btn btn-success btn-search" @click="getClient()" type="button"><img class="filter" src="{{ asset('assets/img/iconos/bx-search-alt.svg') }}" alt=""></button>
                        </div>

                        <div class="col-lg-6">
                            <input type="text" class="form-control" placeholder="Nombre"  v-model="name">
                        </div>
                    </div>
                    <div class="form-group row">
                     
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Dirección"  v-model="address">

                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-6 mb-4">
                            <input type="text" class="form-control" placeholder="Fono"  v-model="telephone" id="telephone" @click="setNumber()" @keyup="checkNumber()" @keypress="isNumber($event)">
                        </div>
                        <div class="col-lg-5  col-md-10 ">
                            <input type="text" class="form-control" placeholder="Patente"  v-model="patent">
                  
                        </div>
                
                        <div class="">
                            <button class="btn btn-success btn-search" @click="getCar()" type="button"><img class="filter" src="{{ asset('assets/img/iconos/bx-search-alt.svg') }}" alt=""></button>
                        </div>
                    <!---    <div class="col-lg-6">
                            <input type="text" class="form-control" placeholder="Dirección"  v-model="address">

                        </div>--->
                    </div>

                     <!---<div style="margin-bottom: 50px;">
                        <div class="form-group row">
                    
                            <div class="col-lg-5">
                                <input type="text" class="form-control" placeholder="Patente"  v-model="patent">
                      
                            </div>
                    
                            <div class="">
                                <button class="btn btn-success" @click="getCar()" type="button"><img class="filter" src="{{ asset('assets/img/iconos/bx-search-alt.svg') }}" alt=""></button>
                            </div>
    
                            <div class="col-lg-6 mb-4">
                                <input type="text" class="form-control" placeholder="Marca"  v-model="brand">
                      
                            </div>
                
                        </div>--->
           
    
                    <div class="form-group row">
                            
                        <div class="col-lg-6 mb-4">
                            <input type="text" class="form-control" placeholder="Marca"  v-model="brand">
                  
                        </div>

                            <div class="col-lg-6 mb-4">
                                <input type="number" class="form-control" placeholder="Año"  v-model="year">
                            </div>
    
                           
                
                    </div>

                        <div class="row">
                        
                            <div class="col-lg-6 mt-33">
                                <input type="text" class="form-control" placeholder="Modelo"  v-model="model">
                            </div>
                            <div class="col-lg-6">
                                <label class="asignar" for="">Asignar delivery</label>
                                <select class="form-control" v-model="delivery" v-cloak>
                                    <option   :value="delivery.id" v-for="(delivery, index) in deliveries" >
                                        @{{ delivery.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 mt-5">
                                <h3 class="text-center">Servicios</h3>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-5">
                                <label class="asignar" for="">Seleccionar servicio</label>
                                <select class="form-control" v-model="serviceIndex" v-cloak>
                                    <option :value="index" v-for="(service, index) in services" >
                                        @{{ service.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-5  col-md-10 mt-33">
                                <input type="text" class="form-control" placeholder="Precio"  v-model="price">
                            </div>
                            <div class="col-lg-2 mt-33">
                                <button class="btn btn-success" type="button" @click="addService()">agregar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Servicio</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(service, index) in orderServices">
                                            <td v-cloak>@{{ index + 1 }}</td>
                                            <td v-cloak>@{{ service.service.name }}</td>
                                            <td v-cloak>@{{ service.price }}</td>
                                            <td v-cloak>
                                                <button class="btn btn-danger" type="button" @click="removeService(service.service.id)"><img class="filter" src="{{ asset('assets/img/iconos/bx-x.svg') }}" alt=""></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>--->
                    <button type="button" class="btn btn-primary" @click="store()">Crear orden</button>
                </div>
            </div>
        </div>
    </div>
  

    <!-- modal -->

@endsection

@push('scripts')

    <script>
                
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    serviceCount:1,
                    rut:'',
                    name:"",
                    address:"",
                    email:"",
                    patent:"",
                    brand:"",
                    telephone:"",
                    year:"",
                    model:"",
                    serviceIndex:"",
                    price:"",
                    services:[],
                    orderServices:[],
                    deliveries:[],
                    delivery:"",
                    orders:[]
                }
            },
            methods:{

                addService(){
                    if(this.service == ""){
                        alert("Debe agregar los servicios al formulario")
                    }else{

                        let service = this.services[this.serviceIndex]
                        var exists = false

                        this.orderServices.forEach((data, index)=>{
                            
                            if(data.service.id == service.id){
                                exists = true
                            }
                        })

                        if(!exists){
                            this.orderServices.push({"service":service, "price": this.price})
                            this.serviceIndex = ""
                            this.price = ""
                            this.serviceCount++;
                        }else{
                            alert("Este servicio ya está agregado")
                        }
                        
                    }
                },
                removeService(id){

                    this.orderServices.forEach((data, index) => {
                        if(data.service.id == id){
                            this.orderServices.splice(index, 1)
                        }
                    })

                },
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
                getOrders(){

                    axios.get("{{ url('/admin/order/take') }}").then(res => {

                        if(res.data.success == true){
                            this.orders = res.data.orders
                        }

                    })

                },
                fetchServices(){

                    axios.get("{{ url('/admin/service/fetchAll') }}").then(res => {

                        if(res.data.success == true){
                            this.services = res.data.services
                        }

                    })

                },
                fetchDeliveries(){

                    axios.get("{{ url('/admin/delivery/fetchAll') }}").then(res => {

                        if(res.data.success == true){
                            this.deliveries = res.data.deliveries
                        }

                    })

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
                store(){

                    axios.post("{{ route('order.store') }}", {rut: this.rut, name: this.name, telephone: this.telephone, address: this.address, patent: this.patent, brand: this.brand, year: this.year, model: this.model, services: this.orderServices, delivery: this.delivery}).then(res => {

                        //console.log("test", res.data)

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.rut = ""
                            this.name = ""
                            this.telephone = ""
                            this.address = ""
                            this.patent = ""
                            this.brand = ""
                            this.year = ""
                            this.model = ""
                            this.orderServices = []
                            this.delivery = ""
                            this.getOrders()

                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                }

            },
            mounted(){
                this.fetchServices()
                this.fetchDeliveries()
                this.getOrders()
                //this.test()
            }

        })

    </script>

@endpush