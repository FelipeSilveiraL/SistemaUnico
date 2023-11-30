function tipoVencimento() {
    var tipoVencimento = document.getElementById("vencimento").value;

    if (tipoVencimento == 2) { //somatorio

        document.getElementById("dias").style.display = 'none';
        document.getElementById("diasCorridos").style.display = 'block';
        document.getElementById("inputDiascorridos").required = true;
        document.getElementById("diasInput").required = false;

    } else if (tipoVencimento == 3) { //fixo

        document.getElementById("dias").style.display = 'block';
        document.getElementById("diasInput").required = true;
        document.getElementById("diasCorridos").style.display = 'none';
        document.getElementById("inputDiascorridos").required = false;

    } else { //nota fiscal

        document.getElementById("dias").style.display = 'none';
        document.getElementById("diasCorridos").style.display = 'none';
    }

}


function diasMaximos() {
    var dias = document.getElementById("diasInput").value;

    if (dias > 31) {
        const date = new Date();
        const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        const lastDayDate = lastDay.toLocaleDateString()
        document.getElementById("diasInput").value = lastDayDate.substr(0, 2);
    }

}

function bancos() {
    var tipoPagamento = document.getElementById("tipoPagamento").value;

    if (tipoPagamento == 2) {
        document.getElementById("tipopagamentoBancos").style.display = 'contents';
        document.getElementById("nomeBanco").required = true;
        document.getElementById("numAgencia").required = true;
        document.getElementById("numConta").required = true;
        document.getElementById("numDigito").required = true;
    } else {
        document.getElementById("tipopagamentoBancos").style.display = 'none';
        document.getElementById("nomeBanco").required = false;
        document.getElementById("numAgencia").required = false;
        document.getElementById("numConta").required = false;
        document.getElementById("numDigito").required = false;
    }
}

function validarPorcentual(input) {
    // Remove quaisquer caracteres não numéricos, exceto pontos decimais
    input.value = input.value.replace(/[^\d.]/g, '');

    // Garante que o valor esteja dentro do intervalo de 1 a 100
    const valor = parseFloat(input.value);
    if (isNaN(valor)) {
      // Se o valor não for um número válido, defina-o como vazio
      input.value = '';
    } else if (valor < 1) {
      input.value = '1';
    } else if (valor > 100) {
      input.value = '100';
    }
  }

