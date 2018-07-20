<?php
	error_reporting(E_ALL);
    ini_set('display_errors', 1);

    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/../defaultLang.php");
	include("$hooks_dir/../language.php");
	include("$hooks_dir/../lib.php");
	
	$od_from = get_sql_from('tb_alocacao');
    if(!$od_from){
        header('HTTP/1.0 401 Unauthorized');
        exit;
    } 
    
    if(isset($_REQUEST['empresa'])){
        $empresa = intval($_REQUEST['empresa']);
        $result = sqlValue("SELECT COUNT(id) FROM tb_alocacao WHERE int_empresa = '{$empresa}'");

	   echo $result;
    }
?>