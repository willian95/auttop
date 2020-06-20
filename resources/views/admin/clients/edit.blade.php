@extends('layouts.user')

@section('content')

@include('partials.admin.navbar')
<section  class="form" id="contact-section" >
        <div class="container pl50">
            	
            <div class="title-form">
                <div>
                    <h2 style=" text-align: center; font-weight: bold; font-size: 20px;    margin-bottom: 10%;    color: #2a497e;" class="">Editar Cliente</h2>
                </div>
                <div class="logo-form">
                    <img style="width: 50px; height: 50px;"src="{{ asset('assets/img/logo.png') }}">
                </div>
            </div>
            <div style="margin-bottom: 50px;">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Rut</label>
                            <input type="text" class="form-control" placeholder="Rut" v-model="rut" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre"  v-model="name">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" placeholder="Fono"  v-model="telephone" id="telephone" @click="setNumber()" @keyup="checkNumber()" @keypress="isNumber($event)">
                        </div>
                
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" placeholder="Dirección"  v-model="address">
                        </div>
                
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="">Comuna</label>
                            <input type="text" class="form-control" placeholder="Comuna"  v-model="location">
                        </div>
                    </div>
        

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" placeholder="Correo"  v-model="email">
                        </div>
                    </div>
                </div> 
            </div>
           
      
                    <div style="margin-bottom: 50px;">
                        <div style="display: flex;justify-content: center;"class="form-group row">
                            <div style="text-align: center;" class="col-md-6">
            
                                <button style="color: #fff;"class="btn-direction" type="button" @click="update()">Actualizar</button>
                            </div>
                        </div>
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
                    rut:"{!! $client->rut !!}",
                    name:"{!! $client->name !!}",
                    telephone:"{!! $client->telephone !!}",
                    address:"{!! $client->address !!}",
                    location:"{!! $client->location !!}",
                    email:"{!! $client->email !!}"
                }
            },
            methods:{

                update(){

                    let formData = new FormData()
                    formData.append("name", this.name)
                    formData.append("telephone", this.telephone)
                    formData.append("address", this.address)
                    formData.append("location", this.location)
                    formData.append("email", this.email)
                    formData.append("id", "{!! $client->id !!}")

                    axios.post("{{ route('admin.client.update') }}", formData)
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href="{{ route('admin.client.index') }}"
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
                isNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
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
                

            },
            mounted(){
                
            }

        })

    </script>

@endpush