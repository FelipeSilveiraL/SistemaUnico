@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Contabilidade</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('contabilidade/index') }}">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-sm-3">
                <a href="{{ url('contabilidade/fluxo') }}" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Excluir Fluxo Finalizado</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="{{ url('contabilidade/bloqueioBancos') }}" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Cadastro/Bloqueio Bancos</h4>
                        </div>
                    </div>
                </a>
            </div>
            <hr style="margin-top: 20px; opacity: 0;"> <!-- Repetir a cada 4 div  -->
        </div>
    </section>

</main><!-- End #main -->

@endsection
