<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'organizer-func.php';

    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__).'/..';
	include("$hooks_dir/defaultLang.php");
	include("$hooks_dir/language.php");
	include("$hooks_dir/lib.php");

    $id = intval($_REQUEST['selectedID']);

    // Identifica o usuário no Mautic antes de alterá-lo
    $sql = "SELECT * FROM tb_contatos WHERE id = '{$id}'";
    echo $sql;
    if($query = sql($sql, $eo)){
        echo "ok";
    }
    $res = db_fetch_assoc($query);

    var_dump($res)."<br/><br/>";

    $n = str_replace($vogais, $subs, $res['str_primeiro_nome']);
    echo $n."<br/>";
    $s = str_replace($vogais, $subs, $res['str_sobrenome']);
    echo $s."<br/>";
    $e = str_replace($vogais, $subs, $res['empresa_id']);
    $e = valida_empresa(empresa($e));
    echo $e."<br/>";
        
    $id_func = funcionario_id($nome_old, $sobrenome_old, $empresa_old);
    echo $id_func."<br/>";

?>