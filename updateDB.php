<?php
	// check this file's MD5 to make sure it wasn't called before
	$prevMD5=@implode('', @file(dirname(__FILE__).'/setup.md5'));
	$thisMD5=md5(@implode('', @file("./updateDB.php")));
	if($thisMD5==$prevMD5){
		$setupAlreadyRun=true;
	}else{
		// set up tables
		if(!isset($silent)){
			$silent=true;
		}

		// set up tables
		setupTable('tb_vaga', "create table if not exists `tb_vaga` (   `requerimento_id` INT unsigned , `int_vaga_numero` INT , `id` INT unsigned not null auto_increment , primary key (`id`), `empresa_id` INT unsigned , `str_alocacao` INT unsigned not null , `recrutador_id` INT unsigned not null , `str_posicao` VARCHAR(150) not null , `dta_abertura` DATE not null , `qtd_vagas` SMALLINT(1) unsigned not null , `str_prioridade` VARCHAR(150) not null , `str_status` VARCHAR(150) not null , `dta_fechamento` DATE , `dta_previsao_fechamento` DATE , `str_obs` VARCHAR(255) , `dta_inicio` DATE , `str_contratado_nome` VARCHAR(150) ) CHARSET utf8", $silent, array( "ALTER TABLE tb_vaga ADD `field15` VARCHAR(40)","ALTER TABLE `tb_vaga` CHANGE `field15` `requerimento_id` VARCHAR(40) ","ALTER TABLE tb_vaga ADD `field16` VARCHAR(40)","ALTER TABLE `tb_vaga` CHANGE `field16` `int_req_n` VARCHAR(40) ","ALTER TABLE `tb_vaga` CHANGE `int_req_n` `int_vaga_numero` VARCHAR(40) "," ALTER TABLE `tb_vaga` CHANGE `int_vaga_numero` `int_vaga_numero` INT "));
		setupIndexes('tb_vaga', array('requerimento_id','empresa_id','str_alocacao','recrutador_id'));
		setupTable('tb_entrevista', "create table if not exists `tb_entrevista` (   `id` INT unsigned not null auto_increment , primary key (`id`), `empresa_id` INT unsigned not null , `vaga_id` INT unsigned not null , `recrutador_id` INT unsigned not null , `dta` DATE not null , `int_qtd_contatos` SMALLINT not null , `int_qtd_entrevistas` SMALLINT not null , `int_qtd_encaminhamentos` SMALLINT not null ) CHARSET utf8", $silent);
		setupIndexes('tb_entrevista', array('empresa_id','vaga_id','recrutador_id'));
		setupTable('tb_contratacao', "create table if not exists `tb_contratacao` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_candidato_nome` VARCHAR(150) not null , `int_cpf` INT not null , unique `int_cpf_unique` (`int_cpf`), `dta_contratacao` DATE not null , `dta_demissao` DATE , `bol_gestor` TINYINT default '0' ) CHARSET utf8", $silent);
		setupTable('tb_alocacao', "create table if not exists `tb_alocacao` (   `id` INT unsigned not null auto_increment , primary key (`id`), `int_empresa` INT unsigned not null , `str_nome` VARCHAR(150) ) CHARSET utf8", $silent);
		setupIndexes('tb_alocacao', array('int_empresa'));
		setupTable('tb_recrutador', "create table if not exists `tb_recrutador` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_nome` VARCHAR(150) not null , `bol_status` TINYINT default '1' , `bol_recrutador` TINYINT , `bol_comercial` TINYINT ) CHARSET utf8", $silent);
		setupTable('tb_empresa', "create table if not exists `tb_empresa` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_nome_fantasia` VARCHAR(150) not null , `str_responsavel` INT unsigned not null , `relacionamento_id` INT unsigned not null , `cidade` VARCHAR(150) , `uf` VARCHAR(2) not null ) CHARSET utf8", $silent);
		setupIndexes('tb_empresa', array('str_responsavel','relacionamento_id'));
		setupTable('tb_prova_tipo', "create table if not exists `tb_prova_tipo` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_nome` VARCHAR(150) not null , `str_descricao` VARCHAR(255) ) CHARSET utf8", $silent);
		setupTable('tb_contato', "create table if not exists `tb_contato` (   `id` INT unsigned not null auto_increment , primary key (`id`), `empresa_id` INT unsigned not null , `str_primeiro_nome` VARCHAR(150) not null , `str_sobrenome` VARCHAR(150) , `str_nivel` VARCHAR(150) not null , `tipo_id` INT unsigned not null , `str_email1` VARCHAR(150) not null , `str_email2` VARCHAR(150) , `str_telefone1` VARCHAR(150) , `str_telefone2` VARCHAR(150) , `str_telefone3` VARCHAR(150) , `cidade` VARCHAR(150) , `uf` VARCHAR(2) , `dta_cadastro` DATE ) CHARSET utf8", $silent);
		setupIndexes('tb_contato', array('empresa_id','tipo_id'));
		setupTable('tb_contato_tipo', "create table if not exists `tb_contato_tipo` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_nome` VARCHAR(150) not null ) CHARSET utf8", $silent);
		setupTable('tb_oportunidade', "create table if not exists `tb_oportunidade` (   `id` INT unsigned not null auto_increment , primary key (`id`), `tipo_id` INT unsigned , `estagio_id` INT unsigned not null , `empresa_id` INT unsigned not null , `contato_id` INT unsigned not null , `str_demanda` VARCHAR(200) , `dta_inicio` DATE not null , `dta_prev_fechamento` DATE , `int_probabilidade` SMALLINT not null , `int_valor` DECIMAL(10,2) unsigned , `int_parcelas` SMALLINT(2) not null default '1' , `dta_proposta` DATE , `str_proposta` VARCHAR(150) , `str_anotacoes` TEXT , `str_responsavel` VARCHAR(150) ) CHARSET utf8", $silent);
		setupIndexes('tb_oportunidade', array('tipo_id','estagio_id','empresa_id','contato_id'));
		setupTable('tb_atendimento', "create table if not exists `tb_atendimento` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_iniciativa` VARCHAR(150) not null , `empresa_id` INT unsigned not null , `contato_id` INT unsigned not null , `str_meio` VARCHAR(150) , `str_finalidade` VARCHAR(150) , `dta` DATE not null , `campanha_id` INT unsigned , `usuario_id` INT unsigned not null , `str_anotacoes` VARCHAR(255) ) CHARSET utf8", $silent);
		setupIndexes('tb_atendimento', array('empresa_id','contato_id','campanha_id','usuario_id'));
		setupTable('tb_oportunidade_tipo', "create table if not exists `tb_oportunidade_tipo` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_nome` VARCHAR(150) not null ) CHARSET utf8", $silent);
		setupTable('tb_oportunidade_estagio', "create table if not exists `tb_oportunidade_estagio` (   `id` INT unsigned not null auto_increment , primary key (`id`), `tipo_id` INT unsigned not null , `str_nome` VARCHAR(150) not null ) CHARSET utf8", $silent);
		setupIndexes('tb_oportunidade_estagio', array('tipo_id'));
		setupTable('tb_acompanhamento', "create table if not exists `tb_acompanhamento` (   `id` INT unsigned not null auto_increment , primary key (`id`), `empresa_id` INT unsigned not null , `contato_id` INT unsigned not null , `contrato_id` INT unsigned not null , `usuario_id` INT unsigned not null , `dta` DATE not null , `str_meio` VARCHAR(150) not null , `str_statusgeral` VARCHAR(150) not null , `str_clima_cliente` VARCHAR(150) not null , `str_clima_equipe` VARCHAR(150) not null , `str_observacoes` TEXT , `str_acoes_corretivas` TEXT ) CHARSET utf8", $silent);
		setupIndexes('tb_acompanhamento', array('empresa_id','contato_id','contrato_id','usuario_id'));
		setupTable('tb_contrato', "create table if not exists `tb_contrato` (   `id` INT unsigned not null auto_increment , primary key (`id`), `empresa_id` INT unsigned not null , `str_nome` VARCHAR(150) not null , `dta_inicio` DATE not null , `dta_termino` DATE , `str_detalhes` TEXT , `str_anexo` VARCHAR(150) , `bol_status` TINYINT default '1' ) CHARSET utf8", $silent);
		setupIndexes('tb_contrato', array('empresa_id'));
		setupTable('tb_campanha', "create table if not exists `tb_campanha` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_nome` VARCHAR(150) not null , `dta_inicio` DATE not null , `st_descricao` TEXT ) CHARSET utf8", $silent);
		setupTable('tb_campanha_contato', "create table if not exists `tb_campanha_contato` (   `id` INT unsigned not null auto_increment , primary key (`id`), `campanha_id` INT unsigned not null , `empresa_id` INT unsigned not null , `contato_id` INT unsigned not null ) CHARSET utf8", $silent);
		setupIndexes('tb_campanha_contato', array('campanha_id','empresa_id','contato_id'));
		setupTable('tb_acompanhamento_colaborador', "create table if not exists `tb_acompanhamento_colaborador` (   `id` INT unsigned not null auto_increment , primary key (`id`), `dta_data` DATE , `acompanhamento_id` INT unsigned , `colaborador_id` INT unsigned , `str_tipo` VARCHAR(150) not null , `str_comentarios` TINYTEXT , `str_responsavel` VARCHAR(150) ) CHARSET utf8", $silent);
		setupIndexes('tb_acompanhamento_colaborador', array('acompanhamento_id','colaborador_id'));
		setupTable('tb_indicador', "create table if not exists `tb_indicador` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_departamento` VARCHAR(150) not null , `str_nome` VARCHAR(150) not null , `str_descricao` VARCHAR(255) not null , `str_unidade_medida` VARCHAR(10) not null ) CHARSET utf8", $silent);
		setupTable('tb_indicador_periodo', "create table if not exists `tb_indicador_periodo` (   `id` INT unsigned not null auto_increment , primary key (`id`), `indicador_id` INT unsigned not null , `str_unidade` VARCHAR(150) , `str_vertical` VARCHAR(150) , `str_responsavel` VARCHAR(150) , `dta` DATE not null , `flo_sazonalidade` DECIMAL(5,2) , `int_meta` INT , `int_meta_ajustada` INT , `int_realizado` INT ) CHARSET utf8", $silent);
		setupIndexes('tb_indicador_periodo', array('indicador_id'));
		setupTable('tb_fatura', "create table if not exists `tb_fatura` (   `id` INT unsigned not null auto_increment , primary key (`id`), `empresa_id` INT unsigned not null , `dta_emissao` DATE not null , `dta_competencia` DATE not null , `flo_valor` DECIMAL(10,2) not null , `int_nf` SMALLINT , `str_observacoes` VARCHAR(255) ) CHARSET utf8", $silent);
		setupIndexes('tb_fatura', array('empresa_id'));
		setupTable('tb_ajuste_colaborador', "create table if not exists `tb_ajuste_colaborador` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_responsavel` VARCHAR(150) , `dta_data` DATE , `colaborador_id` INT unsigned not null , `str_ajuste` VARCHAR(150) not null , `bol_evidencia` TINYINT(1) , `int_quantidade` INT default '1' , `gestor_id` INT unsigned not null , `bol_notificacao` TINYINT(1) ) CHARSET utf8", $silent);
		setupIndexes('tb_ajuste_colaborador', array('colaborador_id','gestor_id'));
		setupTable('tb_requerimento', "create table if not exists `tb_requerimento` (   `id` INT unsigned not null auto_increment , primary key (`id`), `str_status` VARCHAR(40) default 'Pendente' , `str_posicao` VARCHAR(40) not null , `int_n_vagas` INT not null , `str_reposicao` VARCHAR(8) not null , `str_recurso` VARCHAR(40) , `time_horario_entrada` TIME not null , `time_horario_saida` TIME not null , `empresa_id` INT unsigned not null , `contato_id` INT unsigned not null , `str_gestor` VARCHAR(40) not null , `str_telefone` VARCHAR(40) not null , `str_email` VARCHAR(40) not null , `float_salario` FLOAT(10,2) not null , `int_maquinas` INT not null default '0' , `str_beneficios` TEXT , `bool_abertura` VARCHAR(40) not null default 'Abertura imediata' , `data_indicacao` DATE not null , `str_descricao` TEXT ) CHARSET utf8", $silent);
		setupIndexes('tb_requerimento', array('empresa_id','contato_id'));


		// save MD5
		if($fp=@fopen(dirname(__FILE__).'/setup.md5', 'w')){
			fwrite($fp, $thisMD5);
			fclose($fp);
		}
	}


	function setupIndexes($tableName, $arrFields){
		if(!is_array($arrFields)){
			return false;
		}

		foreach($arrFields as $fieldName){
			if(!$res=@db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")){
				continue;
			}
			if(!$row=@db_fetch_assoc($res)){
				continue;
			}
			if($row['Key']==''){
				@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
			}
		}
	}


	function setupTable($tableName, $createSQL='', $silent=true, $arrAlter=''){
		global $Translation;
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)){
			$matches=array();
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/", $arrAlter[0], $matches)){
				$oldTableName=$matches[1];
			}
		}

		if($res=@db_query("select count(1) from `$tableName`")){ // table already exists
			if($row = @db_fetch_array($res)){
				echo str_replace("<TableName>", $tableName, str_replace("<NumRecords>", $row[0],$Translation["table exists"]));
				if(is_array($arrAlter)){
					echo '<br>';
					foreach($arrAlter as $alter){
						if($alter!=''){
							echo "$alter ... ";
							if(!@db_query($alter)){
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							}else{
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				}else{
					echo $Translation["table uptodate"];
				}
			}else{
				echo str_replace("<TableName>", $tableName, $Translation["couldnt count"]);
			}
		}else{ // given tableName doesn't exist

			if($oldTableName!=''){ // if we have a table rename query
				if($ro=@db_query("select count(1) from `$oldTableName`")){ // if old table exists, rename it.
					$renameQuery=array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)){
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					}else{
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				}else{ // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			}else{ // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)){
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';
				}else{
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}
		}

		echo "</div>";

		$out=ob_get_contents();
		ob_end_clean();
		if(!$silent){
			echo $out;
		}
	}
?>