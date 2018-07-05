$j(function(){
    
    // Esconde o campo 'str_recurso' se o campo 'str_reposicao' está marcado como "NÃO"
    $j('#str_reposicao').on('change', function(){
        var Reposicao = $j('#str_reposicao').val();
        
        if(Reposicao == 'SIM'){
            $j('#str_recurso').parents('.form-group').show();
            $j('#str_recurso').focus().select();
        } else {
            $j('#str_recurso').parents('.form-group').hide();
        }
    });
    
    // Força uma change() no campo 'str_reposicao' para esconder ou mostrar o campo 'str_recurso'
    $j('#str_reposicao').change();
    
    // Verifica se a quantidade de vagas é um número maior que 0
    $j('#update, #insert').click(function(){
        var Quantidade = $j('#int_n_vagas').val();

        if(isNaN(Quantidade) || Quantidade <= 0){
            return show_error('int_n_vagas', 'Quantidade de Vagas', 'A quantidade de vagas deve ser um número válido maior que 0.');
        }
    });

    // Verifica se a data é atual ou futura
    $j('#update', '#insert').click(function(){
        var Hoje = new Date();
        var DataIndicacao = get_data('data_indicacao');

        if(DataIndicacao < Hoje){
            return show_error('data_indicacao', 'Data para Indicação','A data para indicação deve ser atual ou futura.');
        }
    });
    
});


// Mostra um modal com uma mensagem de erro e foca no capo com erro depois de fechado
function show_error(campo, titulo, msg){
    modal_window({
        message: '<div class="alert alert-danger">' + msg + '</div>',
        title: 'Erro em ' + titulo,
        close: function(){
            $j('#' + campo).parents('.form-group').focus();
            $j('#' + campo).parents('.form-group').addClass('has-error');
        }
    });

    return false;
}

// Recupera a data do campo 'data_indicacao'
function get_data(campo){
    var ano = $j('#' + campo).val();
    var mes = $j('#' + campo + '-mm').val();
    var dia = $j('#' + campo + '-dd').val();

    var date_object = new Date(ano, mes - 1, dia);
    
    // Se o ano não foi resgatado, retorna falso
    if(!ano){
        return false;
    }

    return date_object;
}