<?php    
    require 'organizer-func.php';

    $id = intval($_REQUEST['SelectedID']);
        
    $query = sql("SELECT str_primeiro_nome, str_sobrenome, empresa_id FROM `tb_contato` WHERE id='{$id}'", $eo);
    
    $data = db_fetch_assoc($query);

    $nome = str_replace($vogais, $subs, $data["str_primeiro_nome"]);
    $sobrenome = str_replace($vogais, $subs, $data["str_sobrenome"]);
    $empresa = str_replace($vogais, $subs, $data["empresa_id"]);
    $empresa = valida_empresa(empresa($empresa));

    $id_func = funcionario_id($nome, $sobrenome, $empresa);

    header('Location: http://localhost/conteudo/s/contacts/view/'.$id_func);
?>