<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/tb_requerimento.php");
	include("$currDir/tb_requerimento_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('tb_requerimento');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "tb_requerimento";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`tb_requerimento`.`id`" => "id",
		"if(`tb_requerimento`.`dta_abertura`,date_format(`tb_requerimento`.`dta_abertura`,'%d/%m/%Y'),'')" => "dta_abertura",
		"`tb_requerimento`.`str_status`" => "str_status",
		"`tb_requerimento`.`str_posicao`" => "str_posicao",
		"`tb_requerimento`.`int_n_vagas`" => "int_n_vagas",
		"`tb_requerimento`.`str_reposicao`" => "str_reposicao",
		"`tb_requerimento`.`str_recurso`" => "str_recurso",
		"`tb_requerimento`.`time_horario_entrada`" => "time_horario_entrada",
		"`tb_requerimento`.`time_horario_saida`" => "time_horario_saida",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa/Cliente Solicitante */" => "empresa_id",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') /* Nome do Contato */" => "contato_id",
		"`tb_requerimento`.`str_gestor`" => "str_gestor",
		"CONCAT_WS('-', LEFT(`tb_requerimento`.`str_telefone`,2), MID(`tb_requerimento`.`str_telefone`,3,4), RIGHT(`tb_requerimento`.`str_telefone`,4))" => "str_telefone",
		"`tb_requerimento`.`str_email`" => "str_email",
		"CONCAT('R$', FORMAT(`tb_requerimento`.`float_salario`, 2))" => "float_salario",
		"`tb_requerimento`.`int_maquinas`" => "int_maquinas",
		"`tb_requerimento`.`str_beneficios`" => "str_beneficios",
		"`tb_requerimento`.`bool_abertura`" => "bool_abertura",
		"if(`tb_requerimento`.`dta_indicacao`,date_format(`tb_requerimento`.`dta_indicacao`,'%d/%m/%Y'),'')" => "dta_indicacao",
		"`tb_requerimento`.`str_descricao`" => "str_descricao"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`tb_requerimento`.`id`',
		2 => '`tb_requerimento`.`dta_abertura`',
		3 => 3,
		4 => 4,
		5 => '`tb_requerimento`.`int_n_vagas`',
		6 => 6,
		7 => 7,
		8 => '`tb_requerimento`.`time_horario_entrada`',
		9 => '`tb_requerimento`.`time_horario_saida`',
		10 => '`tb_empresa1`.`str_nome_fantasia`',
		11 => 11,
		12 => 12,
		13 => 13,
		14 => 14,
		15 => '`tb_requerimento`.`float_salario`',
		16 => '`tb_requerimento`.`int_maquinas`',
		17 => 17,
		18 => 18,
		19 => '`tb_requerimento`.`dta_indicacao`',
		20 => 20
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`tb_requerimento`.`id`" => "id",
		"if(`tb_requerimento`.`dta_abertura`,date_format(`tb_requerimento`.`dta_abertura`,'%d/%m/%Y'),'')" => "dta_abertura",
		"`tb_requerimento`.`str_status`" => "str_status",
		"`tb_requerimento`.`str_posicao`" => "str_posicao",
		"`tb_requerimento`.`int_n_vagas`" => "int_n_vagas",
		"`tb_requerimento`.`str_reposicao`" => "str_reposicao",
		"`tb_requerimento`.`str_recurso`" => "str_recurso",
		"`tb_requerimento`.`time_horario_entrada`" => "time_horario_entrada",
		"`tb_requerimento`.`time_horario_saida`" => "time_horario_saida",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa/Cliente Solicitante */" => "empresa_id",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') /* Nome do Contato */" => "contato_id",
		"`tb_requerimento`.`str_gestor`" => "str_gestor",
		"CONCAT_WS('-', LEFT(`tb_requerimento`.`str_telefone`,2), MID(`tb_requerimento`.`str_telefone`,3,4), RIGHT(`tb_requerimento`.`str_telefone`,4))" => "str_telefone",
		"`tb_requerimento`.`str_email`" => "str_email",
		"CONCAT('R$', FORMAT(`tb_requerimento`.`float_salario`, 2))" => "float_salario",
		"`tb_requerimento`.`int_maquinas`" => "int_maquinas",
		"`tb_requerimento`.`str_beneficios`" => "str_beneficios",
		"`tb_requerimento`.`bool_abertura`" => "bool_abertura",
		"if(`tb_requerimento`.`dta_indicacao`,date_format(`tb_requerimento`.`dta_indicacao`,'%d/%m/%Y'),'')" => "dta_indicacao",
		"`tb_requerimento`.`str_descricao`" => "str_descricao"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`tb_requerimento`.`id`" => "ID",
		"`tb_requerimento`.`dta_abertura`" => "Dta abertura",
		"`tb_requerimento`.`str_status`" => "Status do Requerimento",
		"`tb_requerimento`.`str_posicao`" => "Posi&#231;&#227;o",
		"`tb_requerimento`.`int_n_vagas`" => "N&#250;mero de Vagas",
		"`tb_requerimento`.`str_reposicao`" => "Reposi&#231;&#227;o",
		"`tb_requerimento`.`str_recurso`" => "Recurso &#224; ser reposicionado",
		"`tb_requerimento`.`time_horario_entrada`" => "Hor&#225;rio de Entrada",
		"`tb_requerimento`.`time_horario_saida`" => "Hor&#225;rio de Sa&#237;da",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa/Cliente Solicitante */" => "Empresa/Cliente Solicitante",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') /* Nome do Contato */" => "Nome do Contato",
		"`tb_requerimento`.`str_gestor`" => "Gestor Imediato",
		"`tb_requerimento`.`str_telefone`" => "Tel. do Solicitante",
		"`tb_requerimento`.`str_email`" => "Email do Solicitante",
		"`tb_requerimento`.`float_salario`" => "Sal&#225;rio/Budget",
		"`tb_requerimento`.`int_maquinas`" => "Quantas m&#225;quinas ser&#227;o necess&#225;rias?",
		"`tb_requerimento`.`str_beneficios`" => "Benef&#237;cios oferecidos",
		"`tb_requerimento`.`bool_abertura`" => "Abertura da vaga",
		"`tb_requerimento`.`dta_indicacao`" => "Prazo para indica&#231;&#227;o de candidatos",
		"`tb_requerimento`.`str_descricao`" => "Descri&#231;&#227;o da vaga"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`tb_requerimento`.`id`" => "id",
		"if(`tb_requerimento`.`dta_abertura`,date_format(`tb_requerimento`.`dta_abertura`,'%d/%m/%Y'),'')" => "dta_abertura",
		"`tb_requerimento`.`str_status`" => "str_status",
		"`tb_requerimento`.`str_posicao`" => "str_posicao",
		"`tb_requerimento`.`int_n_vagas`" => "int_n_vagas",
		"`tb_requerimento`.`str_reposicao`" => "str_reposicao",
		"`tb_requerimento`.`str_recurso`" => "str_recurso",
		"`tb_requerimento`.`time_horario_entrada`" => "time_horario_entrada",
		"`tb_requerimento`.`time_horario_saida`" => "time_horario_saida",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa/Cliente Solicitante */" => "empresa_id",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') /* Nome do Contato */" => "contato_id",
		"`tb_requerimento`.`str_gestor`" => "str_gestor",
		"CONCAT_WS('-', LEFT(`tb_requerimento`.`str_telefone`,2), MID(`tb_requerimento`.`str_telefone`,3,4), RIGHT(`tb_requerimento`.`str_telefone`,4))" => "str_telefone",
		"`tb_requerimento`.`str_email`" => "str_email",
		"CONCAT('R$', FORMAT(`tb_requerimento`.`float_salario`, 2))" => "float_salario",
		"`tb_requerimento`.`int_maquinas`" => "int_maquinas",
		"`tb_requerimento`.`str_beneficios`" => "str_beneficios",
		"`tb_requerimento`.`bool_abertura`" => "bool_abertura",
		"if(`tb_requerimento`.`dta_indicacao`,date_format(`tb_requerimento`.`dta_indicacao`,'%d/%m/%Y'),'')" => "dta_indicacao",
		"`tb_requerimento`.`str_descricao`" => "str_descricao"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'empresa_id' => 'Empresa/Cliente Solicitante', 'contato_id' => 'Nome do Contato');

	$x->QueryFrom = "`tb_requerimento` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_requerimento`.`empresa_id` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_requerimento`.`contato_id` ";
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
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "tb_requerimento_view.php";
	$x->RedirectAfterInsert = "tb_requerimento_view.php?SelectedID=#ID#";
	$x->TableTitle = "Requerimento de Vagas";
	$x->TableIcon = "table.gif";
	$x->PrimaryKey = "`tb_requerimento`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Status do Requerimento", "Posi&#231;&#227;o", "N&#250;mero de Vagas", "Empresa/Cliente Solicitante", "Nome do Contato", "Gestor Imediato", "Abertura da vaga", "Prazo para indica&#231;&#227;o de candidatos");
	$x->ColFieldName = array('str_status', 'str_posicao', 'int_n_vagas', 'empresa_id', 'contato_id', 'str_gestor', 'bool_abertura', 'dta_indicacao');
	$x->ColNumber  = array(3, 4, 5, 10, 11, 12, 18, 19);

	// template paths below are based on the app main directory
	$x->Template = 'templates/tb_requerimento_templateTV.html';
	$x->SelectedTemplate = 'templates/tb_requerimento_templateTVS.html';
	$x->TemplateDV = 'templates/tb_requerimento_templateDV.html';
	$x->TemplateDVP = 'templates/tb_requerimento_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_requerimento`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_requerimento' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_requerimento`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_requerimento' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`tb_requerimento`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: tb_requerimento_init
	$render=TRUE;
	if(function_exists('tb_requerimento_init')){
		$args=array();
		$render=tb_requerimento_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: tb_requerimento_header
	$headerCode='';
	if(function_exists('tb_requerimento_header')){
		$args=array();
		$headerCode=tb_requerimento_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: tb_requerimento_footer
	$footerCode='';
	if(function_exists('tb_requerimento_footer')){
		$args=array();
		$footerCode=tb_requerimento_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>