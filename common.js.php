<?php
	if(!defined('datalist_db_encoding')) define('datalist_db_encoding', 'UTF-8');
	if(function_exists('date_default_timezone_set')) @date_default_timezone_set('America/Sao_Paulo');

	/* force caching */
	$last_modified = filemtime(__FILE__);
	$last_modified_gmt = gmdate('D, d M Y H:i:s', $last_modified) . ' GMT';
	$headers = (function_exists('getallheaders') ? getallheaders() : $_SERVER);
	if(isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == $last_modified)){
		@header("Last-Modified: {$last_modified_gmt}", true, 304);
		@header("Cache-Control: public, max-age=240", true);
		exit;
	}

	@header("Last-Modified: {$last_modified_gmt}", true, 200);
	@header("Cache-Control: public, max-age=240", true);
	@header('Content-Type: text/javascript; charset=' . datalist_db_encoding);
	$currDir = dirname(__FILE__);
	include("{$currDir}/defaultLang.php");
	include("{$currDir}/language.php");
?>
var AppGini = AppGini || {};
AppGini.ajaxCache = function(){
	var _tests = [];

	/*
		An array of functions that receive a parameterless url and a parameters object,
		makes a test,
		and if test passes, executes something and/or
		returns a non-false value if test passes,
		or false if test failed (useful to tell if tests should continue or not)
	*/
	var addCheck = function(check){ /* */
		if(typeof(check) == 'function'){
			_tests.push(check);
		}
	};

	var _jqAjaxData = function(opt){ /* */
		var opt = opt || {};   
		var url = opt.url || '';
		var data = opt.data || {};

		var params = url.match(/\?(.*)$/);
		var param = (params !== null ? params[1] : '');

		var sPageURL = decodeURIComponent(param),
			sURLVariables = sPageURL.split('&'),
			sParameter,
			i;

		for(i = 0; i < sURLVariables.length; i++){
			sParameter = sURLVariables[i].split('=');
			if(sParameter[0] == '') continue;
			data[sParameter[0]] = sParameter[1] || '';
		}

		return data;
	};

	var start = function(){ /* */
		if(!_tests.length) return; // no need to monitor ajax requests since no checks were defined
		var reqTests = _tests;
		$j.ajaxPrefilter(function(options, originalOptions, jqXHR){
			var success = originalOptions.success || $j.noop,
				data = _jqAjaxData(originalOptions),
				oUrl = originalOptions.url || '',
				url = oUrl.match(/\?/) ? oUrl.match(/(.*)\?/)[1] : oUrl;

			options.beforeSend = function(){ /* */
				var req, cached = false, resp;

				for(var i = 0; i < reqTests.length; i++){
					resp = reqTests[i](url, data);
					if(resp === false) continue;

					success(resp);
					return false;
				}

				return true;
			}
		});
	};

	return {
		addCheck: addCheck,
		start: start
	};
};

/* initials and fixes */
jQuery(function(){
	AppGini.count_ajaxes_blocking_saving = 0;

	/* add ":truncated" pseudo-class to detect elements with clipped text */
	$j.expr[':'].truncated = function(obj){
		var $this = $j(obj);
		var $c = $this
					.clone()
					.css({ display: 'inline', width: 'auto', visibility: 'hidden', 'padding-right': 0 })
					.css({ 'font-size': $this.css('font-size') })
					.appendTo('body');

		var e_width = $this.outerWidth();
		var c_width = $c.outerWidth();
		$c.remove();

		return ( c_width > e_width );
	};

	var fix_lookup_width = function(field){
		var s2 = $j('div.select2-container[id=s2id_' + field + '-container]');
		if(!s2.length) return;

		var s2new_width = 0, s2view_width = 0, s2parent_width = 0;

		var s2new = s2.parent().find('.add_new_parent:visible');
		var s2view = s2.parent().find('.view_parent:visible');
		if(s2new.length) s2new_width = s2new.outerWidth(true);
		if(s2view.length) s2view_width = s2view.outerWidth(true);
		s2parent_width = s2.parent().innerWidth();

		// console.log({ s2new_width: s2new_width, s2view_width: s2view_width, s2parent_width: s2parent_width });

		s2.css({ width: '100%', 'max-width': (s2parent_width - s2new_width - s2view_width - 1) + 'px' });
	}

	$j(window).resize(function(){
		var window_width = $j(window).width();
		var max_width = $j('body').width() * 0.5;

		$j('.select2-container:not(.option_list)').each(function(){
			var field = $j(this).attr('id').replace(/^s2id_/, '').replace(/-container$/, '');
			fix_lookup_width(field);
		});

		//fix_table_responsive_width();

		var full_img_factor = 0.9; /* xs */
		if(window_width >= 992) full_img_factor = 0.6; /* md, lg */
		else if(window_width >= 768) full_img_factor = 0.9; /* sm */

		$j('.detail_view .img-responsive').css({'max-width' : parseInt($j('.detail_view').width() * full_img_factor) + 'px'});

		/* remove labels from truncated buttons, leaving only glyphicons */
		$j('.btn.truncate:truncated').each(function(){
			// hide text
			var label = $j(this).html();
			var mlabel = label.replace(/.*(<i.*?><\/i>).*/, '$1');
			$j(this).html(mlabel);
		});
	});

	setTimeout(function(){ /* */ $j(window).resize(); }, 1000);
	setTimeout(function(){ /* */ $j(window).resize(); }, 3000);

	/* don't allow saving detail view when there's an ajax request to a url that matches the following */
	var ajax_blockers = new RegExp(/(ajax_combo\.php|_autofill\.php|ajax_check_unique\.php)/);
	$j(document).ajaxSend(function(e, r, s){
		if(s.url.match(ajax_blockers)){
			AppGini.count_ajaxes_blocking_saving++;
			$j('#update, #insert').prop('disabled', true);
		}
	});
	$j(document).ajaxComplete(function(e, r, s){
		if(s.url.match(ajax_blockers)){
			AppGini.count_ajaxes_blocking_saving = Math.max(AppGini.count_ajaxes_blocking_saving - 1, 0);
			if(AppGini.count_ajaxes_blocking_saving <= 0)
				$j('#update, #insert').prop('disabled', false);
		}
	});

	/* don't allow responsive images to initially exceed the smaller of their actual dimensions, or .6 container width */
	jQuery('.detail_view .img-responsive').each(function(){
		 var pic_real_width, pic_real_height;
		 var img = jQuery(this);
		 jQuery('<img/>') // Make in memory copy of image to avoid css issues
				.attr('src', img.attr('src'))
				.load(function() {
					pic_real_width = this.width;
					pic_real_height = this.height;

					if(pic_real_width > $j('.detail_view').width() * .6) pic_real_width = $j('.detail_view').width() * .6;
					img.css({ "max-width": pic_real_width });
				});
	});

	jQuery('.table-responsive .img-responsive').each(function(){
		 var pic_real_width, pic_real_height;
		 var img = jQuery(this);
		 jQuery('<img/>') // Make in memory copy of image to avoid css issues
				.attr('src', img.attr('src'))
				.load(function() {
					pic_real_width = this.width;
					pic_real_height = this.height;

					if(pic_real_width > $j('.table-responsive').width() * .6) pic_real_width = $j('.table-responsive').width() * .6;
					img.css({ "max-width": pic_real_width });
				});
	});

	/* toggle TV action buttons based on selected records */
	jQuery('.record_selector').click(function(){
		var id = jQuery(this).val();
		var checked = jQuery(this).prop('checked');
		update_action_buttons();
	});

	/* select/deselect all records in TV */
	jQuery('#select_all_records').click(function(){
		jQuery('.record_selector').prop('checked', jQuery(this).prop('checked'));
		update_action_buttons();
	});

	/* fix behavior of select2 in bootstrap modal. See: https://github.com/ivaynberg/select2/issues/1436 */
	jQuery.fn.modal.Constructor.prototype.enforceFocus = function(){ /* */ };

	/* remove empty navbar menus */
	$j('nav li.dropdown').each(function(){
		var num_items = $j(this).children('.dropdown-menu').children('li').length;
		if(!num_items) $j(this).remove();
	})

	update_action_buttons();

	/* remove empty images and links from TV, TVP */
	$j('.table a[href="<?php echo $Translation['ImageFolder']; ?>"], .table img[src="<?php echo $Translation['ImageFolder']; ?>"]').remove();

	/* remove empty email links from TV, TVP */
	$j('a[href="mailto:"]').remove();

	/* Disable action buttons when form is submitted to avoid user re-submission on slow connections */
	$j('form').eq(0).submit(function(){
		setTimeout(function(){
			$j('#insert, #update, #delete, #deselect').prop('disabled', true);
		}, 200); // delay purpose is to allow submitting the button values first then disable them.
	});

	/* fix links inside alerts */
	$j('.alert a:not(.btn)').addClass('alert-link');
});

