<?php    
    require 'organizer-func.php';

    $id = intval($_REQUEST['SelectedID']);
        
    $query = sql("SELECT str_primeiro_nome, str_sobrenome, empresa_id FROM `tb_contato` WHERE id='{$id}'", $eo);
    
    $res = db_fetch_assoc($query);

    $nome = $res["str_primeiro_nome"];
    $sobrenome = $res["str_sobrenome"];
    $empresa = valida_empresa(empresa($res["empresa_id"]));

    $id_func = funcionario_id($nome, $sobrenome, $empresa);

    header('Location: http://localhost/conteudo/s/contacts/view/'.$id_func);
?>