@extends('layouts.user')

@section("content")

    @include('partials.user.navbar')
    <section  class="form" id="contact-section" >
        <div class="container">
            <div class="mask">
        
            	<form action="">
                    <div class="title-form">
                        <div>
                              <h2 style=" text-align: center; font-weight: bold; font-size: 20px;    margin-bottom: 10%;    color: #2a497e;" class="">Orden de Trabajo</h2>
                           </div>
                           <div class="logo-form">
                                <img style="width: 50px; height: 50px;"src="{{ asset('assets/img/logo.png') }}">
                           </div>
                    </div>
                    <div style="margin-bottom: 50px;">
                        <div class="form-group row">
    
                            <div class="col-md-4 mb-4">
                                <input type="text" class="form-control" placeholder="Rut" v-model="rut">
                            </div>
                    
                            <div>
                                <button class="btn btn-success" @click="getClient()" type="button">buscar</button>
                            </div>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Nombre"  v-model="name">
                      
                            </div>
                        </div>
       
    
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Fono"  v-model="telephone" id="telephone" @click="setNumber()" @keyup="checkNumber()" @keypress="isNumber($event)">
                      
                            </div>
              
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Dirección"  v-model="address">
                      
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Comuna"  v-model="location">
                      
                            </div>
                
    
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Correo"  v-model="email">
                      
                            </div>
                        </div> 
                    </div>
           
                    <div style="margin-bottom: 50px;">
                        <div class="form-group row">
                    
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Patente"  v-model="patent">
                      
                            </div>
                    
                            <div class="col-md-2">
                                <button class="btn btn-success" @click="getCar()" type="button">buscar</button>
                            </div>
    
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Marca"  v-model="brand">
                      
                            </div>
                
                        </div>
           
    
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
                                <input type="number" class="form-control" placeholder="Año"  v-model="year">
                            </div>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Modelo"  v-model="model">
                            </div>
                
                        </div>
          
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Color"  v-model="color">
                      
                            </div>
                            <div class="col-md-6">
                            
                            </div>  
                    
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
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
                                <input type="text" class="form-control" placeholder="Kms"  v-model="kilometers" @keypress="isNumber($event)">
                            </div>
                        </div>
                    </div>
      
                    <div style="margin-bottom: 50px;">
                        <div class="form-group row">
                            <div class="col-md-12">
                                   <textarea class="form-control" id="" cols="30" rows="10" placeholder="Comentarios"  v-model="comments"></textarea>
                      
                            </div>
                
               
                        </div>
    
                  <!--<div class="form-group row">
                    <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Ingreso de Fondos: Exterior o Interior">
                    </div>
              
               
                  </div>-->
    
                        <div class="form-group row">
                            <div class="col-md-12">
                                <h3 class="text-center">Servicios</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="service" placeholder="ej: cambio de aceite">
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success" type="button" @click="addService()">agregar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>servicio</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(service, index) in services">
                                            <td>@{{ index + 1 }}</td>
                                            <td>@{{ service.service }}</td>
                                            <td>
                                                <button class="btn btn-danger" type="button" @click="removeService(service.id)">X</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
            
    
                  <!--<div class="form-group row">
                    <div class="col-md-12">
                      <input type="text" class="form-control" placeholder="Recepcionado por">
                    </div>
                  </div>
    
                    <div class="form-group row">
                    <div class="col-md-6 mb-4">
                      <input type="text" class="form-control" placeholder="Fondo">
                    </div>
                
     
                    <div class="col-md-6">
                      <input type="text" class="form-control" placeholder="Código">
                    </div>
                  </div>-->
    
                        <div style="display: flex;justify-content: center;"class="form-group row">
                            <div style="text-align: center;" class="col-md-6">
            
                                <button style="color: #fff;"class="btn-direction" type="button" @click="store()">Enviar</button>
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
                    rut:'',
                    name:"",
                    telephone:"",
                    address:"",
                    location:"",
                    email:"",
                    patent:"",
                    brand:"",
                    year:"",
                    model:"",
                    color:"",
                    kilometers:"",
                    gas_amount:"",
                    comments:"",
                    serviceCount:1,
                    service:"",
                    services:[]
                }
            },
            methods:{

                addService(){
                    if(this.service == ""){
                        alert("Debe agregar los servicios al formulario")
                    }else{
                        this.services.push({"service":this.service, "id":this.serviceCount})
                        this.service = ""
                        this.serviceCount++;
                    }
                },
                removeService(id){

                    this.services.forEach((data, index) => {
                        if(data.id == id){
                            this.services.splice(index, 1)
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

                    axios.post("{{ route('order.store') }}", {rut: this.rut, name: this.name, telephone: this.telephone, address: this.address, location: this.location, email: this.email, patent: this.patent, brand: this.brand, year: this.year, model: this.model, color: this.color, kilometers: this.kilometers, gas_amount: this.gas_amount, comments: this.comments, services: this.services}).then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            window.location.href = "{{ url('/') }}"

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
                //this.test()
            }

        })

    </script>

@endpush