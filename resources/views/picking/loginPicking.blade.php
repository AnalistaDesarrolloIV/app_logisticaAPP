@extends('welcome')
@section('tittle',('Recolección'))

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 py-1 py-sm-5 px-1 px-sm-5 mt-5 mt-md-0 opacidad rounded">
                <form action="{{route('loginPick')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col text-center mb-3">
                            <img src="{{url('/')}}/img/login.svg" width="50%" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('documento') is-invalid @enderror" id="doc" placeholder="name@example.com" name="documento" aria-describedby="helpDoc" autofocus>
                                <label for="doc">Usuario <b style="color: red;">*</b></label>
                                <div id="helpDoc" class="form-text">
                                    Ingresar nombre de usuario para iniciar recolección.
                                </div>
                                @error('documento')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>¡Error!</strong> {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-end mb-2">
                        <div class="col-12 col-md-5 pb-3 pb-md-0 d-grid gap-2">
                            <button type="submit" class="btn btn-dark text-white"><i class="fas fa-door-open"></i> Ingresar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .opacidad{
            background: rgba(10, 10, 10, 0.3);
            font-size: larger;
        }
        .picking{
            border-bottom: solid 1px white;
        }
    </style>
@endsection
