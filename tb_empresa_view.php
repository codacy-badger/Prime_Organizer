<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/tb_empresa.php");
	include("$currDir/tb_empresa_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('tb_empresa');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "tb_empresa";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`tb_empresa`.`id`" => "id",
		"`tb_empresa`.`str_nome_fantasia`" => "str_nome_fantasia",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') /* Gerente da conta */" => "str_responsavel",
		"IF(    CHAR_LENGTH(`tb_contato_tipo1`.`str_nome`), CONCAT_WS('',   `tb_contato_tipo1`.`str_nome`), '') /* Relacionamento */" => "relacionamento_id",
		"`tb_empresa`.`cidade`" => "cidade",
		"`tb_empresa`.`uf`" => "uf"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`tb_empresa`.`id`',
		2 => 2,
		3 => '`tb_recrutador1`.`str_nome`',
		4 => '`tb_contato_tipo1`.`str_nome`',
		5 => 5,
		6 => 6
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`tb_empresa`.`id`" => "id",
		"`tb_empresa`.`str_nome_fantasia`" => "str_nome_fantasia",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') /* Gerente da conta */" => "str_responsavel",
		"IF(    CHAR_LENGTH(`tb_contato_tipo1`.`str_nome`), CONCAT_WS('',   `tb_contato_tipo1`.`str_nome`), '') /* Relacionamento */" => "relacionamento_id",
		"`tb_empresa`.`cidade`" => "cidade",
		"`tb_empresa`.`uf`" => "uf"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`tb_empresa`.`id`" => "ID",
		"`tb_empresa`.`str_nome_fantasia`" => "Nome fantasia",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') /* Gerente da conta */" => "Gerente da conta",
		"IF(    CHAR_LENGTH(`tb_contato_tipo1`.`str_nome`), CONCAT_WS('',   `tb_contato_tipo1`.`str_nome`), '') /* Relacionamento */" => "Relacionamento",
		"`tb_empresa`.`cidade`" => "Cidade",
		"`tb_empresa`.`uf`" => "UF"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`tb_empresa`.`id`" => "id",
		"`tb_empresa`.`str_nome_fantasia`" => "str_nome_fantasia",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') /* Gerente da conta */" => "str_responsavel",
		"IF(    CHAR_LENGTH(`tb_contato_tipo1`.`str_nome`), CONCAT_WS('',   `tb_contato_tipo1`.`str_nome`), '') /* Relacionamento */" => "relacionamento_id",
		"`tb_empresa`.`cidade`" => "cidade",
		"`tb_empresa`.`uf`" => "uf"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'str_responsavel' => 'Gerente da conta', 'relacionamento_id' => 'Relacionamento');

	$x->QueryFrom = "`tb_empresa` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_empresa`.`str_responsavel` LEFT JOIN `tb_contato_tipo` as tb_contato_tipo1 ON `tb_contato_tipo1`.`id`=`tb_empresa`.`relacionamento_id` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 0;
	$x->RecordsPerPage = 30;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "tb_empresa_view.php";
	$x->RedirectAfterInsert = "tb_empresa_view.php?SelectedID=#ID#";
	$x->TableTitle = "Contas";
	$x->TableIcon = "resources/table_icons/factory.png";
	$x->PrimaryKey = "`tb_empresa`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150);
	$x->ColCaption = array("Nome fantasia", "Gerente da conta", "Relacionamento", "Cidade", "UF");
	$x->ColFieldName = array('str_nome_fantasia', 'str_responsavel', 'relacionamento_id', 'cidade', 'uf');
	$x->ColNumber  = array(2, 3, 4, 5, 6);

	// template paths below are based on the app main directory
	$x->Template = 'templates/tb_empresa_templateTV.html';
	$x->SelectedTemplate = 'templates/tb_empresa_templateTVS.html';
	$x->TemplateDV = 'templates/tb_empresa_templateDV.html';
	$x->TemplateDVP = 'templates/tb_empresa_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_empresa`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_empresa' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_empresa`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_empresa' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`tb_empresa`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: tb_empresa_init
	$render=TRUE;
	if(function_exists('tb_empresa_init')){
		$args=array();
		$render=tb_empresa_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: tb_empresa_header
	$headerCode='';
	if(function_exists('tb_empresa_header')){
		$args=array();
		$headerCode=tb_empresa_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: tb_empresa_footer
	$footerCode='';
	if(function_exists('tb_empresa_footer')){
		$args=array();
		$footerCode=tb_empresa_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>