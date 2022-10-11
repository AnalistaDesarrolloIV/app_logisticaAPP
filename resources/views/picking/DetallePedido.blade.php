@extends('welcome')
@section('tittle',('Lista Productos'))

@section('content')

    <div class="container-fluid" id="content">
        <div class="row justify-content-center">
            <div class="col-12  pt-3 px-1 px-sm-5 mt-5  opacidad rounded" id="Cont_gen">
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <a class="btn btn-outline-dark" href="{{route('loginPick')}}" id="volver" ><i class="fas fa-chevron-left"></i></a>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-dark"  data-bs-toggle="modal" data-bs-target="#ModalInfo" ><i class="fas fa-info-circle"></i></button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
                    </div>
                </div>

                <div class="row justify-content-center pb-3">
                    <div id="cont_boton_m2">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal2" id="boton_m2"></button>
                    </div>
                    <div class="d-flex justify-content-center" id="menu">
                        <div class="col-sm-5">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
                                <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" id="code_bar" autofocus onchange="lector()">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                            <span class="nav-link text-dark"><small><i class="fas fa-circle text-warning"></i></small> Biologicos.</span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark"><i class="fas fa-circle text-danger"></i></small> Venenos.</a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark"><small><i class="far fa-circle text-light"></i></small> normales.</span>
                        </li>
                    </ul>
                    <div class="col-12">
                       
                        <div class="table-responsive">
                            <table id="tbl" class="table table-striped table-bordered nowrap" style="width:100%; min-width: 100%">
                                <thead class="table-dark">
                                    <tr>
                                        {{-- <th class="text-center">Id</th> --}}
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
            <!-- Modal Info -->
            <div class="modal fade"  id="ModalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalInfoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalInfoLabel">Info Pedido N° {{$id}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"  id="d_fijos">
                    ...
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                </div>
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
        .menu_fix{
            width: 100%;
            height:9%;
            position: fixed;
            z-index: 10000;
            top: 0;
            /* margin-top: calc(100% - 86%); */
            background: rgba(10, 10, 10, 0.3);

        }
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
                let altura = $("#menu").offset().top;
                
                $(window).on('scroll', function() {
                console.log(altura);
                    if ($(window).scrollTop() > altura-20) {
                        $("#menu").addClass('menu_fix pt-2');
                    }else {
                        $("#menu").removeClass('menu_fix pt-2');
                    }
                })
            } );
            
            
            var arreglo = <?php echo json_encode($ped)?>;

            
            let inicioR = '<?php echo $horaI?>';
            let session = '<?php echo $_SESSION['B1SESSION']?>';

            var arreglo2 = <?php echo json_encode($invoices)?>;

            
            var DE = <?php echo json_encode($datExtra)?>;
        


            let cod_wms = [];
            function  buscar_pedido(cod_wms, CodArt, Lote) {
                let id = 0;
                for(let element2 of arreglo2) {
                    if(CodArt == element2['Articulo Efectuado'] && Lote == element2['Lote'] ){
                        cod_wms[id]= [element2['Bahia'], element2['Cantidad']];
                        id+=1;
                    }
                }
                return cod_wms;
            }

            // -------------------------Datos de la tabla--------------------
                
                let arregloP = [];

            for(let element of arreglo) {
                let id = element['LineNum'];
                let CodArt = element['ItemCode'];
                let Lote = element['LOTE'];
                let cod_wms = [];

                let incluye = arregloP.includes(CodArt+"-"+Lote);
                if (!incluye) {
                    arregloP.push(CodArt+"-"+Lote);
                    let busqueda = buscar_pedido(cod_wms, CodArt, Lote);
                    for(let res of busqueda) {
        
                            let bahia = "";
                            let cantidad = "";

                            if (res[0] == '80000') {
                                bahia = "Biologico";
                            }else if (res[0] == '80003') {
                                bahia = "Almacen";
                            } else if(res[0] == '80005'){
                                bahia = "Venenos";
                            } else if(res[0] == '80002' || res[0] == '80011' || res[0] == '80012' || res[0] == '80013' || res[0] == '80014' || res[0] == '80015'){
                                bahia = "Abastecimiento";
                            } else if(res[0] == '11'){
                                bahia = "Modula 1";
                            } else if(res[0] == '21'){
                                bahia = "Modula 2";
                            } else if(res[0] == '31'){
                                bahia = "Modula 3";
                            }
                                cantidad = Math.trunc(res[1]);
                                
                                let id = element['ItemCode']+"-"+res[0]+"-"+cantidad+"-"+element['LOTE'];
                                let ID = id.toString();
                                ID = ID.replace('/','-');

                            if (element['U_IV_ESTA'] == "Por Recoger") {
                                if (element['Biologico'] == 'BIOLOGICOS') {
                                    $('#tabla').append(`
                                        <tr id="fila-${ID}" class="bio">
                                            <td>
                                                <input class="form-check-input" type="checkbox" checked disabled id="check-fila-${ID}" value="" aria-label="...">
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
                                                <b>${element['CodeBars'] == '' || element['CodeBars'] == null ? "1" : element['CodeBars']}</b>
                                            </td>
                                            
                                        </tr> 
                                    `);
                                }else if (element['TOXICO'] == "Y") {
                                    $('#tabla').append(`
                                        <tr id="fila-${ID}" class="tox">
                                            <td>
                                                <input class="form-check-input" type="checkbox" disabled id="check-fila-${ID}" value="" aria-label="...">
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
                                                <b>${element['CodeBars'] == '' || element['CodeBars'] == null ? "1" : element['CodeBars']}</b>
                                            </td>
                                            
                                        </tr> 
                                    `);
                                }else {
                                    $('#tabla').append(`
                                        <tr id="fila-${ID}">
                                            <td>
                                                <input class="form-check-input" type="checkbox" disabled id="check-fila-${ID}" value="" aria-label="...">
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
                                                <b>${element['CodeBars'] == '' || element['CodeBars'] == null ? "1" : element['CodeBars']}</b>
                                            </td>
                                            
                                        </tr> 
                                    `);
                                }
                            }

                    }
                }
                
            }
            
            // ----------------Datos Fijos----------------
            for(let element of arreglo) {
                
                for(let extra of DE) {
                    let unidades = Math.trunc(extra['Cant_Unidades']);
                    $('#d_fijos').text('');
                    $('#d_fijos').append(`
                        <div class="col-12 mb-3 mb-md-0">
                            <ul class="list-group list-group-flush rounded">
                                <li class="list-group-item"><b>Hora de inicio: </b>${inicioR}</li>
                                <li class="list-group-item"><b>Cliente: </b>${element['CardName']}</li>
                                <li class="list-group-item"><b>Cantidad de lineas: </b>${extra['Cant_Linea']} &nbsp;&nbsp;&nbsp; <b>Cantidad de unidades: </b>${unidades}</li>
                                <li class="list-group-item"><b>Departamento: </b>${element['Departamento']}</li>
                                <li class="list-group-item"><b>Municipio / Ciudad: </b>${element['Municipio_Ciudad']}</li>
                                <li class="list-group-item"><b>Fecha Creación: </b>${element['DocDate']}</li>
                                <li class="list-group-item"><b>Comentarios: </b>${extra['Comments']}</li>
                            </ul>
                        </div>
                    `);
                }
            }

            function lector() {
                let codigo = $('#code_bar').val();
                let cont = 0;
                let idu = [];

                $("#tabla").find("tr").each(function (idx, row) {
                    id = $(this).attr('id');
                    if (idx >= 0) {
                        let cod_tbl = $("td:eq(4)", row).text();
                        codigo_tbl = cod_tbl.trim();
                        if (codigo == codigo_tbl) {
                            idu[idx] = id.trim();
                            cont += 1;
                        }
                    }
                });
                
                if (cont == 1) {
                    $("#tabla").find("tr").each(function (idx, row) {
                        id = $(this).attr('id');
                        if (idx >= 0) {
                            for(let id_t of idu) {
                                if (id_t == id) {
                                    let ID = id.toString();
                                    let nombre = $("td:eq(3)", row).text();
                                    let unidad = $("td:eq(1)", row).text();
                                    let lote = $("td:eq(2)", row).text();
                                    let ubicacion = $("td:eq(0)", row).text()
                                    if ($('#check-'+ID).prop('checked') != true) {
                                        Swal.fire({
                                        html: `
                                            <div class="row justify-content-center" style="width:100%">
                                                <div class="col-auto">
                                                    <h3><b>${nombre}</b></h3>
                                                </div>
                                                <div class="col-12 text-start">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><b>Cantidad: </b>${unidad}</li>
                                                        <li class="list-group-item"><b>Lote: </b>${lote}</li>
                                                        <li class="list-group-item"><b>Ubicación: </b>${ubicacion}</li>
                                                    </ul>    
                                                </div>
                                            </div>`,
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si, continuar',
                                        cancelButtonText: 'No, cancelar'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // $('#'+id).addClass('table-success');
                                                $('#check-'+ID).prop("checked", true);
                                                $('#code_bar').focus();
                                                    
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Producto recogido',
                                                    html: `
                                                        <div class="row justify-content-center" style="width:100%">
                                                            <div class="col-auto">
                                                                <p><b>${nombre}</b></p>
                                                            </div>
                                                            <div class="col-12 text-start">
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item"><b>Cantidad: </b>${unidad}</li>
                                                                    <li class="list-group-item"><b>Lote: </b>${lote}</li>
                                                                    <li class="list-group-item"><b>Ubicación: </b>${ubicacion}</li>
                                                                </ul>    
                                                            </div>
                                                        </div>`,
                                                })
                                                
                                                btnFin()
                                            }
                                        })
                                    }else {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Error producto recogido',
                                            html: `<b>${nombre}, ya fue recogido</b>`,
                                        })
                                    }
                                    
                                }
                            }
                        }
                    });

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
                
                
                btnFin()
                $('#code_bar').val('');
            }

            
            function modal2 (codigo) {
                $('#code_bar').val('');
                $("#contenido2").text('');
                $("#contenido2").removeClass('d-flex justify-content-center');
                
                $("#tabla").find("tr").each(function (idx, row) {
                    id = String($(this).attr('id'));
                    if (idx >= 0) {
                        let cod_tbl = $("td:eq(4)", row).text();
                        codigo_tbl = parseInt(cod_tbl);
                        if (codigo == codigo_tbl) {
                                    let ID = id.toString();
                            if ($('#check-'+ID).prop('checked') != true) {
                                
                                $("#contenido2").append(`

                                    <button type="button" class="list-group-item list-group-item-action" id="boton_m" onclick="check_ind('${id}')">
                                        <strong>${$("td:eq(3)", row).text().trim()}</strong> ----  Lote: <small>${$("td:eq(2)", row).text().trim()} ---- Cantidad: ${$("td:eq(1)", row).text().trim()} ---- Ubicación: ${$("td:eq(0)", row).text().trim()}</small>
                                    </button>

                                `);

                            }
                        }
                    }
                });

                if ($("#contenido2").text()== '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error producto recogido',
                        html: `<b>Este producto, ya fue recogido o no se encuentra en el pedido.</b>`,
                    })
                }
            }

            function check_ind( id) {
                $('#code_bar').val('');
                let ID = id.toString();
                
                $("#tabla").find("tr").each(function (idx, row) {
                    id = $(this).attr('id');
                    if (idx >= 0) {
                        if (ID == id) {
                            
                            let nombre = $("td:eq(3)", row).text();
                            let unidad = $("td:eq(1)", row).text();
                            let lote = $("td:eq(2)", row).text();
                            if ($('#check-'+ID).prop('checked') != true) {
                                Swal.fire({
                                html: `
                                    <div class="row justify-content-center" style="width:100%">
                                        <div class="col-auto">
                                            <h3><b>${nombre}</b></h3>
                                        </div>
                                        <div class="col-12 text-start">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><b>Cantidad: </b>${unidad}</li>
                                                <li class="list-group-item"><b>Lote: </b>${lote}</li>
                                                <li class="list-group-item"><b>Ubicación: </b>${ubicacion}</li>
                                            </ul>    
                                        </div>
                                    </div>`,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, continuar',
                                cancelButtonText: 'No, cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // $('#'+id).addClass('table-success');
                                        $('#close_m').click();
                                        $('#check-'+ID).prop("checked", true);
                                        $('#code_bar').val('');
                                        $('#code_bar').focus();
                                            
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Producto',
                                            html: `
                                                <div class="row justify-content-center" style="width:100%">
                                                    <div class="col-auto">
                                                        <h3><b>${nombre}</b></h3>
                                                    </div>
                                                    <div class="col-12 text-start">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><b>Cantidad: </b>${unidad}</li>
                                                            <li class="list-group-item"><b>Lote: </b>${lote}</li>
                                                            <li class="list-group-item"><b>Ubicación: </b>${ubicacion}</li>
                                                        </ul>    
                                                    </div>
                                                </div>`,
                                        })
                                        
                                        btnFin()
                                    }
                                })
                            }
                            
                        }
                    }
                });
                // if ($('#check-'+ID).prop('checked') != true) {
                //     Swal.fire({
                //         icon: 'success',
                //         title: 'Producto',
                //         text: 'Producto recogido.',
                //     })
                //     $('#check-'+ID).prop("checked", true);
                //     $('#close_m').click();
                //     $('#code_bar').focus();
                //     btnFin()
                // }
                
            }

            let ID = <?php echo $id?>;
            let dl = <?php echo $DL?>;

            function btnFin(){
                let tabla_cont = 0;
                let filas = 0;
                let productos = []
                $('#cont_boton_f').text('');
                $("#tabla").find("tr").each(function (idx, row) {
                    if (idx >= 0) {
                        let check = $("td:eq(0) input:checkbox", row).prop('checked')
                        if (check) {
                            tabla_cont+=1
                        }
                    }
                    filas+=1
                })

                if ((tabla_cont) >= filas) {
                    $('#cont_boton_f').append(`
                        <div class="d-grid gap-2 py-3" id="guardar" onclick="guardar()">
                            <a href="{{route('savePick', ['id' => $id, 'DL'=> $DL])}}" class="btn btn-dark">
                                Finalizar
                            </a>
                        </div>
                    `);
                }
            }
            btnFin()

            function guardar() {
                $('#Cont_gen').html(`
                
                    <div class="row justify-content-around">
                        <div class="col-auto">
                            <a class="btn btn-outline-dark disabled"><i class="fas fa-chevron-left"></i></a>
                        </div>
                        <div class="col-10">
                            <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Pedido N° {{$id}}.</h3>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-dark" disabled><i class="fas fa-info-circle"></i></button>
                        </div>
                    </div>

                    <div class="row justify-content-center pb-3">
                        <div id="cont_boton_m2">
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal2" id="boton_m2"></button>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
                                <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" disabled>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <ul class="nav justify-content-end">
                            <li class="nav-item">
                                <span class="nav-link text-dark"><small><i class="fas fa-circle text-warning"></i></small> Biologicos.</span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link text-dark"><i class="fas fa-circle text-danger"></i></small> Venenos.</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link text-dark"><small><i class="far fa-circle text-light"></i></small> normales.</span>
                            </li>
                        </ul>
                        <div class="col-12">
                        
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" style="width:100%; min-width: 100%">
                                    <thead class="table-dark">
                                        <tr>
                                            {{-- <th class="text-center">Id</th> --}}
                                            <th class="text-center">Ubicación</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Lote</th>
                                            <th class="text-center">Nombre producto</th>
                                            <th class="text-center">barras</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: bold;">
                                        <tr>
                                            <td><span class="placeholder col-12 placeholder-lg"></span></td>
                                            <td><span class="placeholder col-6"></span></td>
                                            <td><span class="placeholder col-6"></span></td>
                                            <td><span class="placeholder" style="width: 25%;"></span></td>
                                            <td><span class="placeholder col-6"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="placeholder col-12 placeholder-lg"></span></td>
                                            <td><span class="placeholder col-6"></span></td>
                                            <td><span class="placeholder col-6"></span></td>
                                            <td><span class="placeholder" style="width: 25%;"></span></td>
                                            <td><span class="placeholder col-6"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="row justify-content-end">
                                <div class="col-4">
                                    <div class="d-grid gap-2 py-3">
                                        <button class="btn btn-dark" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm"
                                            role="status" aria-hidden="true"></span> Finalizar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                `) ;
            }
            
        </script>
@endsection