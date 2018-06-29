<?php    
    require 'organizer-func.php';

    //Recebimento das variáveis do Organizer
    $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");
    
    $nome = $data["str_primeiro_nome"];
    $sobrenome = $data["str_sobrenome"];
    $empresa = valida_empresa(empresa($data["empresa_id"]));

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