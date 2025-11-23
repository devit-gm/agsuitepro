@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> {{ $ajustes->modo_operacion === 'mesas' ? __('Mesa - Resumen') : __('Ficha - Resumen') }}</div>

                <div class="card-body">
                    <div class="container-fluid" style="padding:0px;">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="ficha-resumen" action="{{ fichaRoute('enviar', $ficha->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <table class="table table-borderless shadow-sm rounded overflow-hidden">
    <tbody>
        @if($ficha->tipo != 3)
        <tr class="bg-light">
            <th scope="row" class="fw-semibold text-secondary">{{ __('Total consumos') }}</th>
            <td class="text-end">
                {{ number_format($ficha->total_consumos,2) }} 
                <i class="bi bi-currency-euro"></i>
            </td>
        </tr>

        <tr>
            <th scope="row" class="fw-semibold text-secondary">{{ __('Total servicios') }}</th>
            <td class="text-end">
                {{ number_format($ficha->total_servicios,2) }} 
                <i class="bi bi-currency-euro"></i>
            </td>
        </tr>
        @endif

        @if(!isset($ajustes->modo_operacion) || $ajustes->modo_operacion == 'fichas' || (isset($ajustes->mostrar_gastos) && $ajustes->mostrar_gastos == 1))
        <tr class="bg-light">
            <th scope="row" class="fw-semibold text-secondary">{{ __('Total gastos') }}</th>
            <td class="text-end">
                {{ number_format($ficha->total_gastos,2) }} 
                <i class="bi bi-currency-euro"></i>
            </td>
        </tr>
        @endif

        @if($ficha->tipo != 3)
        <tr>
            <th scope="row" class="fw-semibold text-secondary" style="vertical-align:middle;">
                {{ __('Comensales') }}
                @if(!isset($ajustes->modo_operacion) || $ajustes->modo_operacion == 'fichas')
                <br>
                <span class="text-muted small">({{ __('No incluye niños') }})</span>
                @endif
            </th>
            <td class="text-end">{{ $ficha->total_comensales }}</td>
        </tr>

        <tr class="bg-light" style="border-top: 1px solid #e5e5e5;">
            <th scope="row" class="fw-semibold text-secondary">{{ __('Total / comensal') }}</th>
            <td class="text-end">
                {{ number_format($ficha->precio_comensal,2) }} 
                <i class="bi bi-currency-euro"></i>
            </td>
        </tr>

        <tr style="border-top: 1px solid #e5e5e5;">
    <th scope="row" class="fw-semibold text-dark">
        {{ $ajustes->modo_operacion === 'mesas' ? __('TOTAL MESA') : __('TOTAL FICHA') }}
    </th>
    <td class="fw-semibold text-end text-dark">
        {{ number_format($ficha->precio,2) }}
        <i class="bi bi-currency-euro"></i>
    </td>
</tr>
        @endif
    </tbody>
</table>

                                </form>
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
<div class="card-footer">
    <form>
        <div class="d-flex align-items-center justify-content-center">
            @if(!isset($ajustes->modo_operacion) || $ajustes->modo_operacion == 'fichas' || (isset($ajustes->mostrar_gastos) && $ajustes->mostrar_gastos == 1))
            <a class="btn btn-dark mx-1" href={{ fichaRoute('gastos', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
            @else
            <a class="btn btn-dark mx-1" href={{ fichaRoute('servicios', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
            @endif
            
            @if(isset($ajustes->modo_operacion) && $ajustes->modo_operacion == 'mesas')
                {{-- En modo mesas, siempre mostrar el botón para volver al grid --}}
                <a href="{{ route('mesas.index') }}" class="btn btn-success mx-1"><i class="bi bi-grid-3x3-gap"></i></a>
            @elseif(($ficha->precio>0 || ($ficha->tipo == 3 && $ficha->gastos > 0)) && $ficha->estado == 0)
                {{-- En modo fichas, solo mostrar el botón de enviar si hay importe --}}
                <button type="button" onclick="document.getElementById('ficha-resumen').submit();" class="btn btn-success mx-1"><i class="bi bi-send"></i></button>
            @endif
        </div>
    </form>
</div>
@endsection