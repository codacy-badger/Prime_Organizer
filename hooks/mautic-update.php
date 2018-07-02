<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'organizer-func.php';

    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/../defaultLang.php");
	include("$hooks_dir/../language.php");
	include("$hooks_dir/../lib.php");


    $id = intval($_REQUEST['selectedID']);
    
    // Identifica o usuário no Mautic antes de alterá-lo
    $query = sql("SELECT * FROM tb_contato WHERE id = '{$id}'", $eo);
    $res = db_fetch_assoc($query);

    $nome_old = preg_replace($vogais, $subs, $res['str_primeiro_nome']);
    $sobrenome_old = preg_replace($vogais, $subs, $res['str_sobrenome']);
    $empresa_old = empresa($res['empresa_id']);
    $empresa_old = preg_replace($vogais, $subs, $empresa_old);
    $empresa_old = valida_empresa($empresa_old);

    echo $nome_old.'<br/>';
    echo $sobrenome_old.'<br/>';
    echo $empresa_old.'<br/>';

    $id_func = funcionario_id($nome_old, $sobrenome_old, $empresa_old);

    echo $id_func.'<br/><br/>';

    //Recebimento das variáveis do Organizer
    $data = array('str_primeiro_nome' => 'Rafael', 'str_sobrenome' => 'Carneiro de Moraes', 'empresa_id' => 5, 'tipo_id' => 2, 'str_email1' => 'rafinhacarneiro@outlook.com', 'str_telefone1' => '41 3346 7709', 'str_telefone2' => '41 9947 3722', 'cidade' => 'Curitiba', 'uf' => 'PR');

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

    // Inicio da Query
    require 'mautic-conn.php';

    $sql = "UPDATE leads SET firstname = '{$nome}', lastname = '{$sobrenome}', company = '{$empresa}', position = '{$relacionamento}', email = '{$email}', phone = '{$tel1}', mobile = '{$tel2}', city = '{$cidade}', state = '{$estado}' WHERE id = '{$id_func}'";
    
    echo $sql;
    $conn->query($sql);

    if($empresa != $empresa_old){
        $empresa_id = empresa_id($empresa);

        $sql = "UPDATE companies_leads
        SET company_id = '{$empresa_id}'
        WHERE lead_id = '{$id_func}'";

        $conn -> query($sql);
    }

?>