<?php
	define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/defaultLang.php");
	include("$hooks_dir/language.php");
	include("$hooks_dir/lib.php");
	
	/* grant access to the groups 'Admins' and 'Data entry' */
	
	$auth_tab = get_sql_from('tb_contato');
    if(!$auth_tab){
        header('HTTP/1.0 401 Unauthorized');
        exit;
    }

    $selectedID = intval($_REQUEST['SelectedID']);
        
    $query = sql("SELECT * FROM `tb_contato` WHERE id='{$selectedID}'", $eo);
    
    $res = json_encode(db_fetch_assoc($query));

    echo $res;
    
?>
