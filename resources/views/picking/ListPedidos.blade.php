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
                            <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedidos Biologicos.</h3>
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
        const User = '<?php echo $_COOKIE['USER']?>';

        var arreglo = <?php echo json_encode($pedido)?>;

        var biologicos = <?php echo json_encode($pedido_bio)?>;

        
        var session = '<?php echo $_SESSION['B1SESSION']?>';
        
        var DE = <?php echo json_encode($datExtra)?>;
        let numeros = [];

        for(let bio of biologicos) {
            if (User == bio['U_IV_OPERARIO']) {
                numeros.push(bio['BaseRef']); 
            }
        }

        function search_most() {
            
            let busqueda = $('#b_mostrador').val();
                busqueda = busqueda.toUpperCase();
            
            $('#mostrador').text('');
            for(let bio of biologicos) {
                for(let extra of DE) {
                    if (bio['BaseRef'] == extra['BaseRef']) {
                        if (bio['U_IV_ESTA'] == "Por Recoger" && User == bio['U_IV_OPERARIO']) {
                            let unidades = Math.trunc(extra['Cant_Unidades']);
                            let prio = bio['U_IV_Prioridad'];
                                $('#mostrador').append(`
                                <div class="col-12 col-md-10">
                                    <a href="indexPick/${bio['BaseRef']}/${bio['DocEntry']}" style="text-decoration: none; color: black;" onclick="ingreso()">
                                        <div class="card my-2 targeta">
                                            <div class="card-body">
                                                <div class="row justify-content-between">
                                                    <div class="col-8">
                                                        <h4 class="card-title">${bio['CardName']}</h4>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span ${prio == "Alta" ? 'class="badge rounded-pill bg-danger"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-success"'}>
                                                            ${prio}
                                                        </span>
                                                    </div>
                                                </div>
                                                <h5 class="card-subtitle mb-2 text-muted"><b>Pedido N°: </b> ${bio['BaseRef']}</h5>
                                                <h5 class="card-subtitle mb-2 text-muted"><b>N° de lineas: </b> ${extra['Cant_Linea']}</h5>
                                                <h5 class="card-subtitle mb-2 text-muted"><b>Cantidad unidades: </b> ${unidades}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted"><b>Municipio / Ciudad: </b> ${bio['Municipio_Ciudad']}</h6>
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
            if ($('#mostrador').text() == '') {
                $('#mostrador').append(`
                    <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No tienes pedidos biologicos asignados por recoger.</h3>
                `);
            }
        }
        search_most();

        function ingreso() {
            $("#b_mostrador").attr('disabled', true);
            $("#b_envio").attr('disabled', true);
            
            $("#mostrador").html(
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

            $("#envio").html(
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

        function search_env() {

            let busqueda_env = $('#b_envio').val();
                busqueda_env = busqueda_env.toUpperCase();
            
            $('#envio').text('');
            for(let element of arreglo) {
                let incluye = numeros.includes(element['BaseRef']);
                if (!incluye) {
                        
                        let elemento = element['BaseRef'];
                        let elemento2 = element['CardName'];
                        let string = String(elemento);
                        let string2 = String(elemento2);
                        let long = string.length;
                        let inicial = string.substring(1, -long);
                        if (string.indexOf(busqueda_env) !== -1 || string2.indexOf(busqueda_env) !== -1) {
                            for(let extra of DE) {
                                if (element['BaseRef'] == extra['BaseRef']) {
                                    if (element['U_IV_ESTA'] == "Por Recoger" && User == element['U_IV_OPERARIO']) {
                                        let unidades = Math.trunc(extra['Cant_Unidades']);
                                        let prio = element['U_IV_Prioridad'];
                                        $('#envio').append(`
                                            <div class="col-12 col-md-10">
                                                <a href="indexPick/${element['BaseRef']}/${element['DocEntry']}" style="text-decoration: none; color: black;"  onclick="ingreso()">
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
            }
            if ($('#envio').text() == '') {
                $('#envio').append(`
                    <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No tienes pedidos asignados por recoger.</h3>
                `);
            }
        }
        search_env();
        
        
        setInterval("location.reload()",180000);
    </script>

@endsection
