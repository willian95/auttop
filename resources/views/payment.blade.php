@extends('layouts.user')

@section('content')

@include('partials.user.navbar')

<section  class="info-serv" id="contact-section" >
    <div class="title-re">
        <div class="logo-re">
            <img src="{{ asset('assets/img/logo.png') }}">
        </div>
    </div>
    @if($order->status_id == 8)
            <a href="{{ url('/order/payment/'.$order->client_link) }}" class="btn btn-success">Continuar a la confiramción de pago</a>
        @else
    <div id="accordion">
        <div class="card">
            <div style="    background: #fb7300; height: 7vh; display: flex; align-items: center; padding-left: 19px;" sclass="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Reparaciones Aprobadas
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div class="item-reparaciones" v-for="diagnostic in diagnostics" v-if="diagnostic.type == 'aprobada'">
                        
                        <div v-cloak> 
                            @{{ diagnostic.service }}
                        </div>
                        <div v-cloak> 
                            @{{ diagnostic.price }}
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div  class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Reparaciones Urgentes
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    
                    <div class="item-reparaciones" v-for="diagnostic in diagnostics" v-if="diagnostic.type == 'urgente'">
                        
                        <div v-cloak> 
                            @{{ diagnostic.service }}
                        </div>
                        <div v-cloak> 
                            @{{ diagnostic.price }}
                        </div>
                        <div>
                            <input type="checkbox" id="checkbox" @click="toggleCheck(diagnostic.price, diagnostic.id)">
                        </div>
                        
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Reparación Sugeridas
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        
                        <div class="item-reparaciones" v-for="diagnostic in diagnostics" v-if="diagnostic.type == 'sugerida'">
                           
                            <div v-cloak> 
                                @{{ diagnostic.service }}
                            </div>
                            <div v-cloak> 
                                @{{ diagnostic.price }}
                            </div>
                            <div>
                                <input type="checkbox" id="checkbox" @click="toggleCheck(diagnostic.price, diagnostic.id)">
                            </div>
                          
                        </div>

                    </div>
                </div>
            </div>
            <div class="Total"> 
                <div> Suma Total:</div>
                <div>@{{ total }}</div>
            
            </div>
    </section>

    <p class="text-center">
        <button class="btn btn-success" @click="store()">Aceptar</button>
    </p>
    @endif
@endsection

@push('scripts')

    <script>
                
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    total:'{!! $total !!}',
                    amounts:[],
                    diagnostics:[],
                    order_id: '{!! $order_id !!}'
                }
            },
            methods:{


                setTotal(){
                    this.total = parseFloat('{!! $total !!}')
                    this.amounts.forEach((data, index) => {
                        this.total += parseFloat(data.price)
                    })

                },
                toggleCheck(price, id){

                    let exists = false

                    this.amounts.forEach((data, index) => {

                        if(data.id == id){
                            exists = true
                            this.amounts.splice(index, 1)
                            this.setTotal()
                        }

                    })

                    if(exists == false){
                        this.amounts.push({price: price, id: id})
                        this.setTotal()
                    }

                },
                fetch(){

                    axios.post("{{ url('/order/diagnostics') }}", {'order_id': this.order_id})
                    .then(res => {
                        this.diagnostics = res.data
                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                store(){

                    axios.post("{{ route('admin.order.diagnostic.approved') }}", {order_id: this.order_id, amounts: this.amounts})
                    .then(res => {

                        if(res.data.success == true){
                            alertify.success(res.data.msg)

                            window.location.href="{{ url('/order/payment/'.$order->client_link) }}"

                        }else{
                            alertify.error(res.data.msg)
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
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