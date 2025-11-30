@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-key"></i> LICENCIAS</div>
                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="realizar-busqueda" action="{{ route('licencias.index') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    @if (session('success'))
                                    <div class="custom-success-container" id="custom-success-container">
                                        <ul class="custom-success-list">
                                            <li class="custom-success-item">{{ session('success') }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                    @if ($errors->any())
                                    <div class="custom-error-container" id="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <div class="form-group mb-3 required">
                                        <label for="site_id" class="fw-bold form-label">Sociedad</label>
                                        <select name="site_id" id="site_id" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($sites as $site)
                                            <option value="{{ $site->id }}">{{ $site->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                    if($request){
                                    $estado_licencia = $request->estado_licencia;
                                    }
                                    @endphp
                                    <div class="form-group mb-3 required">
                                        <label for="estado_licencia" class="fw-bold form-label">Estado:</label>
                                        <select name="estado_licencia" id="estado_licencia" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if ($estado_licencia==0) selected @endif>Activas</option>
                                            <option value="1" @if ($estado_licencia==1) selected @endif>Caducadas</option>
                                            <option value="2" @if ($estado_licencia==2) selected @endif>Todas</option>
                                        </select>
                                    </div>
                                    @if(count($licenses) > 0)
                                    <br />
                                    <table class="table table-hover table-bordered table-responsive table-hover">
                                        <thead>
                                            <tr class="">
                                                <th scope="col-auto" class="text-center" style="width: 90px;">Sociedad</th>
                                                <th scope="col-auto">Socio</th>
                                                <th scope="col-auto" class="text-center">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($licenses as $license)
                                            <tr class="clickable-row" data-href="{{ route('licencias.edit', $license->id) }}" data-hrefborrar="{{ route('licencias.destroy', $license->id) }}" data-textoborrar="{{ __('¿Está seguro de eliminar la licencia?') }}" data-borrable="{{$license->borrable}}">
                                                <td class="align-middle"><img width="80" height="80" alt="{{ $site->nombre }}" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/{{ $license->site->ruta_logo }}" /></td>
                                                <td class="align-middle">{{ $license->user->name }}</td>
                                                <td class="align-middle text-center">
                                                    @if(strpos($license->estado, 'success') !== false)
                                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 1.5rem;" title="{{ __('Activa') }}"></i>
                                                    @elseif(strpos($license->estado, 'danger') !== false)
                                                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 1.5rem;" title="{{ __('Caducada') }}"></i>
                                                    @else
                                                        <i class="bi bi-clock-fill text-secondary" style="font-size: 1.5rem;" title="{{ __('Inactiva') }}"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </form>
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
                            <button type="button" onclick="document.getElementById('realizar-busqueda').submit();" class="btn btn-secondary mx-1"><i class="bi bi-search"></i></button>
                            @if (Auth::user()->role_id < 4) <a href="{{ route('licencias.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
                                @endif
                        </div>
                    </form>
                </div>
@endsection