/* show/hide TV action buttons based on whether records are selected or not */
function update_action_buttons(){
	if(jQuery('.record_selector:checked').length){
		jQuery('.selected_records').removeClass('hidden');
		jQuery('#select_all_records')
			.prop('checked', (jQuery('.record_selector:checked').length == jQuery('.record_selector').length));
	}else{
		jQuery('.selected_records').addClass('hidden');
	}
}

/* fix table-responsive behavior on Chrome */
function fix_table_responsive_width(){
	var resp_width = jQuery('div.table-responsive').width();
	var table_width;

	if(resp_width){
		jQuery('div.table-responsive table').width('100%');
		table_width = jQuery('div.table-responsive table').width();
		resp_width = jQuery('div.table-responsive').width();
		if(resp_width == table_width){
			jQuery('div.table-responsive table').width(resp_width - 1);
		}
	}
}

function tb_vaga_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field recrutador_id can't be empty */
	if($j('#recrutador_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Recrutador", close: function(){ /* */ $j('[name=recrutador_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_prioridade can't be empty */
	if($j('#str_prioridade').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Prioridade", close: function(){ /* */ $j('[name=str_prioridade]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_status can't be empty */
	if($j('#str_status').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Status", close: function(){ /* */ $j('[name=str_status]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_entrevista_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Empresa", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field vaga_id can't be empty */
	if($j('#vaga_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Vaga", close: function(){ /* */ $j('[name=vaga_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field recrutador_id can't be empty */
	if($j('#recrutador_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Recrutador", close: function(){ /* */ $j('[name=recrutador_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta can't be empty */
	if($j('#dta-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	/* Field int_qtd_contatos can't be empty */
	if($j('#int_qtd_contatos').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Qtd. de contatos", close: function(){ /* */ $j('[name=int_qtd_contatos]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field int_qtd_entrevistas can't be empty */
	if($j('#int_qtd_entrevistas').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Qtd. de entrevistas", close: function(){ /* */ $j('[name=int_qtd_entrevistas]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field int_qtd_encaminhamentos can't be empty */
	if($j('#int_qtd_encaminhamentos').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Qtd. de encaminhamentos", close: function(){ /* */ $j('[name=int_qtd_encaminhamentos]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_contratacao_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_candidato_nome can't be empty */
	if($j('#str_candidato_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome completo do Colaborador", close: function(){ /* */ $j('[name=str_candidato_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field int_cpf can't be empty */
	if($j('#int_cpf').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> CPF", close: function(){ /* */ $j('[name=int_cpf]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta_contratacao can't be empty */
	if($j('#dta_contratacao-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de Contrata&#231;&#227;o", close: function(){ /* */ $j('#dta_contratacao-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_contratacao-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de Contrata&#231;&#227;o", close: function(){ /* */ $j('#dta_contratacao-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_contratacao').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de Contrata&#231;&#227;o", close: function(){ /* */ $j('#dta_contratacao').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	return true;
}
function tb_alocacao_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field int_empresa can't be empty */
	if($j('#int_empresa').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Empresa", close: function(){ /* */ $j('[name=int_empresa]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_recrutador_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome completo", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_empresa_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_nome_fantasia can't be empty */
	if($j('#str_nome_fantasia').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome fantasia", close: function(){ /* */ $j('[name=str_nome_fantasia]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_responsavel can't be empty */
	if($j('#str_responsavel').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Gerente da conta", close: function(){ /* */ $j('[name=str_responsavel]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Radio lookup field relacionamento_id can't be empty */
	if(!$j('[name=relacionamento_id]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Relacionamento", close: function(){ /* */ $j('[name=relacionamento_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field uf can't be empty */
	if($j('#uf').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> UF", close: function(){ /* */ $j('[name=uf]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_prova_tipo_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_contato_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Empresa", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_primeiro_nome can't be empty */
	if($j('#str_primeiro_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Primeiro nome", close: function(){ /* */ $j('[name=str_primeiro_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_nivel can't be empty */
	if($j('#str_nivel').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> N&#237;vel hier&#225;rquico", close: function(){ /* */ $j('[name=str_nivel]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Radio lookup field tipo_id can't be empty */
	if(!$j('[name=tipo_id]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Relacionamento", close: function(){ /* */ $j('[name=tipo_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_email1 can't be empty */
	if($j('#str_email1').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> E-mail 1", close: function(){ /* */ $j('[name=str_email1]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_contato_tipo_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_oportunidade_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field estagio_id can't be empty */
	if($j('#estagio_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Est&#225;gio", close: function(){ /* */ $j('[name=estagio_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Empresa", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field contato_id can't be empty */
	if($j('#contato_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Contato", close: function(){ /* */ $j('[name=contato_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta_inicio can't be empty */
	if($j('#dta_inicio-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_inicio-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_inicio').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	/* Field int_probabilidade can't be empty */
	if($j('#int_probabilidade').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Probabilidade", close: function(){ /* */ $j('[name=int_probabilidade]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field int_parcelas can't be empty */
	if($j('#int_parcelas').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Quantidade de parcelas", close: function(){ /* */ $j('[name=int_parcelas]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_atendimento_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_iniciativa can't be empty */
	if(!$j('[name=str_iniciativa]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Iniciativa", close: function(){ /* */ $j('[name=str_iniciativa]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Empresa", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field contato_id can't be empty */
	if($j('#contato_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Contato", close: function(){ /* */ $j('[name=contato_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta can't be empty */
	if($j('#dta-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	/* Field usuario_id can't be empty */
	if($j('#usuario_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Respons&#225;vel", close: function(){ /* */ $j('[name=usuario_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_oportunidade_tipo_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_oportunidade_estagio_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field tipo_id can't be empty */
	if($j('#tipo_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Tipo da demanda", close: function(){ /* */ $j('[name=tipo_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_acompanhamento_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Conta", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field contato_id can't be empty */
	if($j('#contato_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Contato", close: function(){ /* */ $j('[name=contato_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field contrato_id can't be empty */
	if($j('#contrato_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Contrato", close: function(){ /* */ $j('[name=contrato_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field usuario_id can't be empty */
	if($j('#usuario_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Respons&#225;vel", close: function(){ /* */ $j('[name=usuario_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta can't be empty */
	if($j('#dta-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	/* Field str_meio can't be empty */
	if(!$j('[name=str_meio]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Meio de contato", close: function(){ /* */ $j('[name=str_meio]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_statusgeral can't be empty */
	if(!$j('[name=str_statusgeral]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Status geral", close: function(){ /* */ $j('[name=str_statusgeral]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_clima_cliente can't be empty */
	if($j('#str_clima_cliente').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Clima do cliente", close: function(){ /* */ $j('[name=str_clima_cliente]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_clima_equipe can't be empty */
	if($j('#str_clima_equipe').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Clima da equipe", close: function(){ /* */ $j('[name=str_clima_equipe]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_contrato_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Conta", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta_inicio can't be empty */
	if($j('#dta_inicio-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_inicio-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_inicio').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	return true;
}
function tb_campanha_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta_inicio can't be empty */
	if($j('#dta_inicio-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_inicio-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_inicio').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de in&#237;cio", close: function(){ /* */ $j('#dta_inicio').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	return true;
}
function tb_campanha_contato_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field campanha_id can't be empty */
	if($j('#campanha_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Campanha", close: function(){ /* */ $j('[name=campanha_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Empresa", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field contato_id can't be empty */
	if($j('#contato_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Contato", close: function(){ /* */ $j('[name=contato_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_acompanhamento_colaborador_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_tipo can't be empty */
	if(!$j('[name=str_tipo]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Feedback", close: function(){ /* */ $j('[name=str_tipo]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_indicador_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field str_departamento can't be empty */
	if($j('#str_departamento').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Departamento", close: function(){ /* */ $j('[name=str_departamento]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_nome can't be empty */
	if($j('#str_nome').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome do Indicador", close: function(){ /* */ $j('[name=str_nome]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_descricao can't be empty */
	if($j('#str_descricao').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Descri&#231;&#227;o", close: function(){ /* */ $j('[name=str_descricao]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_unidade_medida can't be empty */
	if($j('#str_unidade_medida').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Unidade de medida", close: function(){ /* */ $j('[name=str_unidade_medida]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_indicador_periodo_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field indicador_id can't be empty */
	if($j('#indicador_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Indicador", close: function(){ /* */ $j('[name=indicador_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta can't be empty */
	if($j('#dta-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data", close: function(){ /* */ $j('#dta').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	return true;
}
function tb_fatura_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Conta", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Date field dta_emissao can't be empty */
	if($j('#dta_emissao-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de emiss&#227;o", close: function(){ /* */ $j('#dta_emissao-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_emissao-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de emiss&#227;o", close: function(){ /* */ $j('#dta_emissao-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_emissao').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de emiss&#227;o", close: function(){ /* */ $j('#dta_emissao').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	/* Date field dta_competencia can't be empty */
	if($j('#dta_competencia-dd').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de compet&#234;ncia", close: function(){ /* */ $j('#dta_competencia-dd').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_competencia-mm').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de compet&#234;ncia", close: function(){ /* */ $j('#dta_competencia-mm').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	if($j('#dta_competencia').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Data de compet&#234;ncia", close: function(){ /* */ $j('#dta_competencia').focus().parents('.form-group').addClass('has-error'); } }); return false; };
	/* Field flo_valor can't be empty */
	if($j('#flo_valor').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Valor total", close: function(){ /* */ $j('[name=flo_valor]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_ajuste_colaborador_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field colaborador_id can't be empty */
	if($j('#colaborador_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Colaborador", close: function(){ /* */ $j('[name=colaborador_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_ajuste can't be empty */
	if($j('#str_ajuste').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Tipo de ajuste", close: function(){ /* */ $j('[name=str_ajuste]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field gestor_id can't be empty */
	if($j('#gestor_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Gestor", close: function(){ /* */ $j('[name=gestor_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}
function tb_requerimento_validateData(){
	$j('.has-error').removeClass('has-error');
	/* Field recrutador_id can't be empty */
	if($j('#recrutador_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Gestor Imediato", close: function(){ /* */ $j('[name=recrutador_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_posicao can't be empty */
	if($j('#str_posicao').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome da Posi&#231;&#227;o", close: function(){ /* */ $j('[name=str_posicao]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field int_n_vagas can't be empty */
	if($j('#int_n_vagas').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Quantidade de Vagas", close: function(){ /* */ $j('[name=int_n_vagas]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_reposicao can't be empty */
	if($j('#str_reposicao').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Trata-se de uma reposi&#231;&#227;o?", close: function(){ /* */ $j('[name=str_reposicao]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_horario can't be empty */
	if($j('#str_horario').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Hor&#225;rio de Entrada/Sa&#237;da", close: function(){ /* */ $j('[name=str_horario]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field empresa_id can't be empty */
	if($j('#empresa_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome da Empresa Solicitante/Cliente", close: function(){ /* */ $j('[name=empresa_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field str_alocacao can't be empty */
	if(!$j('[name=str_alocacao]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Aloca&#231;&#227;o do Recurso", close: function(){ /* */ $j('[name=str_alocacao]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field contato_id can't be empty */
	if($j('#contato_id').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Nome do Contato", close: function(){ /* */ $j('[name=contato_id]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field int_salario can't be empty */
	if($j('#int_salario').val() == ''){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Sal&#225;rio/Budget", close: function(){ /* */ $j('[name=int_salario]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	/* Field bool_abertura can't be empty */
	if(!$j('[name=bool_abertura]:checked').length){ modal_window({ message: '<div class="alert alert-danger"><?php echo addslashes($Translation['field not null']); ?></div>', title: "<?php echo addslashes($Translation['error:']); ?> Abertura da Vaga", close: function(){ /* */ $j('[name=bool_abertura]').eq(0).focus().parents('.form-group').addClass('has-error'); }, footer: [{ label: '<?php echo addslashes($Translation['ok']); ?>' }] }); return false; };
	return true;
}

function post(url, params, update, disable, loading, success_callback){
	$j.ajax({
		url: url,
		type: 'POST',
		data: params,
		beforeSend: function() {
			if($j('#' + disable).length) $j('#' + disable).prop('disabled', true);
			if($j('#' + loading).length && update != loading) $j('#' + loading).html('<div style="direction: ltr;"><img src="loading.gif"> <?php echo addslashes($Translation['Loading ...']); ?></div>');
		},
		success: function(resp) {
			if($j('#' + update).length) $j('#' + update).html(resp);
			if(success_callback != undefined) success_callback();
		},
		complete: function() {
			if($j('#' + disable).length) $j('#' + disable).prop('disabled', false);
			if($j('#' + loading).length && loading != update) $j('#' + loading).html('');
		}
	});
}

function post2(url, params, notify, disable, loading, redirectOnSuccess){
	new Ajax.Request(
		url, {
			method: 'post',
			parameters: params,
			onCreate: function() {
				if($(disable) != undefined) $(disable).disabled=true;
				if($(loading) != undefined) $(loading).show();
			},
			onSuccess: function(resp) {
				/* show notification containing returned text */
				if($(notify) != undefined) $(notify).removeClassName('Error').appear().update(resp.responseText);

				/* in case no errors returned, */
				if(!resp.responseText.match(/<?php echo $Translation['error:']; ?>/)){
					/* redirect to provided url */
					if(redirectOnSuccess != undefined){
						window.location=redirectOnSuccess;

					/* or hide notification after a few seconds if no url is provided */
					}else{
						if($(notify) != undefined) window.setTimeout(function(){ /* */ $(notify).fade(); }, 15000);
					}

				/* in case of error, apply error class */
				}else{
					$(notify).addClassName('Error');
				}
			},
			onComplete: function() {
				if($(disable) != undefined) $(disable).disabled=false;
				if($(loading) != undefined) $(loading).hide();
			}
		}
	);
}
function passwordStrength(password, username){
	// score calculation (out of 10)
	var score = 0;
	re = new RegExp(username, 'i');
	if(username.length && password.match(re)) score -= 5;
	if(password.length < 6) score -= 3;
	else if(password.length > 8) score += 5;
	else score += 3;
	if(password.match(/(.*[0-9].*[0-9].*[0-9])/)) score += 3;
	if(password.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)) score += 5;
	if(password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) score += 2;

	if(score >= 9)
		return 'strong';
	else if(score >= 5)
		return 'good';
	else
		return 'weak';
}
function validateEmail(email) { 
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}
function loadScript(jsUrl, cssUrl, callback){
	// adding the script tag to the head
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = jsUrl;

	if(cssUrl != ''){
		var css = document.createElement('link');
		css.href = cssUrl;
		css.rel = "stylesheet";
		css.type = "text/css";
		head.appendChild(css);
	}

	// then bind the event to the callback function 
	// there are several events for cross browser compatibility
	if(script.onreadystatechange != undefined){ script.onreadystatechange = callback; }
	if(script.onload != undefined){ script.onload = callback; }

	// fire the loading
	head.appendChild(script);
}
/**
 * options object. The following members can be provided:
 *    url: iframe url to load
 *    message: instead of a url to open, you could pass a message. HTML tags allowed.
 *    id: id attribute of modal window. auto-generated if not provided
 *    title: optional modal window title
 *    size: 'default', 'full'
 *    close: optional function to execute on closing the modal
 *    footer: optional array of objects describing the buttons to display in the footer.
 *       Each button object can have the following members:
 *          label: string, label of button
 *          bs_class: string, button bootstrap class. Can be 'primary', 'default', 'success', 'warning' or 'danger'
 *          click: function to execute on clicking the button. If the button closes the modal, this
 *                 function is executed before the close handler
 *          causes_closing: boolean, default is true.
 */
function modal_window(options){
	return jQuery('body').agModal(options).agModal('show').attr('id');
}

function random_string(string_length){
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for(var i = 0; i < string_length; i++)
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	return text;
}

/**
 *  @return array of IDs (PK values) of selected records in TV (records that the user checked)
 */
function get_selected_records_ids(){
	return jQuery('.record_selector:checked').map(function(){ /* */ return jQuery(this).val() }).get();
}

function print_multiple_dv_tvdv(t, ids){
	document.myform.NoDV.value=1;
	document.myform.PrintDV.value=1;
	document.myform.SelectedID.value = '';
	document.myform.submit();
	return true;
}

function print_multiple_dv_sdv(t, ids){
	document.myform.NoDV.value=1;
	document.myform.PrintDV.value=1;
	document.myform.writeAttribute('novalidate', 'novalidate');
	document.myform.submit();
	return true;
}

function mass_delete(t, ids){
	if(ids == undefined) return;
	if(!ids.length) return;

	var confirm_message = '<div class="alert alert-danger">' +
			'<i class="glyphicon glyphicon-warning-sign"></i> ' + 
			'<?php echo addslashes($Translation['<n> records will be deleted. Are you sure you want to do this?']); ?>' +
		'</div>';
	var confirm_title = '<?php echo addslashes($Translation['Confirm deleting multiple records']); ?>';
	var label_yes = '<?php echo addslashes($Translation['Yes, delete them!']); ?>';
	var label_no = '<?php echo addslashes($Translation['No, keep them.']); ?>';
	var progress = '<?php echo addslashes($Translation['Deleting record <i> of <n>']); ?>';
	var continue_delete = true;

	// request confirmation of mass delete operation
	modal_window({
		message: confirm_message.replace(/\<n\>/, ids.length),
		title: confirm_title,
		footer: [ /* shows a 'yes' and a 'no' buttons .. handler for each follows ... */
			{
				label: '<i class="glyphicon glyphicon-trash"></i> ' + label_yes,
				bs_class: 'danger',
				// on confirming, start delete operations
				click: function(){

					// show delete progress, allowing user to abort operations by closing the window or clicking cancel
					var progress_window = modal_window({
						title: '<?php echo addslashes($Translation['Delete progress']); ?>',
						message: '' +
							'<div class="progress">' +
								'<div class="progress-bar progress-bar-warning" role="progressbar" style="width: 0;"></div>' +
							'</div>' + 
							'<button type="button" class="btn btn-default details_toggle" onclick="' +
								'jQuery(this).children(\'.glyphicon\').toggleClass(\'glyphicon-chevron-right glyphicon-chevron-down\'); ' +
								'jQuery(\'.well.details_list\').toggleClass(\'hidden\');'
								+ '">' +
								'<i class="glyphicon glyphicon-chevron-right"></i> ' +
								'<?php echo addslashes($Translation['Show/hide details']); ?>' +
							'</button>' +
							'<div class="well well-sm details_list hidden"><ol></ol></div>',
						close: function(){
							// stop deleting further records ...
							continue_delete = false;
						},
						footer: [
							{
								label: '<i class="glyphicon glyphicon-remove"></i> <?php echo addslashes($Translation['Cancel']); ?>',
								bs_class: 'warning'
							}
						]
					});

					// begin deleting records, one by one
					progress = progress.replace(/\<n\>/, ids.length);
					var delete_record = function(itrn){
						if(!continue_delete) return;
						jQuery.ajax(t + '_view.php', {
							type: 'POST',
							data: { delete_x: 1, SelectedID: ids[itrn] },
							success: function(resp){
								if(resp == 'OK'){
									jQuery(".well.details_list ol").append('<li class="text-success"><?php echo addslashes($Translation['The record has been deleted successfully']); ?></li>');
									jQuery('#record_selector_' + ids[itrn]).prop('checked', false).parent().parent().fadeOut(1500);
									jQuery('#select_all_records').prop('checked', false);
								}else{
									jQuery(".well.details_list ol").append('<li class="text-danger">' + resp + '</li>');
								}
							},
							error: function(){
								jQuery(".well.details_list ol").append('<li class="text-warning"><?php echo addslashes($Translation['Connection error']); ?></li>');
							},
							complete: function(){
								jQuery('#' + progress_window + ' .progress-bar').attr('style', 'width: ' + (Math.round((itrn + 1) / ids.length * 100)) + '%;').html(progress.replace(/\<i\>/, (itrn + 1)));
								if(itrn < (ids.length - 1)){
									delete_record(itrn + 1);
								}else{
									if(jQuery('.well.details_list li.text-danger, .well.details_list li.text-warning').length){
										jQuery('button.details_toggle').removeClass('btn-default').addClass('btn-warning').click();
										jQuery('.btn-warning[id^=' + progress_window + '_footer_button_]')
											.toggleClass('btn-warning btn-default')
											.html('<?php echo addslashes($Translation['ok']); ?>');
									}else{
										setTimeout(function(){ /* */ jQuery('#' + progress_window).agModal('hide'); }, 500);
									}
								}
							}
						});
					}

					delete_record(0);
				}
			},
			{
				label: '<i class="glyphicon glyphicon-ok"></i> ' + label_no,
				bs_class: 'success' 
			}
		]
	});
}

function mass_change_owner(t, ids){
	if(ids == undefined) return;
	if(!ids.length) return;

	var update_form = '<?php echo addslashes($Translation['Change owner of <n> selected records to']); ?> ' + 
		'<span id="new_owner_for_selected_records"></span><input type="hidden" name="new_owner_for_selected_records" value="">';
	var confirm_title = '<?php echo addslashes($Translation['Change owner']); ?>';
	var label_yes = '<?php echo addslashes($Translation['Continue']); ?>';
	var label_no = '<?php echo addslashes($Translation['Cancel']); ?>';
	var progress = '<?php echo addslashes($Translation['Updating record <i> of <n>']); ?>';
	var continue_updating = true;

	// request confirmation of mass update operation
	modal_window({
		message: update_form.replace(/\<n\>/, ids.length),
		title: confirm_title,
		footer: [ /* shows a 'continue' and a 'cancel' buttons .. handler for each follows ... */
			{
				label: '<i class="glyphicon glyphicon-ok"></i> ' + label_yes,
				bs_class: 'success',
				// on confirming, start update operations
				click: function(){
					var memberID = jQuery('input[name=new_owner_for_selected_records]').eq(0).val();
					if(!memberID.length) return;

					// show update progress, allowing user to abort operations by closing the window or clicking cancel
					var progress_window = modal_window({
						title: '<?php echo addslashes($Translation['Update progress']); ?>',
						message: '' +
							'<div class="progress">' +
								'<div class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>' +
							'</div>' + 
							'<button type="button" class="btn btn-default details_toggle" onclick="' +
								'jQuery(this).children(\'.glyphicon\').toggleClass(\'glyphicon-chevron-right glyphicon-chevron-down\'); ' +
								'jQuery(\'.well.details_list\').toggleClass(\'hidden\');'
								+ '">' +
								'<i class="glyphicon glyphicon-chevron-right"></i> ' +
								'<?php echo addslashes($Translation['Show/hide details']); ?>' +
							'</button>' +
							'<div class="well well-sm details_list hidden"><ol></ol></div>',
						close: function(){
							// stop updating further records ...
							continue_updating = false;
						},
						footer: [
							{
								label: '<i class="glyphicon glyphicon-remove"></i> <?php echo addslashes($Translation['Cancel']); ?>',
								bs_class: 'warning'
							}
						]
					});

					// begin updating records, one by one
					progress = progress.replace(/\<n\>/, ids.length);
					var update_record = function(itrn){
						if(!continue_updating) return;
						jQuery.ajax('admin/pageEditOwnership.php', {
							type: 'POST',
							data: {
								pkValue: ids[itrn],
								t: t,
								memberID: memberID,
								saveChanges: 'Save changes'
							},
							success: function(resp){
								if(resp == 'OK'){
									jQuery(".well.details_list ol").append('<li class="text-success"><?php echo addslashes($Translation['record updated']); ?></li>');
									jQuery('#record_selector_' + ids[itrn]).prop('checked', false);
									jQuery('#select_all_records').prop('checked', false);
								}else{
									jQuery(".well.details_list ol").append('<li class="text-danger">' + resp + '</li>');
								}
							},
							error: function(){
								jQuery(".well.details_list ol").append('<li class="text-warning"><?php echo addslashes($Translation['Connection error']); ?></li>');
							},
							complete: function(){
								jQuery('#' + progress_window + ' .progress-bar').attr('style', 'width: ' + (Math.round((itrn + 1) / ids.length * 100)) + '%;').html(progress.replace(/\<i\>/, (itrn + 1)));
								if(itrn < (ids.length - 1)){
									update_record(itrn + 1);
								}else{
									if(jQuery('.well.details_list li.text-danger, .well.details_list li.text-warning').length){
										jQuery('button.details_toggle').removeClass('btn-default').addClass('btn-warning').click();
										jQuery('.btn-warning[id^=' + progress_window + '_footer_button_]')
											.toggleClass('btn-warning btn-default')
											.html('<?php echo addslashes($Translation['ok']); ?>');
									}else{
										jQuery('button.btn-warning[id^=' + progress_window + '_footer_button_]')
											.toggleClass('btn-warning btn-success')
											.html('<i class="glyphicon glyphicon-ok"></i> <?php echo addslashes($Translation['ok']); ?>');
									}
								}
							}
						});
					}

					update_record(0);
				}
			},
			{
				label: '<i class="glyphicon glyphicon-remove"></i> ' + label_no,
				bs_class: 'warning' 
			}
		]
	});

	/* show drop down of users */
	var populate_new_owner_dropdown = function(){

		jQuery('[id=new_owner_for_selected_records]').select2({
			width: '100%',
			formatNoMatches: function(term){ /* */ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
			minimumResultsForSearch: 10,
			loadMorePadding: 200,
			escapeMarkup: function(m){ /* */ return m; },
			ajax: {
				url: 'admin/getUsers.php',
				dataType: 'json',
				cache: true,
				data: function(term, page){ /* */ return { s: term, p: page, t: t }; },
				results: function(resp, page){ /* */ return resp; }
			}
		}).on('change', function(e){
			jQuery('[name="new_owner_for_selected_records"]').val(e.added.id);
		});

	}

	populate_new_owner_dropdown();
}

function add_more_actions_link(){
	window.open('https://bigprof.com/appgini/help/advanced-topics/hooks/multiple-record-batch-actions?r=appgini-action-menu');
}

/* detect current screen size (xs, sm, md or lg) */
function screen_size(sz){
	if(!$j('.device-xs').length){
		$j('body').append(
			'<div class="device-xs visible-xs"></div>' +
			'<div class="device-sm visible-sm"></div>' +
			'<div class="device-md visible-md"></div>' +
			'<div class="device-lg visible-lg"></div>'
		);
	}
	return $j('.device-' + sz).is(':visible');
}

/* enable floating of action buttons in DV so they are visible on vertical scrolling */
function enable_dvab_floating(){
	/* already run? */
	if(window.enable_dvab_floating_run != undefined) return;

	/* scroll action buttons of DV on scrolling DV */
	$j(window).scroll(function(){
		if(!screen_size('md') && !screen_size('lg')) return;
		if(!$j('.detail_view').length) return;

		/* get vscroll amount, DV form height, button toolbar height and position */
		var vscroll = $j(window).scrollTop();
		var dv_height = $j('[id$="_dv_form"]').eq(0).height();
		var bt_height = $j('.detail_view .btn-toolbar').height();
		var form_top = $j('.detail_view .form-group').eq(0).offset().top;
		var bt_top_max = dv_height - bt_height - 10;

		if(vscroll > form_top){
			var tm = parseInt(vscroll - form_top) + 60;
			if(tm > bt_top_max) tm = bt_top_max;

			$j('.detail_view .btn-toolbar').css({ 'margin-top': tm + 'px' });
		}else{
			$j('.detail_view .btn-toolbar').css({ 'margin-top': 0 });
		}
	});
	window.enable_dvab_floating_run = true;
}

/* check if a given field's value is unique and reflect this in the DV form */
function enforce_uniqueness(table, field){
	$j('#' + field).on('change', function(){
		/* check uniqueness of field */
		var data = {
			t: table,
			f: field,
			value: $j('#' + field).val()
		};

		if($j('[name=SelectedID]').val().length) data.id = $j('[name=SelectedID]').val();

		$j.ajax({
			url: 'ajax_check_unique.php',
			data: data,
			complete: function(resp){
				if(resp.responseJSON.result == 'ok'){
					$j('#' + field + '-uniqueness-note').hide();
					$j('#' + field).parents('.form-group').removeClass('has-error');
				}else{
					$j('#' + field + '-uniqueness-note').show();
					$j('#' + field).parents('.form-group').addClass('has-error');
					$j('#' + field).focus();
					setTimeout(function(){ /* */ $j('#update, #insert').prop('disabled', true); }, 500);
				}
			}
		})
	});
}

/* persist expanded/collapsed chidren in DVP */
function persist_expanded_child(id){
	var expand_these = Cookies.getJSON('Prime_Organizer.dvp_expand');
	if(expand_these == undefined) expand_these = [];

	if($j('[id=' + id + ']').hasClass('active')){
		if(expand_these.indexOf(id) < 0){
			// expanded button and not persisting in cookie? save it!
			expand_these.push(id);
			Cookies.set('Prime_Organizer.dvp_expand', expand_these, { expires: 30 });
		}
	}else{
		if(expand_these.indexOf(id) >= 0){
			// collapsed button and persisting in cookie? remove it!
			expand_these.splice(expand_these.indexOf(id), 1);
			Cookies.set('Prime_Organizer.dvp_expand', expand_these, { expires: 30 });
		}
	}
}

/* apply expanded/collapsed status to children in DVP */
function apply_persisting_children(){
	var expand_these = Cookies.getJSON('Prime_Organizer.dvp_expand');
	if(expand_these == undefined) return;

	expand_these.each(function(id){
		$j('[id=' + id + ']:not(.active)').click();
	});
}

function select2_max_width_decrement(){
	return ($j('div.container').eq(0).hasClass('theme-compact') ? 99 : 109);
}

/**
 *  @brief AppGini.TVScroll().more() to scroll one column more. 
 *         AppGini.TVScroll().less() to scroll one column less.
 */
AppGini.TVScroll = function(){

	/**
	 *  @brief Calculates the width of the first n columns of the TV table
	 *  
	 *  @param [in] n how many columns to calculate the width for
	 *  @return Return total width of given n columns, or 0 if n < 1 or invalid
	 */
	var _TVColsWidth = function(n){
		if(isNaN(n)) return 0;
		if(n < 1) return 0;

		var tw = 0, cc;
		for(var i = 0; i < n; i++){
			cc = $j('.table_view .table th:visible').eq(i);
			if(!cc.length) break;
			tw += cc.outerWidth();
		}

		return tw;
	};

	/**
	 *  @brief show/hide tv-scroll buttons based on whether TV is horizontally scrollable or not
	 *  @details should be called once on document load before hiding TV columns (by calling less())
	 */
	var toggle_tv_scroll_tools = function(){
		var tr = $j('.table_view .table-responsive'),
			vpw = tr.width(), // viewport width
			tfw = tr.find('.table').width(); // full width of the table

		if(vpw >= tfw) $j('.tv-scroll').parents('.btn-group').hide();
		else $j('.tv-scroll').parents('.btn-group').show();
	}

	/**
	 *  @brief Prepares variables for use by less & more
	 */
	var _TVScrollSetup = function(){
		if(AppGini._TVColsScrolled === undefined) AppGini._TVColsScrolled = 0;
		AppGini._TVColsCount = $j('.table_view .table th:visible').length;

		/* type of scrolling, https://github.com/othree/jquery.rtl-scroll-type */
		/*
			How to interpret AppGini._ScrollType?
			{LTR | RTL}:{scrollLeft val for left position}:{scrollLeft val for right position}:{initial scrollLeft val}
		*/
		if(AppGini._ScrollType === undefined){
			/* all browsers behave the same on LTR */
			AppGini._ScrollType = 'LTR:0:100:0';

			if($j('.container').hasClass('theme-rtl')){
				var definer = $j('<div dir="rtl" style="font-size: 14px; width: 4px; height: 1px; position: absolute; top: -1000px; overflow: scroll">ABCD</div>').appendTo('body')[0];

				AppGini._ScrollType = 'RTL:100:0:0'; // IE
				if(definer.scrollLeft > 0){
					AppGini._ScrollType = 'RTL:0:100:70'; // WebKit
				}else{
					definer.scrollLeft = 1;
					if(definer.scrollLeft === 0) AppGini._ScrollType = 'RTL:-100:0:0'; // Firefox/Opera
				}
			}

			/* show/hide #tv-scroll buttons based on TV scroll state */
			$j(window).resize(toggle_tv_scroll_tools);
			toggle_tv_scroll_tools();
		}  
	};

	/**
	 *  @brief Resets all scrolling and setup values.
	 *  @details Useful after hiding/showing columns to re-setup TV scrolling
	 */
	var reset = function(){
		if(AppGini._ScrollType === undefined) return; // nothing to reset!
		AppGini._TVColsScrolled = undefined;

		var tr = $j('.table_view .table-responsive');
		switch(AppGini._ScrollType){
			case 'RTL:100:0:0':
			case 'RTL:0:100:0':
			case 'RTL:-100:0:0':
				tr.scrollLeft(0);
				break;
			case 'RTL:0:100:70':
				var vpw = tr.width(), // viewport width
					tfw = tr.find('.table').width(); // full width of the table
				tr.scrollLeft(tfw - vpw + 10);
				break;
		}

		_TVScrollSetup();
	};

	var _TVScroll = function(){
		var scroll = 0,
			tr = $j('.table_view .table-responsive'),
			cw = _TVColsWidth(AppGini._TVColsScrolled); // width of columns to scroll to

		switch(AppGini._ScrollType){
			case 'RTL:100:0:0':
			case 'LTR:0:100:0':
				scroll = cw - 1;
				break;
			case 'RTL:-100:0:0':
				scroll = -1 * cw + 1;
				break;
			case 'RTL:0:100:70':
				var vpw = tr.width(), // viewport width
					tfw = tr.find('.table').width(); // full width of the table
				scroll = tfw - vpw - cw + 1;
				break;
		}

		tr.scrollLeft(scroll);
	};

	/**
	 *  @brief Scroll the TV table 1 column more
	 */
	var more = function(){
		if(AppGini._TVColsScrolled >= AppGini._TVColsCount) return;
		AppGini._TVColsScrolled++;
		_TVScroll();
	};

	/**
	 *  @brief Scroll the TV table 1 column less
	 */
	var less = function(){
		if(AppGini._TVColsScrolled <= 0) return;
		AppGini._TVColsScrolled--;
		_TVScroll();
	};

	_TVScrollSetup();

	return { more: more, less: less, reset: reset };

};

(function($j){
	/*
		apply a modal or an in-page modal to an element,
		or access modal methods/events if it's already 'modal'ed

		Expected usage:
		1. $j('any_selector').agModal({ new modal options .. })
		2. $j('#modal_id').agModal('command')
		3. $j('#modal_id').on('event.bs.modal', event_handler)

		case 1: the selector doesn't matter ... the modal will be created and attached
				to the body element .. to retrieve the modal id if not specified in options:
				var modal_id = $j('any_selector').agModal({ new modal options .. }).attr('id');

		case 2: the selector must be the modal element .. if it's a standard BS modal,
				command will be passed as is to .modal() and the return value returned.
				if it's an in-page modal, command will be emulated and the modal element
				returned.

		case 3: Bootstrap modal events.
	*/
	$j.fn.agModal = function(options){
		var theModal = this,
		open = function(){
			return theModal.trigger('show.bs.modal').removeClass('hide').trigger('shown.bs.modal');
		},
		close = function(){
			return theModal.trigger('hide.bs.modal').addClass('hide').trigger('hidden.bs.modal');
		};

		if(typeof(options) == 'string'){
			if(theModal.hasClass('modal')) return theModal.modal(options);
			if(!theModal.hasClass('inpage-modal')) return theModal;

			/* emulate .modal(command) for the in-page modal */
			switch(options){
				case 'show':
					open();
					break;
				case 'hide':
					close();
					break;
			}

			return theModal;
		}

		var op = $j.extend({
			/* default options */
			id: random_string(20),
			footer: [],
			extras: {},
			size: 'default',
			forceIPM: false
		}, options);

		if(op.url == undefined && op.message == undefined){
			console.error('Missing message/url in call to AppGini.modal().');
			return theModal;
		}

		var iOS = /(iPad|iPhone|iPod)/g.test(navigator.userAgent), /* true for iOS devices */
		auto_id = (options.id === undefined), /* true if modal id is auto-generated */

		_resize = function(id){
			var mod = $j('#' + id);
			if(!mod.length) return;

			var ipm = (mod.hasClass('inpage-modal') ? '.inpage-modal-' : '.modal-');

			var wh = $j(window).height(),
				mtm = mod.find(ipm + 'dialog').css('margin-top'),
				mhfoh = mod.find(ipm + 'header').outerHeight() + mod.find(ipm + 'footer').outerHeight();

			mod.find(ipm + 'dialog').css({
				margin: mtm,
				width: 'calc(100% - 2 * ' + mtm + ')'
			});

			mod.find(ipm + 'body').css({
				height: 'calc(' + wh + 'px - ' + mhfoh + 'px - 2 * ' + mtm + ' - 6px)'
			});
		},

		_bsModal = function(){
			/* build the html of footer buttons into footer_buttons variable */
			var footer_buttons = '';
			for(i = 0; i < op.footer.length; i++){
				if(typeof(op.footer[i].label) != 'string') continue;

				op.footer[i] = $j.extend(
					/* defaults */
					{
						causes_closing: true,
						bs_class: 'default'
					},
					op.footer[i],
					/* enforce the following values */
					{ id: op.id + '_footer_button_' + random_string(10) }
				);

				footer_buttons += '<button ' +
						'type="button" ' +
						'class="btn btn-' + op.footer[i].bs_class + '" ' +
						(op.footer[i].causes_closing ? 'data-dismiss="modal" ' : '') +
						'id="' + op.footer[i].id + '" ' +
						'>' + op.footer[i].label +
					'</button>';
			}

			var mod = $j(
				'<div class="modal fade" tabindex="-1" role="dialog" id="' + op.id + '">' +
					'<div class="modal-dialog" role="document">' +
						'<div class="modal-content">' +
							( op.title != undefined ?
								'<div class="modal-header">' +
									'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
									'<h4 class="modal-title" style="width: 90%;">' + op.title + '</h4>' +
								'</div>'
								: ''
							) +
							'<div class="modal-body">' +
								( op.url != undefined ?
									'<iframe ' +
										'width="100%" height="100%" ' +
										'style="display: block; overflow: scroll !important; -webkit-overflow-scrolling: touch !important;" ' +
										'sandbox="allow-modals allow-forms allow-scripts allow-same-origin allow-popups" ' +
										'src="' + op.url + '">' +
									'</iframe>'
									: op.message
								) +
							'</div>' +
							'<div class="modal-footer">' + footer_buttons + '</div>' +
						'</div>' +
					'</div>' + 
				'</div>'
			);

			if(op.url != undefined){
				mod.find('.modal-body').css('padding', '0');
			}

			return mod;
		},

		_ipModal = function(){
			/* prepare footer buttons, if any */
			var footer_buttons = '', closer_class = '';
			for(i = 0; i < op.footer.length; i++){
				if(typeof(op.footer[i].label) != 'string') continue;

				if(op.footer[i].causes_closing !== false){ op.footer[i].causes_closing = true; }
				op.footer[i].bs_class = op.footer[i].bs_class || 'default';
				op.footer[i].id = op.id + '_footer_button_' + random_string(10);           

				closer_class = (op.footer[i].causes_closing ? ' closes-inpage-modal' : '');

				footer_buttons += '<button type="button" ' +
						'class="hspacer-lg vspacer-lg btn btn-' + op.footer[i].bs_class + closer_class + '" ' +
						'id="' + op.footer[i].id + '" ' +
						'>' + op.footer[i].label + '</button>';
			}

			var imc = $j(
				'<div id="' + op.id + '" ' +
					'class="inpage-modal hide ' + $j('.container').eq(0).attr('class') + '" ' + 
					'style="' +
						'padding-left: 0; padding-right: 0;' +
						'width: 100% !important;' +
					'">' +
					'<div ' +
						'class="inpage-modal-dialog" ' +
						'style="' +
							'box-shadow: 0 0 61px 15px #666;' +
							'margin: 10px !important;' +
							'border: solid 1px;' +
							'border-radius: 5px;' +
						'">' +
						'<div class="inpage-modal-content">' +
							( op.title != undefined ?
								'<div class="inpage-modal-header" style="border-bottom: solid 1px;">' +
									'<div class="row" style="margin: 0;">' + 
										'<div class="col-xs-10 col-sm-11 inpage-modal-title">' +
											'<div class="h4">' + op.title + '</div>' +
										'</div>' +
										'<div class="col-xs-2 col-sm-1 closes-inpage-modal text-center inpage-modal-dismiss" style="cursor: pointer;">' +
											'<h4 class="glyphicon glyphicon-remove"></h4>' +
										'</div>' +
									'</div>' +
								'</div>'
								: ''
							) +

							( footer_buttons.length ?
								'<div class="inpage-modal-footer text-right flip" style="border-bottom: solid 1px;">' + footer_buttons + '</div>'
								: ''
							) +

							'<div class="inpage-modal-body">' +
								( op.url != undefined ?
									'<iframe ' +
										'width="100%" height="100%" ' +
										'style="display: block; overflow: scroll !important; -webkit-overflow-scrolling: touch !important;" ' +
										'sandbox="allow-modals allow-forms allow-scripts allow-same-origin allow-popups" ' +
										'src="' + op.url + '">' +
									'</iframe>'
									: op.message
								) +
							'</div>' +
						'</div>' +
					'</div>' +
				'</div>'
			);

			/* hover effect for dismiss button + close modal if a closer clicked */
			imc.on('mouseover', '.inpage-modal-dismiss', function(){
				$j(this).addClass('text-danger bg-danger');
			}).on('mouseout', '.inpage-modal-dismiss', function(){
				$j(this).removeClass('text-danger bg-danger');
			}).on('click', '.closes-inpage-modal', close);

			imc.find('.inpage-modal-title').css({
				overflow: 'auto',
				'white-space': 'nowrap'
			});

			return imc;
		};

		/* if modal exists, remove it first */
		$j('#' + op.id).remove();

		theModal = ((iOS || op.forceIPM) && op.size == 'full' ? _ipModal() : _bsModal());

		theModal.appendTo('body');

		/* bind footer buttons click handlers */
		for(i = 0; i < op.footer.length; i++){
			if(typeof(op.footer[i].click) == 'function'){
				$j('#' + op.footer[i].id).click(op.footer[i].click);
			}
		}

		theModal
		.on('show.bs.modal', function(){
			if(op.size != 'full') return;

			/* hide main page to avoid all scrolling/panning hell on touch screens! */
			$j('.container').eq(0).hide();
		})
		.on('shown.bs.modal', function(){
			if(op.size != 'full') return;

			var id = op.id, rsz = _resize;
			rsz(id);
			$j(window).resize(function(){ /* */ rsz(id); });
		})
		//.agModal('show')
		.on('hidden.bs.modal', function(){
			/* display main page again */
			if(op.size == 'full') $j('.container').eq(0).show();

			if(typeof(op.close) == 'function'){
				op.close();
			}

			if(!auto_id) return;

			/* if id is automatic, remove modal after 1 minute from DOM */
			var id = op.id;
			var auto_remove = setInterval(function(){
				if($j('#' + id).is(':visible')) return; // don't remove if visible
				$j('#' + id).remove();
				clearInterval(auto_remove);
			}, 60000);
		});

		return theModal;
	};
})(jQuery);

/**
 *  @brief Used in pages loaded inside modals (e.g. those with Embedded=1) to close the containing modal.
 */
AppGini.closeParentModal = function(){
	var pm = window.parent.jQuery(".modal:visible");
	if(!pm.length){
		pm = window.parent.jQuery(".inpage-modal:visible");
	}

	if(pm.length) pm.agModal('hide');
	return;
}

/**
 *  @return boolean indicating whether a modal is currently open or not
 */
AppGini.modalOpen = function(){ /* */
	return jQuery('.modal-dialog:visible').length > 0 || jQuery('.inpage-modal-dialog:visible').length > 0;
};


/**
 *  @return true for mobile devices, false otherwise
 *  @details https://stackoverflow.com/a/11381730/1945185
 */
AppGini.mobileDevice = function(){ /* */
	var check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
};

AppGini.datetimeFormat = function(datetime){ /* */
	if(undefined == datetime) datetime = 'd';

	var dateFormat = 'DD/MM/YYYY';
	var timeFormat = 'HH:mm:ss';

	if(datetime.match(/(dt|td)/i)) return dateFormat + ' ' + timeFormat;
	if(datetime.match(/t/i)) return timeFormat;
	return dateFormat;
};

AppGini.hideViewParentLinks = function() {
	/* find and hide parent links if field label has data 'parent_link' set to 'view_parent_hidden' */
	$j('label[data-parent_link=view_parent_hidden]').each(function(){
		$j(this).parents('.form-group').find('.view_parent').hide();
	});
};
