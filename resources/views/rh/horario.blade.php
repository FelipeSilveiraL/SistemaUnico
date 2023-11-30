@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Horário Trabalho</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('rh/index') }}">Home</a></li>
                <li class="breadcrumb-item">Horário trabalho</li>
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
                    <div class="card-header">
                        <a href="{{ url('rh/novoHorario') }}" class="btn btn-success button-rigth-card" title="Adicionar novo horário">
                            <i class="bx bxs-file-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tabela de horários</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col" class="capitalize">ID</th>
                                    <th scope="col" class="capitalize">Empresa</th>
                                    <th scope="col" class="capitalize">Departamento</th>
                                    <th scope="col" class="capitalize">Segunda/Sexta</th>
                                    <th scope="col" class="capitalize">Seg/Sex - Almoço</th>
                                    <th scope="col" class="capitalize">Sábado</th>
                                    <th scope="col" class="capitalize">Sábado - Almoço</th>
                                    <th scope="col" class="capitalize">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buscaHorarioT as $horarioT)
                                <tr>
                                    <th scope="row">{{ $horarioT->id_horario}}</th>
                                    <td>{{ $horarioT->nome_empresa }}</td>
                                    <td>{{ $horarioT->nome_departamento }}</td>
                                    <td>{{ formatarHorario($horarioT->segunda_sexta) }}</td>
                                    <td>{{ formatarHorario($horarioT->segunda_sexta_almoco) }}</td>
                                    <td>{{ formatarHorario($horarioT->sabado) }}</td>
                                    <td>{{ formatarHorario($horarioT->sabado_almoco) }}</td>
                                    <td>
                                        @if ($horarioT->situacao == 'A')
                                        <a href="{{ url('rh/desativarHorario', ['idHorario' => 'D'.$horarioT->id_horario]) }}" title="Desativar" style="margin-top: 3px;"
                                        class="btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                        @else
                                        <a href="{{ url('rh/desativarHorario', ['idHorario' => 'A'.$horarioT->id_horario]) }}" title="Ativar" style="margin-top: 3px;"
                                            class="btn-success btn-sm"><i class="bi bi-check-square"></i></a>
                                        @endif
                                        <a href="{{ url('rh/editarHorario', ['idHorario' => $horarioT->id_horario]) }}" title="Editar" class="btn-primary btn-sm"><i
                                                class="bi bi-pencil"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
