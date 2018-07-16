<?php
	/*
	 * You can add custom links in the home page by appending them here ...
	 * The format for each link is:
		$homeLinks[] = array(
			'url' => 'path/to/link', 
			'title' => 'Link title', 
			'description' => 'Link text',
			'groups' => array('group1', 'group2'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => '', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => '', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => '', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'path/to/icon', // optional icon to use with the link
			'table_group' => '' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
		);
	 */
    
    $local = "";
    // Link para indicadores  
    $homeLinks[] = array(
        'url' => 'http://indicadores.primecontrol.com.br', 
        'title' => 'Indicadores', 
        'description' => 'Link para o painel de Indicadores gerado pelo Microsoft Power BI',
        'groups' => array('*'), // Mudar para ('RH','Comercial','Financeiro', 'Admins') no servidor
        'grid_column_classes' => 'col-sm-6 col-md-4 col-lg-3', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
        'panel_classes' => 'panel panel-warning', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
        'link_classes' => 'btn btn-block btn-lg btn-warning', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
        'icon' => '', // optional icon to use with the link
        'table_group' => '' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
    );
    
    // Link para os filtros de vagas
    $query = sql("SELECT str_nome FROM tb_recrutador WHERE bol_recrutador = 1", $eo);
    
    while($res = db_fetch_assoc($query)){
        $recrutadores = $recrutadores . '<a href="./tb_vaga_view.php?SortField=&SortDirection=&FilterAnd%5B1%5D=and&FilterField%5B1%5D=10&FilterOperator%5B1%5D=equal-to&FilterValue%5B1%5D='. urlencode($res['str_nome']) .'&FilterAnd%5B2%5D=and&FilterField%5B2%5D=12&FilterOperator%5B2%5D=equal-to&FilterValue%5B2%5D=Aberta">'. $res['str_nome'] .'<a>&nbsp;| ';
    }

    $homeLinks[] = array(
        'url' => './tb_vaga_view.php?SortField=&SortDirection=&FilterAnd%5B1%5D=and&FilterAnd%5B2%5D=and&FilterField%5B2%5D=12&FilterOperator%5B2%5D=equal-to&FilterValue%5B2%5D=Aberta', 
        'title' => 'Vagas Abertas', 
        'description' => 'Mostrar vagas abertas de:<br>'. $recrutadores,
        'groups' => array('Admins','RH'), // Mudar para ('RH','Comercial','Financeiro', 'Admins') no servidor
        'grid_column_classes' => 'col-sm-6 col-md-4 col-lg-3', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
        'panel_classes' => 'panel panel-info', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
        'link_classes' => 'btn btn-block btn-lg btn-info', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
        'icon' => '', // optional icon to use with the link
        'table_group' => 'RH' // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
    );

