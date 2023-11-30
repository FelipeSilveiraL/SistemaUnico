@extends('automacao.layout.master')

@section('content')

<div class="container text-center mt-5">
    <div class="row">
        <form action="">
            <div class="col">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="palavra" placeholder="Insira a palavra" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" onclick="abreviar()">Abreviar</button>
                </div>
            </div>
            <div class="col">
                <h5 style="color: red">Use isso com palavras acima de 25 caracteres</h5>
            </div>
            <div class="col" style="display: none" id="inputAbreviada">
                <div class="input-group">
                    <span class="input-group-text">Palavra abreviada</span>
                    <input type="text" class="form-control" id="palavraAjustada" value="">
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function abreviar() {
        var str = document.getElementById("palavra").value;

        if (str.length > 25) {
            var palavras = str.split(' ');
            var nomeAbreviado = palavras[0].charAt(0).toUpperCase() + '. ' + palavras[1].charAt(0).toUpperCase() + '. ' + str.substring(palavras[0].length + palavras[1].length + 2);
        } else {
            var nomeAbreviado = 'Não precisa abreviar. Total caracteres = ' + str.length;
        }

        var tela = document.getElementById("inputAbreviada").style.display;

        if (tela == 'none') {
            document.getElementById("inputAbreviada").style.display = 'block';
            document.getElementById('palavraAjustada').value = nomeAbreviado ;
        }
    }
</script>
<!-- Content here -->
@endsection
