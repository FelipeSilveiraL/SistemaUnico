<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- v5.0.2-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Subindo Nota</title>
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

    <br />
    <br />
    <div class="container py-2">
        <form method="POST" action="{{ url('notas/salvarNotasRobo') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="formFile" class="form-label">Insira Nota Fiscal:</label>
                <input class="form-control" type="file" name="notaFiscal" id="nota">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Insira boleto:</label>
                <input class="form-control" type="file" name="boleto" id="boleto">
            </div>
            <h4>Dados da NotaFiscal</h4>

            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Serie:</label>
                    <input class="form-control" type="text" name="serie" value="{{ $serie }}" readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">cnpjFornecedor:</label>
                    <input class="form-control" type="text" name="cnpjFornecedor" value="{{ $cnpjFornecedor }}"
                        readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">usuario:</label>
                    <input class="form-control" type="text" name="usuario" value="{{ $usuario }}" readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">numeroNota:</label>
                    <input class="form-control" type="text" name="numeroNota" value="{{ $numeroNota }}" readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">dataEmissao:</label>
                    <input class="form-control" type="text" name="dataEmissao" value="{{ $dataEmissao }}" readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">dataVencimento:</label>
                    <input class="form-control" type="text" name="dataVencimento" value="{{ $dataVencimento }}"
                        readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">valorNota:</label>
                    <input class="form-control" type="text" name="valorNota" value="{{ $valorNota }}" readonly>
                </div>
            </div>
            <div class="cotainer">
                <div class="mb-3">
                    <label for="formFile" class="form-label">cnpjFilial:</label>
                    <input class="form-control" type="text" name="cnpjFilial" value="{{ $cnpjFilial }}" readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="formNota">Enviar</button>
        </form>
    </div>

</body>

</html>
