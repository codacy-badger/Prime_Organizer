<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'tb_ajuste_colaborador';

		/* data for selected record, or defaults if none is selected */
		var data = {
			colaborador_id: <?php echo json_encode(array('id' => $rdata['colaborador_id'], 'value' => $rdata['colaborador_id'], 'text' => $jdata['colaborador_id'])); ?>,
			gestor_id: <?php echo json_encode(array('id' => $rdata['gestor_id'], 'value' => $rdata['gestor_id'], 'text' => $jdata['gestor_id'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for colaborador_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'colaborador_id' && d.id == data.colaborador_id.id)
				return { results: [ data.colaborador_id ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for gestor_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'gestor_id' && d.id == data.gestor_id.id)
				return { results: [ data.gestor_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

