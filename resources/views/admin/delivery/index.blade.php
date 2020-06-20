@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="container form dash" id="contact-section">
        <div class="top_title">
            <h3 class="text-center">Deliveries</h3>
            <button class="btn btn-success mr-5" data-toggle="modal" data-target="#createDelivery">Crear  <img src="{{ asset('assets/img/iconos/bx-list-plus.svg') }}" alt=""></button>
        </div>
       <!-- <div class="row">
            <div class="col-12">
                <h3 class="text-center">Deliveries</h3>
            </div>
        </div>-->
        <div class="bg__tables mt-15" style="margin-left: 130px;">
            <div class="row">
            <!---  <div class="col-12">
                  <p class="text-center">
                      <button class="btn btn-success" data-toggle="modal" data-target="#createDelivery">Crear</button>
                  </p>
              </div>--->
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Clave</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(delivery, index) in deliveries">
                                <th v-cloak>@{{ index + 1 }}</th>
                                <td v-cloak>@{{ delivery.name }}</td>
                                <td v-cloak>@{{ delivery.email }}</td>
                                <td v-cloak>@{{ delivery.password_reveal }}</td>
                                <td v-cloak>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createDelivery" @click="edit(delivery)">editar</button>
                                    <button button class="btn btn-danger" @click="erase(delivery.id)">eliminar</button>
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
                            <li class="page-item" v-for="index in pages">
                                <a class="page-link" href="#" :key="index" @click="fetch(index)" >@{{ index }}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
       </div>
    </div>

    <!-- modal -->

    <div class="modal fade" id="createDelivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" v-model="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" v-model="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" v-model="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="store()" v-if="action == 'create'">Crear</button>
                    <button type="button" class="btn btn-primary" @click="update()" v-if="action == 'edit'">Editar</button>
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
                    modalTitle:"Crear delivery",
                    name:"",
                    email:"",
                    password:"",
                    deliveryId:"",
                    action:"create",
                    deliveries:[],
                    pages:0
                }
            },
            methods:{

                create(){
                    this.modalTitle = "Crear delivery"
                    this.action = "create"
                    this.name = ""
                    this.email = ""
                    this.password = ""
                },
                store(){

                    axios.post("{{ route('admin.delivery.store') }}", {name: this.name, email: this.email, password: this.password})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.name = ""
                            this.email  = ""
                            this.password = ""
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
                update(){

                    axios.post("{{ route('admin.delivery.update') }}", {id: this.deliveryId, name: this.name, email: this.email, password: this.password})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.name = ""
                            this.email  = ""
                            this.password = ""
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
                edit(delivery){
                    this.modalTitle = "Editar delivery"
                    this.action = "edit"
                    this.name = delivery.name
                    this.email = delivery.email
                    this.password = delivery.password_reveal
                    this.deliveryId = delivery.id
                },
                fetch(page = 1){

                    axios.get("{{ url('/admin/delivery/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.deliveries = res.data.deliveries
                        this.pages = Math.ceil(res.data.deliveriesCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/admin/delivery/delete') }}", {id: id}).then(res => {

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

                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush