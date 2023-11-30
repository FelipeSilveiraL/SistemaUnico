 {{-- MENU LATERAL --}}
 <aside id="sidebar" class="sidebar" style="background-image: linear-gradient(to bottom, #fff 73%, 100%);">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/vex/index') }}">
                <i class="bi bi-grid"></i>
                <span>Integração VEX</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <hr>

        <li class="nav-heading">Paginas</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/vex/vistoriaParada') }}">
                <i class="bi bi-exclamation-octagon"></i>
                <span>Vistorias Paradas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/vex/vistoriaLiberar') }}">
                <i class="bi bi-check-circle"></i>
                <span>Liberar Vistoria</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/vex/pdf') }}">
                <i class="bi bi-file-earmark-pdf"></i>
                <span>Liberar / Gerar PDF</span>
            </a>
        </li>

        <li class="nav-heading">Outros</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('index') }}" >
                <i class="bi bi-arrow-90deg-left"></i>
                <span>voltar</span>
            </a>
        </li>

    </ul>
</aside><!-- End MENU-->
