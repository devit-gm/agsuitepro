@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-key"></i> EDITAR LICENCIA</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="editar-licencia" action="{{ route('licencias.update', $licencia->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    @if ($errors->any())
                                    <div class="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group mb-3 text-center">
                                        <img width="100" src="{{ URL::to('/') }}/{{ $licencia->sitio->ruta_logo }}" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="name" class="fw-bold form-label">Sociedad</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $licencia->sitio->nombre }}" disabled>
                                        <input type="hidden" name="site_id" id="site_id" value="{{ $licencia->sitio->id }}" />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="socio" class="fw-bold form-label">Socio</label>
                                        <input type="email" class="form-control" id="socio" name="socio" value="{{ $licencia->usuario->name }}" disabled>
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $licencia->usuario->id }}" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="expires_at" class="fw-bold form-label">Fecha expiración</label>
                                        <input type="date" class="form-control" id="expires_at" name="expires_at" value="{{ $licencia->expires_at }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="license_key" class="fw-bold form-label">Licencia</label>
                                        <input type="text" class="form-control" id="license_key" name="license_key" value="{{ $licencia->license_key }}" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="actived" class="fw-bold form-label">Estado</label><br />
                                        <input type="hidden" name="actived" id="actived" value="{{ $licencia->actived }}" />
                                        {!! $licencia->estado !!}
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
                    <form action="{{ route('licencias.destroy', $licencia->id) }}" method="post">
                        <div class="d-flex align-items-center justify-content-center">
                            @if(Auth::user()->role_id == \App\Enums\Role::ADMIN ) <a class="btn btn-dark mx-1" href={{ route('licencias.index') }}><i class="bi bi-chevron-left"></i></a>
                            @endif
                            <button onclick="document.getElementById('editar-licencia').submit();" type="button" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            @if ($licencia->borrable == 1 && Auth::user()->role_id == \App\Enums\Role::ADMIN) @csrf @method('DELETE') <button type="submit" class="btn btn-danger mx-1 my-1" title="Eliminar licencia" onclick="return confirm('{{ __('¿Está seguro de eliminar la licencia?') }}');"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                    </form>
                </div>
				
@endsection