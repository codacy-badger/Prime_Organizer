<?php
    
    // Integração do Organizer
    require 'organizer-func.php';

    //Recebimento das variáveis do Organizer
    $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú", "Ç", "ç");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u", "C", "c");
    
    $nome = str_replace($vogais, $subs, $data["str_primeiro_nome"]);
    $sobrenome = str_replace($vogais, $subs, $data["str_sobrenome"]);
    $empresa = str_replace($vogais, $subs, $data["empresa_id"]);
    $empresa = valida_empresa(empresa($empresa));
    $relacionamento = relacao($data["tipo_id"]);
    $email = $data["str_email1"];
    $tel1 = $data["str_telefone1"];
    $tel2 = $data["str_telefone2"];
    $cidade = str_replace($vogais, $subs, $data["cidade"]);
    $estado = estado($data["uf"]);

    // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
    $hora = date('Y-m-d H:i:s', time());

    $vazio = array();
    $vazio = serialize($vazio);

    // Inicio da Query
    require('mautic-conn.php');
    
    $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
    VALUES (1,1,'".$hora."',1,'admin admin','".$hora."',1,'admin admin',0,'".$vazio."','".$vazio."','gravatar','".$nome."','".$sobrenome."','".$empresa."','".$relacionamento."', '".$email."', '".$tel1."','".$tel2."','".$cidade."', '".$estado."','Brazil')";

    $conn -> query($sql);

    $id_func = funcionario_id($nome, $sobrenome, $empresa);

    $id_empr = empresa_id($empresa);

    $sql = "INSERT INTO `companies_leads` (company_id, lead_id, date_added, is_primary) VALUES ('".$id_empr."','".$id_func."', '".$hora."', 1)";
    
    $conn -> query($sql);
    
?>