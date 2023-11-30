{{-- MENU LATERAL --}}
<aside id="sidebar" class="sidebar" style="background-image: linear-gradient(to bottom, #fff 73%, 100%);">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('notas/index') }}">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <hr>
        <li class="nav-heading">Notas</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('notas/lancar') }}">
                <i class="bi bi-file-arrow-up"></i>
                <span>Lançamento Manual</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">

            <a class="nav-link collapsed" data-bs-target="#cadastro-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-text"></i><span>Cadastros</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="cadastro-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('notas/fornecedor') }}">
                        <i class="bi bi-circle"></i><span>Rateio Fornecedor</span>
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="relatorio.php">
                <i class="bi bi-clipboard-data"></i>
                <span>Relatório</span>
            </a>
        </li><!-- End Dashboard Nav --> --}}
        {{-- <hr>
        <li class="nav-heading">Paginas</li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#config-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Configurações</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="espelhar_usuarios.php">
                        <i class="bi bi-circle"></i><span>Usuários</span>
                    </a>
                </li>
            </ul>
        </li> --}}

        <hr>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('index') }}">
                <i class="bi bi-arrow-bar-left"></i>
                <span>Voltar</span>
            </a>
        </li>
    </ul>
</aside><!-- End MENU-->
