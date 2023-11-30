@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Central Ajuda</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('app_vendas/index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('app_vendas/configTelas') }}">Configuração de telas</a></li>
                <li class="breadcrumb-item">Central ajuda</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    {{-- MENSAGENS --}}
    @error('error')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span style="font-size: 12px"> {{ $message }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
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
                        <h5 class="card-title">Modais central ajuda</h5>

                        @foreach ($centralAjuda as $ajuda)
                        <!-- Advanced Form Elements -->
                        <form action="{{ url('app_vendas/salvarAjuda') }}" method="POST">
                            @csrf
                            <div class="row mb-3">

                                <input type="text" name="id" value="{{ $ajuda['id'] }}" style="display: none">
                                
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="crm" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['crm'] }}</textarea>
                                        <label for="floatingTextarea">CRM</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="smart" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['smart'] }}</textarea>
                                        <label for="floatingTextarea">SMARTSHARE</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="logistica" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['logistica'] }}</textarea>
                                        <label for="floatingTextarea">LOGÍSTICA</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="faturamento" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['faturamento'] }}</textarea>
                                        <label for="floatingTextarea">FATURAMENTO</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="entrega" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['entrega'] }}</textarea>
                                        <label for="floatingTextarea">ENTREGA</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="despachante" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['despachante'] }}</textarea>
                                        <label for="floatingTextarea">DESPACHANTE</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="pendencia" id="floatingTextarea"
                                            style="height: 100px;" required>{{ $ajuda['pendencia'] }}</textarea>
                                        <label for="floatingTextarea">PÊNDENCIA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-12">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </form><!-- End General Form Elements -->
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@endsection
