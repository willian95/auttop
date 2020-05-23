@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="container form" id="contact-section">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Clientes</h3>
            </div>
        </div>
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
                            <th>@{{ index + 1 }}</th>
                            <td>@{{ client.name }}</td>
                            <td>@{{ client.telephone }}</td>
                            <td>@{{ client.email }}</td>
                            <td>@{{ client.address }}</td>
                            <td>@{{ client.location }}</td>
                            <td>
                                <a class="btn btn-success" :href="'{{ url('/admin/client/edit/') }}'+'/'+client.id">editar</a>
                                <button class="btn btn-danger" @click="erase(client.id)">eliminar</button>
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
                            alert(value)
                        });
                    })

                },
                getClient(){

                    axios.get("{{ url('/admin/client/fetch/') }}").then(res => {

                        if(res.data.success == true){

                            if(res.data.data != null){
                                alert(res.data.msg)
                                this.name = res.data.data.name
                                this.telephone = res.data.data.telephone
                                this.address = res.data.data.address
                                this.location = res.data.data.location
                                this.email = res.data.data.email
                            }else{
                                alert("Cliente no encontrado")
                            }

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
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/admin/client/delete/') }}", {id: id}).then(res => {

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