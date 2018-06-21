<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'tb_entrevista';

		/* data for selected record, or defaults if none is selected */
		var data = {
			empresa_id: <?php echo json_encode(array('id' => $rdata['empresa_id'], 'value' => $rdata['empresa_id'], 'text' => $jdata['empresa_id'])); ?>,
			vaga_id: <?php echo json_encode(array('id' => $rdata['vaga_id'], 'value' => $rdata['vaga_id'], 'text' => $jdata['vaga_id'])); ?>,
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

		/* saved value for vaga_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'vaga_id' && d.id == data.vaga_id.id)
				return { results: [ data.vaga_id ], more: false, elapsed: 0.01 };
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

