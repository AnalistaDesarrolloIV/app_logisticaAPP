@extends('welcome')
@section('tittle',('Lista Productos'))

@section('content')

    <div class="container">
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
                

                <table id="tbl" class="table table-striped table-bordered nowrap" style="width:100%; min-width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <!-- <th>Codigo pedido</th> -->
                            <th class="text-center">Codigo de barras</th>
                            <th class="text-center">Nombre producto</th>
                            <th class="text-center">Lote</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Comentarios</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: bold;">
                        @foreach($ped as $value)  
                        <tr>
                            <!-- <td>{{$value['BaseRef']}}</td> -->
                            <td><b>{{$value['CodeBars']}}</b></td>
                            <td><b>{{$value['Dscription']}}</b></td>
                            <td><b>{{$value['LOTE']}}</b></td>
                            <td><b>{{$value['CantLote']}}</b></td>
                            <td><b>{{$value['Comments']}}</b></td>
                        </tr>                  
                        @endforeach
                    </tbody>
                </table>
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
            } );
            // $(document).ready(function () {
            //     $('#tbl').DataTable( {
            //         "language": {
            //             "lengthMenu": "Mostrar _MENU_ registros por pagina",
            //             "zeroRecords": "No hay registros por mostrar",
            //             "info": "Mostrando página _PAGE_ de _PAGES_",
            //             "infoEmpty": "No hay registros disponibles",
            //             "infoFiltered": "(filtrado de _MAX_ registros totales)",
            //             "search": "Buscar:",
            //             "paginate": {
            //                 'next': 'Siguiente',
            //                 'previous': 'Anterior'
            //             }
            //         }
            //     }  );
            // });
        </script>
@endsection