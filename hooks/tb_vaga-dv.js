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
    
    // Esconde os botões Salvar/Inserir se a vaga está encerrada
    $j('#update, #insert, #delete, #editar').on('change', function(){
        
        var Status = $j('#str_status').val();

        if(Status == "Encerrada"){
            $j('#update, #insert, #editar').parents('.btn-group-vertical').hide();
            $j('#delete').hide();
        } else {
            $j(this).parents('.btn-group-vertical').show();
        }
        
    }).change();
    
});

