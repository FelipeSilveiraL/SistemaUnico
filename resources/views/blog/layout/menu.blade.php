{{-- MENU LATERAL --}}
<aside id="sidebar" class="sidebar" style="background-image: linear-gradient(to bottom, #fff 73%, 100%);">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('blog/index') }}">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <hr>
        <li class="nav-heading">Paginas</li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('blog/nova') }}">
                <i class="bi bi-envelope-open"></i>
                <span>Nova postagem</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('blog/postage') }}">
                <i class="bi bi-calendar3"></i>
                <span>Minhas postagens</span>
            </a>
        </li>

        <hr>
        <li class="nav-heading">Outros</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('index') }}">
                <i class="bi bi-arrow-90deg-left"></i>
                <span>Voltar</span>
            </a>
        </li>

    </ul>

</aside><!-- End MENU-->
