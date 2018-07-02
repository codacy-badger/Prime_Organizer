<?php    
    require 'organizer-func.php';

    $query = sql("SELECT srt_primeiro_nome, str_sobrenome, empresa_id FROM tb_contatos WHERE id = '{$selectedID}'", $eo);
    $data = db_fetch_assoc($query);

    //Recebimento das variáveis do Organizer
    $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");
    
    $nome = str_replace($vogais, $subs, $data['str_primeiro_nome']);
    $sobrenome = str_replace($vogais, $subs, $data['str_sobrenome']);
    $empresa = str_replace($vogais, $subs, $data['empresa_id']);
    $empresa = valida_empresa(empresa($empresa));
    
    // Inicio da Query
    require('mautic-conn.php');    
    
    // Deleta o registro do Funcionário
    $id_func = funcionario_id($nome, $sobrenome, $empresa);
    $sql = "DELETE FROM leads WHERE id = '{$id_func}'";
    $conn->query($sql);
    
    // Retira o funcionário da tabela que liga Funcionário-Empresa
    $id_empr = empresa_id($empresa);
    $sql = "DELETE FROM `companies_leads` WHERE company_id = '{$id_empr}' AND lead_id = '{$id_func}'";

    $conn -> query($sql);
?>