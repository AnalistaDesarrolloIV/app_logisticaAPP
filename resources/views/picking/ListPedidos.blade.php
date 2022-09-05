@extends('welcome')
@section('tittle',('Lista Pedidos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-around">
            <div class="col-10 col-md-6 col-lg-5 py-3 px-3 my-5 my-md-0 opacidad rounded">
                
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <div class="row">
                            <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedidos Envío.</h3>
                            
                            <!-- <div class="col-auto col-sm-2 py-2 py-sm-0">
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
                            </div> -->
                            <div class="input-group input-group-lg mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="b_envio" onkeyup="search_env()" placeholder="Numero Pedido" aria-label="codigo_e" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center flex-row flex-wrap py-3" id="envio">
             
                </div>
            </div>

            
            <div class="col-10 col-md-6 col-lg-5 py-3 px-3 opacidad rounded">
                
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <div class="row">
                            <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedidos Mostrador.</h3>
                            <!-- <div class="col-auto col-sm-2 py-2 py-sm-0">
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
                            </div> -->
                            <div class="input-group input-group-lg  mb-3">
                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" type="number" id="b_mostrador" onkeyup="search_most()" placeholder="Numero Pedido" aria-label="codigo_m" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center flex-row flex-wrap py-3" id="mostrador">
                    
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
        
        .targeta{
            width: 100%;
            overflow: hidden;
            overflow: auto;
            min-height: 14rem;
            max-height: 14rem;
        }

        .targeta::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .targeta::-webkit-scrollbar:vertical {
            width:10px;
        }

        .targeta::-webkit-scrollbar-button:increment,.targeta::-webkit-scrollbar-button {
            display: none;
        } 

        .targeta::-webkit-scrollbar:horizontal {
            height: 5px;
        }

        .targeta::-webkit-scrollbar-thumb {
            background-color: #797979;
            border-radius: 20px;
            border: 1px solid #989898;
        }

        .targeta::-webkit-scrollbar-track {
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
                busqueda = busqueda.toUpperCase();
            
            $('#mostrador').text('');
            for(let element of arreglo) {
                let elemento = element['BaseRef'];
                let elemento2 = element['CardName'];
                let string = String(elemento);
                let string2 = String(elemento2);
                let long = string.length;
                let inicial = string.substring(1, -long);
                if(inicial == 5) {
                    if (string.indexOf(busqueda) !== -1 || string2.indexOf(busqueda) !== -1) {
                        if (element['U_IV_ESTA'] == "Por Recoger") {
                            $('#mostrador').append(`
                                <div class="col-12 col-md-6">
                                    <a href="indexPick/${element['BaseRef']}" style="text-decoration: none; color: black;" >
                                        <div class="card my-2 targeta">
                                            <div class="card-body">
                                                <h4 class="card-title">${element['CardName']}</h4>
                                                <h5 class="card-subtitle mb-2 text-muted"><b>Pedido N°: </b> ${element['BaseRef']}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted"><b>Municipio / Ciudad: </b> ${element['Municipio_Ciudad']}</h6>
                                                <p class="card-text">${element['Comments']}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `);
                        }
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
                busqueda_env = busqueda_env.toUpperCase();
            
            $('#envio').text('');
            for(let element of arreglo) {
                let elemento = element['BaseRef'];
                let elemento2 = element['CardName'];
                let string = String(elemento);
                let string2 = String(elemento2);
                let long = string.length;
                let inicial = string.substring(1, -long);
                if(inicial == 7) {
                    if (string.indexOf(busqueda_env) !== -1 || string2.indexOf(busqueda_env) !== -1) {
                        if (element['U_IV_ESTA'] == "Por Recoger") {
                            $('#envio').append(`
                                <div class="col-12 col-md-6">
                                    <a href="indexPick/${element['BaseRef']}" style="text-decoration: none; color: black;" >
                                        <div class="card my-2 targeta">
                                            <div class="card-body">
                                                <h4 class="card-title">${element['CardName']}</h4>
                                                <h5 class="card-subtitle mb-2 text-muted"><b>Pedido N°: </b> ${element['BaseRef']}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted"><b>Municipio / Ciudad: </b> ${element['Municipio_Ciudad']}</h6>
                                                <p class="card-text">${element['Comments']}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `);
                        }
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
