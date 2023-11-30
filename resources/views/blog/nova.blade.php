@extends('layout.master')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Nova postagem</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('blog/index') }}">Home</a></li>
                <li class="breadcrumb-item">Nova postagem</li>
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
                        <h5 class="card-title">Formulario da postagem</h5>
                        <form action="{{ url('blog/novaPostagem') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Titulo" maxlength="50" name="titulo" required>
                                    <label for="formFile" class="form-label msnLabel">limite de 50 caracteres...</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" id="selectDataDrop" aria-label="Default select example" onchange="dataDrop()" required>
                                        <option value="">Excluir automaticamente ?</option>
                                        <option value="1">sim</option>
                                        <option value="2">nao</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select" id="selectDataPost" aria-label="Default select example" onchange="dataPost()" required>
                                        <option value="">Postagem programada ?</option>
                                        <option value="1">sim</option>
                                        <option value="2">nao</option>
                                    </select>
                                </div>

                                <div class="col-md-12" style="display: none" id="dataExclusao">
                                    <input type="date" class="form-control" placeholder="Data exclusao" name="dataExclusao" aria-label="Last name" id="idDataExclusao">
                                    <label for="formFile" class="form-label msnLabel">Após essa data, postagem será
                                        desativada</label>
                                </div>

                                <div class="col-md-12" style="display: none" id="dataPostagem">
                                    <input type="date" class="form-control" placeholder="Data postagem" name="dataPostagem" aria-label="Last name" id="idDataPostagem">
                                    <label for="formFile" class="form-label msnLabel">Após essa data, postagem será
                                        realizada</label>
                                </div>

                                <div class="col-md-12">
                                    <input class="form-control" type="file" name="imagem" id="formFile" required>
                                </div>


                                <div class="col-md-12 form-floating">
                                    <textarea class="form-control" id="floatingTextarea" name="mensagem"></textarea>
                                    <label for="floatingTextarea">Mensagem</label>
                                </div>

                                <div class="col-md-12">
                                    <button type="reset" class="btn btn-secondary" onclick="oculta()">Limpar</button>
                                    <button type="submit" class="btn btn-primary">Realizar Postagem</button>
                                </div>

                            </div>
                    </div>

                    </form>
                </div>
            </div>

        </div>
        </div>
    </section>

</main><!-- End #main -->

<script>
    function dataDrop(){
        var x = document.getElementById("selectDataDrop").value;

        if(x == 1){
            document.getElementById("dataExclusao").style.display = 'block';
            document.getElementById("idDataExclusao").required = true
        }else{
            document.getElementById("dataExclusao").style.display = "none";
            document.getElementById("idDataExclusao").required = false
        }
    }

    function oculta(){
        document.getElementById("dataExclusao").style.display = "none";
        document.getElementById("idDataPostagem").required = false
    }

    function dataPost(){
        var x = document.getElementById("selectDataPost").value;

        if(x == 1){
            document.getElementById("dataPostagem").style.display = 'block';
            document.getElementById("idDataPostagem").required = true
        }else{
            document.getElementById("dataPostagem").style.display = "none";
            document.getElementById("idDataPostagem").required = false
        }
    }

    function oculta(){
        document.getElementById("dataPostagem").style.display = "none";
        document.getElementById("idDataPostagem").required = false
    }
</script>
@endsection

