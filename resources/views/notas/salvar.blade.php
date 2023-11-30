<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span style="font-size: 12px">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span style="font-size: 12px">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

  <div class="container">
    <form id="salvarNota" method="POST" action="{{ url('notas/alterarAnexo') }}" enctype="multipart/form-data">
        @csrf
      <div class="mb-3">
        <label for="nota" class="form-label">Insira a Nota Fiscal</label>
        <input type="file" class="form-control" id="nota" name="notaFiscal">
      </div>

      <div class="mb-3">
        <label for="idAnexo" class="form-label">ID Anexo</label>
        <input type="text" class="form-control" id="idAnexo" name="idAnexo" value="{{ $idAnexo }}" readonly>
      </div>

      <div class="mb-3">
        <label for="idLancarNota" class="form-label">ID Lancar Nota</label>
        <input type="text" class="form-control" id="idLancarNota" name="idLancarNota" value="{{ $idLancarNota }}" readonly>
      </div>

      <button type="submit" class="btn btn-primary">Salvar</button>

    </form>
  </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</html>
