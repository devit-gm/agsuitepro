@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-tools"></i> {{ __('Services') }}</div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">
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
                                            <th scope="col-auto">Nombre</th>
                                            <th scope="col-auto">Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicios as $servicio)
                                        <tr class="clickable-row" data-href="{{ route('servicios.edit', $servicio->uuid) }}" data-hrefborrar="{{ route('servicios.destroy', $servicio->uuid) }}" data-textoborrar="¿Está seguro de eliminar el servicio?" data-borrable="{{$servicio->borrable}}">
                                            <td class="align-middle">
                                                <div class="fondo-calendario">
                                                    <p style="padding-top:22px">
                                                        <span style="clear: both;display: block; margin-top: 8px;">{{ $servicio->numero }}</span>
                                                    </p>
                                                </div>
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
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            @if (Auth::user()->role_id < 4) <a href="{{ route('servicios.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection