@extends('layout.master')

@section('content')

@if ($buscaNotas['filial'] == null)
    <script>window.location.href = "{{ url('contabilidade/fluxo') }}";</script>
@endif



<main id="main" class="main">
    <div class="pagetitle">
        <h1>Excluir Fluxo Finalizado</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('contabilidade/index') }}">Home</a></li>
                <li class="breadcrumb-item">Excluir Fluxo Finalizado</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            {{-- PRE VISUALIZAÇÃO DA NOTA --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Localizado a Nota fiscal.</h5><br>
                        <p class="text-center text-danger">
                            <i class="bi bi-exclamation-octagon-fill"></i> MUITA ATENÇÃO <i
                                class="bi bi-exclamation-octagon-fill"></i>
                        </p>
                        <p class="text-center">
                            Confirme os dados abaixo para ver se é realmente a nota fiscal que deseja excluir, porque
                            após confirmar <br /><span class="text-danger"> NÃO TERÁ MAIS COMO VOLTAR</span>
                        </p>
                        <br>
                        <!-- Horizontal Form -->
                        <form class="row g-3" action="{{ url('contabilidade/excluirFluxo') }}" method="post">
                            @csrf
                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Responsável:</label>
                                <input type="text" class="form-control" id="validationDefault01" value="{{ auth()->user()->username }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="validationDefault02" class="form-label">Filial Nota Fiscal:</label>
                                <input type="text" class="form-control" id="validationDefault02" value="{{ $buscaNotas['filial'] }}" disabled>
                            </div>

                            <div class="col-md-5">
                                <label for="validationDefault03" class="form-label">Número Fluxo:</label>
                                <input type="text" class="form-control" id="validationDefault03" name="cdFluxo" value="{{ $buscaNotas['numero_fluxo'] }}" readonly>
                            </div>

                            <div class="col-md-5">
                                <label for="validationDefault04" class="form-label">Número Nota:</label>
                                <input type="text" class="form-control" id="validationDefault04" value="{{ $buscaNotas['numero_nota'] }}" disabled>
                            </div>

                            <div class="col-md-2">
                                <label for="validationDefault05" class="form-label">Série Nota:</label>
                                <input type="text" class="form-control" id="validationDefault05" value="{{ $buscaNotas['serie_nota'] }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="validationDefault06" class="form-label">Nome Fornecedor:</label>
                                <input type="text" class="form-control" id="validationDefault06" value="{{ $buscaNotas['nome_fornecedor'] }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="validationDefault07" class="form-label">CNPJ Fornecedor:</label>
                                <input type="text" class="form-control" id="validationDefault07" value="{{ formatCnpj($buscaNotas['cnpj_fornecedor']) }}" disabled>
                            </div>

                            <div class="col-12">
                                <a href="{{ url('contabilidade/fluxo') }}" class="btn btn-success">Voltar</a>
                                <button class="btn btn-danger" type="submit">Confirmar</button>
                            </div>
                        </form><!-- End Horizontal Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
