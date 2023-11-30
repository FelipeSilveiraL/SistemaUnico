@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Home</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-sm-3">
                <a href="{{ url('inventario/colaborador') }}" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Colaboradores</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Equipamentos</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Configuração</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Relatórios</h4>
                        </div>
                    </div>
                </a>
            </div>

            <hr style="margin-top: 20px; opacity: 0;"> <!-- Repetir a cada 4 div  -->

            <div class="col-sm-3">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Google</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Ajuda</h4>
                        </div>
                    </div>
                </a>
            </div>

            <hr style="margin-top: 20px; opacity: 0;"> <!-- Repetir a cada 4 div  -->
        </div>
    </section>

</main><!-- End #main -->

@endsection
