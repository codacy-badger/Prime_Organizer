<?php
    // batch_organizer_mautic.php
    // Passa toda a tabela Contatos do Organizer para a base do Mautic
    
    // Integração do Organizer
    require 'organizer-func.php';

    $query = sql("SELECT * FROM `tb_contato`", $eo);

    while($res = db_fetch_assoc($query)){

        //Recebimento das variáveis do Organizer
        $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú");
        $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");

        $nome = preg_replace($vogais, $subs, $data['str_primeiro_nome']);
        $sobrenome = preg_replace($vogais, $subs, $data['str_sobrenome']);
        $empresa = empresa($data['empresa_id']);
        $empresa = preg_replace($vogais, $subs, $empresa);
        $empresa = valida_empresa($empresa);

        $relacionamento = relacao($data['tipo_id']);
        $email = $data['str_email1'];
        $tel1 = $data['str_telefone1'];
        $tel2 = $data['str_telefone2'];
        $cidade = preg_replace($vogais, $subs, $data['cidade']);
        $estado = estado($data['uf']);

        // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
        $timestamp = date('Y-m-d H:i:s', time());

        $empt = array();
        $empt = serialize($empt);

        // Inicio da Query
        require('mautic-conn.php');

        $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
        VALUES (1,1,'{$timestamp}',1,'admin admin','{$timestamp}',1,'admin admin',0,'{$empt}','{$empt}','gravatar','{$nome}','{$sobrenome}','{$empresa}','{$relacionamento}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

        $conn->query($sql);
        
        $id = sqlValue("SELECT id FROM tb_contato WHERE str_primeiro_nome LIKE '{$nome}', str_sobrenome LIKE '{$sobrenome}', empresa_id = '{$data['empresa_id']}'", $eo);

        $id_func = funcionario_id($id);

        $id_empr = empresa_id($empresa);

        $sql = "INSERT INTO `companies_leads` (company_id, lead_id, date_added, is_primary) VALUES ('{$id_empr}','{$id_func}', '{$timestamp}', 1)";

        if($conn -> query($sql)){
            echo "Contato $id_func OK<br/>";
        }
    }
    
?>
