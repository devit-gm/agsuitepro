@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-people"></i> {{ __('Users') }}</div>
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
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr class="">
                                            <th scope="col-auto" style="width:90px">Imagen</th>
                                            <th scope="col-auto">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $usuario)
                                        <tr style="height:120px;" class="clickable-row" data-href="{{ route('usuarios.edit', $usuario->id) }}" data-hrefborrar="{{ route('usuarios.destroy', $usuario->id) }}" data-textoborrar="¿Está seguro de eliminar el usuario?" data-borrable="{{$usuario->borrable}}">
                                            <td class="align-middle"><img width="80" height="80" class="img-fluid rounded img-responsive" src="{{ URL::to('/') }}/images/{{ $usuario->image }}" /></td>
                                            <td class="align-middle">
                                                {{ $usuario->name }}
                                                <br />
                                                <span class="badge bg-{{ $usuario->role_id == 1 ? 'primary' : 'secondary' }}">
                                                    @foreach($roles as $rol)
                                                    @if ($usuario->role_id == $rol->id)
                                                    {{ $rol->name }}
                                                    @endif
                                                    @endforeach
                                                </span>

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
                            @if (Auth::user()->role_id < 4) <a href="{{ route('usuarios.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
                                @endif
                        </div>
                    </form>
                </div>
				
@endsection