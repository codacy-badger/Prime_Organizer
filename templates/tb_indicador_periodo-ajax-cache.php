<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'tb_indicador_periodo';

		/* data for selected record, or defaults if none is selected */
		var data = {
			indicador_id: <?php echo json_encode(array('id' => $rdata['indicador_id'], 'value' => $rdata['indicador_id'], 'text' => $jdata['indicador_id'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for indicador_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'indicador_id' && d.id == data.indicador_id.id)
				return { results: [ data.indicador_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

