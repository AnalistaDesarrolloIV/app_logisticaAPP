@extends('welcome')
@section('tittle',('Lista Pedidos'))

@section('content')

    <div class="container-fluid mx-3" id="content">
        <div class="row mt-4 mb-3">
            <div class="col-12 mt-4 cont_head">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-light tbl" style="width:100%;">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">N° Pedidos asignados</th>
                                <th class="text-center">P. Alta <small><i class="fas fa-circle text-danger"></i></small></th>
                                <th class="text-center">P. Media <small><i class="fas fa-circle text-warning"></i></small></th>
                                <th class="text-center">P. Baja <small><i class="fas fa-circle text-success"></i></small></th>
                                <th class="text-center">N° Biologicos Asignados</th>
                                <th class="text-center">Total Lineas</th>
                                <th class="text-center">Total Unidades</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: bold;" id="tbl_admin">
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-10">
                {{-- <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px;">Filtros</h3> --}}
                <div class="row justify-content-around">
                    <div class="col-12 col-md-4">
                        <label for="us">Por Operador: </label>
                        <select class="form-select select2" id="us" aria-label="Default select example" onchange="filtros()">
                            <option selected value="">Todos</option>
                            <option value="sin">Sin asignar</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="prior">Por prioridad: </label>
                        <select class="form-select select2" id="prior" aria-label="Default select example" onchange="filtros()">
                            <option selected value="">Seleccione</option>
                            <option value="Baja">Baja</option>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 cont_head">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover nowrap table-light tbl" style="width:100%; min-width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">N° Pedido</th>
                                <th class="text-center">N° De lineas</th>
                                <th class="text-center">N° de unidades</th>
                                <th class="text-center">Municipio</th>
                                <th class="text-center">Comentarios</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Asignado A</th>
                                <th class="text-center">Prioridad</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: bold;" id="tblPed_admin">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Modal --}}
        <div class="modal fade" id="Modal_asignacion" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="titulo">Formulario de asignación</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <form action="{{route('storeAsign')}}" method="post" id="Form_asig">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="DL" id="DL">
                        <div class="row">
                            <div class="col-md-6">
                                <lable class="form-label" for="operatore">Operador</lable>
                                <select class="form-select select2" id="operatore" aria-label="Default select example" name="operatore">
                                    <option selected value="">Seleccione</option>
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
                                    <option selected value="">Seleccione</option>
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
        .cont_head{
            overflow: hidden;
            overflow-y: auto;
            min-height: 10rem;
            max-height: 30rem;
        }
        .cont_head::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .cont_head::-webkit-scrollbar:vertical {
            width:10px;
        }

        .cont_head::-webkit-scrollbar-button:increment,.cont_head::-webkit-scrollbar-button {
            display: none;
        } 

        .cont_head::-webkit-scrollbar:horizontal {
            height: 10px;
        }

        .cont_head::-webkit-scrollbar-thumb {
            background-color: #797979;
            border-radius: 20px;
            border: 2px solid #989898;
        }

        .cont_head::-webkit-scrollbar-track {
            border-radius: 10px;  
        }
        .btn_list{
            cursor: pointer;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>

    <script>
        
        $(document).ready(function() {
                var table = $('.tbl').DataTable( {
                    responsive: false,
                    "language": { 
                        "lengthMenu": "Mostrar"+ `
                            <select class="custom-select custom-select-sm form-select form-select-sm">
                                <option value="50">50</option>    
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
            

        var arreglo = <?php echo json_encode($pedido)?>;

        var biologicos = <?php echo json_encode($pedido_bio)?>;

        
        var session = '<?php echo $_SESSION['B1SESSION']?>';
        
        var DE = <?php echo json_encode($datExtra)?>;

        let numeros = [];
        
        for(let bio of biologicos) {
            numeros.push(bio['BaseRef']); 
        }

        var usuarios = <?php echo json_encode($user)?>;

        for(let U_P of usuarios) {
            let codigo = U_P['Code'];
            let contP = 0;
            let contAlt = 0;
            let contMB = 0;
            let contBJ = 0;
            let contBIO = 0;
            let contLT = 0;
            let contUT = 0;
            for(let element of arreglo) {
                let ped = element['BaseRef'];
                let cod_ped = element['U_IV_OPERARIO'];
                let estado = element['U_IV_ESTA'];
                if (cod_ped == codigo) {
                    contP+=1;
                    if (element['U_IV_Prioridad'] == 'Alta') {
                        contAlt+=1;
                    }else if(element['U_IV_Prioridad'] == 'Media'){
                        contMB+=1;
                    }else if(element['U_IV_Prioridad'] == 'Baja'){
                        contBJ+=1;
                    }
                    for(let de of DE) {
                        if (ped == de['BaseRef']) {
                            contLT+=Math.trunc(de['Cant_Linea']);
                            contUT+=Math.trunc(de['Cant_Unidades']);
                        }
                    }
                    for(let bio of biologicos) {
                        if (ped == bio['BaseRef']) {
                            contBIO+=1;
                        }
                    }
                }
            }
            
            if (contP > 0) {
                $("#tbl_admin").append(`
                    <tr>
                        <td class="text-center">${codigo}</td>
                        <td class="text-center">${contP}</td>
                        <td class="text-center">${contAlt}</td>
                        <td class="text-center">${contMB}</td>
                        <td class="text-center">${contBJ}</td>
                        <td class="text-center">${contBIO}</td>
                        <td class="text-center">${contLT}</td>
                        <td class="text-center">${contUT}</td>
                    </tr>
                `);
            }

            $("#us").append(`
                <option value="${codigo}">${codigo}</option>
            `);

        }

        function filtros() {
            let select = $('#us option:selected').val();
            let prioridad = $('#prior option:selected').val();
            let sel = '';
            if (select == 'sin') {
                sel = "sin asignar"
            }else {
                sel = select;
            }
            if (select == '' && prioridad == '') {
                $('#tblPed_admin').text('');
                for(let element of arreglo) {
                    let incluye = numeros.includes(element['BaseRef']);
                    let elemento = element['BaseRef'];
                    let string = String(elemento);
                    let long = string.length;
                    let inicial = string.substring(1, -long);
                    if(inicial == 7) {
                        if (!incluye) {
                            for(let extra of DE) {

                                if (element['BaseRef'] == extra['BaseRef']) {
                                    let ope ='';
                                    let prio = element['U_IV_Prioridad'];
                                    if (element['U_IV_OPERARIO'] == null || element['U_IV_OPERARIO'] == '') {
                                        ope = "sin asignar";
                                    }else {
                                        ope = element['U_IV_OPERARIO'];
                                    }
                                    let unidades = Math.trunc(extra['Cant_Unidades']);
                                    $('#tblPed_admin').append(`
                                        <tr>
                                            
                                            <td class="text-center">${element['CardName']}</td>
                                            <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${element['BaseRef']}, ${element['DocEntry']})">${element['BaseRef']}</button> </td>
                                            <td class="text-center">${extra['Cant_Linea']}</td>
                                            <td class="text-center">${unidades}</td>
                                            <td class="text-center">${element['Municipio_Ciudad']}</td>
                                            <td class="text-center">${extra['Comments']}</td>
                                            <td class="text-center">${element['U_IV_ESTA']}</td>
                                            <td class="text-center">
                                                <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'} 
                                                data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${element['BaseRef']}, ${element['DocEntry']})">${ope}</button>
                                            </td>
                                            <td class="text-center">
                                                <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                            </td>
                                        </tr>
                                    `);
                                }
                            }
                        }
                    }
                }
                
                // $('#tblPed_admin').append(`
                //     <tr class="table-dark">
                //         <td class="text-center" colspan="8">Con Biologicos</td>
                //     </tr>
                // `);

                for(let bio of biologicos) {
                    for(let extra of DE) {
                        let ope ='';
                        let prio = bio['U_IV_Prioridad'];
                        if (bio['U_IV_OPERARIO'] == null || bio['U_IV_OPERARIO'] == '') {
                            ope = "sin asignar";
                        }else {
                            ope = bio['U_IV_OPERARIO'];
                        }
                        let elementobio = bio['BaseRef'];
                        let string = String(elementobio);
                        let longbio = string.length;
                        let inicial = string.substring(1, -longbio);
                        
                        if(inicial == 7) {
                            if (bio['BaseRef'] == extra['BaseRef']) {
                                let unidades = Math.trunc(extra['Cant_Unidades']);
                                $('#tblPed_admin').append(`
                                    <tr class="table-warning">
                                        <td class="text-center">${bio['CardName']}</td>
                                        <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${bio['BaseRef']}, ${bio['DocEntry']})">${bio['BaseRef']}</button></td>
                                        <td class="text-center">${extra['Cant_Linea']}</td>
                                        <td class="text-center">${unidades}</td>
                                        <td class="text-center">${bio['Municipio_Ciudad']}</td>
                                        <td class="text-center">${extra['Comments']}</td>
                                            <td class="text-center">${bio['U_IV_ESTA']}</td>
                                        <td class="text-center">
                                            <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'}
                                            data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${bio['BaseRef']}, ${bio['DocEntry']})">${ope}</button>
                                        </td>
                                        <td class="text-center">
                                            <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                        </td>
                                    </tr>
                                `);
                            }
                        }
                    }
                }
            }else if(select == '' && prioridad != '')  {
                $('#tblPed_admin').text('');
                for(let element of arreglo) {
                    let incluye = numeros.includes(element['BaseRef']);
                    let elemento = element['BaseRef'];
                    let string = String(elemento);
                    let long = string.length;
                    let inicial = string.substring(1, -long);
                    if(inicial  == 7) {
                        if (!incluye) {
                            for(let extra of DE) {

                                if (element['BaseRef'] == extra['BaseRef']) {
                                    let ope ='';
                                    let prio = element['U_IV_Prioridad'];
                                    if (element['U_IV_OPERARIO'] == null || element['U_IV_OPERARIO'] == '') {
                                        ope = "sin asignar";
                                    }else {
                                        ope = element['U_IV_OPERARIO'];
                                    }
                                    if (prioridad == prio) {
                                        let unidades = Math.trunc(extra['Cant_Unidades']);
                                        $('#tblPed_admin').append(`
                                            <tr>
                                                
                                                <td class="text-center">${element['CardName']}</td>
                                                <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${element['BaseRef']}, ${element['DocEntry']})">${element['BaseRef']}</button></td>
                                                <td class="text-center">${extra['Cant_Linea']}</td>
                                                <td class="text-center">${unidades}</td>
                                                <td class="text-center">${element['Municipio_Ciudad']}</td>
                                                <td class="text-center">${extra['Comments']}</td>
                                                <td class="text-center">${element['U_IV_ESTA']}</td>
                                                <td class="text-center">
                                                    <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'} 
                                                    data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${element['BaseRef']}, ${element['DocEntry']})">${ope}</button>
                                                </td>
                                                <td class="text-center">
                                                    <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                                </td>
                                            </tr>
                                        `);
                                    }
                                }
                            }
                        }
                    }
                }
                
                // $('#tblPed_admin').append(`
                //     <tr class="table-dark">
                //         <td class="text-center" colspan="8">Con Biologicos</td>
                //     </tr>
                // `);

                for(let bio of biologicos) {
                    for(let extra of DE) {
                        let ope ='';
                        let prio = bio['U_IV_Prioridad'];
                        if (bio['U_IV_OPERARIO'] == null || bio['U_IV_OPERARIO'] == '') {
                            ope = "sin asignar";
                        }else {
                            ope = bio['U_IV_OPERARIO'];
                        }
                        if (prioridad == prio) {
                            let elementobio = bio['BaseRef'];
                            let string = String(elementobio);
                            let longbio = string.length;
                            let inicial = string.substring(1, -longbio);
                            
                            if(inicial  == 7) {
                                if (bio['BaseRef'] == extra['BaseRef']) {
                                    let unidades = Math.trunc(extra['Cant_Unidades']);
                                    $('#tblPed_admin').append(`
                                        <tr class="table-warning">
                                            <td class="text-center">${bio['CardName']}</td>
                                            <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${bio['BaseRef']}, ${bio['DocEntry']})">${bio['BaseRef']}</button></td>
                                            <td class="text-center">${extra['Cant_Linea']}</td>
                                            <td class="text-center">${unidades}</td>
                                            <td class="text-center">${bio['Municipio_Ciudad']}</td>
                                            <td class="text-center">${extra['Comments']}</td>
                                            <td class="text-center">${bio['U_IV_ESTA']}</td>
                                            <td class="text-center">
                                                <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'} 
                                                data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${bio['BaseRef']}, ${bio['DocEntry']})">${ope}</button>
                                            </td>
                                            <td class="text-center">
                                                <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                            </td>
                                        </tr>
                                    `);
                                }
                            }
                        }
                    }
                }
            }else if(prioridad == '' && select != ''){
                
                $('#tblPed_admin').text('');
                for(let element of arreglo) {
                    let incluye = numeros.includes(element['BaseRef']);
                    if (!incluye) {
                        for(let extra of DE) {
                            if (element['BaseRef'] == extra['BaseRef']) {
                                let ope ='';
                                let prio = element['U_IV_Prioridad'];
                                if (element['U_IV_OPERARIO'] == null || element['U_IV_OPERARIO'] == '') {
                                    ope = "sin asignar";
                                }else {
                                    ope = element['U_IV_OPERARIO'];
                                }
                                if (ope == sel) {
                                    let unidades = Math.trunc(extra['Cant_Unidades']);
                                    
                                    let elemento = element['BaseRef'];
                                    let string = String(elemento);
                                    let long = string.length;
                                    let inicial = string.substring(1, -long);
                                    if(inicial == 7) {
                                        $('#tblPed_admin').append(`
                                            <tr>
                                                
                                                <td class="text-center">${element['CardName']}</td>
                                                <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${element['BaseRef']}, ${element['DocEntry']})">${element['BaseRef']}</button></td>
                                                <td class="text-center">${extra['Cant_Linea']}</td>
                                                <td class="text-center">${unidades}</td>
                                                <td class="text-center">${element['Municipio_Ciudad']}</td>
                                                <td class="text-center">${extra['Comments']}</td>
                                                <td class="text-center">${element['U_IV_ESTA']}</td>
                                                <td class="text-center">
                                                    <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'}
                                                    data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${element['BaseRef']}, ${element['DocEntry']})">${ope}</button>
                                                </td>
                                                <td class="text-center">
                                                    <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                                </td>
                                            </tr>
                                        `);
                                    }
                                }
                            }
                        }
                    }
                }
                
                // $('#tblPed_admin').append(`
                //     <tr class="table-dark">
                //         <td class="text-center" colspan="8">Con Biologicos</td>
                //     </tr>
                // `);

                for(let bio of biologicos) {
                    for(let extra of DE) {
                        let ope ='';
                        let prio = bio['U_IV_Prioridad'];
                        if (bio['U_IV_OPERARIO'] == null || bio['U_IV_OPERARIO'] == '') {
                            ope = "sin asignar";
                        }else {
                            ope = bio['U_IV_OPERARIO'];
                        }
                        if (ope == sel) {
                            let elementobio = bio['BaseRef'];
                            let string = String(elementobio);
                            let longbio = string.length;
                            let inicial = string.substring(1, -longbio);
                            if(inicial  == 7) {
                                if (bio['BaseRef'] == extra['BaseRef']) {
                                    let unidades = Math.trunc(extra['Cant_Unidades']);
                                    $('#tblPed_admin').append(`
                                        <tr class="table-warning">
                                            <td class="text-center">${bio['CardName']}</td>
                                            <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${bio['BaseRef']}, ${bio['DocEntry']})">${bio['BaseRef']}</button></td>
                                            <td class="text-center">${extra['Cant_Linea']}</td>
                                            <td class="text-center">${unidades}</td>
                                            <td class="text-center">${bio['Municipio_Ciudad']}</td>
                                            <td class="text-center">${extra['Comments']}</td>
                                            <td class="text-center">${bio['U_IV_ESTA']}</td>
                                            <td class="text-center">
                                                <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'}
                                                data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${bio['BaseRef']}, ${bio['DocEntry']})">${ope}</button>
                                            </td>
                                            <td class="text-center">
                                                <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                            </td>
                                        </tr>
                                    `);
                                }
                            }
                        }
                    }
                }
            }else {
                $('#tblPed_admin').text('');
                for(let element of arreglo) {
                    let incluye = numeros.includes(element['BaseRef']);
                    if (!incluye) {
                        for(let extra of DE) {

                            if (element['BaseRef'] == extra['BaseRef']) {
                                let ope ='';
                                let prio = element['U_IV_Prioridad'];
                                if (element['U_IV_OPERARIO'] == null || element['U_IV_OPERARIO'] == '') {
                                    ope = "sin asignar";
                                }else {
                                    ope = element['U_IV_OPERARIO'];
                                }
                                if (ope == sel && prioridad == prio) {
                                    let unidades = Math.trunc(extra['Cant_Unidades']);
                                    let elemento = element['BaseRef'];
                                    let string = String(elemento);
                                    let long = string.length;
                                    let inicial = string.substring(1, -long);
                                    if(inicial == 7) {
                                        $('#tblPed_admin').append(`
                                            <tr>
                                                
                                                <td class="text-center">${element['CardName']}</td>
                                                <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${element['BaseRef']}, ${element['DocEntry']})">${element['BaseRef']}</button></td>
                                                <td class="text-center">${extra['Cant_Linea']}</td>
                                                <td class="text-center">${unidades}</td>
                                                <td class="text-center">${element['Municipio_Ciudad']}</td>
                                                <td class="text-center">${extra['Comments']}</td>
                                                <td class="text-center">${element['U_IV_ESTA']}</td>
                                                <td class="text-center">
                                                    <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'}
                                                    data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${element['BaseRef']}, ${element['DocEntry']})">${ope}</button>
                                                </td>
                                                <td class="text-center">
                                                    <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                                </td>
                                            </tr>
                                        `);
                                    }
                                }
                            }
                        }
                    }
                }
                
                // $('#tblPed_admin').append(`
                //     <tr class="table-dark">
                //         <td class="text-center" colspan="8">Con Biologicos</td>
                //     </tr>
                // `);

                for(let bio of biologicos) {
                    for(let extra of DE) {
                        let ope ='';
                        let prio = bio['U_IV_Prioridad'];
                        if (bio['U_IV_OPERARIO'] == null || bio['U_IV_OPERARIO'] == '') {
                            ope = "sin asignar";
                        }else {
                            ope = bio['U_IV_OPERARIO'];
                        }
                        if (ope == sel && prioridad == prio) {
                            let elementobio = bio['BaseRef'];
                            let string = String(elementobio);
                            let longbio = string.length;
                            let inicial = string.substring(1, -longbio);
                            
                            if(inicial  == 7) {
                                if (bio['BaseRef'] == extra['BaseRef']) {
                                    let unidades = Math.trunc(extra['Cant_Unidades']);
                                    $('#tblPed_admin').append(`
                                        <tr class="table-warning">
                                            <td class="text-center">${bio['CardName']}</td>
                                            <td class="text-center"><button class="btn btn-outline-dark" onclick="modal(${bio['BaseRef']}, ${bio['DocEntry']})">${bio['BaseRef']}</button></td>
                                            <td class="text-center">${extra['Cant_Linea']}</td>
                                            <td class="text-center">${unidades}</td>
                                            <td class="text-center">${bio['Municipio_Ciudad']}</td>
                                            <td class="text-center">${extra['Comments']}</td>
                                            <td class="text-center">${bio['U_IV_ESTA']}</td>
                                            <td class="text-center">
                                                <button ${ope == "sin asignar" ? 'class="btn btn-outline-danger"' : 'class="btn btn-outline-success"'}
                                                data-bs-toggle="modal" data-bs-target="#Modal_asignacion" onclick="openModal(${bio['BaseRef']}, ${bio['DocEntry']})">${ope}</button>
                                            </td>
                                            <td class="text-center">
                                                <span ${prio == "Baja" ? 'class="badge rounded-pill bg-success"' : prio == "Media" ? 'class="badge rounded-pill bg-warning"' : 'class="badge rounded-pill bg-danger"'}>${prio}</span>
                                            </td>
                                        </tr>
                                    `);
                                }
                            }
                        }
                    }
                }
            }

        }
        filtros();

        function openModal(id, Dl) {
            $("#id").val(id);
            $("#DL").val(Dl);
        }

        function modal(cod_ped, DL) {
            let url = 'formAsi/'+cod_ped+'/'+DL;
            $(location).attr('href', url);
            $('#content').html(`
                <div class="row mt-5 mb-3">
                    <div class="col-12 mt-4 cont_head">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-light" style="width:100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">N° Pedidos asignados</th>
                                        <th class="text-center">P Alta <small><i class="fas fa-circle text-danger"></i></small></th>
                                        <th class="text-center">P Media <small><i class="fas fa-circle text-warning"></i></small></th>
                                        <th class="text-center">P Baja <small><i class="fas fa-circle text-success"></i></small></th>
                                        <th class="text-center">N° Biologicos Asignados</th>
                                        <th class="text-center">Total Lineas</th>
                                        <th class="text-center">Total Unidades</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: bold;">
                                    <tr>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mb-3">
                    <div class="col-10">
                        <div class="row justify-content-around">
                            <div class="col-12 col-md-4">
                                <label for="us">Por Operador: </label>
                                <select class="form-select " id="us" aria-label="Disabled  select example" onchange="filtros()">
                                    <option selected value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="prior">Por prioridad: </label>
                                <select class="form-select " id="prior" aria-label="Disabled  select example" onchange="filtros()">
                                    <option selected value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 cont_head">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover nowrap table-light" style="width:100%; min-width: 100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">N° Pedido</th>
                                        <th class="text-center">N° De lineas</th>
                                        <th class="text-center">N° de unidades</th>
                                        <th class="text-center">Municipio</th>
                                        <th class="text-center">Comentarios</th>
                                        <th class="text-center">Asignado A</th>
                                        <th class="text-center">Prioridad</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: bold;">
                                    <tr>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `);
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
                $('#content').html(`
                    <div class="row mt-5 mb-3">
                        <div class="col-12 mt-4 cont_head">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-light" style="width:100%;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">N° Pedidos asignados</th>
                                            <th class="text-center">P Alta <small><i class="fas fa-circle text-danger"></i></small></th>
                                            <th class="text-center">P Media <small><i class="fas fa-circle text-warning"></i></small></th>
                                            <th class="text-center">P Baja <small><i class="fas fa-circle text-success"></i></small></th>
                                            <th class="text-center">N° Biologicos Asignados</th>
                                            <th class="text-center">Total Lineas</th>
                                            <th class="text-center">Total Unidades</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: bold;">
                                        <tr>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <div class="col-10">
                            <div class="row justify-content-around">
                                <div class="col-12 col-md-4">
                                    <label for="us">Por Operador: </label>
                                    <select class="form-select " id="us" aria-label="Disabled  select example" onchange="filtros()">
                                        <option selected value="">Todos</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="prior">Por prioridad: </label>
                                    <select class="form-select " id="prior" aria-label="Disabled  select example" onchange="filtros()">
                                        <option selected value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 cont_head">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover nowrap table-light" style="width:100%; min-width: 100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">N° Pedido</th>
                                            <th class="text-center">N° De lineas</th>
                                            <th class="text-center">N° de unidades</th>
                                            <th class="text-center">Municipio</th>
                                            <th class="text-center">Comentarios</th>
                                            <th class="text-center">Asignado A</th>
                                            <th class="text-center">Prioridad</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: bold;">
                                        <tr>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-wave"><span class="placeholder col-12"></span></p></td>
                                            <td class="text-center"><p class="placeholder-glow"><span class="placeholder col-12"></span></p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `) ;
            }
        }

        setInterval("location.reload()",180000);
    </script>

@endsection
