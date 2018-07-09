<?php
    
    require 'organizer-conn.php';
    require 'organizer-func.php';

    if($query = $org -> query("SELECT str_primeiro_nome, str_sobrenome, empresa_id, str_nivel, tipo_id, str_email1, str_telefone1, str_telefone2, cidade, uf FROM tb_contato")){
        echo "Query ok<br/>";
    }

    if($data = $query -> fetch_all(MYSQLI_BOTH)){
        echo "Fetch ok<br/><br/>";
    }
       
    $org -> close();
    
    for($i = 0; $i < count($data); $i++){
        echo "Contato $i<br/>";
        // Captura dos dados do Organizer
        $nome = retira_caracter_especial($data[$i]['str_primeiro_nome']);
        $sobrenome = retira_caracter_especial($data[$i]['str_sobrenome']);
        
        $empresa = get_empresa_nome_organizer($data[$i]['empresa_id']);
        $empresa = retira_caracter_especial($empresa);
        $empresa = check_company_existe_mautic($empresa);
        
        $cargo = retira_caracter_especial($data[$i]['str_nivel']);
        $relacionamento = check_tag_mautic($data[$i]['tipo_id']);
        
        $email = $data[$i]['str_email1'];
        $tel1 = $data[$i]['str_telefone1'];
        $tel2 = $data[$i]['str_telefone2'];
        
        $cidade = retira_caracter_especial($data[$i]['cidade']);
        $estado = get_estado($data[$i]["uf"]);

        // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
        $hora = date('Y-m-d H:i:s', time());
        $vazio = array();
        $vazio = serialize($vazio);

        // Inicio da Query
        require('mautic-conn.php');
        
        // Insere o contato como lead no Mautic
        $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, date_identified, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
        VALUES (1,1,'{$hora}',1,'admin admin','{$hora}',1,'admin admin',0,'{$vazio}','{$vazio}', '{$hora}','gravatar','{$nome}','{$sobrenome}','{$empresa}','{$cargo}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

        if($conn -> query($sql)){
            echo 'Insert Lead OK<br/>';
        }
        
        // Recupera o id no Mautic do contato criado
        $lead_id = get_lead_id_by_email_mautic($email);
        $company_id = get_company_id_mautic($empresa);

        // Insere o relacionamento do Organizer como uma tag no Mautic
        $sql = "INSERT INTO `lead_tags_xref` (id, tag)
        VALUES ('{$lead_id}','{$relacionamento}');";

        // Faz o link do contato com uma empresa no Mautic para que o mesmo seja exibido
        $sql .= "INSERT INTO `companies_leads` (company_id, lead_id, date_added, is_primary, manually_removed, manually_added)
        VALUES ('{$company_id}','{$lead_id}', '{$hora}', 1, 0, 0);";
        
        if($conn -> multi_query($sql)){
            echo 'Insert Lead in Company OK<br/>';            
        }
    }
    
?>
