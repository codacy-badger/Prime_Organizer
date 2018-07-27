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

    // Esconde os campos Detalhe de Status, Data de Inicio e Canal Fechamento se a vaga foi encerrada
    $j('#str_status').on('change', function(){
        var Status = $j(this).val();

        // Se a vaga é cancelada
        if(Status == 'Encerrada'){
            // Mostra o campo Detalhe do Status
            $j('#str_detalhe_status').parents('.form-group').show();
        // Senão
        } else{
            // Mostra os campos Data de inicio e Observação
            $j('#str_detalhe_status, #dta_inicio, #canal_fechamento').val("");
            $j('#str_detalhe_status, #dta_inicio, #canal_fechamento').parents('.form-group').hide();
        }

    }).change();
    
    
    // Desativa os campos se a vaga está encerrada
    $j('#dta_previsao_fechamento, #recrutador_id, #str_prioridade').on('change', function(){
        var Status = $j('#str_status').val();
        
        if(Status == 'Encerrada'){
            $j(this).prop({
                disabled: true        
            });
        } else{
            $j(this).prop({
                disabled: false        
            });
        }
        
    }).change();

    
    // Verifica o detalhe do Status                                
    $j('#str_detalhe_status').on('change', function(){
        var Detalhe = $j(this).val();

        // Se a vaga não está marcada como cancelada, mostra o campo Data de Inicio
        if(Detalhe != 'Cancelada'){
            $j('#dta_inicio, #canal_fechamento').parents('.form-group').show();
        } else{
            $j('#dta_inicio').val("");
            $j('#dta_inicio').parents('.form-group').hide();
            $j('#canal_fechamento').parents('.form-group').show();
        }

    }).change();
    
    
    // Salva a alteração da vaga
    $j('#salvar_alt').on('click', function(){
        var Status = $j('#str_status').val();

        if(Status == 'Encerrada'){
            var Confirmar = confirm("A vaga não poderá ser editada futuramente. Realmente deseja encerrar esta vaga?");
            
            if(Confirmar == true){
                $j('#update').trigger('click');
            }
            
        } else{
            $j('#update').trigger('click');
        }
    });
    
    // Esconde os botões Salvar/Inserir/Editar se a vaga está encerrada ou usuário não possui permissão
    $j('#update, #insert, #delete, #editar').on('change', function(){
        
        var groupID = parseInt(getCookie('groupID'));
        
        if(groupID == 2 || groupID == 3 || groupID == 8){
        
            var Status = $j('#str_status').val();

            if(Status == "Encerrada"){
                $j('#update, #insert, #editar').parents('.btn-group-vertical').hide();
                $j('#delete').hide();
            } else {
                $j(this).parents('.btn-group-vertical').show();
            }
            
        } else{
            $j(this).parents('.btn-group-vertical').hide();
        }
        
    }).change();
    
});

