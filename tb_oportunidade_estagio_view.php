<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/tb_oportunidade_estagio.php");
	include("$currDir/tb_oportunidade_estagio_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('tb_oportunidade_estagio');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "tb_oportunidade_estagio";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`tb_oportunidade_estagio`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "tipo_id",
		"`tb_oportunidade_estagio`.`str_nome`" => "str_nome"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`tb_oportunidade_estagio`.`id`',
		2 => '`tb_oportunidade_tipo1`.`str_nome`',
		3 => 3
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`tb_oportunidade_estagio`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "tipo_id",
		"`tb_oportunidade_estagio`.`str_nome`" => "str_nome"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`tb_oportunidade_estagio`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "Tipo da demanda",
		"`tb_oportunidade_estagio`.`str_nome`" => "Nome"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`tb_oportunidade_estagio`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "tipo_id",
		"`tb_oportunidade_estagio`.`str_nome`" => "str_nome"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'tipo_id' => 'Tipo da demanda');

	$x->QueryFrom = "`tb_oportunidade_estagio` LEFT JOIN `tb_oportunidade_tipo` as tb_oportunidade_tipo1 ON `tb_oportunidade_tipo1`.`id`=`tb_oportunidade_estagio`.`tipo_id` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 0;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 0;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 0;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "tb_oportunidade_estagio_view.php";
	$x->RedirectAfterInsert = "tb_oportunidade_estagio_view.php?SelectedID=#ID#";
	$x->TableTitle = "Est&#225;gios de oportunidades";
	$x->TableIcon = "table.gif";
	$x->PrimaryKey = "`tb_oportunidade_estagio`.`id`";

	$x->ColWidth   = array(  150, 150);
	$x->ColCaption = array("Tipo da demanda", "Nome");
	$x->ColFieldName = array('tipo_id', 'str_nome');
	$x->ColNumber  = array(2, 3);

	// template paths below are based on the app main directory
	$x->Template = 'templates/tb_oportunidade_estagio_templateTV.html';
	$x->SelectedTemplate = 'templates/tb_oportunidade_estagio_templateTVS.html';
	$x->TemplateDV = 'templates/tb_oportunidade_estagio_templateDV.html';
	$x->TemplateDVP = 'templates/tb_oportunidade_estagio_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_oportunidade_estagio`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_oportunidade_estagio' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_oportunidade_estagio`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_oportunidade_estagio' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`tb_oportunidade_estagio`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: tb_oportunidade_estagio_init
	$render=TRUE;
	if(function_exists('tb_oportunidade_estagio_init')){
		$args=array();
		$render=tb_oportunidade_estagio_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: tb_oportunidade_estagio_header
	$headerCode='';
	if(function_exists('tb_oportunidade_estagio_header')){
		$args=array();
		$headerCode=tb_oportunidade_estagio_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: tb_oportunidade_estagio_footer
	$footerCode='';
	if(function_exists('tb_oportunidade_estagio_footer')){
		$args=array();
		$footerCode=tb_oportunidade_estagio_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>