@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> FICHA - Servicios</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-end col-sm-12 col-md-8 col-lg-12">
                        <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">


                                <form id='editar-serviciosficha' action="{{ route('fichas.updateservicios', $ficha->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')
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
                                            <table class="table table-bordered table-responsive table-hover">
                                                <thead>
                                                    <tr class="">
                                                        <th scope="col-auto">Servicio</th>
                                                        <th scope="col-auto">Precio</th>
                                                        <th scope="col-auto">Añadir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($serviciosFicha as $servicio)
                                                    <tr style="height: 80px;">
                                                        <td class="align-middle">
                                                            {{ $servicio->nombre }}
                                                        </td>

                                                        <td class="align-middle">
                                                            {{ number_format($servicio->precio,2) }} <i class="bi bi-currency-euro">
                                                        </td>
                                                        <td class="align-middle col-md-4">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" name="servicios[]" value="{{ $servicio->uuid }}" id="servicios[]" @if($servicio->marcado == 1) checked @endif @if($ficha->estado == 1) disabled @endif>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('fichas.usuarios', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
                            @if($ficha->estado == 0)
                            <button type="button" onclick="document.getElementById('editar-serviciosficha').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            @endif
                            <a class="btn btn-dark mx-1" href={{ route('fichas.gastos', $ficha->uuid) }}><i class="bi bi-chevron-right"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection