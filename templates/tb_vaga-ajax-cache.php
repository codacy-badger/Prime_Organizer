<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'tb_vaga';

		/* data for selected record, or defaults if none is selected */
		var data = {
			empresa_id: <?php echo json_encode(array('id' => $rdata['empresa_id'], 'value' => $rdata['empresa_id'], 'text' => $jdata['empresa_id'])); ?>,
			str_alocacao: <?php echo json_encode(array('id' => $rdata['str_alocacao'], 'value' => $rdata['str_alocacao'], 'text' => $jdata['str_alocacao'])); ?>,
			recrutador_id: <?php echo json_encode(array('id' => $rdata['recrutador_id'], 'value' => $rdata['recrutador_id'], 'text' => $jdata['recrutador_id'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for empresa_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'empresa_id' && d.id == data.empresa_id.id)
				return { results: [ data.empresa_id ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for str_alocacao */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'str_alocacao' && d.id == data.str_alocacao.id)
				return { results: [ data.str_alocacao ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for recrutador_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'recrutador_id' && d.id == data.recrutador_id.id)
				return { results: [ data.recrutador_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

