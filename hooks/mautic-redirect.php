<?php    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'organizer-func.php';

    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/../defaultLang.php");
	include("$hooks_dir/../language.php");
	include("$hooks_dir/../lib.php");

    $id = intval($_REQUEST['SelectedID']);
        
    $query = sql("SELECT * FROM `tb_contato` WHERE id='{$id}'", $eo);
    
    $data = db_fetch_assoc($query);

    $nome = preg_replace($vogais, $subs, $data["str_primeiro_nome"]);
    $sobrenome = preg_replace($vogais, $subs, $data["str_sobrenome"]);
    $empresa = empresa($data['empresa_id']);
    $empresa = preg_replace($vogais, $subs, $empresa);
    $empresa = valida_empresa($empresa);

    $id_func = funcionario_id($nome, $sobrenome, $empresa);

    echo('Location: http://localhost/conteudo/s/contacts/view/'.$id_func);
?>