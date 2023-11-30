@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Meus Sistemas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Meus sistemas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @foreach ($buscaSistemasUser as $sistemaUser)
            <div class="col-lg-3 py-2">
                @auth
                    <a href="{{ url($sistemaUser->endereco) }}idUsuario={{ auth()->user()->id }}&idEmpresa={{ $sistemaUser->id }}" class="list-group-item list-group-item-action">
                @endauth
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $sistemaUser->nome }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

</main><!-- End #main -->
@endsection
