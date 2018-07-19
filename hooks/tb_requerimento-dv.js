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
    
    
    // Desabilita o campo 'str_status'
    $j('#str_status').on('change', function(){
        $j('#str_status').prop({
           disabled: true 
        });
    }).change();
    
    
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
    
    
    // Esconde os botões Aprovar/Rejeitar se o usuário não é do grupo RH (2), ADMIN (3) ou Vagas (8)
    $j('#aprovar, #rejeitar').on('change', function(){
        var groupID = parseInt(getCookie('groupID'));
        
        if(groupID == 2 || groupID == 3 || groupID == 8){
            $j(this).parents('.btn-group-vertical').show();
        } else {
            $j(this).parents('.btn-group-vertical').hide();
        }
    }).change();
    
    
    // Esconde o campo Alocação de Recurso se a empresa não tem alocações cadastradas
    $j('#empresa_id').on('change', function(){
        $j('#str_alocacao').trigger('atualizaCampo');
    }).change();
    
    // Implementar trigger('click') em empresa_id que ativa o campo str_aclocacao e checa a quantidade de li na ul .select2-results
    $j('#str_alocacao').on('atualizaCampo', function(){
        $j('#str_alocacao').parents('.form-group').show();
    });
    
    
    // Esconde os campos Data de Abertura e Data de Fechamento se o usuário não é do grupo RH (2), ADMIN (3) ou Vagas (8)
    $j('#dta_abertura, #dta_fechamento').on('change', function(){
        var groupID = parseInt(getCookie('groupID'));
        
        if(groupID == 2 || groupID == 3 || groupID == 8){
            $j(this).parents('.form-group').show();
        } else {
            $j(this).parents('.form-group').hide();
        }
    }).change();
    

    // Verifica se a quantidade de vagas é um número maior que 0
    $j('#update, #insert').click(function(){
        var Quantidade = $j('#int_n_vagas').val();

        if(isNaN(Quantidade) || Quantidade <= 0){
            return show_error('int_n_vagas', 'Quantidade de Vagas', 'A quantidade de vagas deve ser um número válido maior que 0.');
        }
    });

    
});

