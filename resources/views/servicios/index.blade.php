@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-tools"></i> {{ __('Services') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
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
                                <table class="table table-bordered table-responsive table-hover">
                                    <thead>
                                        <tr class="">
                                            <th scope="col-auto text-center" style="width: 90px; text-align:center">#</th>
                                            <th scope="col-auto">{{ __('Nombre') }}</th>
                                            <th scope="col-auto">{{ __('Precio') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicios as $servicio)
                                        <tr class="clickable-row" data-href="{{ route('servicios.edit', $servicio->uuid) }}" data-hrefborrar="{{ route('servicios.destroy', $servicio->uuid) }}" data-textoborrar="{{ __('¿Está seguro de eliminar el servicio?') }}" data-borrable="{{$servicio->borrable}}">
                                            <td class="align-middle text-center">
                                                <span style="display: inline-block; min-width: 36px; height: 36px; line-height: 36px; border-radius: 50%; background: #dc3545; color: #fff; font-weight: bold; font-size: 1.1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                                                    {{ $servicio->numero }}
                                                </span>
                                            </td>

                                            <td class="align-middle">
                                                {{ $servicio->nombre }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $servicio->precio }}€
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                            @if (Auth::user()->role_id < 4) <a href="{{ route('servicios.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
                                @endif
                        </div>
                    </form>
                </div>	
@endsection