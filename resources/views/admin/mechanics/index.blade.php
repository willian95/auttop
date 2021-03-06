@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="p160 form dash" id="contact-section">
        <div class="top_title">
            <h3 class="text-center">Mecanicos</h3>  
            <button class="btn btn-success mr-5" data-toggle="modal" data-target="#createMechanic" @click="create()">Crear  <img src="{{ asset('assets/img/iconos/bx-list-plus.svg') }}" alt=""></button>
        </div>

        <div class="container-fluid">

            <div class="bg__tables mt-15 pl50">
                <div class="row">
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
                                <tr v-for="(mechanic, index) in mechanics">
                                    <th v-cloak>@{{ index + 1 }}</th>
                                    <td v-cloak>@{{ mechanic.name }}</td>
                                    <td v-cloak>@{{ mechanic.email }}</td>
                                    <td v-cloak>@{{ mechanic.password_reveal }}</td>
                                    <td v-cloak>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#createMechanic" @click="edit(mechanic)">editar</button>
                                        <button class="btn btn-danger" @click="erase(mechanic.id)">eliminar</button>
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
    </div>

    <!-- modal -->

    <div class="modal fade" id="createMechanic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    modalTitle:"Crear mecánico",
                    name:"",
                    email:"",
                    password:"",
                    mechanicId:"",
                    action:"create",
                    mechanics:[],
                    pages:0,
                    loading:false
                }
            },
            methods:{

                create(){
                    this.action = "create"
                    this.name = ""
                    this.email = ""
                    this.password = ""
                },
                store(){

                    if(this.loading == false){
                        this.loading = true
                        axios.post("{{ route('admin.mechanic.store') }}", {name: this.name, email: this.email, password: this.password})
                        .then(res => {

                            this.loading = false
                            if(res.data.success == true){

                                alertify.success(res.data.msg)
                                this.name = ""
                                this.email  = ""
                                this.password = ""
                                this.fetch()
                            }else{

                                alertify.error(res.data.msg)

                            }

                        })
                        .catch(err => {
                            this.loading = false
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value[0])
                            });
                        })

                    }

                },
                update(){

                    if(this.loading == false){

                        this.loading = true
                        axios.post("{{ route('admin.mechanic.update') }}", {id: this.mechanicId, name: this.name, email: this.email, password: this.password})
                        .then(res => {

                            this.loading = false
                            if(res.data.success == true){

                                alertify.success(res.data.msg)
                                this.name = ""
                                this.email  = ""
                                this.password = ""
                                this.fetch()
                                
                            }else{

                                alertify.error(res.data.msg)

                            }

                        })
                        .catch(err => {
                            this.loading = false
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value[0])
                            });
                        })

                    }

                },
                edit(mechanic){
                    this.action = "edit"
                    this.name = mechanic.name
                    this.email = mechanic.email
                    this.password = mechanic.password_reveal
                    this.mechanicId = mechanic.id
                },
                fetch(page = 1){

                    axios.get("{{ url('/admin/mechanic/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.mechanics = res.data.mechanics
                        this.pages = Math.ceil(res.data.mechanicsCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/admin/mechanic/delete') }}", {id: id}).then(res => {

                            if(res.data.success == true){
                                alertify.success(res.data.msg)
                                this.fetch()
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

                }
                

            },
            mounted(){
                this.fetch()
            }

        })

    </script>

@endpush