@extends('welcome')
@section('tittle',('Inicio Admin'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-around align-content-around">

                <div wire:loading class="col-11 col-md-5 my-5 my-md-0  opacidad rounded ">
                    <a href="{{route('listPick')}}" style="text-decoration: none; color:black;">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="mt-2" style="width: 100%; padding: 0px; margin: 0px;">
                                    <img src="{{url('/')}}/img/ControlPanel.svg" class="card-img-top " height="320rem" alt="Packing">
                                    <div class="card-body text-center">
                                        <h2 class="card-title"><b>Panel Administrador</b></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            
                {{-- <div class="col-11 col-md-5  opacidad rounded">
                    <a href="{{route('listPack')}}" style="text-decoration: none; color:black;">
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
                </div> --}}
                <!-- Button trigger modal -->
                <div class=" fixed-bottom d-flex flex-row-reverse mb-4 mr-4 pr-3">
                    <button type="button" class="boton btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Descargar aplicación mobil">
                        <i class="fas fa-download"></i>
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Apk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <img src="https://chart.apis.google.com/chart?cht=qr&chs=200x200&chld=L|0&chl=https%3A%2F%2Fappsgeyser.com%2Fapi%2Ftrack%2Fredirect%3Furl%3Dhttps%253A%252F%252Ffiles.appsgeyser.com%252FLogisticaIvanAgro_15955868.apk%253Fsrc%253Dpage" alt="QR_Download">
                                    </div>  
                                    <div class="col-12 text-center">
                                        <h4>
                                            Para descargar el apk 
                                            <a href="https://files.appsgeyser.com/LogisticaIvanAgro_15955868.apk?utm_source=email&utm_medium=email&utm_campaign=downloadApp" target="_blank">LogisticaIvanagro </a> 
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        .boton {
            height: 3rem;
            width: 3rem;
            border-radius: 50%;
        }
        .boton:hover {
            background: rgb(116, 115, 115);
            color: #000;
            height: 3rem;
            width: 3rem;
            border-radius: 50%;
        }
    </style>
@endsection

@section('script')

    <script>
       
    </script>

@endsection
