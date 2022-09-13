@extends('welcome')
@section('tittle',('Lista Productos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12  pt-3 px-1 px-sm-5 mt-5  opacidad rounded">
                <div class="row">
                    <div class="col-1">
                        <a class="btn btn-outline-dark" href="{{route('logPick')}}" id="volver" ><i class="fas fa-chevron-left"></i></a>
                    </div>
                    <div class="col-11">
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 col-lg-3 columna cabecera">
                        <div class="row mb-3">
                            <h5><small><i class="fas fa-circle text-warning"></i></small> Biologicos.</h5>
                            <h5><small><i class="fas fa-circle text-danger"></i></small> Venenos.</h5>
                            <h5><small><i class="far fa-circle text-light"></i></small> normales.</h5>
                        </div>
                        
                        <div class="row " id="d_fijos">

                        </div>
                    </div>
                    <div class="col-md-12 col-lg-9 columna">
                        <div class="row justify-content-center pb-3">
                            <div class="col-sm-5">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
                                    <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" id="code_bar" autofocus onchange="lector()">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tbl" class="table table-striped table-bordered nowrap" style="width:100%; min-width: 100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Ubicación</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Lote</th>
                                        <th class="text-center">Nombre producto</th>
                                        <th class="text-center">barras</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: bold;" id="tabla">

                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row justify-content-end">
                            <div class="col-4" id="cont_boton_f">

                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div id="cont_boton_m2">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal2" id="boton_m2"></button>
            </div>
            <!-- Modal 2-->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"  aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">productos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" id="close_m" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="list-group" id="contenido2">
                            </div>
                        </div>
                        <div class="modal-footer" id="foot2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <style>
        
        .picking{
            border-bottom: solid 1px white;
        }
        .back{
            display: none;
        }
        .opacidad{
            overflow: hidden;
            overflow-y: auto;
            min-height: 46rem;
            max-height: 46rem;
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
        .columna{
            overflow: hidden;
            overflow-y: auto;
            min-height: 40rem;
            max-height: 40rem;
        }

        .columna::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .columna::-webkit-scrollbar:vertical {
            width:10px;
        }

        .columna::-webkit-scrollbar-button:increment,.columna::-webkit-scrollbar-button {
            display: none;
        } 

        .columna::-webkit-scrollbar:horizontal {
            height: 10px;
        }

        .columna::-webkit-scrollbar-thumb {
            background-color: #797979;
            border-radius: 20px;
            border: 2px solid #989898;
        }

        .columna::-webkit-scrollbar-track {
            border-radius: 10px;  
        }
        @media (max-width: 600px) {
            .columna{
                min-height: 48rem;
                max-height: 48rem;
            }
            .cabecera{
                min-height: 48rem !important;
                max-height: 48rem !important;
            }
            body {
                font-family: 'Nunito', sans-serif;
                font-size: 12px;
            }
        } 
        @media (max-width: 1000px) {
            .cabecera{
                min-height: 22rem !important;
                max-height: 22rem !important;
                margin-bottom: 3rem !important;
            }
        }
        .bio {
            background: #ffbe00 !important;
        }
        .tox {
            background: #f41b35 !important;
        }
    </style>
@endsection

@section('script')
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script> -->
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#tbl').DataTable( {
                    responsive: false,
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No hay registros por mostrar",
                        "info": "Mostrando pÃ¡gina _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay registros disponibles",
                        "infoFiltered": "(filtrado de _MAX_ registros totales)",
                        "search": "Buscar:",
                        "paginate": {
                            'next': 'Siguiente',
                            'previous': 'Anterior'
                        }
                    }
                } );
            
                new $.fn.dataTable.FixedHeader( table );

                $('#code_bar').focus();
            } );
            
            var array = '<?php echo json_encode($ped)?>';
            
            let arreglo = JSON.parse(array);
            console.log(arreglo);

            
            let inicioR = '<?php echo $_SESSION['H_I_REC']?>';

            var Pedtal = '<?php echo json_encode($invoices)?>';
            
            let arreglo2 = JSON.parse(Pedtal);
            

            for(let element2 of arreglo2) {
                for(let element of arreglo) {
                    if(element['ItemCode'] == element2['Articulo Efectuado'] && element['LOTE'] == element2['Lote'] && element['CantLote'] == element2['Cantidad']){
                        let bahia = "";
                        let cantidad = "";

                        if (element2['Bahia'] == '80000') {
                            bahia = "Biologico";
                        }else if (element2['Bahia'] == '80003') {
                            bahia = "Almacen";
                        } else if(element2['Bahia'] == '80005'){
                            bahia = "Venenos";
                        } else if(element2['Bahia'] == '80002' || element2['Bahia'] == '80011' || element2['Bahia'] == '80012' || element2['Bahia'] == '80013' || element2['Bahia'] == '80014' || element2['Bahia'] == '80015'){
                            bahia = "Abastecimiento";
                        } else if(element2['Bahia'] == '11'){
                            bahia = "Modula 1";
                        } else if(element2['Bahia'] == '21'){
                            bahia = "Modula 2";
                        } else if(element2['Bahia'] == '31'){
                            bahia = "Modula 3";
                        }
                        // if(element2['Cantidad'] !== element['CantLote']){
                            cantidad = Math.trunc(element2['Cantidad']);
                        // }
                        if (element['Biologico'] == 'BIOLOGICOS') {
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}" class="bio">
                                    <td>
                                        <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                                        <b>${bahia}</b>
                                    </td>
                                    <td>
                                        <b>${cantidad}</b>
                                    </td>
                                    <td>
                                        <b>${element['LOTE']}</b>
                                    </td>
                                    <td>
                                        <b>${element['Dscription']}</b>
                                    </td>
                                    <td>
                                        <b>${element['CodeBars']}</b>
                                    </td>
                                    
                                </tr> 
                            `);
                        }else if (element['TOXICO'] == "Y") {
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}" class="tox">
                                    <td>
                                        <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                                        <b>${bahia}</b>
                                    </td>
                                    <td>
                                        <b>${cantidad}</b>
                                    </td>
                                    <td>
                                        <b>${element['LOTE']}</b>
                                    </td>
                                    <td>
                                        <b>${element['Dscription']}</b>
                                    </td>
                                    <td>
                                        <b>${element['CodeBars']}</b>
                                    </td>
                                    
                                </tr> 
                            `);
                        }else {
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}">
                                    <td>
                                        <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                                        <b>${bahia}</b>
                                    </td>
                                    <td>
                                        <b>${cantidad}</b>
                                    </td>
                                    <td>
                                        <b>${element['LOTE']}</b>
                                    </td>
                                    <td>
                                        <b>${element['Dscription']}</b>
                                    </td>
                                    <td>
                                        <b>${element['CodeBars']}</b>
                                    </td>
                                    
                                </tr> 
                            `);
                        }

                    }
                }
            }

            
            for(let element of arreglo) {
                $('#d_fijos').text('');
                $('#d_fijos').append(`
                    <div class="col-12 mb-3 mb-md-0">
                        <ul class="list-group list-group-flush rounded">
                            <li class="list-group-item"><b>Hora de inicio: </b>${inicioR}</li>
                            <li class="list-group-item"><b>Cliente: </b>${element['CardName']}</li>
                            <li class="list-group-item"><b>Departamento: </b>${element['Departamento']}</li>
                            <li class="list-group-item"><b>Municipio / Ciudad: </b>${element['Municipio_Ciudad']}</li>
                            <li class="list-group-item"><b>Fecha Creación: </b>${element['DocDate']}</li>
                            <li class="list-group-item"><b>Comentarios: </b>${element['Comments']}</li>
                        </ul>
                    </div>
                `);
            }

            let tabla_cont = 0;
            function lector() {
                let codigo = $('#code_bar').val();
                let cont = 0;
                for(let element of arreglo) {
                    if (element['CodeBars'] == codigo) {
                        cont += 1;
                    }
                }
                if (cont == 1) {
                    for(let element of arreglo) {
                        let id = element['id__'];
                        if (element['CodeBars'] == codigo) {
                            if ($('#check-'+id).prop('checked') != true) {
                                $('#fila-'+id).addClass('table-success');
                                $('#check-'+id).prop("checked", true);
                                    tabla_cont += 1;
                                    
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Producto',
                                    text: element['Dscription']+' encontrado.',
                                })
                            }
                        }
                    }
                    $('#code_bar').val('');
                    $('#code_bar').focus();
                }else if(cont > 1) {
                    modal2(codigo);

                    $('#boton_m2').click();
                }
                if (cont == 0){
                    
                    $('#code_bar').val('');
                    $('#code_bar').focus();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Producto',
                        text: 'Producto no encontrado dentro del pedido.',
                    })

                }
                $('#cont_boton_f').text('');
                if (tabla_cont == (arreglo.length)) {
                    $('#cont_boton_f').append(`
                        <div class="d-grid gap-2 py-3">
                            <a href="{{route('savePick',$id)}}" class="btn btn-dark">
                                Finalizar
                            </a>
                        </div>
                    `);
                }
            }

            
            function modal2 (codigo) {
                $('#code_bar').val('');
                $("#contenido2").text('');
                $("#contenido2").removeClass('d-flex justify-content-center');
                for(let element of arreglo) {
                    if (element['CodeBars'] == codigo) {
                        if ($('#check-'+element['id__']).prop('checked') != true) {
                            $("#contenido2").append(`
                                <button type="button" class="list-group-item list-group-item-action" id="boton_m" onclick="check_ind(${element['id__']})">
                                    
                                <strong>${element['Dscription']}</strong> ----  Lote: <small>${element['LOTE']}</small>
                                </button>

                            `);
                        }
                    }
                }
                if ($("#contenido2").text()== '') {
                    $("#contenido2").addClass('d-flex justify-content-center');
                    $("#contenido2").append(`
                        <strong class="text-center text-danger">Los productos no estan en el pedido o ya fueron revisados</strong>
                    `);
                }
            }

            function check_ind(id) {
                $('#code_bar').val('');
                if ($('#check-'+id).prop('checked') != true) {
                    $('#fila-'+id).addClass('table-success');
                    $('#check-'+id).prop("checked", true);
                    tabla_cont += 1;
                    $('#close_m').click();
                    $('#code_bar').focus();
                }
                    $('#code_bar').focus();

                $('#cont_boton_f').text('');
                if (tabla_cont == (arreglo.length)) {
                    $('#cont_boton_f').append(`
                        <div class="d-grid gap-2 py-3">
                            <a href="{{route('savePick',$id)}}" class="btn btn-dark">
                                Finalizar
                            </a>
                        </div>
                    `);
                }
            }
        </script>
@endsection