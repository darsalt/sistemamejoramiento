<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>Importacion</title>
    <script src="{{asset('js/app.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="flex-center position-ref full-height">
     
    <div class="container mt-5">
        <h3>Importar Cruzamientos</h3>
 
        @if ( $errors->any() )
 
            <div class="alert alert-danger">
                @foreach( $errors->all() as $error )<li>{{ $error }}</li>@endforeach
            </div>
        @endif
 
        @if(isset($numRows))
            <div class="alert alert-sucess">
                Se importaron {{$numRows}} registros.
            </div>
        @endif
 
        <form action="{{route('cruzamientos.import')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col-3">
                    <div class="custom-file">
                        <input type="file" name="cruzamientos" class="custom-file-input" id="cruzamientos">
                        <label class="custom-file-label" for="cruzamientos">Seleccionar archivo</label>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Importar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>