@extends('layouts.login')

@section('content')

    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background-color:#c8d1df;">
            <div class="auth-box row no-gutters">
                <div class="col-lg-6 col-md-5 modal-bg-img" style="background-image: url('assets/img/car2.jpg');"></div>
                <div class="col-lg-6 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="wrapkit">
                        </div>
                        <h2 style="font-size: 25px" class="mt-3 text-center">Login</h2>
                        <p class="text-center">Ingresa los siguientes datos:</p>
                        <div class="mt-4">
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                <input class="form-control" id="email" type="email" placeholder="Email" v-model="email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                <input class="form-control" id="pwd" type="password" placeholder="Contraseña" v-model="password">
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button style="font-weight: bold;" type="button" class="btn btn-block btn-dark" @click="login()">Ingresar</button>
                            </div>
                            </div>
                        </div>
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
                    email:'',
                    password:""
                }
            },
            methods:{
                
                login(){
                    

                    axios.post("{{ url('/login') }}", {email: this.email, password: this.password})
                    .then(res => {
                        
                        if(res.data.success == true){
                            alert(res.data.msg)
                            if(res.data.user.role_id == 1)
                                window.location.href="{{ route('admin.dashboard.index') }}"
                            else if(res.data.user.role_id == 2)
                                window.location.href="{{ route('mechanic.index') }}"
                            else if(res.data.user.role_id == 3)
                                window.location.href="{{ route('delivery.index') }}"
                        }else{
                            alert(res.data.msg)
                            this.password = ""
                        }

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                        this.password = ""
                    })

                }

            },
            mounted(){
                //this.test()
            }

        })

    </script>


@endpush