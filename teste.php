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
    <input hidden type="text" name="clientKey" value="alcrm5iergg040c408owwkcgk4sk00sg4c0kkwcw4040g4oos">
    <input hidden type="text" name="clientSecret" value="3aphl7804y4g4wgkc804o400s08swc8g8s4oogc4kkcgwww000">
    <input hidden type="text" name="mauticBaseUrl" value="">
    
    <input type="submit">
</form>
