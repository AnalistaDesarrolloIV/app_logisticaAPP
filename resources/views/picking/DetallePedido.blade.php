@extends('welcome')
@section('tittle',('Lista Productos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12  py-3 px-1 px-sm-5 mt-5 mt-sm-0 opacidad rounded">
                <div class="row">
                    <div class="col-1">
                        <a class="btn btn-outline-dark" href="/logPick" id="volver" ><i class="fas fa-chevron-left"></i></a>
                    </div>
                    <div class="col-11">
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3">
                        <div class="row mb-3">
                            <h5><small><i class="fas fa-circle text-warning"></i></small> Biologicos.</h5>
                            <h5><small><i class="fas fa-circle text-danger"></i></small> Venenos.</h5>
                            <h5><small><i class="far fa-circle text-light"></i></small> normales.</h5>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-4" id="cont_boton_f">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row justify-content-center pb-3">
                            <div class="col-sm-5">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
                                    <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" id="code_bar" autofocus onchange="lector()">
                                </div>
                            </div>
                        </div>

                        <table id="tbl" class="table table-striped table-bordered nowrap" style="width:100%; min-width: 100%">
                            <thead class="table-dark">
                                <tr>
                                    <!-- <th>Codigo pedido</th> -->
                                    <th class="text-center">Codigo de barras</th>
                                    <th class="text-center">Nombre producto</th>
                                    <th class="text-center">Lote</th>
                                    <th class="text-center">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: bold;" id="tabla">

                            </tbody>
                        </table>
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
            min-height: 40rem;
            max-height: 40rem;
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
                    responsive: true,
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No hay registros por mostrar",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
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
            

            for(let element of arreglo) {
                $('#tabla').append(`
                    <tr id="fila-${element['id__']}">
                        <td>
                            <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                            <b>${element['CodeBars']}</b>
                        </td>
                        <td>
                            <b>${element['Dscription']}</b>
                        </td>
                        
                        <td>
                            <b>${element['LOTE']}</b>
                        </td>
                        <td>
                            <b>${element['CantLote']}</b>
                        </td>
                    </tr> 
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
                if (cont = 1) {
                    for(let element of arreglo) {
                        let id = element['id__'];
                        if (element['CodeBars'] == codigo) {
                            if ($('#check-'+id).prop('checked') != true) {
                                $('#fila-'+id).addClass('table-success');
                                $('#check-'+id).prop("checked", true);
                                    tabla_cont += 1;
                            }
                        }
                    }
                    $('#code_bar').val('');
                    $('#code_bar').focus();
                }else {
                    modal2(codigo);

                    $('#boton_m2').click();
                }
                $('#cont_boton_f').text('');
                if (tabla_cont == (arreglo.length)) {
                    $('#cont_boton_f').append(`
                        <div class="d-grid gap-2 py-3">
                            <button class="btn btn-dark" type="button">Finalizar</button>
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
                            <button class="btn btn-dark" type="button">Finalizar</button>
                        </div>
                    `);
                }
            }
        </script>
@endsection