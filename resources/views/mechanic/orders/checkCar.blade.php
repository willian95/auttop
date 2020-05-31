
@extends('layouts.user')


@section("content")

    
    @include('partials.user.navbar')
    <section  class="form" id="contact-section" >
        <div class="container">
            
            <div class="row ">
                <div class="col-12 shadow__tables" v-for="category in categories">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th v-cloak>@{{ category.name }}</th>
                                <th v-cloak>OK</th>
                                <th v-cloak>Sug</th>
                                <th v-cloak>Urg</th>
                                <th v-cloak>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="service in category.services">
                                <td v-cloak>@{{ service.name }}</td>
                                <td v-for="index in 3" v-cloak>
                                    <input class="service" type="radio" v-bind:name="'service-'+service.id" :value="index">
                                </td>
                                <td v-cloak>
                                    <input v-bind:class="'obser'+service.id" type="text" class="form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <p class="text-center">
                        <button class="btn btn-success" @click="store()">Procesar</button>
                    </p>
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
                    categories:[],
                    orderId:'{{ $orderId }}',
                    checkedServices:[]
                }
            },
            methods:{

                getCategories(){

                    axios.get("{{ url('/mechanic/category/all/') }}"+"/"+this.orderId)
                    .then(res => {

                        if(res.data.success == true){
                            this.categories = res.data.categories
                        }

                    })

                },
                store(){
                    this.checkedServices = []
                    var element = $('.service').map((_,el) => el).get()
                    element.forEach((data, index) => {
                        if(data.checked == true){
                            let ob = $(".obser"+data.name.substring("8", data.name.length)).val()
                            this.checkedServices.push({"serviceId": data.name.substring("8", data.name.length), "value": data.value, "obser": ob})
                        }
                       
                    })

                    axios.post("{{ url('/mechanic/diagnositc/store') }}", {"orderId": this.orderId, "checkedServices": this.checkedServices})
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            window.location.href="{{ route('mechanic.index') }}"
                        }else{
                            alert(res.data.msg)
                        }

                    })
                    
                }

            },
            mounted(){
                this.getCategories()
            }

        })

    </script>

@endpush