@extends('layouts.user')

@section('content')

@include('partials.admin.navbar')
<section  class="form" id="contact-section" >
        <div class="container">
            <div class="mask">
        
            	<form action="">
                    <div class="title-form">
                        <div>
                              <h2 style=" text-align: center; font-weight: bold; font-size: 20px;    margin-bottom: 10%;    color: #2a497e;" class="">Editar Cliente</h2>
                           </div>
                           <div class="logo-form">
                                <img style="width: 50px; height: 50px;"src="{{ asset('assets/img/logo.png') }}">
                           </div>
                    </div>
                    <div style="margin-bottom: 50px;">
                        <div class="form-group row">
    
                            <div class="col-md-4 mb-4">
                                <input type="text" class="form-control" placeholder="Patente" v-model="patent" readonly>
                            </div>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Marca"  v-model="brand">
                            </div>
                        </div>
       
    
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Año"  v-model="year" id="year" @click="setNumber()" @keypress="isNumber($event)">
                      
                            </div>
              
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Modelo"  v-model="model">
                      
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Color"  v-model="color">
                      
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
                    patent:"{!! $car->patent !!}",
                    brand:"{!! $car->brand !!}",
                    model:"{!! $car->model !!}",
                    color:"{!! $car->color !!}",
                    year:"{!! $car->year !!}"
                }
            },
            methods:{

                update(){

                    let formData = new FormData()
                    formData.append("brand", this.brand)
                    formData.append("model", this.model)
                    formData.append("color", this.color)
                    formData.append("year", this.year)
                    formData.append("id", "{!! $car->id !!}")

                    axios.post("{{ route('admin.car.update') }}", formData)
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href="{{ route('admin.car.index') }}"
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
                }
                

            },
            mounted(){
                
            }

        })

    </script>

@endpush