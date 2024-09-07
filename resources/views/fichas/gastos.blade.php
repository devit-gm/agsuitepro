@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> FICHA - Gastos</div>

                <div class="card-body">
                    @if($ficha->tipo != 3)
                    <div class="d-grid gap-2 d-md-flex justify-content-end col-sm-12 col-md-8 col-lg-12">
                        <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
                    </div>
                    @endif
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
                                <div class="container mt-3">
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

                                        @foreach ($gastosFicha as $componente)
                                        <table class="table table-bordered table-responsive table-hover">

                                            <tbody>
                                                <tr>
                                                    <th colspan="3" class="align-middle fondo-negro">
                                                        {{ $componente->usuario->name }}
                                                        @if($componente->ticket != "")
                                                        @php
                                                        $ruta = URL::to('/') . '/images/' . $componente->ticket;
                                                        @endphp
                                                        <a href="{{ $ruta }}" target="_blank" class="btn btn-md btn-dark icoDescarga"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                        @endif
                                                    </th>

                                                </tr>
                                                <tr class="">

                                                    <th scope="col-auto">Descripción</th>
                                                    <th scope="col-auto" class="text-center">Precio</th>
                                                    <th scope="col-auto" class="text-center"></th>
                                                </tr>
                                                @php
                                                if($ficha->estado == 0){
                                                $clickable = 'clickable-row';
                                                }else{
                                                $clickable = '';
                                                }
                                                @endphp
                                                <tr class="{{$clickable}}" data-hrefborrar="{{ route('fichas.destroygastos', ['uuid' => $ficha->uuid, 'uuid2' => $componente->uuid]) }}" data-textoborrar="¿Está seguro de eliminar el gasto de la lista?" data-borrable="{{$componente->borrable}}">
                                                    <td class="align-middle">
                                                        {{ $componente->descripcion }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        {{ number_format($componente->precio,2) }} <i class="bi bi-currency-euro">
                                                    </td>

                                                    <td class="align-middle text-center">
                                                        <div class="d-flex justify-content-center">
                                                            @if($ficha->estado == 0)
                                                            <a class="btn btn-sm btn-danger" href="#" onclick="triggerParentClick(event,this);"><i class="bi bi-trash"></i></a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class=" card-footer">
    <form id="ficha-resumen" action="{{ route('fichas.enviar', $ficha->uuid) }}" method="post">
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center justify-content-center">
            @if($ficha->tipo != 3)
            <a class="btn btn-dark mx-1" href={{ route('fichas.servicios', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
            @if($ficha->estado == 0)
            <a class="btn btn-info mx-1" href={{ route('fichas.addgastos', $ficha->uuid) }}><i class="bi bi-plus-circle"></i></a>
            <a class="btn btn-success mx-1" href={{ route('fichas.resumen', $ficha->uuid) }}><i class="bi bi-check-circle"></i></a>
            @else
            <a class="btn btn-dark mx-1" href="{{ route('fichas.resumen', ['uuid'=>$ficha->uuid]) }}"><i class="bi bi-chevron-right"></i></a>
            @endif
            @endif

            @if($ficha->tipo == 3)
            <a class="btn btn-dark mx-1" href={{ route('fichas.index', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
            @if($ficha->estado == 0)
            <a class="btn btn-info mx-1" href={{ route('fichas.addgastos', $ficha->uuid) }}><i class="bi bi-plus-circle"></i></a>
            @endif
            @if(count($gastosFicha)>0 && $ficha->estado == 0)
            <button type="button" onclick="document.getElementById('ficha-resumen').submit();" class="btn btn-success mx-1"><i class="bi bi-send"></i></button>
            @endif
            @endif
        </div>
    </form>
</div>
@endsection