@extends('welcome')
@section('tittle',('Inicio'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-around align-content-around">

                <div class="col-11 col-md-5 my-5 my-md-0  opacidad rounded">
                    <a href="{{route('logPick')}}" style="text-decoration: none; color:black;">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/packing.svg" class="card-img-top " height="320rem" alt="Packing">
                                    <div class="card-body text-center">
                                        <h2 class="card-title"><b>Recolección</b></h2>
                                        <!-- <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-primary" type="button">Button</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            
                <div class="col-11 col-md-5  opacidad rounded">
                    <a href="{{route('logPack')}}" style="text-decoration: none; color:black;">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/picking.svg" class="card-img-top " height="320rem"  alt="Packing">
                                    <div class="card-body text-center">
                                        <h2 class="card-title"><b>Empaque</b></h2>
                                        <!-- <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-primary" type="button">Button</a>
                                        </div> -->
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
