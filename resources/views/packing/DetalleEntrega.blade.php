@extends('welcome')
@section('tittle',('Lista productos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12  py-3 px-1 px-sm-3 mt-5 mt-sm-0 opacidad rounded" id="Cont_gen">
                <div class="row mt-5 mt-lg-0">
                    <div class="col-lg-12 ">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <a class="btn btn-outline-dark" href="{{route('loginPack')}}" id="volver" ><i class="fas fa-chevron-left"></i></a>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-outline-dark" onclick="openModal()"><i class="fas fa-info-circle"></i></button>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center" id="content">

                        </div>
                        <div class="row">
                            <div class="d-grid gap-2 py-3">
                                <a href="{{route('savePack',$id)}}" class="btn btn-dark" type="button" id="btnSubmit">Finalizar</a>
                            </div>
                        </div>
                        <button data-bs-toggle="modal" data-bs-target="#ModalInfo" id="btnModal" ></button>
                    </div>
                </div>
            </div>
             
            <!-- Modal Info -->
            <div class="modal fade"  id="ModalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalInfoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down  modal-dialog-scrollable mr-5">
                <div class="modal-content fonfoModal">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5" id="ModalInfoLabel">detalle pedido N° {{$id}}</h1>
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times text-light"></i></button>
                    </div>
                    <div class="modal-body ">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-light nowrap" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Nombre producto</th>
                                        <th class="text-center">Lote</th>
                                        <th class="text-center">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: bold;" id="tabla">

                                </tbody>
                                <tfoot class="tfoot table-dark">
                                    <tr>
                                        <td class="text-center" colspan="2">Total</td>
                                        <td class="text-center" id="Total"></td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
    <style>
        .fonfoModal{
            
            background-image: url("{{url('')}}/img/fondologin.jpg");
                width: 100%;
                height: 100%;
                background-attachment: fixed;
        }
        .packing{
            border-bottom: solid 1px white;
        }
        .back{
            display: none;
        }
        .columna{
            overflow: hidden;
            overflow-y: auto;
            min-height: 35rem;
            max-height: 35rem;
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
            body {
                font-family: 'Nunito', sans-serif;
                font-size: 12px;
            }
        }
        
        @media (max-width: 1000px) {
          
        }
        .conta{
            max-width: 80px;
            min-width: 80px;
            border:solid 1px  black;
            border-radius: 20px;
            padding-left: 10px;
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
                        "lengthMenu": "Mostrar"+ `
                            <select class="custom-select custom-select-sm form-select form-select-sm">
                                <option value="50" selected>50</option>    
                                <option value="100">100</option>    
                                <option value="150">150</option>    
                                <option value="200">200</option>    
                                <option value="-1">Todos</option>
                            </select>
                            ` +"registros por página",
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

          
            var arreglo = <?php echo json_encode($entrega)?>;

            var m_faltante = <?php echo json_encode($justy)?>;


            let inicioE = '<?php echo $horaI?>';
            
            var DE = <?php echo json_encode($datExtra)?>;


            // -----------------Tabla De Entregas--------------------
            function openModal() {
                let total = 0;
                    $('#tabla').text('');
                for(let element of arreglo) {
                    if (element['U_IV_ESTA'] == "Recogido") {
                        total += element['CantLote'];
                        if (element['Biologico'] == 'BIOLOGICOS') {
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}" class="bio">
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
                        }else if (element['TOXICO'] == "Y") {
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}" class="tox">
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
                        }else {
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}">
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
                    }
                }
                
                $("#Total").text(total);
                $("#btnModal").click();
            }

            let contador_cajas = 0;


            // --------------------Datos extra-----------------------
            
            let NumBio = 0; 
            let NumToxi = 0; 
            let NumNorm = 0; 
            for(let element of arreglo) {
                if (element['Biologico'] == 'BIOLOGICOS') {
                    NumBio += 1; 
                }else if (element['TOXICO'] == "Y") {
                    NumToxi += 1; 
                }else {
                    NumNorm +=1;
                }
            }

            console.log(DE);

            let BIOLOGICOS = "BIOLOGICOS";
            let Y = "Y";
            let Normales = "Normales";

            function list() {
                for(let element of arreglo) {

                    for(let extra of DE) {

                        let unidades = Math.trunc(extra['Cant_Unidades']); 
                        $('#content').text('');
                        $('#content').append(`
                            <div class="col-12">
                                <ul class="list-group list-group-flush rounded">
                                    <li class="list-group-item"><b>Inicio empaque: </b>${inicioE}</li>
                                    <li class="list-group-item"><b>Cliente: </b>${element['CardName']}</li>
                                    <li class="list-group-item"><b>Departamento: </b>${element['Departamento']}</li>
                                    <li class="list-group-item"><b>Municipio / Ciudad: </b>${element['Municipio_Ciudad']}</li>
                                    <li class="list-group-item"><b>Fecha Creación: </b>${element['DocDate']}</li>
                                    <li class="list-group-item"><b>Comentarios: </b>${extra['Comments']}</li>
                                    <li class="list-group-item"><b>N° de lineas: </b>${extra['Cant_Linea']}</li>
                                    <li class="list-group-item"><b>N° Unidades: </b>${unidades}</li>
                                </ul>
                            </div>
                        `);
                    }
                }

                $("#content").append(`
                        <h3 class="text-center py-3" style="font-weight: bold; font-size: 35px;">Cantidades por tipo.</h3>
                        <div class="col-12">
                            <ul class="list-group list-group-flush rounded">
                                <button onclick="modalDetalle(${BIOLOGICOS})" class="list-group-item list-group-item-action tipos"><b>N° Biologicos: </b>${NumBio}</button>
                                <button onclick="modalDetalle(${Y})" class="list-group-item list-group-item-action tipos"><b>N° Toxicos: </b>${NumToxi}</button>
                                <button onclick="modalDetalle(${Normales})" class="list-group-item list-group-item-action tipos"><b>N° Normales: </b>${NumNorm}</button>
                            </ul>
                        </div>
                `);
            }
            list();

            function modalDetalle(tipo) {
                let tipe = tipo.toString();
                console.log(tipe);
                let totalCant = 0;
                $('#tabla').html('');
                if (tipe == "BIOLOGICOS") {
                    for(let element of arreglo) {
                        if (element['U_IV_ESTA'] == "Recogido") {
                            if (element['Biologico'] == "BIOLOGICOS") {
                                totalCant += element['CantLote'];
                                $('#tabla').append(`
                                    <tr id="fila-${element['id__']}" class="bio">
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
                        }

                        $("#btnModal").click();
                    }
                }else if (tipe == "Y") {
                    for(let element of arreglo) {
                        if (element['TOXICO'] == "Y") {
                            totalCant += element['CantLote'];
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}" class="tox">
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
                    }
                    $("#btnModal").click();
                }else {
                    for(let element of arreglo) {
                        if (element['TOXICO'] !== "Y" && element['Biologico'] !== "BIOLOGICOS") {
                            totalCant += element['CantLote'];
                            $('#tabla').append(`
                                <tr id="fila-${element['id__']}">
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
                    }
                    $("#btnModal").click();
                }
                $("#Total").text(totalCant);
            }
            
            $ ("#btnSubmit").click(function () {
                $(this).prop("disabled",true);
                    $(".tipos").attr('disabled', true);
                    $(this).html(
                    `<span class="spinner-border spinner-border-sm"
                    role="status" aria-hidden="true"></span> Finalizando...`
                    ) ;
            });
            
            // function guardar() {
            //     $(this).

            //     $('#Cont_gen').html(`
                
            //         <div class="row justify-content-around">
            //             <div class="col-auto">
            //                 <a class="btn btn-outline-dark disabled"><i class="fas fa-chevron-left"></i></a>
            //             </div>
            //             <div class="col-10">
            //                 <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
            //             </div>
            //             <div class="col-auto">
            //                 <button class="btn btn-outline-dark" disabled><i class="fas fa-info-circle"></i></button>
            //             </div>
            //         </div>

            //         <div class="row justify-content-center pb-3">
            //             <div id="cont_boton_m2">
            //                 <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal2" id="boton_m2"></button>
            //             </div>
            //             <div class="col-sm-5">
            //                 <div class="input-group flex-nowrap">
            //                     <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
            //                     <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" disabled>
            //                 </div>
            //             </div>
                        
            //         </div>
                    
            //         <div class="row">
            //             <ul class="nav justify-content-end">
            //                 <li class="nav-item">
            //                     <span class="nav-link text-dark"><small><i class="fas fa-circle text-warning"></i></small> Biologicos.</span>
            //                 </li>
            //                 <li class="nav-item">
            //                     <span class="nav-link text-dark"><i class="fas fa-circle text-danger"></i></small> Venenos.</a>
            //                 </li>
            //                 <li class="nav-item">
            //                     <span class="nav-link text-dark"><small><i class="far fa-circle text-light"></i></small> normales.</span>
            //                 </li>
            //             </ul>
            //             <div class="col-12">
                        
            //                 <div class="table-responsive">
            //                     <table class="table table-striped table-bordered nowrap" style="width:100%; min-width: 100%">
            //                         <thead class="table-dark">
            //                             <tr>
            //                                 {{-- <th class="text-center">Id</th> --}}
            //                                 <th class="text-center">Ubicación</th>
            //                                 <th class="text-center">Cantidad</th>
            //                                 <th class="text-center">Lote</th>
            //                                 <th class="text-center">Nombre producto</th>
            //                                 <th class="text-center">barras</th>
            //                             </tr>
            //                         </thead>
            //                         <tbody style="font-size: bold;">
            //                             <tr>
            //                                 <td><span class="placeholder col-12 placeholder-lg"></span></td>
            //                                 <td><span class="placeholder col-6"></span></td>
            //                                 <td><span class="placeholder col-6"></span></td>
            //                                 <td><span class="placeholder" style="width: 25%;"></span></td>
            //                                 <td><span class="placeholder col-6"></span></td>
            //                             </tr>
            //                             <tr>
            //                                 <td><span class="placeholder col-12 placeholder-lg"></span></td>
            //                                 <td><span class="placeholder col-6"></span></td>
            //                                 <td><span class="placeholder col-6"></span></td>
            //                                 <td><span class="placeholder" style="width: 25%;"></span></td>
            //                                 <td><span class="placeholder col-6"></span></td>
            //                             </tr>
            //                         </tbody>
            //                     </table>
            //                 </div>
                            
            //                 <div class="row justify-content-end">
            //                     <div class="col-4" id="cont_boton_f"></div>

            //                     </div>
            //                 </div>
            //             </div>
            //         </div>   

            //     `) ;
            // }
        </script>
@endsection