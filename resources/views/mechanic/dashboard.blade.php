@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')

    <div class="container">

    <div class="bg__tables">
        <div class="row">
            <div class="col-12">

                <table class="table" style="margin-top: 120px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Vehiculo</th>
                            <th>Link</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders">
                            <th v-cloak>@{{ order.id }}</th>
                            <td v-cloak>@{{ order.client.name }}</td>
                            <td v-cloak>@{{ order.client.telephone }}</td>
                            <td v-cloak>@{{ order.client.address }}</td>
                            <td v-cloak>@{{ order.car.brand }} @{{ order.car.model }} @{{ order.car.year }}</td>
                            <td v-cloak>
                                <a class="btn btn-success text-white"  :href="'{{ url('/order/number') }}'+'/'+order.client_link" v-if="order.status_id >= 2">ver</a>
                            </td>
                            <td v-cloak>
                                <a  v-if="order.status.id == 3" :href="'{{ url('/') }}'+'/mechanic/diagnostic/check/'+order.id" class="btn btn-success text-white">Chequear</a>
                                <a v-if="order.status.id == 7" class="btn btn-success text-white" @click="notificationCarOnDelivery(order.id)">Auto Camino a tu lugar</a>
                                <a v-if="order.status.id == 8" class="btn btn-success text-white" @click="notificationCarFinished(order.id)">Vehiculo entregado</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row" v-cloak>
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

    </div>

@endsection

@push('scripts')

    <script>
                    
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    orders:[],
                    pages:0
                }
            },
            methods:{

                fetch(page = 1){

                    axios.get("{{ url('/mechanic/order/fetch/') }}"+"/"+page)
                    .then(res => {

                        if(res.data.success == true){

                            this.orders = res.data.orders
                            this.pages = Matg.ceil(res.data.ordersCount / 20)

                        }else{
                            alert(res.data.msg)
                        }

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
                notificationCarFinished(id){
                    axios.post("{{ url('/admin/order/notificationFinish') }}", {id: id})
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
            mounted(){
                this.fetch()
            }

        })
    
    </script>

@endpush