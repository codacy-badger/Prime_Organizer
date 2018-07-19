<?php
    
    require 'organizer-conn.php';
    require 'organizer-func.php';

    if($query = $org -> query("SELECT str_primeiro_nome, str_sobrenome, empresa_id, str_nivel, tipo_id, str_email1, str_telefone1, str_telefone2, cidade, uf FROM tb_contato")){
        echo "Query ok<br/>";
    }

    if($datas = $query -> fetch_all(MYSQLI_BOTH)){
        echo "Fetch ok<br/><br/>";
    }
       
    $org -> close();
    
    for each($data as $datas){
        echo "Contato ".$data['str_primeiro_nome']." ".$data['str_sobrenome']."<br/>";
        // Captura dos dados do Organizer
        $email = $data['str_email1'];
        
        // Se o contato existe, atualiza o mesmo
        if($lead_id = get_lead_id_by_email_mautic($email)){
            
            $empresa_old = get_companyname_by_lead_id_mautic($lead_id);
            $relacionamento_old = get_lead_tag_by_lead_id_mautic($lead_id);

            // Captura dos dados do Organizer
            $nome = retira_caracter_especial($data['str_primeiro_nome']);
            $sobrenome = retira_caracter_especial($data['str_sobrenome']);

            $empresa_org = get_empresa_nome_organizer($data['empresa_id']);
            $empresa_nome = retira_caracter_especial($empresa_org);
            $empresa = check_company_existe_mautic($empresa_nome);

            $cargo = retira_caracter_especial($data['str_nivel']);
            $relacionamento = check_tag_mautic($data['tipo_id']);

            $tel1 = $data['str_telefone1'];
            $tel2 = $data['str_telefone2'];

            $cidade = retira_caracter_especial($data['cidade']);
            $estado = get_estado($data["uf"]);

            // Inicio da Query
            require 'mautic-conn.php';

            $sql = "UPDATE leads
            SET firstname = '{$nome}', lastname = '{$sobrenome}', company = '{$empresa}', position = '{$cargo}', email = '{$email}', phone = '{$tel1}', mobile = '{$tel2}', city = '{$cidade}', state = '{$estado}'
            WHERE id = '{$lead_id}';";

            // Revisa se o contato trocou de empresa e atualiza no Mautic        
            if($empresa_old != $empresa){
                $nova_empresa = get_company_id_mautic($empresa);

                $sql .= "UPDATE companies_leads
                SET company_id = '{$nova_empresa}'
                WHERE lead_id = '{$lead_id}';";

            }

            // Revisa se o contato trocou de relacionamento e atualiza no Mautic        
            if($relacionamento_old != $relacionamento){

                $sql .= "UPDATE lead_tags_xref
                SET tag_id = '{$relacionamento}'
                WHERE lead_id = '{$lead_id}'";

            }

            $conn -> multi_query($sql);
            
        // Senão, cria o contato no Mautic   
        } else{
            
            // Captura dos dados do Organizer
            $nome = retira_caracter_especial($data['str_primeiro_nome']);
            $sobrenome = retira_caracter_especial($data['str_sobrenome']);

            $empresa_org = get_empresa_nome_organizer($data['empresa_id']);
            $empresa_nome = retira_caracter_especial($empresa_org);
            $empresa = check_company_existe_mautic($empresa_nome);

            $cargo = retira_caracter_especial($data['str_nivel']);
            $relacionamento = check_tag_mautic($data['tipo_id']);

            $tel1 = $data['str_telefone1'];
            $tel2 = $data['str_telefone2'];

            $cidade = retira_caracter_especial($data['cidade']);
            $estado = get_estado($data["uf"]);

            // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
            $hora = date('Y-m-d H:i:s', time());
            $vazio = array();
            $vazio = serialize($vazio);

            // Inicio da Query
            require('mautic-conn.php');

            // Insere o contato como lead no Mautic
            $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, date_identified, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
            VALUES (1,1,'{$hora}',1,'admin admin','{$hora}',1,'admin admin',0,'{$vazio}','{$vazio}', '{$hora}' ,'gravatar','{$nome}','{$sobrenome}','{$empresa}','{$cargo}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

            $conn -> query($sql);

            // Recupera o id no Mautic do contato criado
            $lead_id = get_lead_id_by_email_mautic($email);
            $company_id = get_company_id_mautic($empresa);

            // Insere o relacionamento do Organizer como uma tag no Mautic
            $sql = "INSERT INTO lead_tags_xref (lead_id, tag_id)
            VALUES ('{$lead_id}','{$relacionamento}');";

            // Faz o link do contato com uma empresa no Mautic para que o mesmo seja exibido
            $sql .= "INSERT INTO companies_leads (company_id, lead_id, date_added, is_primary, manually_removed, manually_added)
            VALUES ('{$company_id}','{$lead_id}', '{$hora}', 1, 0, 0);";

            $conn -> multi_query($sql);
        }
        
    }
    
?>
