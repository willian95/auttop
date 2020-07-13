@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')

    <div class="container form dash pl60" id="contact-section">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">
                    Diagnostico
                </h3>
            </div>
        </div>
        
     <div class="bg__tables m140">
        <div class="row" v-if="approved.length > 0">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in approved">
                            <td v-cloak>@{{ row.service.name }}</td>
                            <td v-cloak>
                                @{{ row.type }}
                            </td>
                            <td v-if="row.type == 'aprobada'" v-cloak>
                                @{{ row.price }}
                            </td>
                            <td v-else v-cloak>
                                <input type="text" class="form-control price" :id="'price'+row.id" @keypress="isNumber($event)">
                            </td>
                        </tr>
                    </tbody>
                </table>
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

            <div style="display: flex; justify-content: center;"class="form-group row">
                <div style="text-align: center;" class="col-md-6">

                    <button style="color: #fff;"class="btn-direction" type="button" @click="update()">Enviar</button>
                </div>
            </div>
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
                    approved:[],
                    prices:[],
                    orderId:'{{ $order->id }}'
                }
            },
            methods:{

                
                update(){
                    this.prices= []
                    //this.approvedElements()
                    var element = $('.price').map((_,el) => el).get()
                    //console.log("test-element", element)
                    element.forEach((data, index) => {

                        this.prices.push({"id": data.id.substring("5", data.id.length), "price": data.value})
                       
                    })

                    axios.post("{{ route('admin.diagnostic.price.update') }}", {prices: this.prices,  orderId: this.orderId})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href="{{ route('admin.order.index') }}"
                        }else{
                            alert(res.data.msg)
                        }

                    })
                    .catch(err =>{
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                isNumber: function(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                fetch(){
                    axios.post("{{ route('admin.order.diagnostic.get') }}", {order_id: "{!! $order->id !!}"})
                    .then(res => {

                        this.approved = res.data

                    })
                    .catch(err =>{
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })
                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush