
function escolheNome() {

    var verificando = document.getElementById("gridRadios1").checked;
    var verificandoCPF = document.getElementById("gridRadios2").checked;

    if (verificando == false) {

        document.getElementById("nomeFuncionario").style.display = 'none';
        document.getElementById("inputNome").required = false;
        document.getElementById("localizar").disabled = false;

        if (verificandoCPF == false) {
            document.getElementById("cpfFuncionario").style.display = 'none';
            document.getElementById("inputCpf").required = false;
        } else {
            document.getElementById("cpfFuncionario").style.display = 'block';
            document.getElementById("inputCpf").required = true;
        }



    } else {
        document.getElementById("nomeFuncionario").style.display = 'block';
        document.getElementById("cpfFuncionario").style.display = 'none';
        document.getElementById("inputCpf").required = false;
        document.getElementById("inputNome").required = true;

        document.getElementById("localizar").disabled = false
    }


}

function escolheCpf() {
    document.getElementById("nomeFuncionario").style.display = 'none';
    document.getElementById("cpfFuncionario").style.display = 'block';
    document.getElementById("inputCpf").required = true;
    document.getElementById("inputNome").required = false;
    document.getElementById("localizar").disabled = false
}

