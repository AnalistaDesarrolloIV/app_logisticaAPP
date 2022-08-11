@extends('welcome')
@section('tittle',('Lista Pedidos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-around">
            <div class="col-10 col-md-6 col-lg-5 py-3 px-5 my-5 my-md-0 opacidad rounded">
                
                <div class="row justify-content-start">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-auto col-sm-2 py-2 py-sm-0">
                                <div style=" float:left;">
                                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto col-sm-10 py-2 py-sm-0">
                                <div>
                                    <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                        <input class="form-control" type="number" width="100%" id="b_envio" onkeyup="search_env()" placeholder="Codigo Pedido">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedidos Envío.</h3>
                <div class="list-group" id="envio">
             
                </div>
            </div>

            
            <div class="col-10 col-md-6 col-lg-5 py-3 px-5 opacidad rounded">
                
                <div class="row justify-content-start">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-auto col-sm-2 py-2 py-sm-0">
                                <div style=" float:left;">
                                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample2" aria-expanded="false" aria-controls="collapseWidthExample2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto col-sm-10 py-2 py-sm-0">
                                <div>
                                    <div class="collapse collapse-horizontal" id="collapseWidthExample2">
                                        <input class="form-control" type="number" id="b_mostrador" onkeyup="search_most()" placeholder="Codigo Pedido">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedidos Mostrador.</h3>
                <div class="list-group" id="mostrador">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .picking{
            border-bottom: solid 1px white;
        }
        .opacidad{
            overflow: hidden;
            overflow-y: auto;
            min-height: 38rem;
            max-height: 38rem;
        }
        .opacidad::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .opacidad::-webkit-scrollbar:vertical {
            width:10px;
        }

        .opacidad::-webkit-scrollbar-button:increment,.opacidad::-webkit-scrollbar-button {
            display: none;
        } 

        .opacidad::-webkit-scrollbar:horizontal {
            height: 10px;
        }

        .opacidad::-webkit-scrollbar-thumb {
            background-color: #797979;
            border-radius: 20px;
            border: 2px solid #989898;
        }

        .opacidad::-webkit-scrollbar-track {
            border-radius: 10px;  
        }
        
    </style>
@endsection

@section('script')

    <script>
            var array = '<?php echo json_encode($pedido)?>';
            
            let arreglo = JSON.parse(array);
        function search_most() {
            
            let busqueda = $('#b_mostrador').val();
            
            $('#mostrador').text('');
            for(let element of arreglo) {
                let elemento = element['BaseRef'];
                let string = String(elemento);
                let long = string.length;
                let inicial = string.substring(1, -long);
                if(inicial == 5) {
                    if (string.indexOf(busqueda) !== -1) {
                        $('#mostrador').append(`
                            <a href="/indexPick/${element['BaseRef']}" class="list-group-item list-group-item-action" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class=" text-start mb-1">${element['BaseRef']} -- ${element['CardName']}</h5>
                                <p>${element['DocDate']}</p>
                                </div>
                            </a>
                        `);
                    }
                }
            }
            if ($('#mostrador').text() == '') {
                $('#mostrador').append(`
                    <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No existe ningun pedido de mostrador con este codigo</h3>
                `);
            }
        }
        search_most();

        function search_env() {

            let busqueda_env = $('#b_envio').val();
            
            $('#envio').text('');
            for(let element of arreglo) {
                let elemento = element['BaseRef'];
                let string = String(elemento);
                let long = string.length;
                let inicial = string.substring(1, -long);
                if(inicial == 7) {
                    if (string.indexOf(busqueda_env) !== -1) {
                        $('#envio').append(`
                            <a href="/indexPick/${element['BaseRef']}" class="list-group-item list-group-item-action" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class=" text-start mb-1">${element['BaseRef']} -- ${element['CardName']}</h5>
                                <p>${element['DocDate']}</p>
                                </div>
                            </a>
                        `);
                    }
                }
            }
            if ($('#envio').text() == '') {
                $('#envio').append(`
                    <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No existe ningun pedido de envío con este codigo</h3>
                `);
            }
        }
        search_env();
    </script>

@endsection
