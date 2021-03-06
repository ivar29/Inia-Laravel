@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Publicación: 
          @if($resumen != null)
            {{$resumen->publicacion->mes->nombre ?: '-' }} - {{ $resumen->publicacion->año ?: '-'}}
          @else 
            No se ha asignado una publicación 
          @endif</div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          @can('resumen.show')
          <strong>RESUMEN EJECUTIVO</strong>
          <hr>

          <table class="table table-striped table-hover table-bordered" width="100%">
            <thead>
              <tr>
                <!--<th width="10px">ID</th>-->
                <th>Mes</th>
                <th>Año</th>
                <th colspan="2" width="30%"><center>Opciones</center></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                @if($resumen != null)
                <td>{{ $resumen->publicacion->mes->nombre ?: '-'}}</td>
                <td>{{ $resumen->publicacion->año ?: '-'}}</td>
                @can('resumen.show')
                <td style="text-align: center;">
                    <a href="{{ route('resumenes.show', encrypt($resumen->id)) }}"
                    class="btn btn-sm btn-primary">Ver</a>
                </td>
                @endcan
                  
                    <td style="text-align: center;">
                      <a href="{{ route('resumenespdf', $resumen->id) }}"
                         class="btn btn-sm btn-warning"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
                    </td>
                 
                @endif

              </tr>
            </tbody>
          </table>
          @endcan
          <strong>BOLETINES</strong>
          <hr>
          <table class="table table-striped table-hover table-bordered" width="100%">
            <thead>
              <tr>
                <th>Región</th>
                <th>Estado</th>
                <th colspan="2" width="30%"><center>Opciones</center></th>
              </tr>
            </thead>
            <tbody>
              @if($userBoletines !=null)
              @foreach($userBoletines as $boletin)
              <tr>

                <td>{{ $boletin->region->name }} </td>
                @if($boletin->estado == 1)
                  <td style="background-color: #e6ffe6; text-align: center;">
                    Abierto
                  </td>
                @else
                  <td style="background-color: #ffcccc; text-align: center;">
                    Cerrado
                  </td>
                @endif

                <td style="text-align: center;">
                  <a href="{{ route('boletines.show', encrypt($boletin->id)) }}"
                  class="btn btn-sm btn-primary">Ver</a>
                </td>
                  @if($rol->id ==2 || $rol->id == 1)
                    <td style="text-align: center;">
                      <a href="{{ route('boletines.pdfTemplate', $boletin->id) }}"
                         class="btn btn-sm btn-warning"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
                    </td>
                    @else
                  @endif
              </tr>
              @endforeach
              @else
              @endif
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
