<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/tb_acompanhamento_colaborador.php");
	include("$currDir/tb_acompanhamento_colaborador_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('tb_acompanhamento_colaborador');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "tb_acompanhamento_colaborador";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`tb_acompanhamento_colaborador`.`id`" => "id",
		"if(`tb_acompanhamento_colaborador`.`dta_data`,date_format(`tb_acompanhamento_colaborador`.`dta_data`,'%d/%m/%Y'),'')" => "dta_data",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`) || CHAR_LENGTH(if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`, ' - ', ' - ', if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), '') /* Acompanhamento id */" => "acompanhamento_id",
		"IF(    CHAR_LENGTH(`tb_contratacao1`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao1`.`id`), CONCAT_WS('',   `tb_contratacao1`.`str_candidato_nome`, ' - ', `tb_contratacao1`.`id`), '') /* Colaborador id */" => "colaborador_id",
		"`tb_acompanhamento_colaborador`.`str_tipo`" => "str_tipo",
		"`tb_acompanhamento_colaborador`.`str_comentarios`" => "str_comentarios",
		"`tb_acompanhamento_colaborador`.`str_responsavel`" => "str_responsavel"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`tb_acompanhamento_colaborador`.`id`',
		2 => '`tb_acompanhamento_colaborador`.`dta_data`',
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`tb_acompanhamento_colaborador`.`id`" => "id",
		"if(`tb_acompanhamento_colaborador`.`dta_data`,date_format(`tb_acompanhamento_colaborador`.`dta_data`,'%d/%m/%Y'),'')" => "dta_data",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`) || CHAR_LENGTH(if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`, ' - ', ' - ', if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), '') /* Acompanhamento id */" => "acompanhamento_id",
		"IF(    CHAR_LENGTH(`tb_contratacao1`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao1`.`id`), CONCAT_WS('',   `tb_contratacao1`.`str_candidato_nome`, ' - ', `tb_contratacao1`.`id`), '') /* Colaborador id */" => "colaborador_id",
		"`tb_acompanhamento_colaborador`.`str_tipo`" => "str_tipo",
		"`tb_acompanhamento_colaborador`.`str_comentarios`" => "str_comentarios",
		"`tb_acompanhamento_colaborador`.`str_responsavel`" => "str_responsavel"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`tb_acompanhamento_colaborador`.`id`" => "ID",
		"`tb_acompanhamento_colaborador`.`dta_data`" => "Data",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`) || CHAR_LENGTH(if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`, ' - ', ' - ', if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), '') /* Acompanhamento id */" => "Acompanhamento id",
		"IF(    CHAR_LENGTH(`tb_contratacao1`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao1`.`id`), CONCAT_WS('',   `tb_contratacao1`.`str_candidato_nome`, ' - ', `tb_contratacao1`.`id`), '') /* Colaborador id */" => "Colaborador id",
		"`tb_acompanhamento_colaborador`.`str_tipo`" => "Feedback",
		"`tb_acompanhamento_colaborador`.`str_comentarios`" => "Coment&#225;rios",
		"`tb_acompanhamento_colaborador`.`str_responsavel`" => "Respons&#225;vel"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`tb_acompanhamento_colaborador`.`id`" => "id",
		"if(`tb_acompanhamento_colaborador`.`dta_data`,date_format(`tb_acompanhamento_colaborador`.`dta_data`,'%d/%m/%Y'),'')" => "dta_data",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`) || CHAR_LENGTH(if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`, ' - ', ' - ', if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), '') /* Acompanhamento id */" => "acompanhamento_id",
		"IF(    CHAR_LENGTH(`tb_contratacao1`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao1`.`id`), CONCAT_WS('',   `tb_contratacao1`.`str_candidato_nome`, ' - ', `tb_contratacao1`.`id`), '') /* Colaborador id */" => "colaborador_id",
		"`tb_acompanhamento_colaborador`.`str_tipo`" => "str_tipo",
		"`tb_acompanhamento_colaborador`.`str_comentarios`" => "str_comentarios",
		"`tb_acompanhamento_colaborador`.`str_responsavel`" => "str_responsavel"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'acompanhamento_id' => 'Acompanhamento id', 'colaborador_id' => 'Colaborador id');

	$x->QueryFrom = "`tb_acompanhamento_colaborador` LEFT JOIN `tb_acompanhamento` as tb_acompanhamento1 ON `tb_acompanhamento1`.`id`=`tb_acompanhamento_colaborador`.`acompanhamento_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_acompanhamento1`.`empresa_id` LEFT JOIN `tb_contratacao` as tb_contratacao1 ON `tb_contratacao1`.`id`=`tb_acompanhamento_colaborador`.`colaborador_id` ";
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
	$x->AllowPrinting = 0;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 50;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "tb_acompanhamento_colaborador_view.php";
	$x->RedirectAfterInsert = "tb_acompanhamento_colaborador_view.php?SelectedID=#ID#";
	$x->TableTitle = "Acompanhamento individual";
	$x->TableIcon = "table.gif";
	$x->PrimaryKey = "`tb_acompanhamento_colaborador`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150);
	$x->ColCaption = array("Data", "Acompanhamento id", "Colaborador id", "Feedback", "Respons&#225;vel");
	$x->ColFieldName = array('dta_data', 'acompanhamento_id', 'colaborador_id', 'str_tipo', 'str_responsavel');
	$x->ColNumber  = array(2, 3, 4, 5, 7);

	// template paths below are based on the app main directory
	$x->Template = 'templates/tb_acompanhamento_colaborador_templateTV.html';
	$x->SelectedTemplate = 'templates/tb_acompanhamento_colaborador_templateTVS.html';
	$x->TemplateDV = 'templates/tb_acompanhamento_colaborador_templateDV.html';
	$x->TemplateDVP = 'templates/tb_acompanhamento_colaborador_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_acompanhamento_colaborador`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_acompanhamento_colaborador' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_acompanhamento_colaborador`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_acompanhamento_colaborador' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`tb_acompanhamento_colaborador`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: tb_acompanhamento_colaborador_init
	$render=TRUE;
	if(function_exists('tb_acompanhamento_colaborador_init')){
		$args=array();
		$render=tb_acompanhamento_colaborador_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: tb_acompanhamento_colaborador_header
	$headerCode='';
	if(function_exists('tb_acompanhamento_colaborador_header')){
		$args=array();
		$headerCode=tb_acompanhamento_colaborador_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: tb_acompanhamento_colaborador_footer
	$footerCode='';
	if(function_exists('tb_acompanhamento_colaborador_footer')){
		$args=array();
		$footerCode=tb_acompanhamento_colaborador_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>