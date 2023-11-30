<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carimbo Notas Grupo Servopa</title>
</head>

<body>
    <table>
        <tr>
            <td style="border: solid 1px; padding: 5px; text-align: center; " colspan="2">CENTRO DE CUSTO</td>
        </tr>

        @foreach ($buscaRateio as $rateio)
        <tr>
            <td style="border: solid 1px; padding: 5px; "> {{ buscaNome($rateio['ID_CENTROCUSTO_BPM']) }}</td>
            <td style="border: solid 1px; padding: 5px; ">{{ $rateio['percentual'] }} %</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="2" style="border: solid 1px; padding: 5px; ">Data: _____/_____/_____</td>
        </tr>
        <tr>
            <td colspan="2" style="border: solid 1px; padding: 5px; ">Responsável: _________________________</td>
        </tr>
        <tr>
            <td colspan="2" style="border: solid 1px; padding: 5px; ">Diretoria: _________________________</td>
        </tr>
    </table>

</body>

</html>
