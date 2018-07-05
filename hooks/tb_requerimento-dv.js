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



// Recupera o Cookie setado no login do usuário
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
    
    // Força uma change() no campo 'str_reposicao' para esconder ou mostrar o campo 'str_recurso'
    // $j('#str_reposicao').change();
    
    
    
    // Verifica se a quantidade de vagas é um número maior que 0
    $j('#update, #insert').click(function(){
        var Quantidade = $j('#int_n_vagas').val();

        if(isNaN(Quantidade) || Quantidade <= 0){
            return show_error('int_n_vagas', 'Quantidade de Vagas', 'A quantidade de vagas deve ser um número válido maior que 0.');
        }
    });

    
    
    // Verifica se a data é atual ou futura
    $j('#update, #insert').click(function(){
        var Hoje = new Date();
        Hoje.setHours(0,0,0,0); // Define o horário como zerado para comparar somente a data
        
        var DataIndicacao = get_data('dta_indicacao');

        if(DataIndicacao < Hoje){
            return show_error('dta_indicacao', 'Data para Indicação', 'A data para indicação deve ser atual ou futura.');
        }
    });
    
    
    
    // Libera a mudança de status do requerimento se o usuário é do grupo RH ou Admin
    // $_COOKIE['groupID']: Recupera o groupID do usuário pelo cookie setado em '__global.php'      
    $j('#str_status').on('change', function(){
        var groupID = parseInt(getCookie('groupID'));
        
        // groupID válidos: 2 (Admins), 3 (RH) e 8 (Vagas)
        if(groupID != 2 || groupID != 3 || groupID != 8){
            // Desabilita o Select de Status
            $j('#str_status').prop({
                disabled: true
            });
        }
    });
    
    // Força uma change() no campo 'str_status' para desabilitar o campo 'str_status'
    $j('str_status').change();
   
});
