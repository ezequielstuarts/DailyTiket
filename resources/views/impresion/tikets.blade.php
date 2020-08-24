<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/bootstrapTable.min.css') }}" rel="stylesheet">
    <title>Imprimir | {{$client->name}} </title>
</head>
<style>
    .table th { padding: 0px;text-align: left; border: red 1px solid }
    .table tr { padding: 0px;text-align: left; border: red 1px solid }
    .table td { padding: 2px;text-align: left; border: red 1px solid }
    .table {border-bottom: 1px solid #000;}
    h2 { color: red;padding-right: 0px;margin-right: 0;}

</style>
<body style="padding-left: 30px;width: 90%">
    <div class="row">
        <h2>Cliente: {{$client->name}} </h2>
    </div>

    <div class="row">
        <h4>Tikets generados: {{$Cantidadtikets}} | Total: $ {{$total}} </h4>
        <table class="table-bordered"  style="width:300px">
            <thead>
              <tr>
                <th style="text-align: left" >#</th>
                <th style="text-align: left" >Monto</th>
                <th style="text-align: left" >Fecha</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($client->tikets as $tiket)
                <tr>
                  <td>{{$tiket->id}}</td>
                  <td>$ {{$tiket->amount}}</td>
                  <td>{{$tiket->created_at->format('d-m-Y')}}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <p>Fin de listado. {{$Cantidadtikets}} Tikets | Total: $ {{$total}}</p>
</body>
</html>