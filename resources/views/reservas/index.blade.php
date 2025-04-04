@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-calendar3"></i> {{ __('Bookings') }}</div>

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
                                @if($reservas->count() > 0)

                                @foreach ($reservas as $reserva)
                                <table class="table table-bordered table-responsive">
                                    <tr>
                                        <th colspan="3" class="align-middle fondo-negro">
                                            {{ $reserva->usuario->name }}

                                        </th>

                                    </tr>
                                    <tr class="">
                                        <th scope="col-auto" style="width:85px" class="text-center">Fecha</th>
                                        <th scope="col-auto">Nombre</th>
                                        <th scope="col-auto"></th>
                                    </tr>

                                    <tr class="clickable-row" data-href="{{ route('reservas.edit', $reserva->uuid) }}" data-hrefborrar="{{ route('reservas.destroy', $reserva->uuid) }}" data-textoborrar="¿Está seguro de eliminar la reserva?" data-borrable="{{$reserva->borrable}}">
                                        <td class="align-middle">
                                            <div class="fondo-calendario">
                                                <p style="padding-top:14px">
                                                    <span style="font-size:0.8em; text-transform:uppercase"><b>{{ $reserva->mes }}</b></span>
                                                    <span style="clear: both;display: block; margin-top: -8px;">{{ $reserva->dia }}</span>
                                                </p>
                                            </div>
                                        </td>


                                        <td class="align-middle">
                                            {{ $reserva->name }}
                                        </td>

                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                @if($reserva->borrable)
                                                <a class="btn btn-sm btn-danger" href="#" onclick="triggerParentClick(event,this);"><i class="bi bi-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                                @endforeach


                                @endif
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
                            <a href="{{ route('reservas.create') }}" class="btn btn-primary fondo-rojo borde-rojo mx-1"><i class="bi bi-plus-circle"></i></a>
                        </div>
                    </form>
                </div>
				
@endsection