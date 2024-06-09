@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-building"></i> SOCIEDADES</div>

                <div class="card-body">

                    <div class="container-fluid">
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
                            <table class="table table-hover table-bordered table-responsive table-hover">
                                <thead>
                                    <tr class="">
                                        <th scope="col-auto" class="text-center" style="width: 90px;">Logo</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto" class="text-center">Socios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sites as $site)
                                    <tr class="clickable-row" data-href="{{ route('sitios.edit', $site->id) }}" data-hrefborrar="{{ route('sitios.destroy', $site->id) }}" data-textoborrar="¿Está seguro de eliminar la sociedad?" data-borrable="{{$site->borrable}}">
                                        <td class="align-middle"><img width="80" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/{{ $site->ruta_logo }}" /></td>
                                        <td class="align-middle">{{ $site->nombre }}</td>
                                        <td class="align-middle text-center">{{ $site->usuarios }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            @if (Auth::user()->role_id < 4) <a href="{{ route('sitios.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection