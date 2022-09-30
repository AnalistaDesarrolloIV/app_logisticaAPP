@extends('welcome')
@section('tittle',('Asignación Pedidos'))

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12  pt-3 px-1 px-sm-5 mt-5  opacidad rounded" id="Cont_gen">
                <div class="row">
                    <div class="col-auto">
                        <a class="btn btn-outline-dark" href="{{route('listPick')}}" id="volver" ><i class="fas fa-chevron-left"></i></a>
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
                        <div class="row justify-content-end mt-4">
                            <div class="col-12 d-grid gap-2" id="btn_as">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Modal_asignacion">
                                    Asignar
                                </button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="Modal_asignacion" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="titulo">Formulario de asignación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('storeAsign')}}" method="post" id="Form_asig">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$id}}">
                                        <input type="hidden" name="DL" value="{{$DL}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <lable class="form-label" for="operatore">Operador</lable>
                                                <select class="form-select select2" id="operatore" aria-label="Default select example" name="operatore">
                                                    <option selected value="">Selecciones</option>
                                                    @foreach ($user as $key => $val)
                                                        @if ($val['U_Tipo_Opr'] !== "ADMINISTRADOR")
                                                            <option value="{{$val['Code']}}">{{$val['Code']}}</option>
                                                        @endif
                                                    @endforeach
                                                  </select>
                                            </div>
                                            <div class="col-md-6">
                                                <lable class="form-label" for="prioridad">Prioridad</lable>
                                                <select class="form-select select2" id="prioridad" aria-label="Default select example" name="prioridad">
                                                    <option selected value="">Selecciones</option>
                                                    <option value="Baja">Baja</option>
                                                    <option value="Media">Media</option>
                                                    <option value="Alta">Alta</option>
                                                  </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="guardar()">Asignar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-9 columna">
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
            
                // new $.fn.dataTable.FixedHeader( table );

            } );
            
            var arreglo = <?php echo json_encode($ped)?>;

            
            let inicioR = '<?php echo $_SESSION['H_I_REC']?>';

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

                    if (element['U_IV_OPERARIO'] !== '' && element['U_IV_OPERARIO'] !== null) {
                        $("#btn_as").html(`
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" disabled>
                                    Asignado a ${element['U_IV_OPERARIO']}
                                </button>
                        `);
                    }

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


                                if (element['Biologico'] == 'BIOLOGICOS') {
                                    $('#tabla').append(`
                                        <tr class="bio">
                                            <td>
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
                                                <b>${element['CodeBars'] == '' || element['CodeBars'] == 'null' ? "1" : element['CodeBars']}</b>
                                            </td>
                                            
                                        </tr> 
                                    `);
                                }else if (element['TOXICO'] == "Y") {
                                    $('#tabla').append(`
                                        <tr class="tox">
                                            <td>
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
                                                <b>${element['CodeBars'] == '' || element['CodeBars'] == 'null' ? "1" : element['CodeBars']}</b>
                                            </td>
                                            
                                        </tr> 
                                    `);
                                }else {
                                    $('#tabla').append(`
                                        <tr>
                                            <td>
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
                                                <b>${element['CodeBars'] == '' || element['CodeBars'] == 'null' ? "1" : element['CodeBars']}</b>
                                            </td>
                                            
                                        </tr> 
                                    `);
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

            function guardar() {
                let person = $("#operatore").val();
                let priori = $("#prioridad").val();
                if(person == "" && priori == "") {
                    $("#operatore").removeClass('is-invalid');
                    $("#prioridad").removeClass('is-invalid');
                    $("#operatore").addClass('is-invalid');
                    $("#prioridad").addClass('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario',
                        text: 'Selecione Operario y Prioridad.',
                    })
                }else if(person == "" && priori != ""){
                    
                    $("#prioridad").removeClass('is-invalid');
                    $("#operatore").addClass('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario',
                        text: 'Asignar a un operaro.',
                    })
                }else if(person != "" && priori == ""){
                    
                    $("#operatore").removeClass('is-invalid');
                    $("#prioridad").addClass('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'Usuario',
                        text: 'Asignar una prioridad.',
                    })
                }else {
                    $("#Form_asig").submit();
                    $('#Cont_gen').html(`
                        <div class="row">
                            <div class="col-1">
                                <a class="btn btn-outline-dark disabled" ><i class="fas fa-chevron-left"></i></a>
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
                                
                                <div class="row">
                                    <div class="col-12 mb-3 mb-md-0">
                                        <ul class="list-group list-group-flush rounded">
                                            <p class="placeholder-glow">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                            <p class="placeholder-wave">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                            <p class="placeholder-glow">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                            <p class="placeholder-wave">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                            <p class="placeholder-glow">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                            <p class="placeholder-wave">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-9 columna">
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
                                        <div class="d-grid gap-2 py-3" id="guardar" onclick="guardar()">
                                            <button type="button" class="btn btn-dark disabled">
                                                <span class="spinner-border spinner-border-sm"
                                                role="status" aria-hidden="true"></span> guardando...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `) ;
                }
            }
            
        </script>
@endsection