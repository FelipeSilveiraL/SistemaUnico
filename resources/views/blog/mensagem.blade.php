@extends('layout.master')

@section('content')

@foreach ($blogPostMsn as $postMSN)
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Mensagem - {{ $postMSN->titulo }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('blog/index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('blog/postage') }}">Minhas postagens</a></li>
                <li class="breadcrumb-item active">Mensagem</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Imagem da postagem</h5>
                        <img src="{{ asset('public/'.$postMSN->file_img) }}" alt="arquivo" style="width: 100%;">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mensagem da postagem</h5>
                        <?= $postMSN->mensagem ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endforeach
@endsection
