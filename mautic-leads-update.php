<?php    
    require 'organizer-func.php';

    //Recebimento das variáveis do Organizer
    $vogais = array("Á", "á", "Ã", "ã", "Â", "â", "É", "é", "Ê", "ê", "Í", "í", "Ó", "ó", "Ô", "ô", "Õ", "õ", "Ú", "ú");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");
    
    $nome = $data["str_primeiro_nome"];
    $sobrenome = $data["str_sobrenome"];
    $empresa = valida_empresa(empresa($data["empresa_id"]));
    $relacionamento = relacao($data["tipo_id"]);
    $email = $data["str_email1"];
    $tel1 = $data["str_telefone1"];
    $tel2 = $data["str_telefone2"];
    $cidade = str_replace($subs, $vogais, $data["cidade"]);
    $estado = str_replace($subs, $vogais, estado($data["uf"]));

    // Inicio da Query
    require 'mautic-conn.php';
    
    $id_func = funcionario_id($nome, $sobrenome, $empresa);
    
    $sql = "UPDATE leads (firstname, lastname, company, position, email, phone, mobile, city, state)
    SET ('{$nome}','{$sobrenome}','{$empresa}','{$relacionamento}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}') WHERE id = '{$id_func}'";

    $conn->query($sql);

    $conn -> query($sql);
?>