@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> Composición producto</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <table class="table table-responsive table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="align-top">
                                                {{ $producto->nombre }}
                                                <br />
                                                @if ($producto->familia)
                                                <span class="badge bg-secondary">{{ $producto->familia->nombre }}</span>
                                                @endif
                                            </td>
                                            <td class="align-top text-end">
                                                <i class="bi bi-cash"></i> {{ $producto->precio }}€<br />
                                                @if ($producto->combinado == 1)
                                                <span class="badge bg-success">Combinado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form id="editar-componentes" action="{{ route('productos.update_components', $producto->uuid) }}" method="post">
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
                                                        <th scope="col-auto">Nombre</th>
                                                        <th scope="col-auto">Precio</th>
                                                        <th scope="col-auto">Añadir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($componentes as $componente)
                                                    <tr style="height: 80px;">
                                                        <td class="align-middle">
                                                            {{ $componente->nombre }}
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $componente->precio }}€
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" name="componentes[]" id="componentes[]" value="{{ $componente->uuid }}" @if($componente->familia == 1) checked @endif>
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

			</div>
        </div>
    </div>
</div>
@endsection
@section('footer')
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('productos.edit', $producto->uuid) }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('editar-componentes').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
            
@endsection