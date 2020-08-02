@extends('layouts.user')

@section('content')

    @include('partials.user.navbar')

    <section  class="info-serv" id="contact-section" >
        <div class="title-re">
            <div class="logo-re">
                <img src="{{ asset('assets/img/logo.png') }}">
            </div>
        </div>
        
       
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(service, index) in approvedDiagnostics">
                                <td v-cloak>@{{ index + 1 }}</td>
                                <td v-cloak>@{{ service.diagnostic.service }}</td>
                                <td v-cloak>@{{ service.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            
            
            <div class="Total"> 
                <div> Suma Total:</div>
                <div v-cloak>@{{ total }}</div>
            
            </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Pagos</h3>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Método de pago</th>
                                <th>Referencia</th>
                                <th>Status</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->payments as $payment)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{ $payment->payment_method }}
                                    </td>
                                    <td>
                                        {{ $payment->transfer_id }}
                                    </td>
                                    <td>
                                        {{ $payment->status }}
                                    </td>
                                    <td>
                                        {{ $payment->description }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4 class="text-center">Método de pago</h4>
                    <input type="radio" id="uno" value="efectivo" v-model="paymentMethod">
                    <label for="uno">Efectivo</label>
                    <br>
                    <input type="radio" id="Dos" value="transferencia bancaria" v-model="paymentMethod">
                    <label for="Dos">Transferencia bancaria</label>
                    <br>
                </div>
                <div class="col-6">
                    <h4 class="text-center" v-if="paymentMethod == 'efectivo'">
                        Dirijase a nuestras oficinas para realizar el pago
                    </h4>
                    <div v-if="paymentMethod == 'transferencia bancaria'">
                        <label for="">ID de transferencia</label>
                        <input type="text" class="form-control" v-model="transferID">
                    </div>

                    <button class="btn btn-success" @click="checkout()">
                        Aceptar
                    </button>
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
                    approvedDiagnostics:[],
                    total:0,
                    order_id: '{!! $order->id !!}',
                    paymentMethod:'efectivo',
                    transferID:"",
                    loading:false
                }
            },
            methods:{

                fetch(){

                    axios.post("{{ url('/order/approvedDiagnostic/get') }}", {'order_id': this.order_id})
                    .then(res => {
                        
                        if(res.data.success == true){
                            this.approvedDiagnostics = res.data.diagnostic
                            this.total = res.data.total
                        }else{
                            alertify.error(res.data.msg)
                        }
                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value)
                        });
                    })

                },
                checkout(){

                    if(this.loading == false){

                        let error = false
                        this.loading = true

                        if(this.paymentMethod == 'transferencia bancaria'){
                            this.loading = false
                            if(this.transferID == ""){
                                alertify.error('Debe colocar el ID de la transacción')
                                error = true
                            }

                        }

                        if(!error){

                            axios.post("{{ url('/order/payment/store') }}", {transferId: this.transferID, paymentMethod: this.paymentMethod, order_id: this.order_id})
                            .then(res => {

                                this.loading = false

                                if(res.data.success == true){

                                    alertify.success(res.data.msg)
                                    window.location.href="{{ url('/order/number/'.$order->client_link) }}"

                                }else{

                                    alertify.error(res.data.msg)

                                }

                            })
                            .catch(err => {
                                this.loading = false
                                $.each(err.response.data.errors, function(key, value){
                                    alertify.error(value)
                                });
                            })

                        }

                    }

                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush