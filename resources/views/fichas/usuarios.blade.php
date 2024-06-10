@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> FICHA - Asistentes</div>

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-end col-sm-12 col-md-8 col-lg-12">
                        <button class="btn btn-lg btn-light border border-dark">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></button>
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-8 col-lg-10">


                                <form id='editar-usuariosficha' action="{{ route('fichas.updateusuarios', $ficha->uuid) }}" method="post">
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
                                                        <th scope="col-auto">Añadir</th>
                                                        <th scope="col-auto">Invitados</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($usuariosFicha as $usuario)
                                                    <tr style="height: 80px;">
                                                        <td class="align-middle">
                                                            {{ $usuario->name }}
                                                        </td>

                                                        <td class="align-middle">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input @if($usuario->id == $ficha->user_id) readonly @endif" type="checkbox" role="switch" name="usuarios[{{ $usuario->id }}]" value="[{{ $usuario->id }}]" id="usuarios[{{ $usuario->id }}]" value="{{ $usuario->id }}" @if($usuario->marcado == 1) checked @endif >
                                                            </div>
                                                        </td>
                                                        <td class="align-middle col-md-4">
                                                            <div class="form-group">
                                                                <input class="form-control" type="number" min="0" max="15" name="invitados[{{ $usuario->id }}]" id="invitados[{{ $usuario->id }}]" value="{{ $usuario->invitados }}">
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
                            <a class="btn btn-dark mx-1" href={{ route('fichas.lista', $ficha->uuid) }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('editar-usuariosficha').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            <a class="btn btn-dark mx-1" href={{ route('fichas.servicios', $ficha->uuid) }}><i class="bi bi-chevron-right"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection