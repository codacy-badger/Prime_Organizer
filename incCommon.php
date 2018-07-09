<?php

	#########################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		getTableList() -- returns an associative array (tableName => tableData, tableData is array(tableCaption, tableDescription, tableIcon)) of tables accessible by current user
		get_table_groups() -- returns an associative array (table_group => tables_array)
		logInMember() -- checks POST login. If not valid, redirects to index.php, else returns TRUE
		getTablePermissions($tn) -- returns an array of permissions allowed for logged member to given table (allowAccess, allowInsert, allowView, allowEdit, allowDelete) -- allowAccess is set to true if any access level is allowed
		get_sql_fields($tn) -- returns the SELECT part of the table view query
		get_sql_from($tn[, true]) -- returns the FROM part of the table view query, with full joins, optionally skipping permissions if true passed as 2nd param.
		get_joined_record($table, $id[, true]) -- returns assoc array of record values for given PK value of given table, with full joins, optionally skipping permissions if true passed as 3rd param.
		get_defaults($table) -- returns assoc array of table fields as array keys and default values (or empty), excluding automatic values as array values
		htmlUserBar() -- returns html code for displaying user login status to be used on top of pages.
		showNotifications($msg, $class) -- returns html code for displaying a notification. If no parameters provided, processes the GET request for possible notifications.
		parseMySQLDate(a, b) -- returns a if valid mysql date, or b if valid mysql date, or today if b is true, or empty if b is false.
		parseCode(code) -- calculates and returns special values to be inserted in automatic fields.
		addFilter(i, filterAnd, filterField, filterOperator, filterValue) -- enforce a filter over data
		clearFilters() -- clear all filters
		loadView($view, $data) -- passes $data to templates/{$view}.php and returns the output
		loadTable($table, $data) -- loads table template, passing $data to it
		filterDropdownBy($filterable, $filterers, $parentFilterers, $parentPKField, $parentCaption, $parentTable, &$filterableCombo) -- applies cascading drop-downs for a lookup field, returns js code to be inserted into the page
		br2nl($text) -- replaces all variations of HTML <br> tags with a new line character
		htmlspecialchars_decode($text) -- inverse of htmlspecialchars()
		entitiesToUTF8($text) -- convert unicode entities (e.g. &#1234;) to actual UTF8 characters, requires multibyte string PHP extension
		func_get_args_byref() -- returns an array of arguments passed to a function, by reference
		permissions_sql($table, $level) -- returns an array containing the FROM and WHERE additions for applying permissions to an SQL query
		error_message($msg[, $back_url]) -- returns html code for a styled error message .. pass explicit false in second param to suppress back button
		toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format)
		reIndex(&$arr) -- returns a copy of the given array, with keys replaced by 1-based numeric indices, and values replaced by original keys
		get_embed($provider, $url[, $width, $height, $retrieve]) -- returns embed code for a given url (supported providers: youtube, googlemap)
		check_record_permission($table, $id, $perm = 'view') -- returns true if current user has the specified permission $perm ('view', 'edit' or 'delete') for the given recors, false otherwise
		NavMenus($options) -- returns the HTML code for the top navigation menus. $options is not implemented currently.
		StyleSheet() -- returns the HTML code for included style sheet files to be placed in the <head> section.
		getUploadDir($dir) -- if dir is empty, returns upload dir configured in defaultLang.php, else returns $dir.
		PrepareUploadedFile($FieldName, $MaxSize, $FileTypes='jpg|jpeg|gif|png', $NoRename=false, $dir="") -- validates and moves uploaded file for given $FieldName into the given $dir (or the default one if empty)
		get_home_links($homeLinks, $default_classes, $tgroup) -- process $homeLinks array and return custom links for homepage. Applies $default_classes to links if links have classes defined, and filters links by $tgroup (using '*' matches all table_group values)
		quick_search_html($search_term, $label, $separate_dv = true) -- returns HTML code for the quick search box.
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/

	#########################################################

	function getTableList($skip_authentication = false){
		$arrAccessTables = array();
		$arrTables = array(
			/* 'table_name' => ['table caption', 'homepage description', 'icon', 'table group name'] */   
			'tb_vaga' => array('Vagas', 'Registros de vagas', 'resources/table_icons/chair.png', 'RH'),
			'tb_entrevista' => array('Atividades de R&S', 'Registros di&#225;rios de contatos, entrevistas e encaminhamentos<br>', 'resources/table_icons/clock_red.png', 'RH'),
			'tb_contratacao' => array('Colaboradores', 'Registros de colaboradores.', 'resources/table_icons/ceo.png', 'RH'),
			'tb_alocacao' => array('Aloca&#231;&#227;o', 'Locais e projetos onde os recursos s&#227;o alocados.', 'resources/table_icons/travel.png', 'RH'),
			'tb_recrutador' => array('Gestores', 'Cadastro dos colaboradores que utilizam o sistema.', 'resources/table_icons/attribution.png', 'Configura&#231;&#245;es'),
			'tb_empresa' => array('Contas', 'Cadastro de empresas (clientes, fornecedores, parceiros, etc.)', 'resources/table_icons/factory.png', 'Comercial'),
			'tb_prova_tipo' => array('Tipos de provas', 'Cadastros de provas para aplica&#231;&#227;o.', 'resources/table_icons/attributes_display.png', 'Configura&#231;&#245;es'),
			'tb_contato' => array('Contato', 'Cadastro de clientes, prospects e leads.', 'resources/table_icons/group.png', 'Comercial'),
			'tb_contato_tipo' => array('Tipos de relacionamento', '', 'table.gif', 'Configura&#231;&#245;es'),
			'tb_oportunidade' => array('Oportunidades', '', 'resources/table_icons/ruby.png', 'Comercial'),
			'tb_atendimento' => array('Atendimentos', 'Cadastro de telefonemas, e-mails e reuni&#245;es.', 'resources/table_icons/comments.png', 'Comercial'),
			'tb_oportunidade_tipo' => array('Tipos das oportunidades', 'Classifique as oportunidades em tipos (pipelines).', 'table.gif', 'Configura&#231;&#245;es'),
			'tb_oportunidade_estagio' => array('Est&#225;gios de oportunidades', '', 'table.gif', 'Configura&#231;&#245;es'),
			'tb_acompanhamento' => array('Acompanhamento', 'Registros de acompanhamento de contas.', 'resources/table_icons/hot.png', 'Comercial'),
			'tb_contrato' => array('Contratos', '', 'resources/table_icons/document_mark_as_final.png', 'Comercial'),
			'tb_campanha' => array('Campanha', '', 'resources/table_icons/advertising.png', 'Marketing'),
			'tb_campanha_contato' => array('Contatos da campanha', '', 'table.gif', 'Marketing'),
			'tb_acompanhamento_colaborador' => array('Acompanhamento individual', '', 'table.gif', 'Comercial'),
			'tb_indicador' => array('Metas e Indicadores', 'Cadastre metas e indicadores para gerar um hist&#243;rico de performance.', 'resources/table_icons/chart_up_color.png', 'Marketing'),
			'tb_indicador_periodo' => array('Per&#237;odos dos indicadores', '', 'table.gif', 'Marketing'),
			'tb_fatura' => array('Faturamento', 'Lan&#231;amento de faturas e notas fiscais.', 'resources/table_icons/blogs.png', 'Financeiro'),
			'tb_ajuste_colaborador' => array('Ajustes do Colaborador', 'Registros de ajustes do pontos dos colaboradores', 'resources/table_icons/clock_edit.png', 'RH'),
			'tb_requerimento' => array('Requerimento de Vagas', 'Requerimento de vagas por parceiros', 'resources/table_icons/group_add.png', 'RH')
		);
		if($skip_authentication || getLoggedAdmin()) return $arrTables;

		if(is_array($arrTables)){
			foreach($arrTables as $tn => $tc){
				$arrPerm = getTablePermissions($tn);
				if($arrPerm[0]){
					$arrAccessTables[$tn] = $tc;
				}
			}
		}

		return $arrAccessTables;
	}

	#########################################################

	function get_table_groups($skip_authentication = false){
		$tables = getTableList($skip_authentication);
		$all_groups = array('RH', 'Comercial', 'Marketing', 'Financeiro', 'Configura&#231;&#245;es');

		$groups = array();
		foreach($all_groups as $grp){
			foreach($tables as $tn => $td){
				if($td[3] && $td[3] == $grp) $groups[$grp][] = $tn;
				if(!$td[3]) $groups[0][] = $tn;
			}
		}

		return $groups;
	}

	#########################################################

	function getTablePermissions($tn){
		static $table_permissions = array();
		if(isset($table_permissions[$tn])) return $table_permissions[$tn];

		$groupID = getLoggedGroupID();
		$memberID = makeSafe(getLoggedMemberID());
		$res_group = sql("select tableName, allowInsert, allowView, allowEdit, allowDelete from membership_grouppermissions where groupID='{$groupID}'", $eo);
		$res_user = sql("select tableName, allowInsert, allowView, allowEdit, allowDelete from membership_userpermissions where lcase(memberID)='{$memberID}'", $eo);

		while($row = db_fetch_assoc($res_group)){
			$table_permissions[$row['tableName']] = array(
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			);
		}

		// user-specific permissions, if specified, overwrite his group permissions
		while($row = db_fetch_assoc($res_user)){
			$table_permissions[$row['tableName']] = array(
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			);
		}

		// if user has any type of access, set 'access' flag
		foreach($table_permissions as $t => $p){
			$table_permissions[$t]['access'] = $table_permissions[$t][0] = false;

			if($p['insert'] || $p['view'] || $p['edit'] || $p['delete']){
				$table_permissions[$t]['access'] = $table_permissions[$t][0] = true;
			}
		}

		return $table_permissions[$tn];
	}

	#########################################################

	function get_sql_fields($table_name){
		$sql_fields = array(   
			'tb_vaga' => "`tb_vaga`.`id` as 'id', IF(    CHAR_LENGTH(`tb_requerimento1`.`id`), CONCAT_WS('',   `tb_requerimento1`.`id`), '') as 'requerimento_id', `tb_vaga`.`int_vaga_numero` as 'int_vaga_numero', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_alocacao1`.`str_nome`), CONCAT_WS('',   `tb_alocacao1`.`str_nome`), '') as 'str_alocacao', IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`) || CHAR_LENGTH(`tb_recrutador1`.`bol_comercial`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`, `tb_recrutador1`.`bol_comercial`), '') as 'recrutador_id', `tb_vaga`.`str_posicao` as 'str_posicao', if(`tb_vaga`.`dta_abertura`,date_format(`tb_vaga`.`dta_abertura`,'%d/%m/%Y'),'') as 'dta_abertura', `tb_vaga`.`str_prioridade` as 'str_prioridade', `tb_vaga`.`str_status` as 'str_status', if(`tb_vaga`.`dta_fechamento`,date_format(`tb_vaga`.`dta_fechamento`,'%d/%m/%Y'),'') as 'dta_fechamento', if(`tb_vaga`.`dta_previsao_fechamento`,date_format(`tb_vaga`.`dta_previsao_fechamento`,'%d/%m/%Y'),'') as 'dta_previsao_fechamento', `tb_vaga`.`str_obs` as 'str_obs', if(`tb_vaga`.`dta_inicio`,date_format(`tb_vaga`.`dta_inicio`,'%d/%m/%Y'),'') as 'dta_inicio', `tb_vaga`.`str_contratado_nome` as 'str_contratado_nome'",
			'tb_entrevista' => "`tb_entrevista`.`id` as 'id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_vaga1`.`str_posicao`) || CHAR_LENGTH(`tb_alocacao1`.`str_nome`), CONCAT_WS('',   `tb_vaga1`.`str_posicao`, ' - ', `tb_alocacao1`.`str_nome`), '') as 'vaga_id', IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') as 'recrutador_id', if(`tb_entrevista`.`dta`,date_format(`tb_entrevista`.`dta`,'%d/%m/%Y'),'') as 'dta', `tb_entrevista`.`int_qtd_contatos` as 'int_qtd_contatos', `tb_entrevista`.`int_qtd_entrevistas` as 'int_qtd_entrevistas', `tb_entrevista`.`int_qtd_encaminhamentos` as 'int_qtd_encaminhamentos'",
			'tb_contratacao' => "`tb_contratacao`.`id` as 'id', `tb_contratacao`.`str_candidato_nome` as 'str_candidato_nome', `tb_contratacao`.`int_cpf` as 'int_cpf', if(`tb_contratacao`.`dta_contratacao`,date_format(`tb_contratacao`.`dta_contratacao`,'%d/%m/%Y'),'') as 'dta_contratacao', if(`tb_contratacao`.`dta_demissao`,date_format(`tb_contratacao`.`dta_demissao`,'%d/%m/%Y'),'') as 'dta_demissao', `tb_contratacao`.`bol_gestor` as 'bol_gestor'",
			'tb_alocacao' => "`tb_alocacao`.`id` as 'id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'int_empresa', `tb_alocacao`.`str_nome` as 'str_nome'",
			'tb_recrutador' => "`tb_recrutador`.`id` as 'id', `tb_recrutador`.`str_nome` as 'str_nome', `tb_recrutador`.`bol_status` as 'bol_status', `tb_recrutador`.`bol_recrutador` as 'bol_recrutador', `tb_recrutador`.`bol_comercial` as 'bol_comercial'",
			'tb_empresa' => "`tb_empresa`.`id` as 'id', `tb_empresa`.`str_nome_fantasia` as 'str_nome_fantasia', IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') as 'str_responsavel', IF(    CHAR_LENGTH(`tb_contato_tipo1`.`str_nome`), CONCAT_WS('',   `tb_contato_tipo1`.`str_nome`), '') as 'relacionamento_id', `tb_empresa`.`cidade` as 'cidade', `tb_empresa`.`uf` as 'uf'",
			'tb_prova_tipo' => "`tb_prova_tipo`.`id` as 'id', `tb_prova_tipo`.`str_nome` as 'str_nome', `tb_prova_tipo`.`str_descricao` as 'str_descricao'",
			'tb_contato' => "`tb_contato`.`id` as 'id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', `tb_contato`.`str_primeiro_nome` as 'str_primeiro_nome', `tb_contato`.`str_sobrenome` as 'str_sobrenome', `tb_contato`.`str_nivel` as 'str_nivel', IF(    CHAR_LENGTH(`tb_contato_tipo1`.`str_nome`), CONCAT_WS('',   `tb_contato_tipo1`.`str_nome`), '') as 'tipo_id', `tb_contato`.`str_email1` as 'str_email1', `tb_contato`.`str_email2` as 'str_email2', `tb_contato`.`str_telefone1` as 'str_telefone1', `tb_contato`.`str_telefone2` as 'str_telefone2', `tb_contato`.`str_telefone3` as 'str_telefone3', `tb_contato`.`cidade` as 'cidade', `tb_contato`.`uf` as 'uf', if(`tb_contato`.`dta_cadastro`,date_format(`tb_contato`.`dta_cadastro`,'%d/%m/%Y'),'') as 'dta_cadastro'",
			'tb_contato_tipo' => "`tb_contato_tipo`.`id` as 'id', `tb_contato_tipo`.`str_nome` as 'str_nome'",
			'tb_oportunidade' => "`tb_oportunidade`.`id` as 'id', IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') as 'tipo_id', IF(    CHAR_LENGTH(`tb_oportunidade_estagio1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_estagio1`.`str_nome`), '') as 'estagio_id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_empresa2`.`str_nome_fantasia`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' - ', `tb_empresa2`.`str_nome_fantasia`), '') as 'contato_id', `tb_oportunidade`.`str_demanda` as 'str_demanda', if(`tb_oportunidade`.`dta_inicio`,date_format(`tb_oportunidade`.`dta_inicio`,'%d/%m/%Y'),'') as 'dta_inicio', if(`tb_oportunidade`.`dta_prev_fechamento`,date_format(`tb_oportunidade`.`dta_prev_fechamento`,'%d/%m/%Y'),'') as 'dta_prev_fechamento', `tb_oportunidade`.`int_probabilidade` as 'int_probabilidade', CONCAT('$', FORMAT(`tb_oportunidade`.`int_valor`, 2)) as 'int_valor', `tb_oportunidade`.`int_parcelas` as 'int_parcelas', if(`tb_oportunidade`.`dta_proposta`,date_format(`tb_oportunidade`.`dta_proposta`,'%d/%m/%Y'),'') as 'dta_proposta', `tb_oportunidade`.`str_proposta` as 'str_proposta', `tb_oportunidade`.`str_anotacoes` as 'str_anotacoes', `tb_oportunidade`.`str_responsavel` as 'str_responsavel'",
			'tb_atendimento' => "`tb_atendimento`.`id` as 'id', `tb_atendimento`.`str_iniciativa` as 'str_iniciativa', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`) || CHAR_LENGTH(`tb_empresa1`.`id`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`, ' - ID ', `tb_empresa1`.`id`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') as 'contato_id', `tb_atendimento`.`str_meio` as 'str_meio', `tb_atendimento`.`str_finalidade` as 'str_finalidade', if(`tb_atendimento`.`dta`,date_format(`tb_atendimento`.`dta`,'%d/%m/%Y'),'') as 'dta', IF(    CHAR_LENGTH(`tb_campanha1`.`str_nome`), CONCAT_WS('',   `tb_campanha1`.`str_nome`), '') as 'campanha_id', IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') as 'usuario_id', `tb_atendimento`.`str_anotacoes` as 'str_anotacoes'",
			'tb_oportunidade_tipo' => "`tb_oportunidade_tipo`.`id` as 'id', `tb_oportunidade_tipo`.`str_nome` as 'str_nome'",
			'tb_oportunidade_estagio' => "`tb_oportunidade_estagio`.`id` as 'id', IF(    CHAR_LENGTH(`tb_oportunidade_tipo1`.`str_nome`), CONCAT_WS('',   `tb_oportunidade_tipo1`.`str_nome`), '') as 'tipo_id', `tb_oportunidade_estagio`.`str_nome` as 'str_nome'",
			'tb_acompanhamento' => "`tb_acompanhamento`.`id` as 'id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') as 'contato_id', IF(    CHAR_LENGTH(`tb_contrato1`.`str_nome`), CONCAT_WS('',   `tb_contrato1`.`str_nome`), '') as 'contrato_id', IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') as 'usuario_id', if(`tb_acompanhamento`.`dta`,date_format(`tb_acompanhamento`.`dta`,'%d/%m/%Y'),'') as 'dta', `tb_acompanhamento`.`str_meio` as 'str_meio', `tb_acompanhamento`.`str_statusgeral` as 'str_statusgeral', `tb_acompanhamento`.`str_clima_cliente` as 'str_clima_cliente', `tb_acompanhamento`.`str_clima_equipe` as 'str_clima_equipe', `tb_acompanhamento`.`str_observacoes` as 'str_observacoes', `tb_acompanhamento`.`str_acoes_corretivas` as 'str_acoes_corretivas'",
			'tb_contrato' => "`tb_contrato`.`id` as 'id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', `tb_contrato`.`str_nome` as 'str_nome', if(`tb_contrato`.`dta_inicio`,date_format(`tb_contrato`.`dta_inicio`,'%d/%m/%Y'),'') as 'dta_inicio', if(`tb_contrato`.`dta_termino`,date_format(`tb_contrato`.`dta_termino`,'%d/%m/%Y'),'') as 'dta_termino', `tb_contrato`.`str_detalhes` as 'str_detalhes', `tb_contrato`.`str_anexo` as 'str_anexo', `tb_contrato`.`bol_status` as 'bol_status'",
			'tb_campanha' => "`tb_campanha`.`id` as 'id', `tb_campanha`.`str_nome` as 'str_nome', if(`tb_campanha`.`dta_inicio`,date_format(`tb_campanha`.`dta_inicio`,'%d/%m/%Y'),'') as 'dta_inicio', `tb_campanha`.`st_descricao` as 'st_descricao'",
			'tb_campanha_contato' => "`tb_campanha_contato`.`id` as 'id', IF(    CHAR_LENGTH(`tb_campanha1`.`str_nome`), CONCAT_WS('',   `tb_campanha1`.`str_nome`), '') as 'campanha_id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') as 'contato_id'",
			'tb_acompanhamento_colaborador' => "`tb_acompanhamento_colaborador`.`id` as 'id', if(`tb_acompanhamento_colaborador`.`dta_data`,date_format(`tb_acompanhamento_colaborador`.`dta_data`,'%d/%m/%Y'),'') as 'dta_data', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`) || CHAR_LENGTH(if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`, ' - ', ' - ', if(`tb_acompanhamento1`.`dta`,date_format(`tb_acompanhamento1`.`dta`,'%d/%m/%Y'),'')), '') as 'acompanhamento_id', IF(    CHAR_LENGTH(`tb_contratacao1`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao1`.`id`), CONCAT_WS('',   `tb_contratacao1`.`str_candidato_nome`, ' - ', `tb_contratacao1`.`id`), '') as 'colaborador_id', `tb_acompanhamento_colaborador`.`str_tipo` as 'str_tipo', `tb_acompanhamento_colaborador`.`str_comentarios` as 'str_comentarios', `tb_acompanhamento_colaborador`.`str_responsavel` as 'str_responsavel'",
			'tb_indicador' => "`tb_indicador`.`id` as 'id', `tb_indicador`.`str_departamento` as 'str_departamento', `tb_indicador`.`str_nome` as 'str_nome', `tb_indicador`.`str_descricao` as 'str_descricao', `tb_indicador`.`str_unidade_medida` as 'str_unidade_medida'",
			'tb_indicador_periodo' => "`tb_indicador_periodo`.`id` as 'id', IF(    CHAR_LENGTH(`tb_indicador1`.`str_departamento`) || CHAR_LENGTH(`tb_indicador1`.`str_nome`), CONCAT_WS('',   `tb_indicador1`.`str_departamento`, ' - ', `tb_indicador1`.`str_nome`), '') as 'indicador_id', `tb_indicador_periodo`.`str_unidade` as 'str_unidade', `tb_indicador_periodo`.`str_vertical` as 'str_vertical', `tb_indicador_periodo`.`str_responsavel` as 'str_responsavel', if(`tb_indicador_periodo`.`dta`,date_format(`tb_indicador_periodo`.`dta`,'%d/%m/%Y'),'') as 'dta', `tb_indicador_periodo`.`flo_sazonalidade` as 'flo_sazonalidade', `tb_indicador_periodo`.`int_meta` as 'int_meta', `tb_indicador_periodo`.`int_meta_ajustada` as 'int_meta_ajustada', `tb_indicador_periodo`.`int_realizado` as 'int_realizado'",
			'tb_fatura' => "`tb_fatura`.`id` as 'id', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', if(`tb_fatura`.`dta_emissao`,date_format(`tb_fatura`.`dta_emissao`,'%d/%m/%Y'),'') as 'dta_emissao', if(`tb_fatura`.`dta_competencia`,date_format(`tb_fatura`.`dta_competencia`,'%d/%m/%Y'),'') as 'dta_competencia', `tb_fatura`.`flo_valor` as 'flo_valor', `tb_fatura`.`int_nf` as 'int_nf', `tb_fatura`.`str_observacoes` as 'str_observacoes'",
			'tb_ajuste_colaborador' => "`tb_ajuste_colaborador`.`id` as 'id', `tb_ajuste_colaborador`.`str_responsavel` as 'str_responsavel', if(`tb_ajuste_colaborador`.`dta_data`,date_format(`tb_ajuste_colaborador`.`dta_data`,'%d/%m/%Y'),'') as 'dta_data', IF(    CHAR_LENGTH(`tb_contratacao1`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao1`.`id`), CONCAT_WS('',   `tb_contratacao1`.`str_candidato_nome`, '-', `tb_contratacao1`.`id`), '') as 'colaborador_id', `tb_ajuste_colaborador`.`str_ajuste` as 'str_ajuste', `tb_ajuste_colaborador`.`bol_evidencia` as 'bol_evidencia', `tb_ajuste_colaborador`.`int_quantidade` as 'int_quantidade', IF(    CHAR_LENGTH(`tb_contratacao2`.`str_candidato_nome`) || CHAR_LENGTH(`tb_contratacao2`.`id`), CONCAT_WS('',   `tb_contratacao2`.`str_candidato_nome`, '-', `tb_contratacao2`.`id`), '') as 'gestor_id', `tb_ajuste_colaborador`.`bol_notificacao` as 'bol_notificacao'",
			'tb_requerimento' => "`tb_requerimento`.`id` as 'id', if(`tb_requerimento`.`dta_requisicao`,date_format(`tb_requerimento`.`dta_requisicao`,'%d/%m/%Y'),'') as 'dta_requisicao', if(`tb_requerimento`.`dta_abertura`,date_format(`tb_requerimento`.`dta_abertura`,'%d/%m/%Y'),'') as 'dta_abertura', if(`tb_requerimento`.`dta_fechamento`,date_format(`tb_requerimento`.`dta_fechamento`,'%d/%m/%Y'),'') as 'dta_fechamento', `tb_requerimento`.`str_status` as 'str_status', if(`tb_requerimento`.`dta_prev_fechamento`,date_format(`tb_requerimento`.`dta_prev_fechamento`,'%d/%m/%Y'),'') as 'dta_prev_fechamento', IF(    CHAR_LENGTH(`tb_recrutador1`.`str_nome`), CONCAT_WS('',   `tb_recrutador1`.`str_nome`), '') as 'recrutador_id', `tb_requerimento`.`str_posicao` as 'str_posicao', `tb_requerimento`.`int_n_vagas` as 'int_n_vagas', `tb_requerimento`.`str_reposicao` as 'str_reposicao', `tb_requerimento`.`str_recurso` as 'str_recurso', `tb_requerimento`.`time_horario_entrada` as 'time_horario_entrada', `tb_requerimento`.`time_horario_saida` as 'time_horario_saida', IF(    CHAR_LENGTH(`tb_empresa1`.`str_nome_fantasia`), CONCAT_WS('',   `tb_empresa1`.`str_nome_fantasia`), '') as 'empresa_id', IF(    CHAR_LENGTH(`tb_alocacao1`.`str_nome`), CONCAT_WS('',   `tb_alocacao1`.`str_nome`), '') as 'str_alocacao', IF(    CHAR_LENGTH(`tb_contato1`.`str_primeiro_nome`) || CHAR_LENGTH(`tb_contato1`.`str_sobrenome`), CONCAT_WS('',   `tb_contato1`.`str_primeiro_nome`, ' ', `tb_contato1`.`str_sobrenome`), '') as 'contato_id', CONCAT_WS('-', LEFT(`tb_requerimento`.`str_telefone`,2), MID(`tb_requerimento`.`str_telefone`,3,4), RIGHT(`tb_requerimento`.`str_telefone`,4)) as 'str_telefone', `tb_requerimento`.`str_email` as 'str_email', CONCAT('R$', FORMAT(`tb_requerimento`.`float_salario`, 2)) as 'float_salario', `tb_requerimento`.`int_maquinas` as 'int_maquinas', `tb_requerimento`.`str_beneficios` as 'str_beneficios', `tb_requerimento`.`bool_abertura` as 'bool_abertura', if(`tb_requerimento`.`dta_indicacao`,date_format(`tb_requerimento`.`dta_indicacao`,'%d/%m/%Y'),'') as 'dta_indicacao', `tb_requerimento`.`str_descricao` as 'str_descricao'"
		);

		if(isset($sql_fields[$table_name])){
			return $sql_fields[$table_name];
		}

		return false;
	}

	#########################################################

	function get_sql_from($table_name, $skip_permissions = false){
		$sql_from = array(   
			'tb_vaga' => "`tb_vaga` LEFT JOIN `tb_requerimento` as tb_requerimento1 ON `tb_requerimento1`.`id`=`tb_vaga`.`requerimento_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_vaga`.`empresa_id` LEFT JOIN `tb_alocacao` as tb_alocacao1 ON `tb_alocacao1`.`id`=`tb_vaga`.`str_alocacao` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_vaga`.`recrutador_id` ",
			'tb_entrevista' => "`tb_entrevista` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_entrevista`.`empresa_id` LEFT JOIN `tb_vaga` as tb_vaga1 ON `tb_vaga1`.`id`=`tb_entrevista`.`vaga_id` LEFT JOIN `tb_alocacao` as tb_alocacao1 ON `tb_alocacao1`.`id`=`tb_vaga1`.`str_alocacao` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_entrevista`.`recrutador_id` ",
			'tb_contratacao' => "`tb_contratacao` ",
			'tb_alocacao' => "`tb_alocacao` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_alocacao`.`int_empresa` ",
			'tb_recrutador' => "`tb_recrutador` ",
			'tb_empresa' => "`tb_empresa` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_empresa`.`str_responsavel` LEFT JOIN `tb_contato_tipo` as tb_contato_tipo1 ON `tb_contato_tipo1`.`id`=`tb_empresa`.`relacionamento_id` ",
			'tb_prova_tipo' => "`tb_prova_tipo` ",
			'tb_contato' => "`tb_contato` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_contato`.`empresa_id` LEFT JOIN `tb_contato_tipo` as tb_contato_tipo1 ON `tb_contato_tipo1`.`id`=`tb_contato`.`tipo_id` ",
			'tb_contato_tipo' => "`tb_contato_tipo` ",
			'tb_oportunidade' => "`tb_oportunidade` LEFT JOIN `tb_oportunidade_tipo` as tb_oportunidade_tipo1 ON `tb_oportunidade_tipo1`.`id`=`tb_oportunidade`.`tipo_id` LEFT JOIN `tb_oportunidade_estagio` as tb_oportunidade_estagio1 ON `tb_oportunidade_estagio1`.`id`=`tb_oportunidade`.`estagio_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_oportunidade`.`empresa_id` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_oportunidade`.`contato_id` LEFT JOIN `tb_empresa` as tb_empresa2 ON `tb_empresa2`.`id`=`tb_contato1`.`empresa_id` ",
			'tb_atendimento' => "`tb_atendimento` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_atendimento`.`empresa_id` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_atendimento`.`contato_id` LEFT JOIN `tb_campanha` as tb_campanha1 ON `tb_campanha1`.`id`=`tb_atendimento`.`campanha_id` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_atendimento`.`usuario_id` ",
			'tb_oportunidade_tipo' => "`tb_oportunidade_tipo` ",
			'tb_oportunidade_estagio' => "`tb_oportunidade_estagio` LEFT JOIN `tb_oportunidade_tipo` as tb_oportunidade_tipo1 ON `tb_oportunidade_tipo1`.`id`=`tb_oportunidade_estagio`.`tipo_id` ",
			'tb_acompanhamento' => "`tb_acompanhamento` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_acompanhamento`.`empresa_id` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_acompanhamento`.`contato_id` LEFT JOIN `tb_contrato` as tb_contrato1 ON `tb_contrato1`.`id`=`tb_acompanhamento`.`contrato_id` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_acompanhamento`.`usuario_id` ",
			'tb_contrato' => "`tb_contrato` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_contrato`.`empresa_id` ",
			'tb_campanha' => "`tb_campanha` ",
			'tb_campanha_contato' => "`tb_campanha_contato` LEFT JOIN `tb_campanha` as tb_campanha1 ON `tb_campanha1`.`id`=`tb_campanha_contato`.`campanha_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_campanha_contato`.`empresa_id` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_campanha_contato`.`contato_id` ",
			'tb_acompanhamento_colaborador' => "`tb_acompanhamento_colaborador` LEFT JOIN `tb_acompanhamento` as tb_acompanhamento1 ON `tb_acompanhamento1`.`id`=`tb_acompanhamento_colaborador`.`acompanhamento_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_acompanhamento1`.`empresa_id` LEFT JOIN `tb_contratacao` as tb_contratacao1 ON `tb_contratacao1`.`id`=`tb_acompanhamento_colaborador`.`colaborador_id` ",
			'tb_indicador' => "`tb_indicador` ",
			'tb_indicador_periodo' => "`tb_indicador_periodo` LEFT JOIN `tb_indicador` as tb_indicador1 ON `tb_indicador1`.`id`=`tb_indicador_periodo`.`indicador_id` ",
			'tb_fatura' => "`tb_fatura` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_fatura`.`empresa_id` ",
			'tb_ajuste_colaborador' => "`tb_ajuste_colaborador` LEFT JOIN `tb_contratacao` as tb_contratacao1 ON `tb_contratacao1`.`id`=`tb_ajuste_colaborador`.`colaborador_id` LEFT JOIN `tb_contratacao` as tb_contratacao2 ON `tb_contratacao2`.`id`=`tb_ajuste_colaborador`.`gestor_id` ",
			'tb_requerimento' => "`tb_requerimento` LEFT JOIN `tb_recrutador` as tb_recrutador1 ON `tb_recrutador1`.`id`=`tb_requerimento`.`recrutador_id` LEFT JOIN `tb_empresa` as tb_empresa1 ON `tb_empresa1`.`id`=`tb_requerimento`.`empresa_id` LEFT JOIN `tb_alocacao` as tb_alocacao1 ON `tb_alocacao1`.`id`=`tb_requerimento`.`str_alocacao` LEFT JOIN `tb_contato` as tb_contato1 ON `tb_contato1`.`id`=`tb_requerimento`.`contato_id` "
		);

		$pkey = array(   
			'tb_vaga' => 'id',
			'tb_entrevista' => 'id',
			'tb_contratacao' => 'id',
			'tb_alocacao' => 'id',
			'tb_recrutador' => 'id',
			'tb_empresa' => 'id',
			'tb_prova_tipo' => 'id',
			'tb_contato' => 'id',
			'tb_contato_tipo' => 'id',
			'tb_oportunidade' => 'id',
			'tb_atendimento' => 'id',
			'tb_oportunidade_tipo' => 'id',
			'tb_oportunidade_estagio' => 'id',
			'tb_acompanhamento' => 'id',
			'tb_contrato' => 'id',
			'tb_campanha' => 'id',
			'tb_campanha_contato' => 'id',
			'tb_acompanhamento_colaborador' => 'id',
			'tb_indicador' => 'id',
			'tb_indicador_periodo' => 'id',
			'tb_fatura' => 'id',
			'tb_ajuste_colaborador' => 'id',
			'tb_requerimento' => 'id'
		);

		if(isset($sql_from[$table_name])){
			if($skip_permissions) return $sql_from[$table_name];

			// mm: build the query based on current member's permissions
			$perm = getTablePermissions($table_name);
			if($perm[2] == 1){ // view owner only
				$sql_from[$table_name] .= ", membership_userrecords WHERE `{$table_name}`.`{$pkey[$table_name]}`=membership_userrecords.pkValue and membership_userrecords.tableName='{$table_name}' and lcase(membership_userrecords.memberID)='" . getLoggedMemberID() . "'";
			}elseif($perm[2] == 2){ // view group only
				$sql_from[$table_name] .= ", membership_userrecords WHERE `{$table_name}`.`{$pkey[$table_name]}`=membership_userrecords.pkValue and membership_userrecords.tableName='{$table_name}' and membership_userrecords.groupID='" . getLoggedGroupID() . "'";
			}elseif($perm[2] == 3){ // view all
				$sql_from[$table_name] .= ' WHERE 1=1';
			}else{ // view none
				return false;
			}
			return $sql_from[$table_name];
		}

		return false;
	}

	#########################################################

	function get_joined_record($table, $id, $skip_permissions = false){
		$sql_fields = get_sql_fields($table);
		$sql_from = get_sql_from($table, $skip_permissions);

		if(!$sql_fields || !$sql_from) return false;

		$pk = getPKFieldName($table);
		if(!$pk) return false;

		$safe_id = makeSafe($id, false);
		$sql = "SELECT {$sql_fields} FROM {$sql_from} AND `{$table}`.`{$pk}`='{$safe_id}'";
		$eo['silentErrors'] = true;
		$res = sql($sql, $eo);
		if($row = db_fetch_assoc($res)) return $row;

		return false;
	}

	#########################################################

	function get_defaults($table){
		/* array of tables and their fields, with default values (or empty), excluding automatic values */
		$defaults = array(
			'tb_vaga' => array(
				'id' => '',
				'requerimento_id' => '',
				'int_vaga_numero' => '',
				'empresa_id' => '',
				'str_alocacao' => '',
				'recrutador_id' => '',
				'str_posicao' => '',
				'dta_abertura' => '',
				'str_prioridade' => '',
				'str_status' => '',
				'dta_fechamento' => '',
				'dta_previsao_fechamento' => '',
				'str_obs' => '',
				'dta_inicio' => '',
				'str_contratado_nome' => ''
			),
			'tb_entrevista' => array(
				'id' => '',
				'empresa_id' => '',
				'vaga_id' => '',
				'recrutador_id' => '',
				'dta' => '',
				'int_qtd_contatos' => '',
				'int_qtd_entrevistas' => '',
				'int_qtd_encaminhamentos' => ''
			),
			'tb_contratacao' => array(
				'id' => '',
				'str_candidato_nome' => '',
				'int_cpf' => '',
				'dta_contratacao' => '',
				'dta_demissao' => '',
				'bol_gestor' => '0'
			),
			'tb_alocacao' => array(
				'id' => '',
				'int_empresa' => '',
				'str_nome' => ''
			),
			'tb_recrutador' => array(
				'id' => '',
				'str_nome' => '',
				'bol_status' => '1',
				'bol_recrutador' => '',
				'bol_comercial' => ''
			),
			'tb_empresa' => array(
				'id' => '',
				'str_nome_fantasia' => '',
				'str_responsavel' => '',
				'relacionamento_id' => '',
				'cidade' => '',
				'uf' => ''
			),
			'tb_prova_tipo' => array(
				'id' => '',
				'str_nome' => '',
				'str_descricao' => ''
			),
			'tb_contato' => array(
				'id' => '',
				'empresa_id' => '',
				'str_primeiro_nome' => '',
				'str_sobrenome' => '',
				'str_nivel' => '',
				'tipo_id' => '',
				'str_email1' => '',
				'str_email2' => '',
				'str_telefone1' => '',
				'str_telefone2' => '',
				'str_telefone3' => '',
				'cidade' => '',
				'uf' => '',
				'dta_cadastro' => ''
			),
			'tb_contato_tipo' => array(
				'id' => '',
				'str_nome' => ''
			),
			'tb_oportunidade' => array(
				'id' => '',
				'tipo_id' => '',
				'estagio_id' => '',
				'empresa_id' => '',
				'contato_id' => '',
				'str_demanda' => '',
				'dta_inicio' => '',
				'dta_prev_fechamento' => '',
				'int_probabilidade' => '',
				'int_valor' => '',
				'int_parcelas' => '1',
				'dta_proposta' => '',
				'str_proposta' => '',
				'str_anotacoes' => '',
				'str_responsavel' => ''
			),
			'tb_atendimento' => array(
				'id' => '',
				'str_iniciativa' => '',
				'empresa_id' => '',
				'contato_id' => '',
				'str_meio' => '',
				'str_finalidade' => '',
				'dta' => '',
				'campanha_id' => '',
				'usuario_id' => '',
				'str_anotacoes' => ''
			),
			'tb_oportunidade_tipo' => array(
				'id' => '',
				'str_nome' => ''
			),
			'tb_oportunidade_estagio' => array(
				'id' => '',
				'tipo_id' => '',
				'str_nome' => ''
			),
			'tb_acompanhamento' => array(
				'id' => '',
				'empresa_id' => '',
				'contato_id' => '',
				'contrato_id' => '',
				'usuario_id' => '',
				'dta' => '',
				'str_meio' => '',
				'str_statusgeral' => '',
				'str_clima_cliente' => '',
				'str_clima_equipe' => '',
				'str_observacoes' => '',
				'str_acoes_corretivas' => ''
			),
			'tb_contrato' => array(
				'id' => '',
				'empresa_id' => '',
				'str_nome' => '',
				'dta_inicio' => '',
				'dta_termino' => '',
				'str_detalhes' => '',
				'str_anexo' => '',
				'bol_status' => '1'
			),
			'tb_campanha' => array(
				'id' => '',
				'str_nome' => '',
				'dta_inicio' => '',
				'st_descricao' => ''
			),
			'tb_campanha_contato' => array(
				'id' => '',
				'campanha_id' => '',
				'empresa_id' => '',
				'contato_id' => ''
			),
			'tb_acompanhamento_colaborador' => array(
				'id' => '',
				'dta_data' => '',
				'acompanhamento_id' => '',
				'colaborador_id' => '',
				'str_tipo' => '',
				'str_comentarios' => '',
				'str_responsavel' => ''
			),
			'tb_indicador' => array(
				'id' => '',
				'str_departamento' => '',
				'str_nome' => '',
				'str_descricao' => '',
				'str_unidade_medida' => ''
			),
			'tb_indicador_periodo' => array(
				'id' => '',
				'indicador_id' => '',
				'str_unidade' => '',
				'str_vertical' => '',
				'str_responsavel' => '',
				'dta' => '',
				'flo_sazonalidade' => '',
				'int_meta' => '',
				'int_meta_ajustada' => '',
				'int_realizado' => ''
			),
			'tb_fatura' => array(
				'id' => '',
				'empresa_id' => '',
				'dta_emissao' => '',
				'dta_competencia' => '',
				'flo_valor' => '',
				'int_nf' => '',
				'str_observacoes' => ''
			),
			'tb_ajuste_colaborador' => array(
				'id' => '',
				'str_responsavel' => '',
				'dta_data' => '',
				'colaborador_id' => '',
				'str_ajuste' => '',
				'bol_evidencia' => '',
				'int_quantidade' => '1',
				'gestor_id' => '',
				'bol_notificacao' => ''
			),
			'tb_requerimento' => array(
				'id' => '',
				'dta_requisicao' => '',
				'dta_abertura' => '',
				'dta_fechamento' => '',
				'str_status' => 'Pendente',
				'dta_prev_fechamento' => '',
				'recrutador_id' => '',
				'str_posicao' => '',
				'int_n_vagas' => '',
				'str_reposicao' => '',
				'str_recurso' => '',
				'time_horario_entrada' => '',
				'time_horario_saida' => '',
				'empresa_id' => '',
				'str_alocacao' => '',
				'contato_id' => '',
				'str_telefone' => '',
				'str_email' => '',
				'float_salario' => '',
				'int_maquinas' => '0',
				'str_beneficios' => '',
				'bool_abertura' => 'Abertura imediata',
				'dta_indicacao' => '',
				'str_descricao' => ''
			)
		);

		return isset($defaults[$table]) ? $defaults[$table] : array();
	}

	#########################################################

	function logInMember(){
		$redir = 'index.php';
		if($_POST['signIn'] != ''){
			if($_POST['username'] != '' && $_POST['password'] != ''){
				$username = makeSafe(strtolower($_POST['username']));
				$password = md5($_POST['password']);

				if(sqlValue("select count(1) from membership_users where lcase(memberID)='$username' and passMD5='$password' and isApproved=1 and isBanned=0")==1){
					$_SESSION['memberID']=$username;
					$_SESSION['memberGroupID']=sqlValue("select groupID from membership_users where lcase(memberID)='$username'");
					if($_POST['rememberMe']==1){
						@setcookie('Prime_Organizer_rememberMe', md5($username.$password), time()+86400*30);
					}else{
						@setcookie('Prime_Organizer_rememberMe', '', time()-86400*30);
					}

					// hook: login_ok
					if(function_exists('login_ok')){
						$args=array();
						if(!$redir=login_ok(getMemberInfo(), $args)){
							$redir='index.php';
						}
					}

					redirect($redir);
					exit;
				}
			}

			// hook: login_failed
			if(function_exists('login_failed')){
				$args=array();
				login_failed(array(
					'username' => $_POST['username'],
					'password' => $_POST['password'],
					'IP' => $_SERVER['REMOTE_ADDR']
					), $args);
			}

			if(!headers_sent()) header('HTTP/1.0 403 Forbidden');
			redirect("index.php?loginFailed=1");
			exit;
		}elseif((!$_SESSION['memberID'] || $_SESSION['memberID']==$adminConfig['anonymousMember']) && $_COOKIE['Prime_Organizer_rememberMe']!=''){
			$chk=makeSafe($_COOKIE['Prime_Organizer_rememberMe']);
			if($username=sqlValue("select memberID from membership_users where convert(md5(concat(memberID, passMD5)), char)='$chk' and isBanned=0")){
				$_SESSION['memberID']=$username;
				$_SESSION['memberGroupID']=sqlValue("select groupID from membership_users where lcase(memberID)='$username'");
			}
		}
	}

	#########################################################

	function htmlUserBar(){
		global $adminConfig, $Translation;
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');

		ob_start();
		$home_page = (basename($_SERVER['PHP_SELF'])=='index.php' ? true : false);

		?>
		<nav class="navbar navbar-default navbar-fixed-top hidden-print" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- application title is obtained from the name besides the yellow database icon in AppGini, use underscores for spaces -->
				<a class="navbar-brand" href="<?php echo PREPEND_PATH; ?>index.php"><i class="glyphicon glyphicon-home"></i> Prime Organizer</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<?php if(!$home_page){ ?>
						<?php echo NavMenus(); ?>
					<?php } ?>
				</ul>

				<?php if(getLoggedAdmin()){ ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn hidden-xs" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn visible-xs btn-lg" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
					</ul>
				<?php } ?>

				<?php if(!$_GET['signIn'] && !$_GET['loginFailed']){ ?>
					<?php if(getLoggedMemberID() == $adminConfig['anonymousMember']){ ?>
						<p class="navbar-text navbar-right">&nbsp;</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success navbar-btn navbar-right"><?php echo $Translation['sign in']; ?></a>
						<p class="navbar-text navbar-right">
							<?php echo $Translation['not signed in']; ?>
						</p>
					<?php }else{ ?>
						<ul class="nav navbar-nav navbar-right hidden-xs" style="min-width: 330px;">
							<a class="btn navbar-btn btn-default" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link"><?php echo getLoggedMemberID(); ?></a></strong>
							</p>
						</ul>
						<ul class="nav navbar-nav visible-xs">
							<a class="btn navbar-btn btn-default btn-lg visible-xs" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text text-center">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link"><?php echo getLoggedMemberID(); ?></a></strong>
							</p>
						</ul>
						<script>
							/* periodically check if user is still signed in */
							setInterval(function(){
								$j.ajax({
									url: '<?php echo PREPEND_PATH; ?>ajax_check_login.php',
									success: function(username){
										if(!username.length) window.location = '<?php echo PREPEND_PATH; ?>index.php?signIn=1';
									}
								});
							}, 60000);
						</script>
					<?php } ?>
				<?php } ?>
			</div>
		</nav>
		<?php

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	#########################################################

	function showNotifications($msg = '', $class = '', $fadeout = true){
		global $Translation;

		$notify_template_no_fadeout = '<div id="%%ID%%" class="alert alert-dismissable %%CLASS%%" style="display: none; padding-top: 6px; padding-bottom: 6px;">' .
					'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
					'%%MSG%%</div>' .
					'<script> jQuery(function(){ /* */ jQuery("#%%ID%%").show("slow"); }); </script>'."\n";
		$notify_template = '<div id="%%ID%%" class="alert %%CLASS%%" style="display: none; padding-top: 6px; padding-bottom: 6px;">%%MSG%%</div>' .
					'<script>' .
						'jQuery(function(){' .
							'jQuery("#%%ID%%").show("slow", function(){' .
								'setTimeout(function(){ /* */ jQuery("#%%ID%%").hide("slow"); }, 4000);' .
							'});' .
						'});' .
					'</script>'."\n";

		if(!$msg){ // if no msg, use url to detect message to display
			if($_REQUEST['record-added-ok'] != ''){
				$msg = $Translation['new record saved'];
				$class = 'alert-success';
			}elseif($_REQUEST['record-added-error'] != ''){
				$msg = $Translation['Couldn\'t save the new record'];
				$class = 'alert-danger';
				$fadeout = false;
			}elseif($_REQUEST['record-updated-ok'] != ''){
				$msg = $Translation['record updated'];
				$class = 'alert-success';
			}elseif($_REQUEST['record-updated-error'] != ''){
				$msg = $Translation['Couldn\'t save changes to the record'];
				$class = 'alert-danger';
				$fadeout = false;
			}elseif($_REQUEST['record-deleted-ok'] != ''){
				$msg = $Translation['The record has been deleted successfully'];
				$class = 'alert-success';
				$fadeout = false;
			}elseif($_REQUEST['record-deleted-error'] != ''){
				$msg = $Translation['Couldn\'t delete this record'];
				$class = 'alert-danger';
				$fadeout = false;
			}else{
				return '';
			}
		}
		$id = 'notification-' . rand();

		$out = ($fadeout ? $notify_template : $notify_template_no_fadeout);
		$out = str_replace('%%ID%%', $id, $out);
		$out = str_replace('%%MSG%%', $msg, $out);
		$out = str_replace('%%CLASS%%', $class, $out);

		return $out;
	}

	#########################################################

	function parseMySQLDate($date, $altDate){
		// is $date valid?
		if(preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", trim($date))){
			return trim($date);
		}

		if($date != '--' && preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", trim($altDate))){
			return trim($altDate);
		}

		if($date != '--' && $altDate && intval($altDate)==$altDate){
			return @date('Y-m-d', @time() + ($altDate >= 1 ? $altDate - 1 : $altDate) * 86400);
		}

		return '';
	}

	#########################################################

	function parseCode($code, $isInsert=true, $rawData=false){
		if($isInsert){
			$arrCodes=array(
				'<%%creatorusername%%>' => $_SESSION['memberID'],
				'<%%creatorgroupid%%>' => $_SESSION['memberGroupID'],
				'<%%creatorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%creatorgroup%%>' => sqlValue("select name from membership_groups where groupID='{$_SESSION['memberGroupID']}'"),

				'<%%creationdate%%>' => ($rawData ? @date('Y-m-d') : @date('j/n/Y')),
				'<%%creationtime%%>' => ($rawData ? @date('H:i:s') : @date('h:i:s a')),
				'<%%creationdatetime%%>' => ($rawData ? @date('Y-m-d H:i:s') : @date('j/n/Y h:i:s a')),
				'<%%creationtimestamp%%>' => ($rawData ? @date('Y-m-d H:i:s') : @time())
			);
		}else{
			$arrCodes=array(
				'<%%editorusername%%>' => $_SESSION['memberID'],
				'<%%editorgroupid%%>' => $_SESSION['memberGroupID'],
				'<%%editorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%editorgroup%%>' => sqlValue("select name from membership_groups where groupID='{$_SESSION['memberGroupID']}'"),

				'<%%editingdate%%>' => ($rawData ? @date('Y-m-d') : @date('j/n/Y')),
				'<%%editingtime%%>' => ($rawData ? @date('H:i:s') : @date('h:i:s a')),
				'<%%editingdatetime%%>' => ($rawData ? @date('Y-m-d H:i:s') : @date('j/n/Y h:i:s a')),
				'<%%editingtimestamp%%>' => ($rawData ? @date('Y-m-d H:i:s') : @time())
			);
		}

		$pc=str_ireplace(array_keys($arrCodes), array_values($arrCodes), $code);

		return $pc;
	}

	#########################################################

	function addFilter($index, $filterAnd, $filterField, $filterOperator, $filterValue){
		// validate input
		if($index < 1 || $index > 80 || !is_int($index)) return false;
		if($filterAnd != 'or')   $filterAnd = 'and';
		$filterField = intval($filterField);

		/* backward compatibility */
		if(in_array($filterOperator, $GLOBALS['filter_operators'])){
			$filterOperator = array_search($filterOperator, $GLOBALS['filter_operators']);
		}

		if(!in_array($filterOperator, array_keys($GLOBALS['filter_operators']))){
			$filterOperator = 'like';
		}

		if(!$filterField){
			$filterOperator = '';
			$filterValue = '';
		}

		$_REQUEST['FilterAnd'][$index] = $filterAnd;
		$_REQUEST['FilterField'][$index] = $filterField;
		$_REQUEST['FilterOperator'][$index] = $filterOperator;
		$_REQUEST['FilterValue'][$index] = $filterValue;

		return true;
	}

	#########################################################

	function clearFilters(){
		for($i=1; $i<=80; $i++){
			addFilter($i, '', 0, '', '');
		}
	}

	#########################################################

	if(!function_exists('str_ireplace')){
		function str_ireplace($search, $replace, $subject){
			$ret=$subject;
			if(is_array($search)){
				for($i=0; $i<count($search); $i++){
					$ret=str_ireplace($search[$i], $replace[$i], $ret);
				}
			}else{
				$ret=preg_replace('/'.preg_quote($search, '/').'/i', $replace, $ret);
			}

			return $ret;
		} 
	} 

	#########################################################

	/**
	* Loads a given view from the templates folder, passing the given data to it
	* @param $view the name of a php file (without extension) to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_view (optional) associative array containing the data to pass to the view
	* @return the output of the parsed view as a string
	*/
	function loadView($view, $the_data_to_pass_to_the_view=false){
		global $Translation;

		$view = dirname(__FILE__)."/templates/$view.php";
		if(!is_file($view)) return false;

		if(is_array($the_data_to_pass_to_the_view)){
			foreach($the_data_to_pass_to_the_view as $k => $v)
				$$k = $v;
		}
		unset($the_data_to_pass_to_the_view, $k, $v);

		ob_start();
		@include($view);
		$out=ob_get_contents();
		ob_end_clean();

		return $out;
	}

	#########################################################

	/**
	* Loads a table template from the templates folder, passing the given data to it
	* @param $table_name the name of the table whose template is to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_table associative array containing the data to pass to the table template
	* @return the output of the parsed table template as a string
	*/
	function loadTable($table_name, $the_data_to_pass_to_the_table = array()){
		$dont_load_header = $the_data_to_pass_to_the_table['dont_load_header'];
		$dont_load_footer = $the_data_to_pass_to_the_table['dont_load_footer'];

		$header = $table = $footer = '';

		if(!$dont_load_header){
			// try to load tablename-header
			if(!($header = loadView("{$table_name}-header", $the_data_to_pass_to_the_table))){
				$header = loadView('table-common-header', $the_data_to_pass_to_the_table);
			}
		}

		$table = loadView($table_name, $the_data_to_pass_to_the_table);

		if(!$dont_load_footer){
			// try to load tablename-footer
			if(!($footer = loadView("{$table_name}-footer", $the_data_to_pass_to_the_table))){
				$footer = loadView('table-common-footer', $the_data_to_pass_to_the_table);
			}
		}

		return "{$header}{$table}{$footer}";
	}

	#########################################################

	function filterDropdownBy($filterable, $filterers, $parentFilterers, $parentPKField, $parentCaption, $parentTable, &$filterableCombo){
		$filterersArray = explode(',', $filterers);
		$parentFilterersArray = explode(',', $parentFilterers);
		$parentFiltererList = '`' . implode('`, `', $parentFilterersArray) . '`';
		$res=sql("SELECT `$parentPKField`, $parentCaption, $parentFiltererList FROM `$parentTable` ORDER BY 2", $eo);
		$filterableData = array();
		while($row=db_fetch_row($res)){
			$filterableData[$row[0]] = $row[1];
			$filtererIndex = 0;
			foreach($filterersArray as $filterer){
				$filterableDataByFilterer[$filterer][$row[$filtererIndex + 2]][$row[0]] = $row[1];
				$filtererIndex++;
			}
			$row[0] = addslashes($row[0]);
			$row[1] = addslashes($row[1]);
			$jsonFilterableData .= "\"{$row[0]}\":\"{$row[1]}\",";
		}
		$jsonFilterableData .= '}';
		$jsonFilterableData = '{'.str_replace(',}', '}', $jsonFilterableData);     
		$filterJS = "\nvar {$filterable}_data = $jsonFilterableData;";

		foreach($filterersArray as $filterer){
			if(is_array($filterableDataByFilterer[$filterer])) foreach($filterableDataByFilterer[$filterer] as $filtererItem => $filterableItem){
				$jsonFilterableDataByFilterer[$filterer] .= '"'.addslashes($filtererItem).'":{';
				foreach($filterableItem as $filterableItemID => $filterableItemData){
					$jsonFilterableDataByFilterer[$filterer] .= '"'.addslashes($filterableItemID).'":"'.addslashes($filterableItemData).'",';
				}
				$jsonFilterableDataByFilterer[$filterer] .= '},';
			}
			$jsonFilterableDataByFilterer[$filterer] .= '}';
			$jsonFilterableDataByFilterer[$filterer] = '{'.str_replace(',}', '}', $jsonFilterableDataByFilterer[$filterer]);

			$filterJS.="\n\n// code for filtering {$filterable} by {$filterer}\n";
			$filterJS.="\nvar {$filterable}_data_by_{$filterer} = {$jsonFilterableDataByFilterer[$filterer]}; ";
			$filterJS.="\nvar selected_{$filterable} = \$j('#{$filterable}').val();";
			$filterJS.="\nvar {$filterable}_change_by_{$filterer} = function(){";
			$filterJS.="\n\t$('{$filterable}').options.length=0;";
			$filterJS.="\n\t$('{$filterable}').options[0] = new Option();";
			$filterJS.="\n\tif(\$j('#{$filterer}').val()){";
			$filterJS.="\n\t\tfor({$filterable}_item in {$filterable}_data_by_{$filterer}[\$j('#{$filterer}').val()]){";
			$filterJS.="\n\t\t\t$('{$filterable}').options[$('{$filterable}').options.length] = new Option(";
			$filterJS.="\n\t\t\t\t{$filterable}_data_by_{$filterer}[\$j('#{$filterer}').val()][{$filterable}_item],";
			$filterJS.="\n\t\t\t\t{$filterable}_item,";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false),";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false)";
			$filterJS.="\n\t\t\t);";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t}else{";
			$filterJS.="\n\t\tfor({$filterable}_item in {$filterable}_data){";
			$filterJS.="\n\t\t\t$('{$filterable}').options[$('{$filterable}').options.length] = new Option(";
			$filterJS.="\n\t\t\t\t{$filterable}_data[{$filterable}_item],";
			$filterJS.="\n\t\t\t\t{$filterable}_item,";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false),";
			$filterJS.="\n\t\t\t\t({$filterable}_item == selected_{$filterable} ? true : false)";
			$filterJS.="\n\t\t\t);";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t\tif(selected_{$filterable} && selected_{$filterable} == \$j('#{$filterable}').val()){";
			$filterJS.="\n\t\t\tfor({$filterer}_item in {$filterable}_data_by_{$filterer}){";
			$filterJS.="\n\t\t\t\tfor({$filterable}_item in {$filterable}_data_by_{$filterer}[{$filterer}_item]){";
			$filterJS.="\n\t\t\t\t\tif({$filterable}_item == selected_{$filterable}){";
			$filterJS.="\n\t\t\t\t\t\t$('{$filterer}').value = {$filterer}_item;";
			$filterJS.="\n\t\t\t\t\t\tbreak;";
			$filterJS.="\n\t\t\t\t\t}";
			$filterJS.="\n\t\t\t\t}";
			$filterJS.="\n\t\t\t\tif({$filterable}_item == selected_{$filterable}) break;";
			$filterJS.="\n\t\t\t}";
			$filterJS.="\n\t\t}";
			$filterJS.="\n\t}";
			$filterJS.="\n\t$('{$filterable}').highlight();";
			$filterJS.="\n};";
			$filterJS.="\n$('{$filterer}').observe('change', function(){ /* */ window.setTimeout({$filterable}_change_by_{$filterer}, 25); });";
			$filterJS.="\n";
		}

		$filterableCombo = new Combo;
		$filterableCombo->ListType = 0;
		$filterableCombo->ListItem = array_slice(array_values($filterableData), 0, 10);
		$filterableCombo->ListData = array_slice(array_keys($filterableData), 0, 10);
		$filterableCombo->SelectName = $filterable;
		$filterableCombo->AllowNull = true;

		return $filterJS;
	}

	#########################################################
	function br2nl($text){
		return  preg_replace('/\<br(\s*)?\/?\>/i', "\n", $text);
	}

	#########################################################

	if(!function_exists('htmlspecialchars_decode')){
		function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT){
			return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
		}
	}

	#########################################################

	function entitiesToUTF8($input){
		return preg_replace_callback('/(&#[0-9]+;)/', '_toUTF8', $input);
	}

	function _toUTF8($m){
		if(function_exists('mb_convert_encoding')){
			return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
		}else{
			return $m[1];
		}
	}

	#########################################################

	function func_get_args_byref() {
		if(!function_exists('debug_backtrace')) return false;

		$trace = debug_backtrace();
		return $trace[1]['args'];
	}

	#########################################################

	function permissions_sql($table, $level = 'all'){
		if(!in_array($level, array('user', 'group'))){ $level = 'all'; }
		$perm = getTablePermissions($table);
		$from = '';
		$where = '';
		$pk = getPKFieldName($table);

		if($perm[2] == 1 || ($perm[2] > 1 && $level == 'user')){ // view owner only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."')";
		}elseif($perm[2] == 2 || ($perm[2] > 2 && $level == 'group')){ // view group only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and membership_userrecords.groupID='".getLoggedGroupID()."')";
		}elseif($perm[2] == 3){ // view all
			// no further action
		}elseif($perm[2] == 0){ // view none
			return false;
		}

		return array('where' => $where, 'from' => $from, 0 => $where, 1 => $from);
	}

	#########################################################

	function error_message($msg, $back_url = '', $full_page = true){
		$curr_dir = dirname(__FILE__);
		global $Translation;

		ob_start();

		if($full_page) include_once($curr_dir . '/header.php');

		echo '<div class="panel panel-danger">';
			echo '<div class="panel-heading"><h3 class="panel-title">' . $Translation['error:'] . '</h3></div>';
			echo '<div class="panel-body"><p class="text-danger">' . $msg . '</p>';
			if($back_url !== false){ // explicitly passing false suppresses the back link completely
				echo '<div class="text-center">';
				if($back_url){
					echo '<a href="' . $back_url . '" class="btn btn-danger btn-lg vspacer-lg"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}else{
					echo '<a href="#" class="btn btn-danger btn-lg vspacer-lg" onclick="history.go(-1); return false;"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}
				echo '</div>';
			}
			echo '</div>';
		echo '</div>';

		if($full_page) include_once($curr_dir . '/footer.php');

		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}

	#########################################################

	function toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format){
		// extract date elements
		$de=explode($sep, $formattedDate);
		$mySQLDate=intval($de[strpos($ord, 'Y')]).'-'.intval($de[strpos($ord, 'm')]).'-'.intval($de[strpos($ord, 'd')]);
		return $mySQLDate;
	}

	#########################################################

	function reIndex(&$arr){
		$i=1;
		foreach($arr as $n=>$v){
			$arr2[$i]=$n;
			$i++;
		}
		return $arr2;
	}

	#########################################################

	function get_embed($provider, $url, $max_width = '', $max_height = '', $retrieve = 'html'){
		global $Translation;
		if(!$url) return '';

		$providers = array(
			'youtube' => array('oembed' => 'http://www.youtube.com/oembed?'),
			'googlemap' => array('oembed' => '', 'regex' => '/^http.*\.google\..*maps/i')
		);

		if(!isset($providers[$provider])){
			return '<div class="text-danger">' . $Translation['invalid provider'] . '</div>';
		}

		if(isset($providers[$provider]['regex']) && !preg_match($providers[$provider]['regex'], $url)){
			return '<div class="text-danger">' . $Translation['invalid url'] . '</div>';
		}

		if($providers[$provider]['oembed']){
			$oembed = $providers[$provider]['oembed'] . 'url=' . urlencode($url) . "&maxwidth={$max_width}&maxheight={$max_height}&format=json";
			$data_json = request_cache($oembed);

			$data = json_decode($data_json, true);
			if($data === null){
				/* an error was returned rather than a json string */
				if($retrieve == 'html') return "<div class=\"text-danger\">{$data_json}\n<!-- {$oembed} --></div>";
				return '';
			}

			return (isset($data[$retrieve]) ? $data[$retrieve] : $data['html']);
		}

		/* special cases (where there is no oEmbed provider) */
		if($provider == 'googlemap') return get_embed_googlemap($url, $max_width, $max_height, $retrieve);

		return '<div class="text-danger">Invalid provider!</div>';
	}

	#########################################################

	function get_embed_googlemap($url, $max_width = '', $max_height = '', $retrieve = 'html'){
		global $Translation;
		$url_parts = parse_url($url);
		$coords_regex = '/-?\d+(\.\d+)?[,+]-?\d+(\.\d+)?(,\d{1,2}z)?/'; /* https://stackoverflow.com/questions/2660201 */

		if(preg_match($coords_regex, $url_parts['path'] . '?' . $url_parts['query'], $m)){
			list($lat, $long, $zoom) = explode(',', $m[0]);
			$zoom = intval($zoom);
			if(!$zoom) $zoom = 10; /* default zoom */
			if(!$max_height) $max_height = 360;
			if(!$max_width) $max_width = 480;

			$api_key = '';
			$embed_url = "https://www.google.com/maps/embed/v1/view?key={$api_key}&center={$lat},{$long}&zoom={$zoom}&maptype=roadmap";
			$thumbnail_url = "https://maps.googleapis.com/maps/api/staticmap?key={$api_key}&center={$lat},{$long}&zoom={$zoom}&maptype=roadmap&size={$max_width}x{$max_height}";

			if($retrieve == 'html'){
				return "<iframe width=\"{$max_width}\" height=\"{$max_height}\" frameborder=\"0\" style=\"border:0\" src=\"{$embed_url}\"></iframe>";
			}else{
				return $thumbnail_url;
			}
		}else{
			return '<div class="text-danger">' . $Translation['cant retrieve coordinates from url'] . '</div>';
		}
	}

	#########################################################

	function request_cache($request, $force_fetch = false){
		$max_cache_lifetime = 7 * 86400; /* max cache lifetime in seconds before refreshing from source */

		/* membership_cache table exists? if not, create it */
		static $cache_table_exists = false;
		if(!$cache_table_exists && !$force_fetch){
			$te = sqlValue("show tables like 'membership_cache'");
			if(!$te){
				if(!sql("CREATE TABLE `membership_cache` (`request` VARCHAR(100) NOT NULL, `request_ts` INT, `response` TEXT NOT NULL, PRIMARY KEY (`request`))", $eo)){
					/* table can't be created, so force fetching request */
					return request_cache($request, true);
				}
			}
			$cache_table_exists = true;
		}

		/* retrieve response from cache if exists */
		if(!$force_fetch){
			$res = sql("select response, request_ts from membership_cache where request='" . md5($request) . "'", $eo);
			if(!$row = db_fetch_array($res)) return request_cache($request, true);

			$response = $row[0];
			$response_ts = $row[1];
			if($response_ts < time() - $max_cache_lifetime) return request_cache($request, true);
		}

		/* if no response in cache, issue a request */
		if(!$response || $force_fetch){
			$response = @file_get_contents($request);
			if($response === false){
				$error = error_get_last();
				$error_message = preg_replace('/.*: (.*)/', '$1', $error['message']);
				return $error_message;
			}elseif($cache_table_exists){
				/* store response in cache */
				$ts = time();
				sql("replace into membership_cache set request='" . md5($request) . "', request_ts='{$ts}', response='" . makeSafe($response, false) . "'", $eo);
			}
		}

		return $response;
	}

	#########################################################

	function check_record_permission($table, $id, $perm = 'view'){
		if($perm != 'edit' && $perm != 'delete') $perm = 'view';

		$perms = getTablePermissions($table);
		if(!$perms[$perm]) return false;

		$safe_id = makeSafe($id);
		$safe_table = makeSafe($table);

		if($perms[$perm] == 1){ // own records only
			$username = getLoggedMemberID();
			$owner = sqlValue("select memberID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner == $username) return true;
		}elseif($perms[$perm] == 2){ // group records
			$group_id = getLoggedGroupID();
			$owner_group_id = sqlValue("select groupID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner_group_id == $group_id) return true;
		}elseif($perms[$perm] == 3){ // all records
			return true;
		}

		return false;
	}

	#########################################################

	function NavMenus($options = array()){
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		global $Translation;
		$prepend_path = PREPEND_PATH;

		/* default options */
		if(empty($options)){
			$options = array(
				'tabs' => 7
			);
		}

		$table_group_name = array_keys(get_table_groups()); /* 0 => group1, 1 => group2 .. */
		/* if only one group named 'None', set to translation of 'select a table' */
		if((count($table_group_name) == 1 && $table_group_name[0] == 'None') || count($table_group_name) < 1) $table_group_name[0] = $Translation['select a table'];
		$table_group_index = array_flip($table_group_name); /* group1 => 0, group2 => 1 .. */
		$menu = array_fill(0, count($table_group_name), '');

		$t = time();
		$arrTables = getTableList();
		if(is_array($arrTables)){
			foreach($arrTables as $tn => $tc){
				/* ---- list of tables where hide link in nav menu is set ---- */
				$tChkHL = array_search($tn, array('tb_campanha_contato','tb_acompanhamento_colaborador'));

				/* ---- list of tables where filter first is set ---- */
				$tChkFF = array_search($tn, array());
				if($tChkFF !== false && $tChkFF !== null){
					$searchFirst = '&Filter_x=1';
				}else{
					$searchFirst = '';
				}

				/* when no groups defined, $table_group_index['None'] is NULL, so $menu_index is still set to 0 */
				$menu_index = intval($table_group_index[$tc[3]]);
				if(!$tChkHL && $tChkHL !== 0) $menu[$menu_index] .= "<li><a href=\"{$prepend_path}{$tn}_view.php?t={$t}{$searchFirst}\"><img src=\"{$prepend_path}" . ($tc[2] ? $tc[2] : 'blank.gif') . "\" height=\"32\"> {$tc[0]}</a></li>";
			}
		}

		// custom nav links, as defined in "hooks/links-navmenu.php" 
		global $navLinks;
		if(is_array($navLinks)){
			$memberInfo = getMemberInfo();
			$links_added = array();
			foreach($navLinks as $link){
				if(!isset($link['url']) || !isset($link['title'])) continue;
				if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
					$menu_index = intval($link['table_group']);
					if(!$links_added[$menu_index]) $menu[$menu_index] .= '<li class="divider"></li>';

					/* add prepend_path to custom links if they aren't absolute links */
					if(!preg_match('/^(http|\/\/)/i', $link['url'])) $link['url'] = $prepend_path . $link['url'];
					if(!preg_match('/^(http|\/\/)/i', $link['icon']) && $link['icon']) $link['icon'] = $prepend_path . $link['icon'];

					$menu[$menu_index] .= "<li><a href=\"{$link['url']}\"><img src=\"" . ($link['icon'] ? $link['icon'] : "{$prepend_path}blank.gif") . "\" height=\"32\"> {$link['title']}</a></li>";
					$links_added[$menu_index]++;
				}
			}
		}

		$menu_wrapper = '';
		for($i = 0; $i < count($menu); $i++){
			$menu_wrapper .= <<<EOT
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$table_group_name[$i]} <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">{$menu[$i]}</ul>
				</li>
EOT;
		}

		return $menu_wrapper;
	}

	#########################################################

	function StyleSheet(){
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		$prepend_path = PREPEND_PATH;

		$css_links = <<<EOT

			<link rel="stylesheet" href="{$prepend_path}resources/initializr/css/cerulean.css">
			<link rel="stylesheet" href="{$prepend_path}resources/lightbox/css/lightbox.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/select2/select2.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/timepicker/bootstrap-timepicker.min.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}dynamic.css.php">
EOT;

		return $css_links;
	}

	#########################################################

	function getUploadDir($dir){
		global $Translation;

		if($dir==""){
			$dir=$Translation['ImageFolder'];
		}

		if(substr($dir, -1)!="/"){
			$dir.="/";
		}

		return $dir;
	}

	#########################################################

	function PrepareUploadedFile($FieldName, $MaxSize, $FileTypes = 'jpg|jpeg|gif|png', $NoRename = false, $dir = ''){
		global $Translation;
		$f = $_FILES[$FieldName];
		if($f['error'] == 4 || !$f['name']) return '';

		$dir = getUploadDir($dir);

		/* get php.ini upload_max_filesize in bytes */
		$php_upload_size_limit = trim(ini_get('upload_max_filesize'));
		$last = strtolower($php_upload_size_limit[strlen($php_upload_size_limit) - 1]);
		switch($last){
			case 'g':
				$php_upload_size_limit *= 1024;
			case 'm':
				$php_upload_size_limit *= 1024;
			case 'k':
				$php_upload_size_limit *= 1024;
		}

		$MaxSize = min($MaxSize, $php_upload_size_limit);

		if($f['size'] > $MaxSize || $f['error']){
			echo error_message(str_replace('<MaxSize>', intval($MaxSize / 1024), $Translation['file too large']));
			exit;
		}
		if(!preg_match('/\.(' . $FileTypes . ')$/i', $f['name'], $ft)){
			echo error_message(str_replace('<FileTypes>', str_replace('|', ', ', $FileTypes), $Translation['invalid file type']));
			exit;
		}

		$name = str_replace(' ', '_', $f['name']);
		if(!$NoRename) $name = substr(md5(microtime() . rand(0, 100000)), -17) . $ft[0];

		if(!file_exists($dir)) @mkdir($dir, 0777);

		if(!@move_uploaded_file($f['tmp_name'], $dir . $name)){
			echo error_message("Couldn't save the uploaded file. Try chmoding the upload folder '{$dir}' to 777.");
			exit;
		}

		@chmod($dir . $name, 0666);
		return $name;
	}

	#########################################################

	function get_home_links($homeLinks, $default_classes, $tgroup = ''){
		if(!is_array($homeLinks) || !count($homeLinks)) return '';

		$memberInfo = getMemberInfo();

		ob_start();
		foreach($homeLinks as $link){
			if(!isset($link['url']) || !isset($link['title'])) continue;
			if($tgroup != $link['table_group'] && $tgroup != '*') continue;

			/* fall-back classes if none defined */
			if(!$link['grid_column_classes']) $link['grid_column_classes'] = $default_classes['grid_column'];
			if(!$link['panel_classes']) $link['panel_classes'] = $default_classes['panel'];
			if(!$link['link_classes']) $link['link_classes'] = $default_classes['link'];

			if($memberInfo['admin'] || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])){
				?>
				<div class="col-xs-12 <?php echo $link['grid_column_classes']; ?>">
					<div class="panel <?php echo $link['panel_classes']; ?>">
						<div class="panel-body">
							<a class="btn btn-block btn-lg <?php echo $link['link_classes']; ?>" title="<?php echo preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", html_attr(strip_tags($link['description']))); ?>" href="<?php echo $link['url']; ?>"><?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?><strong><?php echo $link['title']; ?></strong></a>
							<div class="panel-body-description"><?php echo $link['description']; ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		}

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	#########################################################

	function quick_search_html($search_term, $label, $separate_dv = true){
		global $Translation;

		$safe_search = html_attr($search_term);
		$safe_label = html_attr($label);
		$safe_clear_label = html_attr($Translation['Reset Filters']);

		if($separate_dv){
			$reset_selection = "document.myform.SelectedID.value = '';";
		}else{
			$reset_selection = "document.myform.writeAttribute('novalidate', 'novalidate');";
		}
		$reset_selection .= ' document.myform.NoDV.value=1; return true;';

		$html = <<<EOT
		<div class="input-group" id="quick-search">
			<input type="text" id="SearchString" name="SearchString" value="{$safe_search}" class="form-control" placeholder="{$safe_label}">
			<span class="input-group-btn">
				<button name="Search_x" value="1" id="Search" type="submit" onClick="{$reset_selection}" class="btn btn-default" title="{$safe_label}"><i class="glyphicon glyphicon-search"></i></button>
				<button name="ClearQuickSearch" value="1" id="ClearQuickSearch" type="submit" onClick="\$j('#SearchString').val(''); {$reset_selection}" class="btn btn-default" title="{$safe_clear_label}"><i class="glyphicon glyphicon-remove-circle"></i></button>
			</span>
		</div>
EOT;
		return $html;
	}

	#########################################################

