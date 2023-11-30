 {{-- MENU LATERAL --}}
 <aside id="sidebar" class="sidebar" style="background-image: linear-gradient(to bottom, #fff 73%, 100%);">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a href="{{ url("inventario/index") }}" class="nav-link collapsed">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <hr>

        <li class="nav-heading">Paginas</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('inventario/colaborador') }}">
                <i class="bi bi-people"></i>
                <span>Colaboradores</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-laptop"></i>
                <span>Equipamentos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-gear"></i>
                <span>Configurações</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-clipboard-data"></i>
                <span>Relatórios</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-google"></i>
                <span>Google</span>
            </a>
        </li>

        <li class="nav-heading">Outros</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-patch-question"></i>
                <span>Ajuda?</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('index') }}" >
                <i class="bi bi-arrow-90deg-left"></i>
                <span>voltar</span>
            </a>
        </li>
    </ul>
</aside><!-- End MENU-->
