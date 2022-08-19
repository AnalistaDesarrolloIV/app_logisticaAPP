@extends('welcome')
@section('tittle',('Lista Entregas'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11  py-5 px-1 px-sm-5 mt-5 mt-sm-0 opacidad rounded">
                <div class="row justify-content-center mb-3">
                    <div class="col-sm-8">
                        <div class="row">
                            <!-- <div class="col-2 col-sm-2 col-md-1 py-2 py-sm-0">
                                <div style=" float:left;">
                                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample2" aria-expanded="false" aria-controls="collapseWidthExample2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-10 col-sm-10 col-md-11 py-2 py-sm-0">
                                <div>
                                    <div class="collapse collapse-horizontal" id="collapseWidthExample2">
                                        <input class="form-control" type="number" id="b_lista" onkeyup="search()" autofocus  placeholder="Numero de pedido">
                                    </div>
                                </div>
                            </div> -->
                            <div class="input-group input-group-lg mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="b_lista" onkeyup="search()" autofocus  placeholder="Numero pedido" aria-label="n_ped" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center flex-row flex-wrap py-3" id="lista">
             
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        
        .packing{
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
        @media (max-width: 600px) {
            .opacidad{
                min-height: 48rem;
                max-height: 48rem;
            }
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
            
            var array = '<?php echo json_encode($entregas)?>';
            
            let pedi = JSON.parse(array);
            console.log(pedi);

            function search() {
                
                let busqueda = $('#b_lista').val();
                $('#lista').text('');

                for(let element of pedi) {
                    let elemento = element['BaseRef'];
                    let string = String(elemento);
                        if (string.indexOf(busqueda) !== -1) {
                            // if (element['Estado_linea'] == "Recogido") {
                                $('#lista').append(`
                                    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                                        <a href="/indexPack/${element['BaseRef']}" style="text-decoration: none; color: black;" >
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
                            // }
                        }
                }
                if ($('#lista').text() == '') {
                    $('#lista').append(`
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No hay pedidos por empacar.</h3>
                    `);
                }
            }
            search();
        </script>
@endsection