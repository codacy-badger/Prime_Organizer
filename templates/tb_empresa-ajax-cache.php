<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'tb_empresa';

		/* data for selected record, or defaults if none is selected */
		var data = {
			str_responsavel: <?php echo json_encode(array('id' => $rdata['str_responsavel'], 'value' => $rdata['str_responsavel'], 'text' => $jdata['str_responsavel'])); ?>,
			relacionamento_id: <?php echo json_encode(array('id' => $rdata['relacionamento_id'], 'value' => $rdata['relacionamento_id'], 'text' => $jdata['relacionamento_id'])); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for str_responsavel */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'str_responsavel' && d.id == data.str_responsavel.id)
				return { results: [ data.str_responsavel ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

