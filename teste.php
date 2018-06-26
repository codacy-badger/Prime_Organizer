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

<form action="api-mautic.php" method="POST">
    <input hidden type="text" name="clientKey" value="4uaxpgcn756okw8wk4ss8ggc0kosg0084w4occ84kcskskgc04">
    <input hidden type="text" name="clientSecret" value="587mnnsz8bwok8ccwcwkck88ww4sk84gk8wgg4sgck84kwcowo">
    <input hidden type="text" name="mauticBaseUrl" value="http://localhost/conteudo">
    
    <input type="submit">
</form>
