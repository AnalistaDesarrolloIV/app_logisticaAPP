@extends('welcome')
@section('tittle',('Lista productos'))

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12  py-3 px-1 px-sm-5 mt-5 mt-sm-0 opacidad rounded">
                <div class="row">
                    <div class="col-1">
                        <a class="btn btn-outline-dark" href="/logPack" id="volver" ><i class="fas fa-chevron-left"></i></a>
                    </div>
                    <div class="col-11">
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Entrega N° {{$id}}.</h3>
                    </div>
                </div>
                <div class="row justify-content-center pb-3">
                    <div class="col-5">
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="CodeBar"> <i class="fas fa-barcode"></i> </span>
                            <input type="text" class="form-control" placeholder="Codigo de barras" aria-label="Codigo de barras" aria-describedby="CodeBar" id="code_bar" onchange="lector()">
                        </div>
                    </div>
                </div>

                <table id="tbl" class="table table-striped table-bordered nowrap" style="width:100%">
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
                        <!-- @foreach($entrega as $value)  
                        
                            <tr>
                                <td><b>{{$value['CodeBars']}}</b></td>
                                <td>
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" id="boton{{$value['id__']}}" onclick="modal_p()">
                                        <s>{{$value['id__']}}</s>
                                        <b>{{$value['Dscription']}}</b>
                                    </button>
                                </td>
                                
                                <td><b>{{$value['LOTE']}}</b></td>
                                <td><b>{{$value['CantLote']}}</b></td>
                                <td><b>{{$value['Comments']}}</b></td>
                            </tr>                  
                        @endforeach -->
                    </tbody>

                </table>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="contenido">
                    
                    </div>
                    <div class="modal-footer" id="foot">

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
        .conta{
            max-width: 80px;
            min-width: 80px;
            border:solid 1px  black;
            border-radius: 20px;
            padding-left: 10px;
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
            } );
            
            $('#code_bar').focus();
            
            var array = '<?php echo json_encode($entrega)?>';
            
            let arreglo = JSON.parse(array);
            

            for(let element of arreglo) {
                $('#tabla').append(`
                <tr id="fila-${element['id__']}">
                    <td><b>${element['CodeBars']}</b></td>
                    <td>
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" id="boton_m" onclick="modal_p(${element['id__']})">
                            <b>${element['Dscription']}</b>
                        </button>
                    </td>
                    
                    <td><b>${element['LOTE']}</b></td>
                    <td><b>${element['CantLote']}</b></td>
                </tr> 
                `);
            }

            function modal_p(id) {
                $("#contenido").text('');
                $('#foot').text('');
                for(let element of arreglo) {
                    if (element['id__'] == id) {
                        if (element['CantLote'] > 5) {
                            console.log(element['Dscription'])
                            $("#contenido").append(`
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>Codigo de barras:</b> ${element['CodeBars']}</li>
                                    <li class="list-group-item"><b>Producto:</b> ${element['Dscription']}</li>
                                    <li class="list-group-item"><b>Lote:</b> ${element['LOTE']}</li>
                                    <li class="list-group-item"><b>Cantidad:</b> <input type="number" class="conta" id="contador${element['id__']}" value="1"> <b>de</b> ${element['CantLote']}</li>
                                    <li class="list-group-item"><b>Comentarios de empaque:</b> ${element['Comments']}</li>
                                </ul>
                            `);
                            $('#foot').append(`
                                <button type="button"  id="cerrar"  class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="check(${element['id__']})">Guardar</button>
                            `);
                        }else {
                            
                            console.log(element['Dscription'])
                            $("#contenido").append(`
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>Codigo de barras:</b> ${element['CodeBars']}</li>
                                    <li class="list-group-item"><b>Producto:</b> ${element['Dscription']}</li>
                                    <li class="list-group-item"><b>Lote:</b> ${element['LOTE']}</li>
                                    <li class="list-group-item"><b>Cantidad:</b> <input type="number" class="conta" id="contador${element['id__']}" readonly value="1"> <b>de</b> ${element['CantLote']}</li>
                                    <li class="list-group-item"><b>Comentarios de empaque:</b> ${element['Comments']}</li>
                                </ul>
                            `);
                            $('#foot').append(`
                                <button type="button"  id="cerrar"  class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="check(${element['id__']})">Guardar</button>
                            `);
                        }
                    }
                }
            }
            
            function lector() {
                let codigo = $('#code_bar').val();
                console.log(codigo);
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
                }else {

                }

                $('#code_bar').val('');
            }

            function check(id) {

                for(let element of arreglo) {
                    if (element['id__'] == id) {
                        if ($('#contador'+element['id__']).val() == element['CantLote']) {
                            $('#fila-'+id).addClass('table-success');
                            $('#cerrar').click();
                        }else {

                        }
                    }
                }

            }
        </script>
@endsection