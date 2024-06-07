@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header fondo-rojo"><i class="bi bi-receipt"></i> FICHA - {{ __('Families') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="d-grid gap-2 d-md-flex justify-content-end mb-3">
                            <a class="btn btn-lg btn-light border border-dark" href="">{{number_format($ficha->precio,2)}} <i class="bi bi-currency-euro"></i></a>
                        </div>

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

                        @foreach($familias as $familia)
                        <div class="col-6 mb-4 col-md-2">
                            <div class="card border-0">
                                <a href="{{ route('fichas.productos', [$ficha->uuid, $familia->uuid]) }}"><img src="{{ URL::to('/') }}/images/{{ $familia->imagen }}" class="img-fluid rounded img-responsive w-100" style="max-width:170px !important;" alt="{{ $familia->nombre }}"></a>
                            </div>
                        </div>
                        @if($loop->iteration % 4 == 0)
                    </div>
                    <div class="row">
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-warning mx-1" href="{{ route('fichas.show', ['uuid'=>$ficha->uuid]) }}"><i class="bi bi-eye"></i></a>
                            <a class="btn btn-primary mx-1" href="{{ route('fichas.lista', ['uuid'=>$ficha->uuid]) }}"><i class="bi bi-cart"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection