@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="container form" id="contact-section">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Servicios</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-center">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createService" @click="create()">Crear</button>
                </p>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Servicio</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(service, index) in services">
                            <th v-cloak>@{{ index + 1 }}</th>
                            <td v-cloak>@{{ service.name }}</td>
                            <td v-cloak>@{{ service.category.name }}</td>
                            <td v-cloak>
                                <button class="btn btn-success" data-toggle="modal" data-target="#createService" @click="edit(service)">editar</button>
                                <button class="btn btn-danger" @click="erase(service.id)">eliminar</button>
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

    <!-- modal -->

    <div class="modal fade" id="createService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="name">Categoría</label>
                        <select class="form-control" v-model="selectedCategory">
                            <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                        </select>
                        <button class="btn btn-success" @click="openCategory()">+</button>
                    </div>
                    <div v-if="showCategory == true">
                        <h3 class="text-center">Nueva categoría</h3>
                        <div class="form-group">
                            
                            <label for="name">Categoría</label>
                            <input type="text" class="form-control" v-model="categoryName">
                        </div>
                        <div>
                            <p>
                                <button class="btn btn-danger" @click="closeCategory()">cerrar</button>
                                <button class="btn btn-success" @click="storeCategory()">crear</button>
                            </p>
                        </div>
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
                    modalTitle:"Crear servicio",
                    selectedCategory:"",
                    services:[],
                    name:"",
                    serviceId:"",
                    action:"create",
                    categories:[],
                    pages:0,
                    page:0,
                    showCategory:false,
                }
            },
            methods:{

                create(){
                    this.action = "create"
                    this.name = ""
                    this.selectedCategory = ""
                },
                store(){

                    axios.post("{{ route('admin.service.store') }}", {name: this.name, categoryId: this.selectedCategory})
                    .then(res => {

                        if(res.data.success == true){
                            alert(res.data.msg)
                            this.name = ""
                            this.selectedCategory = ""
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

                    axios.post("{{ route('admin.service.update') }}", {id: this.serviceId, name: this.name, selectedCategory: this.selectedCategory})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.name = ""
                            this.serviceId = ""
                            this.selectedCategory = ""
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
                edit(service){
                    this.action = "edit"
                    this.name = service.name
                    this.serviceId = service.id
                    this.selectedCategory = service.category.id
                },
                fetch(page = 1){
                    this.page = page
                    axios.get("{{ url('/admin/service/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.services = res.data.services
                        this.pages = Math.ceil(res.data.servicesCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                fetchCategories(){

                    axios.get("{{ url('/admin/category/all') }}")
                    .then(res => {
                       
                        if(res.data.success == true){
                            this.categories = res.data.categories
                        }

                    })

                },
                storeCategory(){

                    axios.post("{{ route('admin.category.store') }}", {name: this.categoryName})
                    .then(res => {

                        if(res.data.success == true){

                            alert(res.data.msg)
                            this.categoryName = ""
                            this.fetchCategories()
                            this.showCategory = false

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

                        axios.post("{{ url('/admin/service/delete') }}", {id: id}).then(res => {

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
                openCategory(){

                    this.showCategory = true

                },
                closeCategory(){

                    this.showCategory = false

                }
                

            },
            mounted(){
                this.fetch()
                this.fetchCategories()
            }

        })

    </script>

@endpush