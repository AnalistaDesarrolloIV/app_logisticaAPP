@extends('welcome')
@section('tittle',('Lista Entregas'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10  py-5 px-1 px-sm-5 mt-5 mt-sm-0 opacidad rounded">
                <div class="row justify-content-start mb-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-2 col-sm-2 col-md-1 py-2 py-sm-0">
                                <div style=" float:left;">
                                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample2" aria-expanded="false" aria-controls="collapseWidthExample2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-10 col-sm-10 col-md-11 py-2 py-sm-0">
                                <div>
                                    <div class="collapse collapse-horizontal" id="collapseWidthExample2">
                                        <input class="form-control" type="number" id="b_lista" onkeyup="search()" autofocus  placeholder="Codigo entrega">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-group " id="lista">
                    <!-- @foreach($entregas as $value)
                        <a href="/indexPack/{{$value['DocNum']}}" class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                            <h5 class=" text-center mb-1">{{$value['DocNum']}}-- {{$value['CardName']}}</h5>
                            <p>{{$value['DocDate']}}</p>
                            </div>
                        </a>
                    @endforeach -->
             
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        
        .packing{
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
        @media (max-width: 600px) {
            .opacidad{
                min-height: 48rem;
                max-height: 48rem;
            }
        }
    </style>
@endsection

@section('script')
        <script>
            
            var array = '<?php echo json_encode($entregas)?>';
            
            let pedi = JSON.parse(array);

            function search() {
                
                let busqueda = $('#b_lista').val();
                $('#lista').text('');

                for(let element of pedi) {
                    let elemento = element['DocNum'];
                    let string = String(elemento);
                        if (string.indexOf(busqueda) !== -1) {
                            $('#lista').append(`
                               
                                <a href="/indexPack/${element['DocNum']}" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                    <h5 class=" text-center mb-1">${element['DocNum']}-- ${element['CardName']}</h5>
                                    <p>${element['DocDate']}</p>
                                    </div>
                                </a>
                            `);
                        }
                }
                if ($('#lista').text() == '') {
                    $('#lista').append(`
                        <h3 class="text-center pb-3" style="font-weight: bold; font-size: 35px; color: red;">No existe ningun pedido de mostrador con este codigo</h3>
                    `);
                }
            }
            search();
        </script>
@endsection