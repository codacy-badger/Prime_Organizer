<?php

	/**
	 * @file
	 * This file contains hook functions that get called when data operations are performed on 'tb_vaga' table. 
	 * For example, when a new record is added, when a record is edited, when a record is deleted, � etc.
	*/

	/**
	 * Called before rendering the page. This is a very powerful hook that allows you to control all aspects of how the page is rendered.
	 * 
	 * @param $options
	 * (passed by reference) a DataList object that sets options for rendering the page.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/DataList
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * True to render the page. False to cancel the operation (which could be useful for error handling to display 
	 * an error message to the user and stop displaying any data).
	*/

	function tb_vaga_init(&$options, $memberInfo, &$args){
		/* Inserted by Search Page Maker for AppGini on 2018-07-04 01:45:18 */
		$options->FilterPage = 'hooks/tb_vaga_filter.php';
		/* End of Search Page Maker for AppGini code */


		return TRUE;
	}

	/**
	 * Called before displaying page content. Can be used to return a customized header template for the table.
	 * 
	 * @param $contentType
	 * specifies the type of view that will be displayed. Takes one the following values: 
	 * 'tableview', 'detailview', 'tableview+detailview', 'print-tableview', 'print-detailview', 'filters'
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * String containing the HTML header code. If empty, the default 'header.php' is used. If you want to include
	 * the default header besides your customized header, include the <%%HEADER%%> placeholder in the returned string.
	*/

	function tb_vaga_header($contentType, $memberInfo, &$args){
		$header='';

		switch($contentType){
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}

	/**
	 * Called after displaying page content. Can be used to return a customized footer template for the table.
	 * 
	 * @param $contentType
	 * specifies the type of view that will be displayed. Takes one the following values: 
	 * 'tableview', 'detailview', 'tableview+detailview', 'print-tableview', 'print-detailview', 'filters'
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * String containing the HTML footer code. If empty, the default 'footer.php' is used. If you want to include 
	 * the default footer besides your customized footer, include the <%%FOOTER%%> placeholder in the returned string.
	*/

	function tb_vaga_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}

	/**
	 * Called before executing the insert query.
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values to be inserted into the new record.
	 * Note: if a field is set as read-only or hidden in detail view, it can't be modified through $data. You should use a direct SQL statement instead.
	 * For this table, the array items are: 
	 *     $data['empresa_id'], $data['str_alocacao'], $data['recrutador_id'], $data['str_posicao'], $data['dta_abertura'], $data['qtd_vagas'], $data['str_prioridade'], $data['str_status'], $data['dta_fechamento'], $data['dta_previsao_fechamento'], $data['str_obs'], $data['dta_inicio'], $data['str_contratado_nome']
	 * $data array is passed by reference so that modifications to it apply to the insert query.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * A boolean TRUE to perform the insert operation, or FALSE to cancel it.
	*/

	function tb_vaga_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	/**
	 * Called after executing the insert query (but before executing the ownership insert query).
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values that were inserted into the new record.
	 * For this table, the array items are: 
	 *     $data['empresa_id'], $data['str_alocacao'], $data['recrutador_id'], $data['str_posicao'], $data['dta_abertura'], $data['qtd_vagas'], $data['str_prioridade'], $data['str_status'], $data['dta_fechamento'], $data['dta_previsao_fechamento'], $data['str_obs'], $data['dta_inicio'], $data['str_contratado_nome']
	 * Also includes the item $data['selectedID'] which stores the value of the primary key for the new record.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * A boolean TRUE to perform the ownership insert operation or FALSE to cancel it.
	 * Warning: if a FALSE is returned, the new record will have no ownership info.
	*/

	function tb_vaga_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}

	/**
	 * Called before executing the update query.
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values.
	 * Note: if a field is set as read-only or hidden in detail view, it can't be modified through $data. You should use a direct SQL statement instead.
	 * For this table, the array items are: 
	 *     $data['id'], $data['empresa_id'], $data['str_alocacao'], $data['recrutador_id'], $data['str_posicao'], $data['dta_abertura'], $data['qtd_vagas'], $data['str_prioridade'], $data['str_status'], $data['dta_fechamento'], $data['dta_previsao_fechamento'], $data['str_obs'], $data['dta_inicio'], $data['str_contratado_nome']
	 * Also includes the item $data['selectedID'] which stores the value of the primary key for the record to be updated.
	 * $data array is passed by reference so that modifications to it apply to the update query.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * True to perform the update operation or false to cancel it.
	*/

	function tb_vaga_before_update(&$data, $memberInfo, &$args){
        
		return TRUE;
	}

	/**
	 * Called after executing the update query and before executing the ownership update query.
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values.
	 * For this table, the array items are: 
	 *     $data['id'], $data['empresa_id'], $data['str_alocacao'], $data['recrutador_id'], $data['str_posicao'], $data['dta_abertura'], $data['qtd_vagas'], $data['str_prioridade'], $data['str_status'], $data['dta_fechamento'], $data['dta_previsao_fechamento'], $data['str_obs'], $data['dta_inicio'], $data['str_contratado_nome']
	 * Also includes the item $data['selectedID'] which stores the value of the primary key for the record.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * True to perform the ownership update operation or false to cancel it. 
	*/

	function tb_vaga_after_update($data, $memberInfo, &$args){
        
        // Fecha o requerimento se todas as vagas foram preenchidas ou canceladas
        $id_vaga = $data['selectedID'];
        
        if(empty($data['requerimento_id'])){
            $requerimento = 0;
        } else{
            $requerimento = $data['requerimento_id'];
        }
        
        $data = date('Y-m-d');
        
        // Vagas preenchidas/canceladas
        $vagas_preenchidas = sqlValue("SELECT COUNT(str_status) FROM tb_vaga WHERE requerimento_id = '{$requerimento}' AND str_status LIKE 'Encerrada'");
        // Total de vagas do requerimento
        $vagas_totais = sqlValue("SELECT COUNT(int_vaga_numero) FROM tb_vaga WHERE requerimento_id = '{$requerimento}'");
        
        // Se as vagas foram ecnerradas (preenchidas/canceladas), fecha o requerimento
        if($vagas_preenchidas == $vagas_totais){
            $sql = "UPDATE tb_requerimento
            SET dta_fechamento = '{$data}' WHERE id = '{$requerimento}'";
            
            sql($sql, $eo);
            
            $sql = "UPDATE tb_vaga
            SET dta_fechamento = '{$data}' WHERE requerimento_id = '{$requerimento}'";
            
            sql($sql, $eo);
        }
        
        // Se as vagas n�o foram encerradas, deixa o requerimento aberto
        if($vagas_preenchidas != $vagas_totais){
            $sql = "UPDATE tb_requerimento
            SET dta_fechamento = NULL WHERE id = '{$requerimento}'";
            
            sql($sql, $eo);
            
            $sql = "UPDATE tb_vaga
            SET dta_fechamento = NULL WHERE requerimento_id = '{$requerimento}'";
            
            sql($sql, $eo);
        }
        
        
        return TRUE;
	}

	/**
	 * Called before deleting a record (and before performing child records check).
	 * 
	 * @param $selectedID
	 * The primary key value of the record to be deleted.
	 * 
	 * @param $skipChecks
	 * A flag passed by reference that determines whether child records check should be performed or not.
	 * If you set $skipChecks to TRUE, no child records check will be made. If you set it to FALSE, the check will be performed.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * True to perform the delete operation or false to cancel it.
	*/

	function tb_vaga_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}

	/**
	 * Called after deleting a record.
	 * 
	 * @param $selectedID
	 * The primary key value of the record to be deleted.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function tb_vaga_after_delete($selectedID, $memberInfo, &$args){

	}

	/**
	 * Called when a user requests to view the detail view (before displaying the detail view).
	 * 
	 * @param $selectedID
	 * The primary key value of the record selected. False if no record is selected (i.e. the detail view will be 
	 * displayed to enter a new record).
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $html
	 * (passed by reference) the HTML code of the form ready to be displayed. This could be useful for manipulating 
	 * the code before displaying it using regular expressions, � etc.
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function tb_vaga_dv($selectedID, $memberInfo, &$html, &$args){
        if(isset($_REQUEST['dvprint_x'])) return;
        
        ob_start(); ?>

        

		<script>
            $j(function(){
                <?php if($selectedID){ ?>
                $j('#tb_vaga_dv_action_buttons .btn-toolbar').append(
                    '<p></p>' +
                    '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' +
                        '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#fecharVaga">' +
                            '<i class="glyphicon glyphicon-pencil"></i> Alterar Status' +
                        '</button>' +
                    '</div>' +
                '<p></p>'
                );
                <?php } ?> 
            });
        </script><?php
        
        $botao = ob_get_contents();
		ob_end_clean();

		$html .= $botao;
	}

	/**
	 * Called when a user requests to download table data as a CSV file (by clicking on the SAVE CSV button)
	 * 
	 * @param $query
	 * Contains the query that will be executed to return the data in the CSV file.
	 * 
	 * @param $memberInfo
	 * An array containing logged member's info.
	 * @see https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks/memberInfo
	 * 
	 * @param $args
	 * An empty array. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * A string containing the query to use for fetching the CSV data. If FALSE or empty is returned, the default query is used.
	*/

	function tb_vaga_csv($query, $memberInfo, &$args){

		return $query;
	}
	/**
	 * Called when displaying the table view to retrieve custom record actions
	 * 
	 * @return
	 * A 2D array describing custom record actions. The format of the array is:
	 *   array(
	 *      array(
	 *         'title' => 'Title', // the title/label of the custom action as displayed to users
	 *         'function' => 'js_function_name', // the name of a javascript function to be executed when user selects this action
	 *         'class' => 'CSS class(es) to apply to the action title', // optional, refer to Bootstrap documentation for CSS classes
	 *         'icon' => 'icon name' // optional, refer to Bootstrap glyphicons for supported names
	 *      ), ...
	 *   )
	*/

	function tb_vaga_batch_actions(&$args){

		return array();
	}
