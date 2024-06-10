@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> Productos - Inventario</div>

                <div class="card-body">

                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">


                                <form id='editar-inventario' action="{{ route('productos.inventory') }}" method="post">
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
                                                        <th scope="col-auto" class="text-center">Imagen</th>
                                                        <th scope="col-auto">Nombre</th>
                                                        <th scope="col-auto">Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($productos as $producto)
                                                    <tr style="height: 80px;">
                                                        <td class="align-middle">
                                                            <img width="80" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" />
                                                            <input type="hidden" name="uuid[{{ $producto->uuid }}]" value="{{ $producto->uuid }}">
                                                        </td>

                                                        <td class="align-middle">
                                                            {{ $producto->nombre }}
                                                        </td>
                                                        <td class="align-middle col-md-4">
                                                            <div class="form-group">
                                                                <input class="form-control" type="number" min="0" max="15" name="stock[{{ $producto->uuid }}]" id="stock[{{ $producto->uuid }}]" value="{{ $producto->stock }}">
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
                            <a class="btn btn-secondary mx-1" href={{ route('productos.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('editar-inventario').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection