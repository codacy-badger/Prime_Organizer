<?php
    // Integração do Organizer
	define('PREPEND_PATH', '../');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/../defaultLang.php");
	include("$hooks_dir/../language.php");
	include("$hooks_dir/../lib.php");

    require 'organizer-conn.php';
    require 'organizer-func.php';

    if($query = $org -> query("SELECT * FROM tb_contato")){
        echo "Query ok<br/>";
    }

    if($data = $query -> fetch_all(MYSQLI_BOTH)){
        echo "Fetch ok<br/>";
    }
       
    $org -> close();
    
    for($i = 0; $i < count($data); $i++){
        $vogais = array("/Á/", "/á/", "/Ã/", "/ã/", "/Â/", "/â/", "/É/", "/é/", "/Ê/", "/ê/", "/Í/", "/í/", "/Ó/", "/ó/", "/Ô/", "/ô/", "/Õ/", "/õ/", "/Ú/", "/ú/", "/Ç/", "/ç/");
        $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u", "C", "c");

        //Recebimento das variáveis do Organizer
        $nome = preg_replace($vogais, $subs, $data[$i]['str_primeiro_nome']);
        $sobrenome = preg_replace($vogais, $subs, $data[$i]['str_sobrenome']);
        $empresa = empresa($data[$i]['empresa_id']);
        $empresa = preg_replace($vogais, $subs, $empresa);
        $empresa = valida_empresa($empresa);

        $relacionamento = relacao($data[$i]['tipo_id']);
        $email = $data[$i]['str_email1'];
        $tel1 =$data[$i]['str_telefone1'];
        $tel2 = $data[$i]['str_telefone2'];
        $cidade = preg_replace($vogais, $subs, $data[$i]['cidade']);
        $estado = estado($data[$i]['uf']);

        // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
        $timestamp = date('Y-m-d H:i:s', time());

        $empt = array();
        $empt = serialize($empt);

        // Inicio da Query
        require('mautic-conn.php');

        $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
        VALUES (1,1,'{$timestamp}',1,'admin admin','{$timestamp}',1,'admin admin',0,'{$empt}','{$empt}','gravatar','{$nome}','{$sobrenome}','{$empresa}','{$relacionamento}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

        $conn->query($sql);
        
        $id = id_org($nome, $sobrenome, $data[$i]['empresa_id']);

        $id_func = funcionario_id($id);
        echo "Contato Mautic: $id_func<br/>";

        $id_empr = empresa_id($empresa);
        echo "Empresa Mautic: $id_empr<br/>";

        $sql = "INSERT INTO `companies_leads` (company_id, lead_id, date_added, is_primary) VALUES ('{$id_empr}','{$id_func}', '{$timestamp}', 1)";
        
        $conn -> query($sql);
        echo "Contato $id_func OK<br/><br/>";
        
        $conn -> close();
    }
    
?>
