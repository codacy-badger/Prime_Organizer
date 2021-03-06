<?php
	$rdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('nl2br', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function(){
		var tn = 'tb_atendimento';

		/* data for selected record, or defaults if none is selected */
		var data = {
			empresa_id: <?php echo json_encode(array('id' => $rdata['empresa_id'], 'value' => $rdata['empresa_id'], 'text' => $jdata['empresa_id'])); ?>,
			contato_id: <?php echo json_encode(array('id' => $rdata['contato_id'], 'value' => $rdata['contato_id'], 'text' => $jdata['contato_id'])); ?>,
			campanha_id: <?php echo json_encode(array('id' => $rdata['campanha_id'], 'value' => $rdata['campanha_id'], 'text' => $jdata['campanha_id'])); ?>,
			usuario_id: <?php echo json_encode(array('id' => $rdata['usuario_id'], 'value' => $rdata['usuario_id'], 'text' => $jdata['usuario_id'])); ?>
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

		/* saved value for contato_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'contato_id' && d.id == data.contato_id.id)
				return { results: [ data.contato_id ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for campanha_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'campanha_id' && d.id == data.campanha_id.id)
				return { results: [ data.campanha_id ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for usuario_id */
		cache.addCheck(function(u, d){
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'usuario_id' && d.id == data.usuario_id.id)
				return { results: [ data.usuario_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

