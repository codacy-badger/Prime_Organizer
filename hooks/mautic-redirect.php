<?php    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/../defaultLang.php");
	include("$hooks_dir/../language.php");
	include("$hooks_dir/../lib.php");

    require 'organizer-func.php';
    
    $id = intval($_REQUEST['SelectedID']);
        
    $id_func = funcionario_id($id);

    header('Location: http://localhost/conteudo/s/contacts/view/'.$id_func);
?>