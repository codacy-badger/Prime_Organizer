$j(function(){
    $j('#str_recurso').on('change', function(){
        var recurso = $j(this).val();
        
        if($j('#str_recurso') == "SIM"){
            $j('#str_recurso').parents('.form-group').show();
            $j('#Freight').focus().select();
        } else if($j('#str_recurso') == "NÃO"){
           $j('#str_recurso').parents('.form-group').hide();
        }
    });
    
    $j('#str_recurso').change();
})