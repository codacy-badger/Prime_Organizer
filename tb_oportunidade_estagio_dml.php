<?php

// Data functions (insert, update, delete, form) for table tb_oportunidade_estagio

// This script and data application were generated by AppGini 5.72
// Download AppGini for free from https://bigprof.com/appgini/download/

function tb_oportunidade_estagio_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('tb_oportunidade_estagio');
	if(!$arrPerm[1]){
		return false;
	}

	$data['tipo_id'] = makeSafe($_REQUEST['tipo_id']);
		if($data['tipo_id'] == empty_lookup_value){ $data['tipo_id'] = ''; }
	$data['str_nome'] = makeSafe($_REQUEST['str_nome']);
		if($data['str_nome'] == empty_lookup_value){ $data['str_nome'] = ''; }
	if($data['tipo_id']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Tipo da demanda': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['str_nome']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Nome': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: tb_oportunidade_estagio_before_insert
	if(function_exists('tb_oportunidade_estagio_before_insert')){
		$args=array();
		if(!tb_oportunidade_estagio_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `tb_oportunidade_estagio` set       `tipo_id`=' . (($data['tipo_id'] !== '' && $data['tipo_id'] !== NULL) ? "'{$data['tipo_id']}'" : 'NULL') . ', `str_nome`=' . (($data['str_nome'] !== '' && $data['str_nome'] !== NULL) ? "'{$data['str_nome']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"tb_oportunidade_estagio_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: tb_oportunidade_estagio_after_insert
	if(function_exists('tb_oportunidade_estagio_after_insert')){
		$res = sql("select * from `tb_oportunidade_estagio` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!tb_oportunidade_estagio_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('tb_oportunidade_estagio', $recID, getLoggedMemberID());

	return $recID;
}

function tb_oportunidade_estagio_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('tb_oportunidade_estagio');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: tb_oportunidade_estagio_before_delete
	if(function_exists('tb_oportunidade_estagio_before_delete')){
		$args=array();
		if(!tb_oportunidade_estagio_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	// child table: tb_oportunidade
	$res = sql("select `id` from `tb_oportunidade_estagio` where `id`='$selected_id'", $eo);
	$id = db_fetch_row($res);
	$rires = sql("select count(1) from `tb_oportunidade` where `estagio_id`='".addslashes($id[0])."'", $eo);
	$rirow = db_fetch_row($rires);
	if($rirow[0] && !$AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["couldn't delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "tb_oportunidade", $RetMsg);
		return $RetMsg;
	}elseif($rirow[0] && $AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["confirm delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "tb_oportunidade", $RetMsg);
		$RetMsg = str_replace("<Delete>", "<input type=\"button\" class=\"button\" value=\"".$Translation['yes']."\" onClick=\"window.location='tb_oportunidade_estagio_view.php?SelectedID=".urlencode($selected_id)."&delete_x=1&confirmed=1';\">", $RetMsg);
		$RetMsg = str_replace("<Cancel>", "<input type=\"button\" class=\"button\" value=\"".$Translation['no']."\" onClick=\"window.location='tb_oportunidade_estagio_view.php?SelectedID=".urlencode($selected_id)."';\">", $RetMsg);
		return $RetMsg;
	}

	sql("delete from `tb_oportunidade_estagio` where `id`='$selected_id'", $eo);

	// hook: tb_oportunidade_estagio_after_delete
	if(function_exists('tb_oportunidade_estagio_after_delete')){
		$args=array();
		tb_oportunidade_estagio_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='$selected_id'", $eo);
}

function tb_oportunidade_estagio_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('tb_oportunidade_estagio');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['tipo_id'] = makeSafe($_REQUEST['tipo_id']);
		if($data['tipo_id'] == empty_lookup_value){ $data['tipo_id'] = ''; }
	if($data['tipo_id']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Tipo da demanda': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['str_nome'] = makeSafe($_REQUEST['str_nome']);
		if($data['str_nome'] == empty_lookup_value){ $data['str_nome'] = ''; }
	if($data['str_nome']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Nome': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['selectedID']=makeSafe($selected_id);

	// hook: tb_oportunidade_estagio_before_update
	if(function_exists('tb_oportunidade_estagio_before_update')){
		$args=array();
		if(!tb_oportunidade_estagio_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `tb_oportunidade_estagio` set       `tipo_id`=' . (($data['tipo_id'] !== '' && $data['tipo_id'] !== NULL) ? "'{$data['tipo_id']}'" : 'NULL') . ', `str_nome`=' . (($data['str_nome'] !== '' && $data['str_nome'] !== NULL) ? "'{$data['str_nome']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="tb_oportunidade_estagio_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: tb_oportunidade_estagio_after_update
	if(function_exists('tb_oportunidade_estagio_after_update')){
		$res = sql("SELECT * FROM `tb_oportunidade_estagio` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!tb_oportunidade_estagio_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='tb_oportunidade_estagio' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function tb_oportunidade_estagio_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('tb_oportunidade_estagio');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_tipo_id = thisOr(undo_magic_quotes($_REQUEST['filterer_tipo_id']), '');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: tipo_id
	$combo_tipo_id = new DataCombo;

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='tb_oportunidade_estagio' and pkValue='".makeSafe($selected_id)."'");
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

		$res = sql("select * from `tb_oportunidade_estagio` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'tb_oportunidade_estagio_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_tipo_id->SelectedData = $row['tipo_id'];
	}else{
		$combo_tipo_id->SelectedData = $filterer_tipo_id;
	}
	$combo_tipo_id->HTML = '<span id="tipo_id-container' . $rnd1 . '"></span><input type="hidden" name="tipo_id" id="tipo_id' . $rnd1 . '" value="' . html_attr($combo_tipo_id->SelectedData) . '">';
	$combo_tipo_id->MatchText = '<span id="tipo_id-container-readonly' . $rnd1 . '"></span><input type="hidden" name="tipo_id" id="tipo_id' . $rnd1 . '" value="' . html_attr($combo_tipo_id->SelectedData) . '">';

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_tipo_id__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['tipo_id'] : $filterer_tipo_id); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(tipo_id_reload__RAND__) == 'function') tipo_id_reload__RAND__();
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function tipo_id_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#tipo_id-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_tipo_id__RAND__.value, t: 'tb_oportunidade_estagio', f: 'tipo_id' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="tipo_id"]').val(resp.results[0].id);
							$j('[id=tipo_id-container-readonly__RAND__]').html('<span id="tipo_id-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_oportunidade_tipo_view_parent]').hide(); }else{ $j('.btn[id=tb_oportunidade_tipo_view_parent]').show(); }


							if(typeof(tipo_id_update_autofills__RAND__) == 'function') tipo_id_update_autofills__RAND__();
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
					data: function(term, page){ /* */ return { s: term, p: page, t: 'tb_oportunidade_estagio', f: 'tipo_id' }; },
					results: function(resp, page){ /* */ return resp; }
				},
				escapeMarkup: function(str){ /* */ return str; }
			}).on('change', function(e){
				AppGini.current_tipo_id__RAND__.value = e.added.id;
				AppGini.current_tipo_id__RAND__.text = e.added.text;
				$j('[name="tipo_id"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_oportunidade_tipo_view_parent]').hide(); }else{ $j('.btn[id=tb_oportunidade_tipo_view_parent]').show(); }


				if(typeof(tipo_id_update_autofills__RAND__) == 'function') tipo_id_update_autofills__RAND__();
			});

			if(!$j("#tipo_id-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_tipo_id__RAND__.value, t: 'tb_oportunidade_estagio', f: 'tipo_id' },
					success: function(resp){
						$j('[name="tipo_id"]').val(resp.results[0].id);
						$j('[id=tipo_id-container-readonly__RAND__]').html('<span id="tipo_id-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_oportunidade_tipo_view_parent]').hide(); }else{ $j('.btn[id=tb_oportunidade_tipo_view_parent]').show(); }

						if(typeof(tipo_id_update_autofills__RAND__) == 'function') tipo_id_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_tipo_id__RAND__.value, t: 'tb_oportunidade_estagio', f: 'tipo_id' },
				success: function(resp){
					$j('[id=tipo_id-container__RAND__], [id=tipo_id-container-readonly__RAND__]').html('<span id="tipo_id-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=tb_oportunidade_tipo_view_parent]').hide(); }else{ $j('.btn[id=tb_oportunidade_tipo_view_parent]').show(); }

					if(typeof(tipo_id_update_autofills__RAND__) == 'function') tipo_id_update_autofills__RAND__();
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
	$templateCode = @file_get_contents('./templates/tb_oportunidade_estagio_templateDV.html');

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Detalhes da oportunidade', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert){
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return tb_oportunidade_estagio_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return tb_oportunidade_estagio_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
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
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return tb_oportunidade_estagio_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
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
	if(($selected_id && !$AllowUpdate && !$AllowInsert) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#tipo_id').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#tipo_id_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#str_nome').replaceWith('<div class=\"form-control-static\" id=\"str_nome\">' + (jQuery('#str_nome').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif($AllowInsert){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(tipo_id)%%>', $combo_tipo_id->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(tipo_id)%%>', $combo_tipo_id->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(tipo_id)%%>', urlencode($combo_tipo_id->MatchText), $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'tipo_id' => array('tb_oportunidade_tipo', 'Tipo da demanda'));
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
	$templateCode = str_replace('<%%UPLOADFILE(tipo_id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(str_nome)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(tipo_id)%%>', safe_html($urow['tipo_id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(tipo_id)%%>', html_attr($row['tipo_id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(tipo_id)%%>', urlencode($urow['tipo_id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(str_nome)%%>', safe_html($urow['str_nome']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(str_nome)%%>', html_attr($row['str_nome']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_nome)%%>', urlencode($urow['str_nome']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(tipo_id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(tipo_id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(str_nome)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(str_nome)%%>', urlencode(''), $templateCode);
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
	$rdata = $jdata = get_defaults('tb_oportunidade_estagio');
	if($selected_id){
		$jdata = get_joined_record('tb_oportunidade_estagio', $selected_id);
		if($jdata === false) $jdata = get_defaults('tb_oportunidade_estagio');
		$rdata = $row;
	}
	$templateCode .= loadView('tb_oportunidade_estagio-ajax-cache', array('rdata' => $rdata, 'jdata' => $jdata));

	// hook: tb_oportunidade_estagio_dv
	if(function_exists('tb_oportunidade_estagio_dv')){
		$args=array();
		tb_oportunidade_estagio_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>