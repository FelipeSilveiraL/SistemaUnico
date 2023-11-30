@extends('layout.master')

@section('content')

@foreach ($buscaHorario as $horario)

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Editar horário Trabalho</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('rh/index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('rh/horario') }}">Horário trabalho</a></li>
                <li class="breadcrumb-item">Editar horário trabalho</li>
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
                        <h5 class="card-title">Horário</h5>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" action="{{ route('horario.editar', ['idHorario' => $horario->id_horario]) }}" method="POST" onsubmit="return validarForm()">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="empresa" id="id_empresa" aria-label="State" required>

                                        <option value="{{ $horario->id_empresa }}">{{ $horario->nome_empresa }}</option>

                                        <option value="">----------</option>
                                        @foreach ($buscaEmpresa as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->nome_empresa }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Empresa</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="id_departamento" name="departamento" aria-label="State" required>
                                        <option value="{{ $horario->id_departamento }}">{{ $horario->nome_departamento }}</option>
                                        <option value="">----------</option>
                                        @foreach ($buscaDepartBpmgp as $depart)
                                        <option value="{{ $depart->id_departamento }}">{{ $depart->nome_departamento }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Departamento</label>
                                </div>
                            </div>

                            <h5 class="card-title">Segunda á Sexta</h5>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioSemanal" id="HoraInicioSemanal"
                                     value="{{ horaInicial($horario->segunda_sexta).":".minutoInicial($horario->segunda_sexta) }}">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalSemanal" id="HoraFinalSemanal" aria-label="State"
                                    value="{{ horaFinal($horario->segunda_sexta).":".minutoFinal($horario->segunda_sexta) }}">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-top: -18px;">
                                <h5 class="card-title" style="margin-bottom: 20px;">Almoço</h5>
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioAlmocoSemanal" onblur="almocoSemanal()" id="almocoInicialSemanal"
                                    value="{{ horaInicial($horario->segunda_sexta_almoco).":".minutoInicial($horario->segunda_sexta_almoco) }}">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalAlmocoSemanal" id="almocoFinalSemanal" onblur="almocoSemanal()"
                                    value="{{ horaFinal($horario->segunda_sexta_almoco).":".minutoFinal($horario->segunda_sexta_almoco) }}">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>
                            <h5 class="card-title">Sábado</h5>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioSabado" id="sabadoHorarioInicial" onblur="sabadoHorario()"
                                    value="{{ horaInicial($horario->sabado).":".minutoInicial($horario->sabado) }}">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalSabado" id="sabadoHorarioFinal" onblur="sabadoHorario()"
                                    value="{{ horaFinal($horario->sabado).":".minutoFinal($horario->sabado) }}">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: -18px;">
                                <h5 class="card-title" style="margin-bottom: 20px;">Almoço</h5>
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraInicioAlmocoSabado" id="sabadoAlmocoInicial" onblur="sabadoHorario()"
                                    value="{{ horaInicial($horario->sabado_almoco).":".minutoInicial($horario->sabado_almoco) }}">
                                    <label for="floatingSelect">Entrada</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="HoraFinalAlmocoSabado" id="sabadoAlmocoFinal" onblur="sabadoAlmoco()"
                                    value="{{ horaFinal($horario->sabado_almoco).":".minutoFinal($horario->sabado_almoco) }}">
                                    <label for="floatingSelect">Saída</label>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="{{ url('rh/horario') }}" class="btn btn-secondary">Voltar</a>
                                <button type="submit" class="btn btn-success">Editar</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@endforeach

@endsection
