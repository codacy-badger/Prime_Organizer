<?php
    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/defaultLang.php");
	include("$hooks_dir/language.php");
	include("$hooks_dir/lib.php");

    function empresa($id){
        $nome_empresa = sqlValue("SELECT `str_nome_fantasia` FROM `tb_empresa` WHERE id='{$id}'", $eo);
    
        return $nome_empresa;
    }

    function cria_empresa($id){
        
        if($empresa_existe){
            return true;
        else{
            return false;
        }
    }
        
    function relacionamento($id){
        return rel;
    }
?>