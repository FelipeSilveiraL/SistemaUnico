@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Vistorias Paradas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/vex/index') }}">Home</a></li>
                <li class="breadcrumb-item active">Vistorias paradas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Json_Decode</h5>

                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item iframe_WeebHook"
                                src="http://rede.paranapart.com.br/sistemaUnico/api/webhook" allowfullscreen></iframe>
                        </div>
                        <p class="alerta">{"alerta":null} = não possui vistorias para serem analisadas.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <a href="{{ url('/vex/vistoriaLiberar') }}" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Liberar Vistoria
                </a>
                <button type="button" class="btn btn-success" onclick="atualizarPagina()">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reenviar Vistoria
                </button>
            </div>

        </div>
    </section>

</main><!-- End #main -->
@endsection

<script>
    function atualizarPagina() {
        location.reload();
    }
</script>
