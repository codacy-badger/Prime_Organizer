<?php
// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/tb_oportunidade.php");
	include("$currDir/tb_oportunidade_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('tb_oportunidade');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "tb_oportunidade";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`tb_oportunidade`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "tipo_id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_estagio1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_estagio1`.`str_nome`), '') /* Est&#225;gio */" => "estagio_id",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "empresa_id",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_empresa2`.`str_nome_fantasia`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' - ', `tb_empresa2`.`str_nome_fantasia`), '') /* Contato */" => "contato_id",
		"`tb_oportunidade`.`str_demanda`" => "str_demanda",
		"if(`tb_oportunidade`.`dta_inicio`,date_format(`tb_oportunidade`.`dta_inicio`,'%d/%m/%Y'),'')" => "dta_inicio",
		"if(`tb_oportunidade`.`dta_prev_fechamento`,date_format(`tb_oportunidade`.`dta_prev_fechamento`,'%d/%m/%Y'),'')" => "dta_prev_fechamento",
		"`tb_oportunidade`.`int_probabilidade`" => "int_probabilidade",
		"CONCAT('$', FORMAT(`tb_oportunidade`.`int_valor`, 2))" => "int_valor",
		"`tb_oportunidade`.`int_parcelas`" => "int_parcelas",
		"if(`tb_oportunidade`.`dta_proposta`,date_format(`tb_oportunidade`.`dta_proposta`,'%d/%m/%Y'),'')" => "dta_proposta",
		"`tb_oportunidade`.`str_proposta`" => "str_proposta",
		"`tb_oportunidade`.`str_anotacoes`" => "str_anotacoes",
		"`tb_oportunidade`.`str_responsavel`" => "str_responsavel"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`tb_oportunidade`.`id`',
		2 => '`tb_oportunidade_tipo1`.`str_nome`',
		3 => '`tb_oportunidade_estagio1`.`str_nome`',
		4 => '`tb_empresa1`.`str_nome_fantasia`',
		5 => 5,
		6 => 6,
		7 => '`tb_oportunidade`.`dta_inicio`',
		8 => '`tb_oportunidade`.`dta_prev_fechamento`',
		9 => '`tb_oportunidade`.`int_probabilidade`',
		10 => '`tb_oportunidade`.`int_valor`',
		11 => '`tb_oportunidade`.`int_parcelas`',
		12 => '`tb_oportunidade`.`dta_proposta`',
		13 => 13,
		14 => 14,
		15 => 15
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`tb_oportunidade`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "tipo_id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_estagio1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_estagio1`.`str_nome`), '') /* Est&#225;gio */" => "estagio_id",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "empresa_id",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_empresa2`.`str_nome_fantasia`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' - ', `tb_empresa2`.`str_nome_fantasia`), '') /* Contato */" => "contato_id",
		"`tb_oportunidade`.`str_demanda`" => "str_demanda",
		"if(`tb_oportunidade`.`dta_inicio`,date_format(`tb_oportunidade`.`dta_inicio`,'%d/%m/%Y'),'')" => "dta_inicio",
		"if(`tb_oportunidade`.`dta_prev_fechamento`,date_format(`tb_oportunidade`.`dta_prev_fechamento`,'%d/%m/%Y'),'')" => "dta_prev_fechamento",
		"`tb_oportunidade`.`int_probabilidade`" => "int_probabilidade",
		"CONCAT('$', FORMAT(`tb_oportunidade`.`int_valor`, 2))" => "int_valor",
		"`tb_oportunidade`.`int_parcelas`" => "int_parcelas",
		"if(`tb_oportunidade`.`dta_proposta`,date_format(`tb_oportunidade`.`dta_proposta`,'%d/%m/%Y'),'')" => "dta_proposta",
		"`tb_oportunidade`.`str_proposta`" => "str_proposta",
		"`tb_oportunidade`.`str_anotacoes`" => "str_anotacoes",
		"`tb_oportunidade`.`str_responsavel`" => "str_responsavel"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`tb_oportunidade`.`id`" => "ID",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "Tipo da demanda",
		"IF(    CHAR_LENGTH(`tb_oportunidade_estagio1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_estagio1`.`str_nome`), '') /* Est&#225;gio */" => "Est&#225;gio",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "Empresa",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_empresa2`.`str_nome_fantasia`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' - ', `tb_empresa2`.`str_nome_fantasia`), '') /* Contato */" => "Contato",
		"`tb_oportunidade`.`str_demanda`" => "Demanda",
		"`tb_oportunidade`.`dta_inicio`" => "Data de in&#237;cio",
		"`tb_oportunidade`.`dta_prev_fechamento`" => "Previs&#227;o para fechamento",
		"`tb_oportunidade`.`int_probabilidade`" => "Probabilidade",
		"`tb_oportunidade`.`int_valor`" => "Valor mensal",
		"`tb_oportunidade`.`int_parcelas`" => "Quantidade de parcelas",
		"`tb_oportunidade`.`dta_proposta`" => "Data da proposta",
		"`tb_oportunidade`.`str_proposta`" => "Anexar proposta",
		"`tb_oportunidade`.`str_anotacoes`" => "Anota&#231;&#245;es",
		"`tb_oportunidade`.`str_responsavel`" => "Criado por"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`tb_oportunidade`.`id`" => "id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') /* Tipo da demanda */" => "tipo_id",
		"IF(    CHAR_LENGTH(`tb_oportunidade_estagio1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_estagio1`.`str_nome`), '') /* Est&#225;gio */" => "estagio_id",
		"IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') /* Empresa */" => "empresa_id",
		"IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_empresa2`.`str_nome_fantasia`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' - ', `tb_empresa2`.`str_nome_fantasia`), '') /* Contato */" => "contato_id",
		"`tb_oportunidade`.`str_demanda`" => "str_demanda",
		"if(`tb_oportunidade`.`dta_inicio`,date_format(`tb_oportunidade`.`dta_inicio`,'%d/%m/%Y'),'')" => "dta_inicio",
		"if(`tb_oportunidade`.`dta_prev_fechamento`,date_format(`tb_oportunidade`.`dta_prev_fechamento`,'%d/%m/%Y'),'')" => "dta_prev_fechamento",
		"`tb_oportunidade`.`int_probabilidade`" => "int_probabilidade",
		"CONCAT('$', FORMAT(`tb_oportunidade`.`int_valor`, 2))" => "int_valor",
		"`tb_oportunidade`.`int_parcelas`" => "int_parcelas",
		"if(`tb_oportunidade`.`dta_proposta`,date_format(`tb_oportunidade`.`dta_proposta`,'%d/%m/%Y'),'')" => "dta_proposta",
		"`tb_oportunidade`.`str_proposta`" => "str_proposta",
		"`tb_oportunidade`.`str_anotacoes`" => "str_anotacoes",
		"`tb_oportunidade`.`str_responsavel`" => "str_responsavel"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'tipo_id' => 'Tipo da demanda', 'estagio_id' => 'Est&#225;gio', 'empresa_id' => 'Empresa', 'contato_id' => 'Contato');

	$x->QueryFrom = "`tb_oportunidade` LEFT JOIN `tb_oportunidade_tipo` as tb_oportunidade_tipo1 ON `tb_oportunidade_tipo1`.`id`=`tb_oportunidade`.`tipo_id` LEFT JOIN `tb_oportunidade_estagio` as tb_oportunidade_estagio1 ON `tb_oportunidade_estagio1`.`id`=`tb_oportunidade`.`estagio_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_oportunidade`.`empresa_id` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_oportunidade`.`contato_id` LEFT JOIN `tb_empresa` as tb_empresa2 ON `tb_empresa2`.`id`=`tb_contato1`.`empresa_id` ";
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
	$x->AllowPrinting = 0;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 30;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "tb_oportunidade_view.php";
	$x->RedirectAfterInsert = "tb_oportunidade_view.php?SelectedID=#ID#";
	$x->TableTitle = "Oportunidades";
	$x->TableIcon = "resources/table_icons/ruby.png";
	$x->PrimaryKey = "`tb_oportunidade`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Tipo da demanda", "Est&#225;gio", "Empresa", "Contato", "Demanda", "Data de in&#237;cio", "Previs&#227;o para fechamento", "Valor mensal", "Quantidade de parcelas", "Anexar proposta");
	$x->ColFieldName = array('tipo_id', 'estagio_id', 'empresa_id', 'contato_id', 'str_demanda', 'dta_inicio', 'dta_prev_fechamento', 'int_valor', 'int_parcelas', 'str_proposta');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 7, 8, 10, 11, 13);

	// template paths below are based on the app main directory
	$x->Template = 'templates/tb_oportunidade_templateTV.html';
	$x->SelectedTemplate = 'templates/tb_oportunidade_templateTVS.html';
	$x->TemplateDV = 'templates/tb_oportunidade_templateDV.html';
	$x->TemplateDVP = 'templates/tb_oportunidade_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_oportunidade`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_oportunidade' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `tb_oportunidade`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='tb_oportunidade' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`tb_oportunidade`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: tb_oportunidade_init
	$render=TRUE;
	if(function_exists('tb_oportunidade_init')){
		$args=array();
		$render=tb_oportunidade_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// column sums
	if(strpos($x->HTML, '<!-- tv data below -->')){
		// if printing multi-selection TV, calculate the sum only for the selected records
		if(isset($_REQUEST['Print_x']) && is_array($_REQUEST['record_selector'])){
			$QueryWhere = '';
			foreach($_REQUEST['record_selector'] as $id){   // get selected records
				if($id != '') $QueryWhere .= "'" . makeSafe($id) . "',";
			}
			if($QueryWhere != ''){
				$QueryWhere = 'where `tb_oportunidade`.`id` in ('.substr($QueryWhere, 0, -1).')';
			}else{ // if no selected records, write the where clause to return an empty result
				$QueryWhere = 'where 1=0';
			}
		}else{
			$QueryWhere = $x->QueryWhere;
		}

		$sumQuery = "select CONCAT('$', FORMAT(sum(`tb_oportunidade`.`int_valor`), 2)) from {$x->QueryFrom} {$QueryWhere}";
		$res = sql($sumQuery, $eo);
		if($row = db_fetch_row($res)){
			$sumRow = '<tr class="success">';
			if(!isset($_REQUEST['Print_x'])) $sumRow .= '<td class="text-center"><strong>&sum;</strong></td>';
			$sumRow .= '<td class="tb_oportunidade-tipo_id"></td>';
			$sumRow .= '<td class="tb_oportunidade-estagio_id"></td>';
			$sumRow .= '<td class="tb_oportunidade-empresa_id"></td>';
			$sumRow .= '<td class="tb_oportunidade-contato_id"></td>';
			$sumRow .= '<td class="tb_oportunidade-str_demanda"></td>';
			$sumRow .= '<td class="tb_oportunidade-dta_inicio"></td>';
			$sumRow .= '<td class="tb_oportunidade-dta_prev_fechamento"></td>';
			$sumRow .= "<td class=\"tb_oportunidade-int_valor text-right\">{$row[0]}</td>";
			$sumRow .= '<td class="tb_oportunidade-int_parcelas"></td>';
			$sumRow .= '<td class="tb_oportunidade-str_proposta"></td>';
			$sumRow .= '</tr>';

			$x->HTML = str_replace('<!-- tv data below -->', '', $x->HTML);
			$x->HTML = str_replace('<!-- tv data above -->', $sumRow, $x->HTML);
		}
	}

	// hook: tb_oportunidade_header
	$headerCode='';
	if(function_exists('tb_oportunidade_header')){
		$args=array();
		$headerCode=tb_oportunidade_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: tb_oportunidade_footer
	$footerCode='';
	if(function_exists('tb_oportunidade_footer')){
		$args=array();
		$footerCode=tb_oportunidade_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>