<?php
    
    // Integração do Organizer
    require('organizer-func.php');

    $id = intval($_REQUEST['SelectedID']);
        
    $query = sql("SELECT * FROM `tb_contato` WHERE id='{$id}'", $eo);
    
    $res = db_fetch_assoc($query);
    
    var_dump($res);

    //Recebimento das variáveis do Organizer
    $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");
    
    $nome = $res["str_primeiro_nome"];
    $sobrenome $res["str_sobrenome]";
    $empresa = empresa($res["empresa_id"]);
    $relacionamento = rel($res["tipo_id"]);
    $email = $res["str_email"];
    $tel1 = $res["str_telefone1"];
    $tel2 = $res["str_telefone2"];
    $cidade = str_replace($subs, $vogais, $res["cidade"]);
    $estado = str_replace($subs, $vogais, $res["uf"]);
    $pais = 'Brazil';

    // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
    $timestamp = new DateTime();
    $timestamp -> format('Y-m-d H:i:s');

    $empt = array();
    $empt = serialize($empt);

    // Inicio da Query
    require('mautic-conn.php');
    
    $stmt = $conn->prepare("INSERT INTO `leads`(`owner_id`, `is_published`, `date_added`, `created_by`, `created_by_user`, `date_modified`, `modified_by`, `modified_by_user`, `checked_out`, `checked_out_by`, `checked_out_by_user`, `points`, `internal`, `social_cache`, `date_identified`, `preferred_profile_image`, `firstname`, `lastname`, `company`, `position`, `email`, `phone`, `mobile`, `city`, `state`, `country`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param("iisississisissssssssssssss", $owner_id, $is_published, $date_added, $create_by, $create_by_user, $date_modified, $modified_by, $modified_by_user, $checked_out, $checked_out_by, $checked_out_by_user, $points, $internal, $social_cache, $date_identified, $preferred_profile_image, $firstname, $lastname, $company, $position, $email, $phone, $mobile, $city, $state, $country);
    
    $owner_id = 1;
    $is_published = 1;
    $date_added = $timestamp;;
    $created_by = 1;
    $created_by_user = 'admin admin';
    $date_modified = $timestamp;
    $modified_by = 1;
    $modified_by_user = 'admin admin';
    $checked_out = $timestamp;
    $checked_out_by = 1;
    $checked_out_by_user = 'admin admin';
    $points = 0;    
    $internal = $empt;
    $social_cache = $empt;
    $date_identified = $timestamp;
    $preferred_profile_image = 'gravatar';
    $firstname = $nome;
    $lastname = $sobrenome;
    $company = $empresa;
    $position = $relacionamento;
    $email = $email;
    $phone = $tel1;
    $mobile = $tel2;
    $city = $cidade;
    $state = $estado;
    $country = $pais;


?>