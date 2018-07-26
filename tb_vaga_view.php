<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/tb_vaga.php");
	include("$currDir/tb_vaga_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('tb_vaga');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "tb_vaga";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`tb_vaga`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_requerimento1`.`id`), CONCAT_WS('',   `tb_requerimento1`.`id`), '') /* REQ */" => "requerimento_id",
		"`tb_vaga`.`int_vaga_numero`" => "int_vaga_numero",
		"if(`tb_vaga`.`dta_abertura`,date_format(`tb_vaga`.`dta_abertura`,'%d/%m/%Y'),'')" => "dta_abertura",
		"if(`tb_vaga`.`dta_previsao_fechamento`,date_format(`tb_vaga`.`dta_previsao_fechamento`,'%d/%m/%Y'),'')" => "dta_previsao_fechamento",
		"if(`tb_vaga`.`dta_fechamento`,date_format(`tb_vaga`.`dta_fechamento`,'%d/%m/%Y'),'')" => "dta_fechamento",
		"`tb_vaga`.`str_status`" => "str_status",
		"`tb_vaga`.`str_detalhe_status`" => "str_detalhe_status",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`) || CHAR_LENGTH(`tb_recrutador1`.`bol_comercial`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`, `tb_recrutador1`.`bol_comercial`), '') /* Recrutador */" => "recrutador_id",
		"`tb_vaga`.`str_prioridade`" => "str_prioridade",
		"`tb_vaga`.`str_posicao`" => "str_posicao",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "empresa_id",
		"`tb_vaga`.`str_alocacao`" => "str_alocacao",
		"`tb_vaga`.`canal_fechamento`" => "canal_fechamento",
		"`tb_vaga`.`str_obs`" => "str_obs",
		"if(`tb_vaga`.`dta_inicio`,date_format(`tb_vaga`.`dta_inicio`,'%d/%m/%Y'),'')" => "dta_inicio"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`tb_vaga`.`id`',
		2 => '`tb_requerimento1`.`id`',
		3 => '`tb_vaga`.`int_vaga_numero`',
		4 => '`tb_vaga`.`dta_abertura`',
		5 => '`tb_vaga`.`dta_previsao_fechamento`',
		6 => '`tb_vaga`.`dta_fechamento`',
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => '`tb_empresa1`.`str_nome_fantasia`',
		13 => 13,
		14 => 14,
		15 => 15,
		16 => '`tb_vaga`.`dta_inicio`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`tb_vaga`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_requerimento1`.`id`), CONCAT_WS('',   `tb_requerimento1`.`id`), '') /* REQ */" => "requerimento_id",
		"`tb_vaga`.`int_vaga_numero`" => "int_vaga_numero",
		"if(`tb_vaga`.`dta_abertura`,date_format(`tb_vaga`.`dta_abertura`,'%d/%m/%Y'),'')" => "dta_abertura",
		"if(`tb_vaga`.`dta_previsao_fechamento`,date_format(`tb_vaga`.`dta_previsao_fechamento`,'%d/%m/%Y'),'')" => "dta_previsao_fechamento",
		"if(`tb_vaga`.`dta_fechamento`,date_format(`tb_vaga`.`dta_fechamento`,'%d/%m/%Y'),'')" => "dta_fechamento",
		"`tb_vaga`.`str_status`" => "str_status",
		"`tb_vaga`.`str_detalhe_status`" => "str_detalhe_status",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`) || CHAR_LENGTH(`tb_recrutador1`.`bol_comercial`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`, `tb_recrutador1`.`bol_comercial`), '') /* Recrutador */" => "recrutador_id",
		"`tb_vaga`.`str_prioridade`" => "str_prioridade",
		"`tb_vaga`.`str_posicao`" => "str_posicao",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "empresa_id",
		"`tb_vaga`.`str_alocacao`" => "str_alocacao",
		"`tb_vaga`.`canal_fechamento`" => "canal_fechamento",
		"`tb_vaga`.`str_obs`" => "str_obs",
		"if(`tb_vaga`.`dta_inicio`,date_format(`tb_vaga`.`dta_inicio`,'%d/%m/%Y'),'')" => "dta_inicio"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`tb_vaga`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`tb_requerimento1`.`id`), CONCAT_WS('',   `tb_requerimento1`.`id`), '') /* REQ */" => "REQ",
		"`tb_vaga`.`int_vaga_numero`" => "Vaga",
		"`tb_vaga`.`dta_abertura`" => "Data de abertura",
		"`tb_vaga`.`dta_previsao_fechamento`" => "Data de previs&#227;o de fechamento",
		"`tb_vaga`.`dta_fechamento`" => "Data de fechamento",
		"`tb_vaga`.`str_status`" => "Status",
		"`tb_vaga`.`str_detalhe_status`" => "Detalhes do Status",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`) || CHAR_LENGTH(`tb_recrutador1`.`bol_comercial`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`, `tb_recrutador1`.`bol_comercial`), '') /* Recrutador */" => "Recrutador",
		"`tb_vaga`.`str_prioridade`" => "Prioridade",
		"`tb_vaga`.`str_posicao`" => "Posi&#231;&#227;o",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "Empresa",
		"`tb_vaga`.`str_alocacao`" => "Aloca&#231;&#227;o",
		"`tb_vaga`.`canal_fechamento`" => "Canal de Fechamento",
		"`tb_vaga`.`str_obs`" => "Observa&#231;&#245;es",
		"`tb_vaga`.`dta_inicio`" => "Data de admiss&#227;o/in&#237;cio"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`tb_vaga`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_requerimento1`.`id`), CONCAT_WS('',   `tb_requerimento1`.`id`), '') /* REQ */" => "requerimento_id",
		"`tb_vaga`.`int_vaga_numero`" => "int_vaga_numero",
		"if(`tb_vaga`.`dta_abertura`,date_format(`tb_vaga`.`dta_abertura`,'%d/%m/%Y'),'')" => "dta_abertura",
		"if(`tb_vaga`.`dta_previsao_fechamento`,date_format(`tb_vaga`.`dta_previsao_fechamento`,'%d/%m/%Y'),'')" => "dta_previsao_fechamento",
		"if(`tb_vaga`.`dta_fechamento`,date_format(`tb_vaga`.`dta_fechamento`,'%d/%m/%Y'),'')" => "dta_fechamento",
		"`tb_vaga`.`str_status`" => "str_status",
		"`tb_vaga`.`str_detalhe_status`" => "str_detalhe_status",
		"IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`) || CHAR_LENGTH(`tb_recrutador1`.`bol_comercial`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`, `tb_recrutador1`.`bol_comercial`), '') /* Recrutador */" => "recrutador_id",
		"`tb_vaga`.`str_prioridade`" => "str_prioridade",
		"`tb_vaga`.`str_posicao`" => "str_posicao",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "empresa_id",
		"`tb_vaga`.`str_alocacao`" => "str_alocacao",
		"`tb_vaga`.`canal_fechamento`" => "canal_fechamento",
		"`tb_vaga`.`str_obs`" => "str_obs",
		"if(`tb_vaga`.`dta_inicio`,date_format(`tb_vaga`.`dta_inicio`,'%d/%m/%Y'),'')" => "dta_inicio"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'requerimento_id' => 'REQ', 'recrutador_id' => 'Recrutador', 'empresa_id' => 'Empresa');

	$x->QueryFrom = "`tb_vaga` LEFT JOIN `tb_requerimento` as tb_requerimento1 ON `tb_requerimento1`.`id`=`tb_vaga`.`requerimento_id` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_vaga`.`recrutador_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_vaga`.`empresa_id` ";
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
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 30;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "tb_vaga_view.php";
	$x->RedirectAfterInsert = "tb_vaga_view.php?SelectedID=#ID#";
	$x->TableTitle = "Vagas";
	$x->TableIcon = "resources/table_icons/chair.png";
	$x->PrimaryKey = "`tb_vaga`.`id`";
	$x->DefaultSortField = '`tb_vaga`.`dta_abertura`';
	$x->DefaultSortDirection = 'desc';

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("REQ", "Vaga", "Data de abertura", "Data de fechamento", "Status", "Detalhes do Status", "Recrutador", "Prioridade", "Posi&#231;&#227;o", "Empresa", "Canal de Fechamento", "Observa&#231;&#245;es");
	$x->ColFieldName = array('requerimento_id', 'int_vaga_numero', 'dta_abertura', 'dta_fechamento', 'str_status', 'str_detalhe_status', 'recrutador_id', 'str_prioridade', 'str_posicao', 'empresa_id', 'canal_fechamento', 'str_obs');
	$x->ColNumber  = array(2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 14, 15);

	// template paths below are based on the app main directory
	$x->Template = 'templates/tb_vaga_templateTV.html';
	$x->SelectedTemplate = 'templates/tb_vaga_templateTVS.html';
	$x->TemplateDV = 'templates/tb_vaga_templateDV.html';
	$x->TemplateDVP = 'templates/tb_vaga_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_vaga`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_vaga' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_vaga`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_vaga' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`tb_vaga`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: tb_vaga_init
	$render=TRUE;
	if(function_exists('tb_vaga_init')){
		$args=array();
		$render=tb_vaga_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: tb_vaga_header
	$headerCode='';
	if(function_exists('tb_vaga_header')){
		$args=array();
		$headerCode=tb_vaga_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: tb_vaga_footer
	$footerCode='';
	if(function_exists('tb_vaga_footer')){
		$args=array();
		$footerCode=tb_vaga_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>