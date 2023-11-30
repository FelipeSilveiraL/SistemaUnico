@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Aplicativo Vendedores</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('app_vendas/index') }}">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-3 py-2">
                <a href="{{ url('app_vendas/configTelas') }}"
                    class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Manutenção telas</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@endsection
