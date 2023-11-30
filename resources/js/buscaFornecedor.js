$("#cnpjVet").on("blur", function() {

    var cnpj = $("#cnpjVet").val();
    var nomefilial = $("#selectFilial").val();
    var idUsuario = $("#idUsuario").val();

    $.ajax({

        url: '{{ url("notas/buscaFornecedor") }}',
        type: 'POST',
        data: {
            idFilial: nomefilial,
            cnpj: cnpj,
            idUsuario: idUsuario,
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function(data) {

            if (data.fornecedor !== null) {
                $("#NomeFornecedor").val(data.fornecedor);

                //DEMAIS INFORMAÇÕES DO FORMULARIO

                //tipoPagamento
                $("#tipoPagamento").html(data.tipoPagamento);

                if(data.tipoPagamento == '<option value="2">Depósito Bancário</option>'){
                    $('#tipopagamentoBancos').show();
                }

                //telefone
                $("#telefone").val(data.telefone);

            } else {
                // Trate o caso em que nenhum fornecedor foi encontrado, por exemplo, exiba uma mensagem de erro.
                $("#NomeFornecedor").val("Fornecedor não encontrado");
            }
        },

        error: function() {
            // Trate erros de requisição, se necessário.
           $("#NomeFornecedor").val("Erro ao buscar o fornecedor");
        }
    });

});
