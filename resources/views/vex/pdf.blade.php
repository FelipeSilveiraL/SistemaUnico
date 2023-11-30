@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Liberar / Gerar PDF</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/vex/index') }}">Home</a></li>
                <li class="breadcrumb-item active">PDF</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gerador PDF</h5>
                        <br>
                        <!-- Horizontal Form -->
                        <form method="POST" action="{{ url('/vex/gerarPDF') }}">
                            @csrf
                            <div class="col-md-6" id="nomeFuncionario">
                                <label for="inputName5" class="form-label">ID vistoria:</label>
                                <input type="number" class="form-control" name="numeroVistoria" required>
                                <p class="alerta">Número de identifação da vistoria que se encontra na VEX</p>
                            </div>

                            <div class="text-center buttom_search">
                                <button type="submit" class="btn btn-success" id="localizar" style="margin-top: -54px;" title="Liberar / Gerar PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>
                            </div>
                        </form><!-- End Horizontal Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>

</main><!-- End #main -->
@endsection
