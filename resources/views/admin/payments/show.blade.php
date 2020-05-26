@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')

    <section  class="form" id="contact-section" >
        <div class="container">
            <div class="mask">
        
            	<form action="">
                    <div class="title-form">
                        <div>
                              <h2 style=" text-align: center; font-weight: bold; font-size: 20px;    margin-bottom: 10%;    color: #2a497e;" class="">Pagos</h2>
                           </div>
                           <div class="logo-form">
                                <img style="width: 50px; height: 50px;"src="{{ asset('assets/img/logo.png') }}">
                           </div>
                    </div>
           
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Método de pago</th>
                                <th>Referencia</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(payment, index) in payments">
                                <td v-cloak>@{{ index + 1 }}</td>
                                <td v-cloak>@{{ payment.payment_method }}</td>
                                <td v-cloak>@{{ payment.transfer_id }}</td>
                                <td v-cloak>@{{ payment.status }}</td>
                                <td v-cloak>
                                    <button class="btn btn-success" @click="approve(payment.id)" v-if="payment.status == 'en espera'" >aprobar</button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModal" @click="reject(payment.id)" v-if="payment.status == 'en espera'">rechazar</button>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Servicios</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedDiagnostics as $approved)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $approved->diagnostic->service }}</td>
                                    <td>{{ $approved->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <strong>Total:</strong> {{ $order->final_total }}
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
                    order_id: '{!! $order->id !!}',
                    payments: [],
                    description:"",
                    rejectId:0
                }
            },
            methods:{
                
                approve(id){

                    axios.post("{{ url('/admin/order/payment/approve') }}", {order_id: this.order_id, paymentId: id})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href = "/admin/order/index"
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
                /*setRejectId(id){

                    this.rejectId = id

                },*/
                reject(id){

                    this.description = prompt("Ingresa la razón de rechazo");

                    axios.post("{{ url('/admin/order/payment/reject') }}", {order_id: this.order_id, paymentId: id, description: this.description})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href = "/admin/order/index"
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
                fetch(){

                    axios.get("{{ url('/admin/order/get/payments/') }}"+"/"+this.order_id)
                    .then(res => {

                        if(res.data.success == true){
                            
                            this.payments = res.data.payments
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
                this.fetch()
            }

        })

    </script>    

@endpush