 {{-- MENU LATERAL --}}
 <aside id="sidebar" class="sidebar" style="background-image: linear-gradient(to bottom, #fff 73%, 100%);">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link">
                <i class="bi bi-grid"></i>
                <span>Meus Sistemas</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <hr>

        <li class="nav-heading">Paginas</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="modal" data-bs-target="#meuPerfil">
                <i class="bi bi-person"></i>
                <span>Minhas postagens</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="modal" data-bs-target="#meuPerfil">
                <i class="bi bi-person"></i>
                <span>Comentários</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="modal" data-bs-target="#meuPerfil">
                <i class="bi bi-person"></i>
                <span>Nova postagem</span>
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
