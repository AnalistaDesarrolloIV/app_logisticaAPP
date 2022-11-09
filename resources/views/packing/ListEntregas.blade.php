@extends('welcome')
@section('tittle',('Lista Entregas'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11  py-5 px-1 px-sm-5 mt-5 mt-sm-0 opacidad rounded">
                <div class="row justify-content-center mb-3">
                    <div class="col-sm-8">
                        <div class="row">
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
            
            let User = '<?php echo $_COOKIE['USER']?>';

            var pedi = <?php echo json_encode($entregas)?>;
            
            var DE = <?php echo json_encode($datExtra)?>;
             
        
            function search() {
                
                let busqueda = $('#b_lista').val();
                
                $('#b_lista').val(busqueda.toUpperCase());
                busqueda = busqueda.toUpperCase();
                $('#lista').text('');

                for(let element of pedi) {
                    let elemento = element['BaseRef'];
                    let elemento2 = element['CardName'];
                    let string = String(elemento);
                    let string2 = String(elemento2);
                        if (string.indexOf(busqueda) !== -1 || string2.indexOf(busqueda) !== -1) {
                            for(let extra of DE) {
                                if (element['BaseRef'] == extra['BaseRef'] ) {
                                    if (element['U_IV_ESTA'] == "Recogido" && User == element['U_IV_OPERARIO']) {
                                        let unidades = Math.trunc(extra['Cant_Unidades']);
                                        let prio = element['U_IV_Prioridad'];
                                        $('#lista').append(`
                                            <div class="col-12 col-sm-6 col-md-4" id="ingreso_${element['BaseRef']}" onclick="ingreso()">
                                                <a href="indexPack/${element['BaseRef']}" style="text-decoration: none; color: black;" >
                                                    <div class="card my-2 targeta">
                                                        <div class="card-body">
                                                            <div class="row justify-content-between">
                                                                <div class="col-8">
                                                                    <h4 class="card-title">${element['CardName']}</h4>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <span ${prio == "Alta" ? 'class="badge rounded-pill bg-danger"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-success"'}>
                                                                        ${prio}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <h5 class="card-subtitle mb-2 text-muted"><b>Pedido N°: </b> ${element['BaseRef']}</h5>
                                                            <h5 class="card-subtitle mb-2 text-muted"><b>N° de lineas: </b> ${extra['Cant_Linea']}</h5>
                                                            <h5 class="card-subtitle mb-2 text-muted"><b>Cantidad unidades: </b> ${unidades}</h5>
                                                            <h6 class="card-subtitle mb-2 text-muted"><b>Municipio / Ciudad: </b> ${element['Municipio_Ciudad']}</h6>
                                                            <p class="card-text">${extra['Comments']}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        `);
                                    }
                                }
                            }
                        }
                }
                if ($('#lista').text() == '') {
                    $('#lista').append(`
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No hay pedidos por empacar.</h3>
                    `);
                }
            }
            search();
            
        function ingreso() {
            $("#b_lista").attr('disabled', true);

            $("#lista").html(
            `
            <div class="col-12 col-md-6">
                <div class="card" aria-hidden="true">
                    <div class="card-body">
                        <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                        </h5>
                        <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                        </p>
                        <a href="#" tabindex="-1" class="btn btn-dark disabled placeholder col-6"></a>
                    </div>
                </div>
            </div>
            `
            );
        }
        
        setInterval("location.reload()",150000);
        </script>
@endsection