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
    
    date_object.setHours(0,0,0,0);
    
    // Se o ano não foi resgatado, retorna falso
    if(!ano){
        return false;
    }

    return date_object;
}

// Recupera o cookie com a groupID do usuário
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


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
    }).change();
    
    
    // Esconde o campo Data de Previsão de Fechamento se o usuário não pertence ao grupo RH, Vagas ou Admin
    $j('#dta_previsao_fechamento').on('change', function(){
        var GroupID = parseInt(getCookie('groupID'));
        
        // groupID válidos: 2 (Admins), 3 (RH), 8 (Vagas)
        if(GroupID == 2 || GroupID == 3 || GroupID == 8){
            $j('#dta_previsao_fechamento').parents('.form-group').show();
        } else{
            $j('#dta_previsao_fechamento').parents('.form-group').hide();
        }
    }).change();
    
    
    // Verifica se a quantidade de vagas é um número maior que 0
    $j('#update, #insert').click(function(){
        var Quantidade = $j('#int_n_vagas').val();

        if(isNaN(Quantidade) || Quantidade <= 0){
            return show_error('int_n_vagas', 'Quantidade de Vagas', 'A quantidade de vagas deve ser um número válido maior que 0.');
        }
    });

    
    // Verifica se a data de indicação é atual ou futura
    $j('#update, #insert').click(function(){
        var Hoje = new Date();
        Hoje.setHours(0,0,0,0);
        
        var DataIndicacao = get_data('dta_indicacao');
        DataIndicacao.setHours(0,0,0,0);

        if(DataIndicacao < Hoje){
            return show_error('dta_indicacao', 'Data para Indicação','A data para indicação deve ser atual ou futura.');
        }
    });
    
    
    // Verifica se a data de previsão de fechamento é igual ou futura à de indicação
    $j('#update, #insert').click(function(){
        var DataIndicacao = get_data('dta_indicacao');
        var DataPrev = get_data('dta_previsao_fechamento');

        if(DataPrev < DataIndicacao){
            return show_error('dta_previsao_fechamento', 'Data de Previsao de Fechamento','A Data de Previsão de Fechamento deve ser igual ou futura à Data de Indicação.');
        }
    });
    
    
    // Desabilita o select de Status do Requerimento se o usuário não pertence ao grupo de usuários válido
    $j('#str_status').on('change', function(){
        var GroupID = parseInt(getCookie('groupID'));
        
        // groupID válidos: 2 (Admins), 3 (RH), 8 (Vagas)
        if(GroupID == 2 || GroupID == 3 || GroupID == 8){
            // Habilita o Select
            $j(this).prop({
                disabled: false
            });
        } else{
            // Desabilita o Select
            $j(this).prop({
                disabled: true
            });            
        }
    }).change();
    
    
});

