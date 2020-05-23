@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="container form" id="contact-section">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Correos</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createEmail" @click="create()">Crear</button>
                </p>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(email, index) in emails">
                            <th>@{{ index + 1 }}</th>
                            <td>@{{ email.email }}</td>
                            <td>
                                <button class="btn btn-success" data-toggle="modal" data-target="#createEmail" @click="edit(email)">editar</button>
                                <button class="btn btn-danger" @click="erase(email.id)">eliminar</button>
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

    <!-- modal -->

    <div class="modal fade" id="createEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="name">Email</label>
                        <input type="text" class="form-control" id="name" v-model="email">
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
                    modalTitle:"Crear email",
                    email:"",
                    emailId:"",
                    action:"create",
                    emails:[],
                }
            },
            methods:{

                create(){
                    this.modalTitle = "Crear email"
                    this.action = "create"
                    this.name = ""
                    this.emailId = ""
                },
                store(){

                    axios.post("{{ route('admin.email.store') }}", {email: this.email})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.email = ""
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

                    axios.post("{{ route('admin.email.update') }}", {emailId: this.emailId, email: this.email})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.email = ""
                            this.emailId = ""
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
                edit(email){
                    this.modalTitle = "Actualizar email"
                    this.action = "edit"
                    this.email = email.email
                    this.emailId = email.id
                },
                fetch(){

                    axios.get("{{ url('/admin/email/fetch/') }}")
                    .then(res => {

                        this.emails = res.data.emails

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/admin/email/delete/') }}", {emailId: id}).then(res => {

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