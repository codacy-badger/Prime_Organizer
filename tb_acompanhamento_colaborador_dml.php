<?php

// Data functions (insert, update, delete, form) for table tb_acompanhamento_colaborador

// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

function tb_acompanhamento_colaborador_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('tb_acompanhamento_colaborador');
	if(!$arrPerm[1]){
		return false;
	}

	$data['dta_data'] = parseCode('<%%creationDate%%>', true, true);
	$data['acompanhamento_id'] = makeSafe($_REQUEST['acompanhamento_id']);
		if($data['acompanhamento_id'] == empty_lookup_value){ $data['acompanhamento_id'] = ''; }
	$data['colaborador_id'] = makeSafe($_REQUEST['colaborador_id']);
		if($data['colaborador_id'] == empty_lookup_value){ $data['colaborador_id'] = ''; }
	$data['str_tipo'] = makeSafe($_REQUEST['str_tipo']);
		if($data['str_tipo'] == empty_lookup_value){ $data['str_tipo'] = ''; }
	$data['str_comentarios'] = br2nl(makeSafe($_REQUEST['str_comentarios']));
	$data['str_responsavel'] = parseCode('<%%creatorUsername%%>', true);
	if($data['str_tipo']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Feedback': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: tb_acompanhamento_colaborador_before_insert
	if(function_exists('tb_acompanhamento_colaborador_before_insert')){
		$args=array();
		if(!tb_acompanhamento_colaborador_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `tb_acompanhamento_colaborador` set       `dta_data`=' . "'{$data['dta_data']}'" . ', `acompanhamento_id`=' . (($data['acompanhamento_id'] !== '' && $data['acompanhamento_id'] !== NULL) ? "'{$data['acompanhamento_id']}'" : 'NULL') . ', `colaborador_id`=' . (($data['colaborador_id'] !== '' && $data['colaborador_id'] !== NULL) ? "'{$data['colaborador_id']}'" : 'NULL') . ', `str_tipo`=' . (($data['str_tipo'] !== '' && $data['str_tipo'] !== NULL) ? "'{$data['str_tipo']}'" : 'NULL') . ', `str_comentarios`=' . (($data['str_comentarios'] !== '' && $data['str_comentarios'] !== NULL) ? "'{$data['str_comentarios']}'" : 'NULL') . ', `str_responsavel`=' . "'{$data['str_responsavel']}'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"tb_acompanhamento_colaborador_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: tb_acompanhamento_colaborador_after_insert
	if(function_exists('tb_acompanhamento_colaborador_after_insert')){
		$res = sql("select * from `tb_acompanhamento_colaborador` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!tb_acompanhamento_colaborador_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('tb_acompanhamento_colaborador', $recID, getLoggedMemberID());

	return $recID;
}

function tb_acompanhamento_colaborador_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('tb_acompanhamento_colaborador');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: tb_acompanhamento_colaborador_before_delete
	if(function_exists('tb_acompanhamento_colaborador_before_delete')){
		$args=array();
		if(!tb_acompanhamento_colaborador_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `tb_acompanhamento_colaborador` where `id`='$selected_id'", $eo);

	// hook: tb_acompanhamento_colaborador_after_delete
	if(function_exists('tb_acompanhamento_colaborador_after_delete')){
		$args=array();
		tb_acompanhamento_colaborador_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='$selected_id'", $eo);
}

function tb_acompanhamento_colaborador_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('tb_acompanhamento_colaborador');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['dta_data'] = parseMySQLDate('', '<%%creationDate%%>');
	$data['acompanhamento_id'] = makeSafe($_REQUEST['acompanhamento_id']);
		if($data['acompanhamento_id'] == empty_lookup_value){ $data['acompanhamento_id'] = ''; }
	$data['colaborador_id'] = makeSafe($_REQUEST['colaborador_id']);
		if($data['colaborador_id'] == empty_lookup_value){ $data['colaborador_id'] = ''; }
	$data['str_tipo'] = makeSafe($_REQUEST['str_tipo']);
		if($data['str_tipo'] == empty_lookup_value){ $data['str_tipo'] = ''; }
	if($data['str_tipo']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Feedback': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['str_comentarios'] = br2nl(makeSafe($_REQUEST['str_comentarios']));
	$data['selectedID']=makeSafe($selected_id);

	// hook: tb_acompanhamento_colaborador_before_update
	if(function_exists('tb_acompanhamento_colaborador_before_update')){
		$args=array();
		if(!tb_acompanhamento_colaborador_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `tb_acompanhamento_colaborador` set       `dta_data`=`dta_data`' . ', `acompanhamento_id`=' . (($data['acompanhamento_id'] !== '' && $data['acompanhamento_id'] !== NULL) ? "'{$data['acompanhamento_id']}'" : 'NULL') . ', `colaborador_id`=' . (($data['colaborador_id'] !== '' && $data['colaborador_id'] !== NULL) ? "'{$data['colaborador_id']}'" : 'NULL') . ', `str_tipo`=' . (($data['str_tipo'] !== '' && $data['str_tipo'] !== NULL) ? "'{$data['str_tipo']}'" : 'NULL') . ', `str_comentarios`=' . (($data['str_comentarios'] !== '' && $data['str_comentarios'] !== NULL) ? "'{$data['str_comentarios']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="tb_acompanhamento_colaborador_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: tb_acompanhamento_colaborador_after_update
	if(function_exists('tb_acompanhamento_colaborador_after_update')){
		$res = sql("SELECT * FROM `tb_acompanhamento_colaborador` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!tb_acompanhamento_colaborador_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='tb_acompanhamento_colaborador' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function tb_acompanhamento_colaborador_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('tb_acompanhamento_colaborador');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_acompanhamento_id = thisOr(undo_magic_quotes($_REQUEST['filterer_acompanhamento_id']), '');
	$filterer_colaborador_id = thisOr(undo_magic_quotes($_REQUEST['filterer_colaborador_id']), '');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: dta_data
	$combo_dta_data = new DateCombo;
	$combo_dta_data->DateFormat = "dmy";
	$combo_dta_data->MinYear = 1900;
	$combo_dta_data->MaxYear = 2100;
	$combo_dta_data->DefaultDate = parseMySQLDate('<%%creationDate%%>', '<%%creationDate%%>');
	$combo_dta_data->MonthNames = $Translation['month names'];
	$combo_dta_data->NamePrefix = 'dta_data';
	// combobox: acompanhamento_id
	$combo_acompanhamento_id = new DataCombo;
	// combobox: colaborador_id
	$combo_colaborador_id = new DataCombo;
	// combobox: str_tipo
	$combo_str_tipo = new Combo;
	$combo_str_tipo->ListType = 2;
	$combo_str_tipo->MultipleSeparator = ', ';
	$combo_str_tipo->ListBoxHeight = 10;
	$combo_str_tipo->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/tb_acompanhamento_colaborador.str_tipo.csv')){
		$str_tipo_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/tb_acompanhamento_colaborador.str_tipo.csv')));
		$combo_str_tipo->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($str_tipo_data)));
		$combo_str_tipo->ListData = $combo_str_tipo->ListItem;
	}else{
		$combo_str_tipo->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("P&#201;SSIMO;;RUIM;;BOM;;EXCELENTE")));
		$combo_str_tipo->ListData = $combo_str_tipo->ListItem;
	}
	$combo_str_tipo->SelectName = 'str_tipo';
	$combo_str_tipo->AllowNull = false;

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='tb_acompanhamento_colaborador' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `tb_acompanhamento_colaborador` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'tb_acompanhamento_colaborador_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_dta_data->DefaultDate = $row['dta_data'];
		$combo_acompanhamento_id->SelectedData = $row['acompanhamento_id'];
		$combo_colaborador_id->SelectedData = $row['colaborador_id'];
		$combo_str_tipo->SelectedData = $row['str_tipo'];
	}else{
		$combo_acompanhamento_id->SelectedData = $filterer_acompanhamento_id;
		$combo_colaborador_id->SelectedData = $filterer_colaborador_id;
		$combo_str_tipo->SelectedText = ( $_REQUEST['FilterField'][1]=='5' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "");
	}
	$combo_acompanhamento_id->HTML = '<span id="acompanhamento_id-container' . $rnd1 . '"></span><input type="hidden" name="acompanhamento_id" id="acompanhamento_id' . $rnd1 . '" value="' . html_attr($combo_acompanhamento_id->SelectedData) . '">';
	$combo_acompanhamento_id->MatchText = '<span id="acompanhamento_id-container-readonly' . $rnd1 . '"></span><input type="hidden" name="acompanhamento_id" id="acompanhamento_id' . $rnd1 . '" value="' . html_attr($combo_acompanhamento_id->SelectedData) . '">';
	$combo_colaborador_id->HTML = '<span id="colaborador_id-container' . $rnd1 . '"></span><input type="hidden" name="colaborador_id" id="colaborador_id' . $rnd1 . '" value="' . html_attr($combo_colaborador_id->SelectedData) . '">';
	$combo_colaborador_id->MatchText = '<span id="colaborador_id-container-readonly' . $rnd1 . '"></span><input type="hidden" name="colaborador_id" id="colaborador_id' . $rnd1 . '" value="' . html_attr($combo_colaborador_id->SelectedData) . '">';
	$combo_str_tipo->Render();

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_acompanhamento_id__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['acompanhamento_id'] : $filterer_acompanhamento_id); ?>"};
		AppGini.current_colaborador_id__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['colaborador_id'] : $filterer_colaborador_id); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(acompanhamento_id_reload__RAND__) == 'function') acompanhamento_id_reload__RAND__();
				if(typeof(colaborador_id_reload__RAND__) == 'function') colaborador_id_reload__RAND__();
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function acompanhamento_id_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#acompanhamento_id-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_acompanhamento_id__RAND__.value, t: 'tb_acompanhamento_colaborador', f: 'acompanhamento_id' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="acompanhamento_id"]').val(resp.results[0].id);
							$j('[id=acompanhamento_id-container-readonly__RAND__]').html('<span id="acompanhamento_id-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_acompanhamento_view_parent]').hide(); }else{ $j('.btn[id=tb_acompanhamento_view_parent]').show(); }


							if(typeof(acompanhamento_id_update_autofills__RAND__) == 'function') acompanhamento_id_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ /* */ return { s: term, p: page, t: 'tb_acompanhamento_colaborador', f: 'acompanhamento_id' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_acompanhamento_id__RAND__.value = e.added.id;
				AppGini.current_acompanhamento_id__RAND__.text = e.added.text;
				$j('[name="acompanhamento_id"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_acompanhamento_view_parent]').hide(); }else{ $j('.btn[id=tb_acompanhamento_view_parent]').show(); }


				if(typeof(acompanhamento_id_update_autofills__RAND__) == 'function') acompanhamento_id_update_autofills__RAND__();
			});

			if(!$j("#acompanhamento_id-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_acompanhamento_id__RAND__.value, t: 'tb_acompanhamento_colaborador', f: 'acompanhamento_id' },
					success: function(resp){
						$j('[name="acompanhamento_id"]').val(resp.results[0].id);
						$j('[id=acompanhamento_id-container-readonly__RAND__]').html('<span id="acompanhamento_id-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_acompanhamento_view_parent]').hide(); }else{ $j('.btn[id=tb_acompanhamento_view_parent]').show(); }

						if(typeof(acompanhamento_id_update_autofills__RAND__) == 'function') acompanhamento_id_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_acompanhamento_id__RAND__.value, t: 'tb_acompanhamento_colaborador', f: 'acompanhamento_id' },
				success: function(resp){
					$j('[id=acompanhamento_id-container__RAND__], [id=acompanhamento_id-container-readonly__RAND__]').html('<span id="acompanhamento_id-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_acompanhamento_view_parent]').hide(); }else{ $j('.btn[id=tb_acompanhamento_view_parent]').show(); }

					if(typeof(acompanhamento_id_update_autofills__RAND__) == 'function') acompanhamento_id_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function colaborador_id_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#colaborador_id-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_colaborador_id__RAND__.value, t: 'tb_acompanhamento_colaborador', f: 'colaborador_id' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="colaborador_id"]').val(resp.results[0].id);
							$j('[id=colaborador_id-container-readonly__RAND__]').html('<span id="colaborador_id-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_contratacao_view_parent]').hide(); }else{ $j('.btn[id=tb_contratacao_view_parent]').show(); }


							if(typeof(colaborador_id_update_autofills__RAND__) == 'function') colaborador_id_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ /* */ return { s: term, p: page, t: 'tb_acompanhamento_colaborador', f: 'colaborador_id' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_colaborador_id__RAND__.value = e.added.id;
				AppGini.current_colaborador_id__RAND__.text = e.added.text;
				$j('[name="colaborador_id"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_contratacao_view_parent]').hide(); }else{ $j('.btn[id=tb_contratacao_view_parent]').show(); }


				if(typeof(colaborador_id_update_autofills__RAND__) == 'function') colaborador_id_update_autofills__RAND__();
			});

			if(!$j("#colaborador_id-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_colaborador_id__RAND__.value, t: 'tb_acompanhamento_colaborador', f: 'colaborador_id' },
					success: function(resp){
						$j('[name="colaborador_id"]').val(resp.results[0].id);
						$j('[id=colaborador_id-container-readonly__RAND__]').html('<span id="colaborador_id-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_contratacao_view_parent]').hide(); }else{ $j('.btn[id=tb_contratacao_view_parent]').show(); }

						if(typeof(colaborador_id_update_autofills__RAND__) == 'function') colaborador_id_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_colaborador_id__RAND__.value, t: 'tb_acompanhamento_colaborador', f: 'colaborador_id' },
				success: function(resp){
					$j('[id=colaborador_id-container__RAND__], [id=colaborador_id-container-readonly__RAND__]').html('<span id="colaborador_id-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_contratacao_view_parent]').hide(); }else{ $j('.btn[id=tb_contratacao_view_parent]').show(); }

					if(typeof(colaborador_id_update_autofills__RAND__) == 'function') colaborador_id_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/tb_acompanhamento_colaborador_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/tb_acompanhamento_colaborador_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Detalhes do acompanhamento individual', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return tb_acompanhamento_colaborador_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return tb_acompanhamento_colaborador_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'AppGini.closeParentModal(); return false;';
	}else{
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return tb_acompanhamento_colaborador_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#acompanhamento_id').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#acompanhamento_id_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#colaborador_id').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#colaborador_id_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('input[name=str_tipo]').parent().html('<div class=\"form-control-static\">' + jQuery('input[name=str_tipo]:checked').next().text() + '</div>')\n";
		$jsReadOnly .= "\tjQuery('#str_comentarios').replaceWith('<div class=\"form-control-static\" id=\"str_comentarios\">' + (jQuery('#str_comentarios').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif(($AllowInsert && !$selected_id) || ($AllowUpdate && $selected_id)){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(dta_data)%%>', ($selected_id && !$arrPerm[3] ? '<div class="form-control-static">' . $combo_dta_data->GetHTML(true) . '</div>' : $combo_dta_data->GetHTML()), $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(dta_data)%%>', $combo_dta_data->GetHTML(true), $templateCode);
	$templateCode = str_replace('<%%COMBO(acompanhamento_id)%%>', $combo_acompanhamento_id->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(acompanhamento_id)%%>', $combo_acompanhamento_id->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(acompanhamento_id)%%>', urlencode($combo_acompanhamento_id->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(colaborador_id)%%>', $combo_colaborador_id->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(colaborador_id)%%>', $combo_colaborador_id->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(colaborador_id)%%>', urlencode($combo_colaborador_id->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(str_tipo)%%>', $combo_str_tipo->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(str_tipo)%%>', $combo_str_tipo->SelectedData, $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'acompanhamento_id' => array('tb_acompanhamento', 'Acompanhamento id'), 'colaborador_id' => array('tb_contratacao', 'Colaborador id'));
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(dta_data)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(acompanhamento_id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(colaborador_id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(str_tipo)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(str_comentarios)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(str_responsavel)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		$templateCode = str_replace('<%%VALUE(dta_data)%%>', @date('d/m/Y', @strtotime(html_attr($row['dta_data']))), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(dta_data)%%>', urlencode(@date('d/m/Y', @strtotime(html_attr($urow['dta_data'])))), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(acompanhamento_id)%%>', safe_html($urow['acompanhamento_id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(acompanhamento_id)%%>', html_attr($row['acompanhamento_id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(acompanhamento_id)%%>', urlencode($urow['acompanhamento_id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(colaborador_id)%%>', safe_html($urow['colaborador_id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(colaborador_id)%%>', html_attr($row['colaborador_id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(colaborador_id)%%>', urlencode($urow['colaborador_id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(str_tipo)%%>', safe_html($urow['str_tipo']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(str_tipo)%%>', html_attr($row['str_tipo']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_tipo)%%>', urlencode($urow['str_tipo']), $templateCode);
		if($dvprint || (!$AllowUpdate && !$AllowInsert)){
			$templateCode = str_replace('<%%VALUE(str_comentarios)%%>', safe_html($urow['str_comentarios']), $templateCode);
		}else{
			$templateCode = str_replace('<%%VALUE(str_comentarios)%%>', html_attr($row['str_comentarios']), $templateCode);
		}
		$templateCode = str_replace('<%%URLVALUE(str_comentarios)%%>', urlencode($urow['str_comentarios']), $templateCode);
		$templateCode = str_replace('<%%VALUE(str_responsavel)%%>', safe_html($urow['str_responsavel']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_responsavel)%%>', urlencode($urow['str_responsavel']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(dta_data)%%>', '<%%creationDate%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(dta_data)%%>', urlencode('<%%creationDate%%>'), $templateCode);
		$templateCode = str_replace('<%%VALUE(acompanhamento_id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(acompanhamento_id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(colaborador_id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(colaborador_id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(str_tipo)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_tipo)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(str_comentarios)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_comentarios)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(str_responsavel)%%>', '<%%creatorUsername%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_responsavel)%%>', urlencode('<%%creatorUsername%%>'), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('tb_acompanhamento_colaborador');
	if($selected_id){
		$jdata = get_joined_record('tb_acompanhamento_colaborador', $selected_id);
		if($jdata === false) $jdata = get_defaults('tb_acompanhamento_colaborador');
		$rdata = $row;
	}
	$templateCode .= loadView('tb_acompanhamento_colaborador-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: tb_acompanhamento_colaborador_dv
	if(function_exists('tb_acompanhamento_colaborador_dv')){
		$args=array();
		tb_acompanhamento_colaborador_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>