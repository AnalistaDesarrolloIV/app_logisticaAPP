@extends('welcome')
@section('tittle',('Lista productos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12  py-3 px-1 px-sm-3 mt-5 mt-sm-0 opacidad rounded">
                <div class="row mt-5 mt-lg-0">
                    <div class="col-lg-12 ">
                        <div class="row">
                            <div class="col-1">
                                <a class="btn btn-outline-dark" href="/logPack" id="volver" ><i class="fas fa-chevron-left"></i></a>
                            </div>
                            <div class="col-11">
                                <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-3 columna cabecera">
                                
                                <div class="row mb-3">
                                    <div class="col">
                                        <h5><small><i class="fas fa-circle text-warning"></i></small> Biologicos.</h5>
                                        <h5><small><i class="fas fa-circle text-danger"></i></small> Venenos.</h5>
                                        <h5><small><i class="far fa-circle text-light"></i></small> normales.</h5>
                                    </div>
                                </div>

                                <div class="row " id="d_fijos">

                                </div>

                                <form action="{{route('savePack',$id)}}" method="post">
                                    @csrf
                                    <div class="row justify-content-end">

                                        <div class="col-5" id="cont_boton_f">

                                        </div>
                                    </div>
                                    <div class="row" id="lista_form">

                                    </div>
                                </form>

                            </div>
                            <div class="col-md-12 col-lg-9 columna">
                                <div class="row justify-content-center py-3">
                                    <div class="col-md-5 col-lg-8">
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
                                            <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" id="code_bar" onchange="lector()">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table id="tbl" class="table table-striped table-bordered nowrap" style="width:100%">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center">Codigo de barras</th>
                                                <th class="text-center">Nombre producto</th>
                                                <th class="text-center">Lote</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-center">Cajas</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: bold;" id="tabla">

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal 1-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="close_m" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="contenido">

                    </div>
                    <div class="modal-footer" id="foot">

                    </div>
                    </div>
                </div>
            </div>

            <div id="cont_boton_m2">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal2" id="boton_m2"></button>
            </div>
            <!-- Modal 2-->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">productos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
    <style>
        
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
            }
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
        <!-- <script src="sweetalert2.all.min.js"></script> -->
        <script>
            let tabla_cont = 0;
            $(document).ready(function() {
                var table = $('#tbl').DataTable( {
                    responsive: false,
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

          
            var array = '<?php echo json_encode($entrega)?>';
            
            let arreglo = JSON.parse(array);

            var faltante = '<?php echo json_encode($justy)?>';
            
            let m_faltante = JSON.parse(faltante);

            console.log(m_faltante);

            let inicioE = '<?php echo $_SESSION['H_I_EMP']?>';

            for(let element of arreglo) {
                if (element['Biologico'] == 'BIOLOGICOS') {
                    $('#tabla').append(`
                        <tr id="fila-${element['id__']}" class="bio">
                            <td>
                                <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                                <b>${element['CodeBars']}</b>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm " data-bs-toggle="modal" data-bs-target="#exampleModal" id="boton_m" onclick="modal_p(${element['id__']})">
                                    <b>${element['Dscription']}</b>
                                </button>
                            </td>
                            
                            <td>
                                <b>${element['LOTE']}</b>
                            </td>
                            <td>
                                <b>${element['CantLote']}</b>
                            </td>
                            <td>
                                <ul  id="n_cajas-${element['id__']}">
                                
                                </ul>
                            </td>
                        </tr> 
                    `);
                }else if (element['TOXICO'] == "Y") {
                    $('#tabla').append(`
                        <tr id="fila-${element['id__']}" class="tox">
                            <td>
                                <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                                <b>${element['CodeBars']}</b>
                            </td>
                            <td>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" id="boton_m" onclick="modal_p(${element['id__']})">
                                    <b>${element['Dscription']}</b>
                                </button>
                            </td>
                            
                            <td>
                                <b>${element['LOTE']}</b>
                            </td>
                            <td>
                                <b>${element['CantLote']}</b>
                            </td>
                            <td>
                                <b id="n_cajas-${element['id__']}"></b>
                            </td>
                        </tr> 
                    `);
                }else {
                    $('#tabla').append(`
                        <tr id="fila-${element['id__']}">
                            <td>
                                <input class="form-check-input" type="checkbox" disabled id="check-${element['id__']}" value="" aria-label="...">
                                <b>${element['CodeBars']}</b>
                            </td>
                            <td>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" id="boton_m" onclick="modal_p(${element['id__']})">
                                    <b>${element['Dscription']}</b>
                                </button>
                            </td>
                            
                            <td>
                                <b>${element['LOTE']}</b>
                            </td>
                            <td>
                                <b>${element['CantLote']}</b>
                            </td>
                            <td>
                                <b id="n_cajas-${element['id__']}"></b>
                            </td>
                        </tr> 
                    `);
                }
            }

            let contador_cajas = 0;

            for(let element of arreglo) {
                $('#d_fijos').text('');
                $('#d_fijos').append(`
                    <div class="col-12">
                        <ul class="list-group list-group-flush rounded">
                            <li class="list-group-item"><b>Hora de inicio: </b>${inicioE}</li>
                            <li class="list-group-item"><b>Cliente: </b>${element['CardName']}</li>
                            <li class="list-group-item"><b>Departamento: </b>${element['Departamento']}</li>
                            <li class="list-group-item"><b>Municipio / Ciudad: </b>${element['Municipio_Ciudad']}</li>
                            <li class="list-group-item"><b>Fecha Creación: </b>${element['DocDate']}</li>
                            <li class="list-group-item"><b>Comentarios: </b>${element['Comments']}</li>
                        </ul>
                    </div>
                `);
            }

            function modal_p(id) {
                $("#contenido").text('');
                $("#contenido").removeClass('d-flex justify-content-center');
                $('#foot').text('');
                $('#divi').text('');
                contador_cajas = 0;
                for(let element of arreglo) {
                    if ($('#check-'+id).prop('checked') != true) {
                        if (element['id__'] == id) {
                            if (element['CantLote'] > 5) {
                                $("#contenido").append(`
                                    <div class="row justify-content-center pb-3">
                                        <div class="col-lg-5">
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="Code_b"> <i class="fas fa-barcode"></i> </span>
                                                <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="Code_b" id="code" onchange="contador(${element['id__']})">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <b>Codigo de barras:</b>
                                            ${element['CodeBars']}
                                         </li>
                                        <li class="list-group-item">
                                            <b>Producto:</b> 
                                            ${element['Dscription']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Lote:</b> 
                                            ${element['LOTE']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Fecha de vencimiento:</b>
                                            ${element['Fecha_Vencimiento_Lote']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Cantidad:</b>
                                            <input type="number" class="conta" id="contador${element['id__']}" value="1"> 
                                            <b>de</b> 
                                            ${element['CantLote']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Comentarios de empaque:</b>
                                            ${element['Comments']}
                                        </li>
                                        <li class="list-group-item">
                                            <input type="number" class="conta" id="unidades-${element['id__']}-${contador_cajas}" onchange="valid(${element['id__']}, ${contador_cajas})"> 
                                            <b> unidades empacadas en </b>
                                                <select class="conta" id="tipo_emp-${element['id__']}-${contador_cajas}">
                                                    <option value="CAJA GENERICA">CAJA GENERICA</option>
                                                    <option value="BOLSA">BOLSA</option>
                                                    <option value="NEVERA 7LT">NEVERA 7LT</option>
                                                    <option value="NEVERA 10LT">NEVERA 10LT</option>
                                                    <option value="NEVERA 14LT">NEVERA 14LT</option>
                                                </select>
                                            <b> N° </b>
                                            <input type="number" class="conta" id="caja-${element['id__']}-${contador_cajas}" value="${contador_cajas+1}"> 
                                            <button class="btn btn-dark btn-sm" id="btn_div" onclick="dividir(${element['id__']})">Dividir</button>
                                        </li>
                                        <li class="list-group-item" id="divi">

                                        </li>

                                    </ul>

                                    <div id="tit_just">

                                    </div>

                                    <div class="form-floating" id="just">
                                    
                                    </div>
                                `);
                                $('#foot').append(`
                                    <button type="button"  id="cerrar1"  class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cerrar
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="check(${element['id__']})">Guardar</button>
                                `);
                            }else {
                                
                                $("#contenido").append(`
                                    <div class="row justify-content-center pb-3">
                                        <div class="col-lg-5">
                                            <div class="input-group flex-nowrap">
                                                <span class="input-group-text" id="Code_b"> <i class="fas fa-barcode"></i> </span>
                                                <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="Code_b" id="code" onchange="contador(${element['id__']})">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <b>Codigo de barras:</b> 
                                            ${element['CodeBars']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Producto:</b> 
                                            ${element['Dscription']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Lote:</b> 
                                            ${element['LOTE']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Fecha de vencimiento:</b>
                                            ${element['Fecha_Vencimiento_Lote']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Cantidad:</b> 
                                            <input type="number" class="conta" id="contador${element['id__']}" readonly value="1"> 
                                            <b>de</b>
                                            ${element['CantLote']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Comentarios de empaque:</b> 
                                            ${element['Comments']}
                                        </li>
                                        <li class="list-group-item">
                                            <b>Cajas de empaque:</b>
                                            <input type="number" class="conta" id="unidades-${element['id__']}-${contador_cajas}" onchange="valid(${element['id__']}, ${contador_cajas})"> 
                                            <b> unidades empacadas en </b>
                                                <select class="conta" id="tipo_emp-${element['id__']}-${contador_cajas}">
                                                    <option value="CAJA GENERICA">CAJA GENERICA</option>
                                                    <option value="BOLSA">BOLSA</option>
                                                    <option value="NEVERA 7LT">NEVERA 7LT</option>
                                                    <option value="NEVERA 10LT">NEVERA 10LT</option>
                                                    <option value="NEVERA 14LT">NEVERA 14LT</option>
                                                </select>
                                            <b> N° </b>
                                            <input type="number" class="conta" id="caja-${element['id__']}-${contador_cajas}" value="${contador_cajas+1}"> 
                                            <button class=" btn btn-dark btn-sm" id="btn_div" onclick="dividir(${element['id__']})">Dividir</button>
                                        </li>
                                        <li class="list-group-item" id="divi">

                                        </li>
                                    </ul>

                                    <div id="tit_just">

                                    </div>
                                    
                                    <div class="form-floating" id="just">
                                    
                                    </div>
                                `);
                                $('#foot').append(`
                                    <button type="button"  id="cerrar1"  class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" onclick="check(${element['id__']})">Guardar</button>
                                `);
                            }
                        }
                    }
                }
                if ($("#contenido").text()== '') {
                    $("#contenido").addClass('d-flex justify-content-center');
                    $("#contenido").append(`
                        <strong class="text-center text-danger text-lg">El producto no esta en el pedido o ya fue revisado</strong>
                    `);
                }
            }

            function dividir(id) {
                contador_cajas +=1;
                $('#divi').append(` 
                    <hr>
                    <input type="number" class="conta" id="unidades-${id}-${contador_cajas}" onchange="valid(${id}, ${contador_cajas})"> 
                    <b> unidades empacadas en </b>
                        <select class="conta" id="tipo_emp-${id}-${contador_cajas}">
                            <option value="CAJA GENERICA">CAJA GENERICA</option>
                            <option value="BOLSA">BOLSA</option>
                            <option value="NEVERA 7LT">NEVERA 7LT</option>
                            <option value="NEVERA 10LT">NEVERA 10LT</option>
                            <option value="NEVERA 14LT">NEVERA 14LT</option>
                        </select>
                    <b> N° </b>
                    <input type="number" class="conta" id="caja-${id}-${contador_cajas}" value="${contador_cajas+1}"> 
                    <button class=" btn btn-dark btn-sm" id="btn_div" onclick="dividir(${id})">Dividir</button>
                `);
            }

            function valid(id, contador_cajas) {
                let u = $("#unidades-"+id+"-"+contador_cajas).val();
                let u_esc = $("#contador"+id).val();
                // for(let element of arreglo) {
                //     if (element['id__'] == id) {
                        if (parseInt(u_esc) < parseInt(u)) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Cantidad en caja',
                                text: 'Imposible cantidad escaneada insuficiente.',
                            })
                            $("#unidades-"+id+"-"+contador_cajas).val('');
                        }
                //     }
                // }
            }
            
            function contador(id) {
                let codigo = $('#code').val();
                for(let element of arreglo) {
                    if (element['id__'] == id) {
                        if (element['CodeBars'] == codigo) {
                            let cantidad = $('#contador'+id).val();
                            if (element['CantLote'] > cantidad) {
                                $('#contador'+id).val(parseInt(cantidad)+1);
                            }else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Cantidad',
                                    text: 'Cantidad alcanzada',
                                })
                            }
                        }
                    }
                }
                $('#code').val('');
                $('#code').focus();
            }
            
            function lector() {
                let codigo = $('#code_bar').val();
                let cont = 0;
                for(let element of arreglo) {
                    if (element['CodeBars'] == codigo) {
                        cont+= 1;
                    }
                }
                if (cont == 1) {
                    for(let element of arreglo) {
                        if (element['CodeBars'] == codigo) {
                            $('#boton_m').click();

                            modal_p(element['id__']);
                        }
                    }
                }else if(cont > 1) {
                    $('#boton_m2').click();

                    modal2(codigo);
                }
                if (cont == 0) {
                    
                    $('#code_bar').val('');
                    $('#code_bar').focus();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Producto',
                        text: 'Producto no encontrado dentro del pedido.',
                    })
                }

            }

            function modal2 (codigo) {
                    $("#contenido2").text('');
                    $("#contenido2").removeClass('d-flex justify-content-center');
                    for(let element of arreglo) {
                        if ($('#check-'+element['id__']).prop('checked') != true) {
                            if (element['CodeBars'] == codigo) {
                                $("#contenido2").append(`
                                    <button type="button" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#exampleModal" id="boton_m" onclick="modal_p(${element['id__']})">
                                        
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


            function check(id) {

                for(let element of arreglo) {
                    if (element['id__'] == id) {
                        if ($('#contador'+element['id__']).val() == element['CantLote']) {
                            // $('#fila-'+id).addClass('table-success');
                                let cantidadEmp = $('#contador'+element['id__']).val();
                                    $('#lista_form').append(`
                                        <div class="form-floating mb-3">
                                            <input type="hidden" class="form-control" id="floatingInput" name="cantidadE[]" value="${cantidadEmp}" placeholder="${cantidadEmp}">
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="hidden" class="form-control" id="floatingInput" value=" " name="justify[]">
                                        </div>
                                        `);
                            for (let c = 0; c <= contador_cajas; c++) {
                                let uni = $('#unidades-'+id+'-'+c).val();
                                let tipo_e = $("#tipo_emp-"+id+'-'+c+" option:selected").val();
                                console.log(tipo_e);
                                let ca = $('#caja-'+id+'-'+c).val();
                                if (uni !== '') {
                                    $('#n_cajas-'+id).append(`
                                        <li><b>${uni}</b> unidades en <b> ${tipo_e} </b> N° <b>${ca}</b></li>
                                    `);
                                    $('#lista_form').append(`
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3">
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" value="${ca}" name="embalaje[${c}][caja]">
                                                    </div>
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" name="embalaje[${c}][tipo_emp]" value="${tipo_e}">
                                                    </div>
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" name="embalaje[${c}][Producto]" value="${element['ItemCode']}" placeholder="${element['ItemCode']}">
                                                    </div>
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" name="embalaje[${c}][UoMEntry]" value="${element['UomEntry']}" placeholder="${element['UomEntry']}">
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" value="${uni}" name="embalaje[${c}][unidad]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                    
                                    $('#check-'+id).prop("checked", true);
                                    tabla_cont += 1;
                                    console.log(tabla_cont);
                                    $('#cerrar1').click();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Check',
                                        text: 'Checkeado completo.',
                                    })
                                }
                                if (uni == '') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Complete',
                                        text: 'Ingresar las cunidades en cajas.',
                                    })
                                }
                            }
                        }
                    }
                }


                for(let element of arreglo) {
                    if (element['id__'] == id) {
                        if ($('#contador'+element['id__']).val() != element['CantLote']) {
                            Swal.fire({
                                title: 'Segur@?',
                                text: "Cantidad insuficiente! Justificar faltante.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si',
                                cancelButtonText: 'No'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#justy").text('');
                                        $('#tit_just').text('');
                                        $('#tit_just').append(`
                                            <h4 class="text-danger text-center">Justificación</h4>
                                        `);
                                        $("#just").text('');     
                                        $("#just").append(`
                                            <select class="form-select" id="justy" aria-label="Justificacion">
                                                <option selected value="0">Seleccionar</option>
                                            </select>
                                            <label for="justy">Justificación</label>
                                        `);
                                        $('#foot').text('');
                                        $('#foot').append(`
                                            <button type="button" class="btn btn-primary" onclick="check_just(${element['id__']})">Guardar y justificar</button>
                                        `);
                                        for(let f of m_faltante) {
                                            $("#justy").append(`
                                                    <option value="${f['FldValue']}">${f['Descr']}</option>
                                            `);
                                        }
                                    }
                                })
                        }
                    }
                }
                
                if (tabla_cont >= (arreglo.length)) {
                    $('#cont_boton_f').text('');
                    $('#cont_boton_f').append(`
                        <div class="d-grid gap-2 py-3">
                            <button class="btn btn-dark" type="submit">Finalizar</button>
                        </div>
                    `);
                }
                $('#code_bar').val('');
                $('#code_bar').focus();

            }
            
            function check_just(id) {
                let just = $('#justy option:selected').val();
                let just_text = $('#justy option:selected').text();
                if (just == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Justificación',
                        text: 'Seleccionar una opcion para la justificación',
                    })
                }else {
                    for(let element of arreglo) {
                        if (element['id__'] == id) {
                                let cantidadEmp = $('#contador'+element['id__']).val();
                                    $('#lista_form').append(`
                                        <div class="form-floating mb-3">
                                            <input type="hidden" class="form-control" id="floatingInput" name="cantidadE[]" value="${cantidadEmp}" placeholder="${cantidadEmp}">
                                        </div>
                                        
                                            <div class="form-floating mb-3">
                                                <input type="hidden" class="form-control" id="floatingInput" value="${just}" name="justify[]">
                                            </div>
                                        `);
                            for (let c = 0; c < contador_cajas+1; c++) {
                                let uni = $('#unidades-'+id+'-'+c).val();
                                let tipo_e = $("#tipo_emp-"+id+'-'+c+" option:selected").val();
                                console.log(tipo_e);
                                let ca = $('#caja-'+id+'-'+c).val();
                                if (uni !== '') {
                                    $('#check-'+id).prop("checked", true);
                                    
                                    $('#n_cajas-'+id).append(`
                                            <li><b>Justificación faltante: </b>${just_text} </li>
                                        `);
                                    $('#n_cajas-'+id).append(`
                                        <li><b>${uni}</b> unidades en <b> ${tipo_e} </b> N° <b>${ca}</b></li>
                                    `);
                                    $('#lista_form').append(`
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3">
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" value="${ca}" name="embalaje[${c}][caja]">
                                                    </div>
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" name="embalaje[${c}][tipo_emp]" value="${tipo_e}">
                                                    </div>
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" name="embalaje[${c}][Producto]" value="${element['ItemCode']}" placeholder="${element['ItemCode']}">
                                                    </div>
                                                    
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" name="embalaje[${c}][UoMEntry]" value="${element['UomEntry']}" placeholder="${element['UomEntry']}">
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="floatingInput" value="${uni}" name="embalaje[${c}][unidad]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                    tabla_cont += 1;
                                    console.log(tabla_cont);
                                    $('#close_m').click();
                                    Swal.fire(
                                        'Justificado!',
                                        'Checkeado y justificado exitosamente.',
                                        'success'
                                    );
                                }
                                
                                if (uni == '') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Complete',
                                        text: 'Ingresar las cunidades en cajas.',
                                    })
                                }
                            }
                                
                        }
                    }
                }
                
              
                if (tabla_cont >= (arreglo.length)) {
                    $('#cont_boton_f').text('');
                    $('#cont_boton_f').append(`
                        <div class="d-grid gap-2 py-3">
                            <button class="btn btn-dark" type="submit">Finalizar</button>
                        </div>
                    `);
                }
                $('#code_bar').val('');
                $('#code_bar').focus();
            }
        </script>
@endsection