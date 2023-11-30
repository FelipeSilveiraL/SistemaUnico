@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Novo horário Trabalho</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('rh/index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('rh/horario') }}">Horário trabalho</a></li>
                <li class="breadcrumb-item">Novo horário trabalho</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Horário</h5>

                        <!-- Floating Labels Form -->
                        <form class="row g-3" action="{{ route('horario.salvar') }}" method="POST" onsubmit="return validarForm()">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="empresa" id="id_empresa" aria-label="State" required>
                                        <option value="">----------</option>
                                        @foreach ($buscaEmpresa as $empresa)
                                        <option value="{{ $empresa->id_empresa }}"> {{ $empresa->nome_empresa }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Empresa</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="id_departamento" name="departamento" aria-label="State" required>
                                        <option value="">----------</option>
                                        @foreach ($buscaDepartBpmgp as $depart)
                                        <option value="{{ $depart->id_departamento }}"> {{ $depart->nome_departamento }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Departamento</label>
                                </div>
                            </div>

                            <h5 class="card-title">Segunda á Sexta</h5>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioSemanal"
                                        id="HoraInicioSemanal" placeholder="xx:xx" required>
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalSemanal"
                                        id="HoraFinalSemanal" aria-label="State" required>
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-top: -18px;">
                                <h5 class="card-title" style="margin-bottom: 20px;">Almoço</h5>
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioAlmocoSemanal" onblur="almocoSemanal()"
                                        id="almocoInicialSemanal" placeholder="xx:xx">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalAlmocoSemanal" id="almocoFinalSemanal"
                                        onblur="almocoSemanal()">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>
                            <h5 class="card-title">Sábado</h5>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioSabado" id="sabadoHorarioInicial"
                                        onblur="sabadoHorario()" placeholder="xx:xx">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalSabado" id="sabadoHorarioFinal"
                                        onblur="sabadoHorario()" placeholder="xx:xx">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: -18px;">
                                <h5 class="card-title" style="margin-bottom: 20px;">Almoço</h5>
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioAlmocoSabado" id="sabadoAlmocoInicial"
                                        onblur="sabadoHorario()" placeholder="xx:xx">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalAlmocoSabado" id="sabadoAlmocoFinal"
                                        onblur="sabadoAlmoco()" placeholder="xx:xx">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="reset" class="btn btn-secondary">Limpar</button>
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
