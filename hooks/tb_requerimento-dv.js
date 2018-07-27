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
    
    
    // Esconde os botões Salvar/Inserir se o usuário não é do grupo RH (2), ADMIN (3) ou Vagas (8)
    $j('#update, #insert, #delete').on('change', function(){
        var groupID = parseInt(getCookie('groupID'));
        
        if(groupID == 2 || groupID == 3 || groupID == 8){
            // Esconde os botões Salvar/Inserir se o requerimento já está aprovado/rejeitado
            var Status = $j('#str_status').val();
        
            if(Status != "Pendente"){
                $j('#update, #insert').parents('.btn-group-vertical').hide();
                $j('#delete').hide();
            }
        } else {
            $j(this).parents('.btn-group-vertical').hide();
        }
        
    }).change();
    
    
    // Esconde os botões Abrir Vagas/Rejeitar Requisição se o usuário não é do grupo RH (2), ADMIN (3) ou Vagas (8)
    $j('#yes').on('change', function(){
        var groupID = parseInt(getCookie('groupID'));
        
        if(groupID == 2 || groupID == 3 || groupID == 8){
            // Esconde os botões Abrir Vagas/Rejeitar Requisição se o requerimento já está aprovado/rejeitado
            var Status = $j('#str_status').val();
        
            if(Status != "Pendente"){
                $j(this).parents('.btn-group-vertical').hide();
            }
        } else {
            $j(this).parents('.btn-group-vertical').hide();
        }
        
    }).change();
    
        
    // Verifica se o salário/budget é um número maior que 0
    $j('#update, #insert').click(function(){
        var Salario = $j('#int_salario').val();
        var Quantidade = $j('#int_n_vagas').val();
        var Ok = true;

        // Verifica se a quantidade de vagas é um número maior que 0
        if(isNaN(Quantidade) || Quantidade <= 0){
            Ok = false;
            return show_error('int_n_vagas', 'Quantidade de Vagas', 'A quantidade de vagas deve ser um número válido maior que 0.');
        }
        
        // Verifica se o salário/budget é um número maior que 0
        if(isNaN(Salario) || Salario <= 0){
            Ok = false;
            return show_error('int_salario', 'Salário/Budget', 'Salário/Budget deve ser um número maior ou igual à 0.');
        }
        
        // Ativa o campo status para habilitar salvamento
        if(Ok == true){
            $j('#str_status').prop({
                disabled: false
            });
        }
        
    });
    
    
    // Aprova a requisição
    $j('#aprovar').click(function(){
        
        $j('#str_status').prop({
            disabled: false
        });
        
        $j('#str_status').val("Aprovado");
        $j('#update').trigger("click");

    });

    
    // Rejeita a requisição
    $j('#rejeitar').click(function(){
        
        $j('#str_status').prop({
            disabled: false
        });
        
        $j('#str_status').val("Rejeitado");
        $j('#update').trigger("click");

    });
    
    
});

