@extends('layout.master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Home</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('blog/index') }}">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Navegação -->

    <section>

        <div class="row">

            <section class="section">

                <div class="row">

                    <div class="col-lg-3 py-2">
                        <a href="{{ url('blog/nova') }}" class="list-group-item list-group-item-action">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nova postagem</h5>

                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 py-2">
                        <a href="{{ url('blog/postage') }}" class="list-group-item list-group-item-action">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Minhas postagens</h5>

                                </div>
                            </div>
                        </a>
                    </div>

                </div>

            </section>

        </div>

    </section>

</main><!-- End #main -->

@endsection
