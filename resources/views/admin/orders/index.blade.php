@extends('layouts.user')

@section("content")

    @include('partials.admin.navbar')
    <div class="container form" id="contact-section">

        <div class="row">
            <div class="col-12">
                <input type="text" class="form-control" placeholder="RUT" @keyup="search()" v-model="rut">
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
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
                            <th scope="col">Link</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders">
                            <th>@{{ order.id }}</th>
                            <td>@{{ order.client.name }}</td>
                            <td>@{{ order.client.rut }}</td>
                            <td>@{{ order.car.brand }} @{{ order.car.model }} @{{ order.car.year }}</td>
                            <td>@{{ order.car.patent }}</td>
                            <td>@{{ order.created_at.substring(0, 10) }}</td>
                            <td>@{{ order.status.text }}</td>
                            <td>
                                <a :href="'{{ url('/order/number') }}'+'/'+order.client_link" v-if="order.status_id >= 2">ver</a>
                            </td>
                            <td>
                            
                                <a v-if="order.status.id == 1" class="btn btn-success text-white" @click="notificationCarOnTheWay(order.id)">Notificar camino al taller</a>
                                <a v-if="order.status.id == 2" class="btn btn-success text-white" @click="notificationCarProcess(order.id)">Notificar auto en proceso</a>
                                <a v-if="order.status.id == 4" class="btn btn-success text-white" :href="'{{ url('/admin/order/diagnostic/') }}'+'/'+order.id">Diagnostico</a>
                                <a v-if="order.status.id == 9" class="btn btn-success text-white" :href="'{{ url('/admin/order/show/payments/') }}'+'/'+order.id">Ver pagos</a>
                                <a v-if="order.status.id == 10" class="btn btn-success text-white" @click="notificationCarOnDelivery(order.id)">Auto Camino a tu lugar</a>
                                <p v-if="order.status.id == 11">Orden finalizada</p>
                                <p v-if="order.status.id == 12">Orden cancelada</p>
                                <!--<button class="btn btn-danger" v-if="order.status != 3 && order.status.id < 11" @click="cancel(order.id)">cancelar</button>-->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" v-for="index in pages" :key="index" @click="fetch(index)" >@{{ index }}</a>
                        </li>
                    </ul>
                </nav>
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
                    orders:[],
                    rut:"",
                    pages:0
                }
            },
            methods:{

                fetch(page = 1){

                    axios.get("{{ url('/admin/order/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.orders = res.data.orders
                        this.pages = Math.ceil(res.data.ordersCount / 15)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                notificationCarOnDelivery(id){
                    axios.post("{{ url('/admin/order/notificationCarOnDelivery') }}", {id: id})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.fetch()
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
                notificationCarProcess(id){
                    axios.post("{{ route('admin.order.notificationCarProcess') }}", {id: id})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.fetch()
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
                cancel(id){

                    if(confirm("¿Está seguro?")){
                        axios.post("{{ url('/admin/order/cancel/') }}", {id: id})
                        .then(res => {

                            if(res.data.success == true){
                                alert(res.data.msg)
                                this.fetch()
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
                search(){
                    if(this.rut != ""){

                        axios.get("{{ url('/admin/order/search/') }}"+"/"+this.rut)
                        .then(res => {

                            if(res.data.success == true){
                            this.orders = res.data.orders
                            }else{
                                alert(res.data.msg)
                            }

                        })
                        .catch(err => {
                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });
                        })

                    }else{

                        this.fetch()

                    }
                },


            },

            mounted(){
                
                this.fetch()
            }

        })

    </script>


@endpush