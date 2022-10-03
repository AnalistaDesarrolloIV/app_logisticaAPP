@extends('welcome')
@section('tittle',('Inicio'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-around align-content-around" id="content">

                <div wire:loading class="col-11 col-md-5 my-5 my-md-0  opacidad rounded ">
                    <a href="{{route('loginPick')}}" style="text-decoration: none; color:black;" onclick="load()">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/packing.svg" class="card-img-top " height="320rem" alt="Packing">
                                    <div class="card-body text-center">
                                        <h2 class="card-title"><b>Recolección</b></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            
                <div class="col-11 col-md-5  opacidad rounded">
                    <a href="{{route('loginPack')}}" style="text-decoration: none; color:black;" onclick="load()">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/picking.svg" class="card-img-top " height="320rem"  alt="Packing">
                                    <div class="card-body text-center">
                                        <h2 class="card-title"><b>Empaque</b></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .opacidad :hover{
            background: rgba(10, 10, 10, 0.1);
        }
        .back, .picking, .packing{
            display: none;
        }
        .home{
            border-bottom: solid 1px white;
        }
    </style>
@endsection

@section('script')

    <script>

        function load() {
            $("#content").html(`
            
            <div wire:loading class="col-11 col-md-5 my-5 my-md-0  opacidad rounded ">
                    <a style="text-decoration: none; color:black;" disabled>
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/packing.svg" class="card-img-top " height="320rem" alt="Packing">
                                    <div class="card-body text-center">
                                        <div class="spinner-border spinner-border-sm" style="width: 3rem; height: 3rem;" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <h2 class="card-title">
                                            <b>
                                                Recolección
                                            </b>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            
                <div class="col-11 col-md-5  opacidad rounded">
                    <a style="text-decoration: none; color:black;" disabled>
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/picking.svg" class="card-img-top " height="320rem"  alt="Packing">
                                    <div class="card-body text-center">
                                        
                                        <div class="spinner-border spinner-border-sm" style="width: 3rem; height: 3rem;" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <h2 class="card-title">
                                            <b>
                                                Empaque
                                            </b>
                                        </h2>
                                        <!-- <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-primary" type="button">Button</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `)
        }
       
    </script>

@endsection
