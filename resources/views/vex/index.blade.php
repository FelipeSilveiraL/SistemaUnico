@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Integração VEX</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ url('/vex/index') }}">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">

            <div class="col-lg-3 py-2">
                <a href="{{ url('/vex/vistoriaParada') }}" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vistorias Paradas</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 py-2">
                <a href="{{ url('/vex/vistoriaLiberar') }}" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Liberar Vistoria</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 py-2">
                <a href="{{ url('/vex/pdf') }}" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Liberar / Gerar PDF</h5>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </section>

</main><!-- End #main -->

@endsection
