<?php
    
    // Integração do Organizer
    require 'organizer-func.php';

    $id = intval($_REQUEST['SelectedID']);
        
    $query = sql("SELECT * FROM `tb_contato` WHERE id='{$id}'", $eo);
    
    $res = db_fetch_assoc($query);

    //Recebimento das variáveis do Organizer
    $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");
    
    $nome = $res["str_primeiro_nome"];
    $sobrenome = $res["str_sobrenome"];
    $empresa = valida_empresa(empresa($res["empresa_id"]));
    $relacionamento = relacao($res["tipo_id"]);
    $email = $res["str_email1"];
    $tel1 = $res["str_telefone1"];
    $tel2 = $res["str_telefone2"];
    $cidade = str_replace($subs, $vogais, $res["cidade"]);
    $estado = str_replace($subs, $vogais, $res["uf"]);
    $pais = 'Brazil';

    // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
    $timestamp = date('Y-m-d H:i:s', time());

    $empt = array();
    $empt = serialize($empt);

    // Inicio da Query
    require('mautic-conn.php');
    
    $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
    VALUES (1,1,'{$timestamp}',1,'admin admin','{$timestamp}',1,'admin admin',0,'{$empt}','{$empt}','gravatar','{$nome}','{$sobrenome}','{$empresa}','{$relacionamento}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

    $conn->query($sql);

    $id_func = funcionario_id($nome, $sobrenome, $empresa);

    $id_empr = empresa_id($empresa);

    $sql = "INSERT INTO `companies_leads` (company_id, lead_id, date_added, is_primary) VALUES ('{$id_empr}','{$id_func}', '{$timestamp}', 1)";

    if($conn -> query($sql)){
        header('Location: http://localhost/conteudo/s/contacts/edit/'.$id_func);
    }
    
?>