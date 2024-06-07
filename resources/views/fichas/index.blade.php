@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> {{ __('Tokens') }}</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                        @if (Auth::user()->hasRole('Administrador'))
                        <a class="btn btn-lg btn-success fs-3" href={{ route('fichas.create') }}><i class="bi bi-plus-circle"></i> Nueva Ficha</a>
                        @endif
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row">
                            @if ($errors->any())
                            <div class="custom-error-container" id="custom-error-container">
                                <ul class="custom-error-list">
                                    @foreach ($errors->all() as $error)
                                    <li class="custom-error-item">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (session('success'))
                            <div class="custom-success-container" id="custom-success-container">
                                <ul class="custom-success-list">
                                    <li class="custom-success-item">{{ session('success') }}</li>
                                </ul>
                            </div>
                            @endif
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto" style="width:90px">Fecha</th>
                                        <th scope="col-auto">Usuario</th>
                                        <th scope="col-auto">Importe</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fichas as $ficha)
                                    <tr class="clickable-row" data-href="{{ route('fichas.edit', ['uuid'=>$ficha->uuid]) }}" data-hrefborrar="{{ route('fichas.destroy', $ficha->uuid) }}" data-textoborrar="¿Está seguro de eliminar la ficha?" data-borrable="{{$ficha->borrable}}">
                                        <td class="align-middle">
                                            <div class="fondo-calendario">
                                                <p style="padding-top:22px">
                                                    <span style="font-size:0.8em; text-transform:uppercase"><b>{{ $ficha->mes }}</b></span>
                                                    <span style="clear: both;display: block; margin-top: -8px;">{{ \Carbon\Carbon::parse($ficha->fecha)->format('j') }}</span>
                                                </p>
                                            </div>

                                        </td>


                                        <td class="align-middle">
                                            {{ $ficha->usuario->name }}
                                            <br />
                                            @if ($ficha->tipo == 1)
                                            <span class="badge bg-secondary">Individual</span>
                                            @elseif($ficha->tipo == 2)
                                            <span class="badge bg-secondary">Conjunta</span>
                                            @elseif($ficha->tipo == 3)
                                            <span class="badge bg-secondary">Compra</span>
                                            @elseif($ficha->tipo == 4)
                                            <span class="badge bg-secondary">Evento</span>
                                            @endif
                                            <br />
                                            @if ($ficha->estado == 0)
                                            <span class="badge btn bt-sm btn-primary">Abierta</span>
                                            @elseif ($ficha->estado == 1)
                                            <span class="badge btn bt-sm btn-info color-negro">Cerrada</span>
                                            @endif

                                        </td>
                                        <td class="align-middle">
                                            {{ number_format($ficha->precio,2) }} €
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection