 {{-- MENU LATERAL --}}
 <aside id="sidebar" class="sidebar" style="background-image: linear-gradient(to bottom, #fff 73%, 100%);">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Sistemas</li>

        <li class="nav-item">
            <a class="nav-link {{ $currentPath == 'index' ?: 'collapsed' }}" href="{{ url('index') }}">
                <i class="bi bi-grid"></i>
                <span>Meus Sistemas</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <hr>

        <li class="nav-heading">Paginas</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="modal" data-bs-target="#meuPerfil">
                <i class="bi bi-person"></i>
                <span>Meu perfil</span>
            </a>
        </li>

        <li class="nav-item {{ $administrador }}">

            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Configurações</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('usuarios') }}">
                        <i class="bi bi-circle"></i><span>Lista Usuários</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('sistemas') }}">
                        <i class="bi bi-circle"></i><span>Sistemas</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>API</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Charts Nav -->
    </ul>
</aside><!-- End MENU-->
