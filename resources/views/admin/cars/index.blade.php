@extends('layouts.user')

@section('content')

    @include('partials.admin.navbar')
    <div class="container form dash" id="contact-section">
        <div class="top_title">
            <h3 class="text-center">Vehiculos</h3>
        </div>
      <!--  <div class="row">
            <div class="col-12">
                <h3 class="text-center">Vehiculos</h3>
            </div>
        </div>--->
       <div class="bg__tables mt-15" style="margin-left: 130px;">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Patente</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Color</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(car, index) in cars">
                            <th v-cloak>@{{ index + 1 }}</th>
                            <td v-cloak>@{{ car.patent }}</td>
                            <td v-cloak>@{{ car.brand }}</td>
                            <td v-cloak>@{{ car.model }}</td>
                            <td v-cloak>@{{ car.year }}</td>
                            <td v-cloak>@{{ car.color }}</td>
                            <td v-cloak>
                                <a class="btn btn-success" :href="'{{ url('/admin/car/edit/') }}'+'/'+car.id">editar</a>
                                <button class="btn btn-danger" @click="erase(car.id)">eliminar</button>
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
                            <a class="page-link" href="#"  :key="index" @click="fetch(index)" >@{{ index }}</a>
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
                    cars:[],
                    pages:0
                }
            },
            methods:{

                fetch(page = 1){

                    axios.get("{{ url('/admin/car/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.cars = res.data.cars
                        this.pages = Math.ceil(res.data.carsCount / 15)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                erase(id){

                    if(confirm("¿Está seguro?")){

                        axios.post("{{ url('/admin/car/delete/') }}", {id: id}).then(res => {

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