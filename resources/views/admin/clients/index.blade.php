@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="p160 form dash" id="contact-section">
        <div class="top_title">
            <h3 class="text-center">Clientes</h3>
        </div>
        <div class="container-fluid">
            <div class="bg__tables mt-15">
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Rut</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">email</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Comuna</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(client, index) in clients">
                                    <th v-cloak>@{{ index + 1 }}</th>
                                    <td v-cloak>@{{ client.name }}</td>
                                    <td v-cloak>@{{ client.telephone }}</td>
                                    <td v-cloak>@{{ client.email }}</td>
                                    <td v-cloak>@{{ client.address }}</td>
                                    <td v-cloak>@{{ client.location }}</td>
                                    <td v-cloak>
                                        <a class="btn btn-success" :href="'{{ url('/admin/client/edit/') }}'+'/'+client.id">editar</a>
                                        <button class="btn btn-danger" @click="erase(client.id)">eliminar</button>
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

@endsection

@push('scripts')

    <script>
                    
        const app = new Vue({
            el: '#dev-app',
            data(){
                return{
                    clients:[],
                    pages:0
                }
            },
            methods:{

                fetch(page = 1){

                    axios.get("{{ url('/admin/client/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.clients = res.data.clients
                        this.pages = Math.ceil(res.data.clientsCount / 15)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                getClient(){

                    axios.get("{{ url('/admin/client/fetch/') }}").then(res => {

                        if(res.data.success == true){

                            if(res.data.data != null){
                                alertify.success(res.data.msg)
                                this.name = res.data.data.name
                                this.telephone = res.data.data.telephone
                                this.address = res.data.data.address
                                this.location = res.data.data.location
                                this.email = res.data.data.email
                            }else{
                                alertify.error("Cliente no encontrado")
                            }

                        }else{

                            alertify.error(res.data.msg)

                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alertify.error(value[0])
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/admin/client/delete/') }}", {id: id}).then(res => {

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