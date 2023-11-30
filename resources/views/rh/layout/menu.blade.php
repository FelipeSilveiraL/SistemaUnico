{{-- MENU LATERAL --}}
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('rh/index') }}">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <hr>
        <li class="nav-item">
            <a class="nav-link  collapsed" href="{{ url('rh/busca') }}">
                <i class="bi bi-person-bounding-box"></i>
                <span>Buscar CPF</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  collapsed" href="{{ url('rh/horario') }}">
                <i class="bi bi-alarm"></i>
                <span>Horário de trabalho</span>
            </a>
        </li>
        <hr>

        <li class="nav-heading">Outros</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('index') }}">
                <i class="bi bi-arrow-90deg-left"></i>
                <span>voltar</span>
            </a>
        </li>
    </ul>
</aside><!-- End MENU-->
