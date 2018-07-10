<?php

	/**
	 * @file
	 * This file contains hook functions that get called when data operations are performed on 'tb_requerimento' table. 
	 * For example, when a new record is added, when a record is edited, when a record is deleted, … etc.
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

	function tb_requerimento_init(&$options, $memberInfo, &$args){

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

	function tb_requerimento_header($contentType, $memberInfo, &$args){
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

	function tb_requerimento_footer($contentType, $memberInfo, &$args){
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
	 *     $data['str_posicao'], $data['int_n_vagas'], $data['bool_reposicao'], $data['str_recurso'], $data['time_horario_entrada'], $data['time_horario_saida'], $data['empresa_id'], $data['contato_id'], $data['str_gestor'], $data['str_telefone'], $data['str_email'], $data['float_salario'], $data['int_maquinas'], $data['str_beneficios'], $data['bool_abertura'], $data['data_indicacao'], $data['str_descricao']
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

	function tb_requerimento_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	/**
	 * Called after executing the insert query (but before executing the ownership insert query).
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values that were inserted into the new record.
	 * For this table, the array items are: 
	 *     $data['str_posicao'], $data['int_n_vagas'], $data['str_status'], $data['bool_reposicao'], $data['str_recurso'], $data['time_horario_entrada'], $data['time_horario_saida'], $data['empresa_id'], $data['contato_id'], $data['str_gestor'], $data['str_telefone'], $data['str_email'], $data['float_salario'], $data['int_maquinas'], $data['str_beneficios'], $data['bool_abertura'], $data['data_indicacao'], $data['str_descricao']
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

	function tb_requerimento_after_insert($data, $memberInfo, &$args){
        // Checa se o status do Requerimento é aprovado
            // Se sim, inclui as vagas na tabela Vaga
        $status = $data['str_status'];
        
        $requerimento = $data['selectedID'];
        
        if($status == "Aprovado"){
            
            // Quantidade de Vagas // ID da vaga
            $quantidade = $data['int_n_vagas'];
            // Data de previsão de fechamento
            $previsao = $data['dta_prev_fechamento'];
            
            // Cargo da vaga
            $posicao = $data['str_posicao'];
            // Empresa solicitante
            $empresa = $data['empresa_id'];
            // Local de alocação na empresa
            $alocacao = $data['str_alocacao'];
            
            // Recrutador responsável
            $recrutador = $data['recrutador_id'];
            
            // Status de abertura da vaga
            if($data['bool_abertura'] == 'Abertura imediata'){
                $status_vaga = 'Aberta';
                $data_abertura_vaga = date('Y-m-d');
                $data_abertura_vaga = "'$data_abertura_vaga'";
            } else{
                $status_vaga = 'Congelada';
                $data_abertura_vaga = 'NULL';
            }
            
            // Cria as vagas de acordo com a quantidade proposta
            for($i = 1; $i <= $quantidade; $i++){
                $sql = "INSERT INTO tb_vaga(requerimento_id, int_vaga_numero, dta_abertura, str_alocacao, str_posicao, recrutador_id, empresa_id, str_status, dta_prev_fechamento)
                VALUES ('{$requerimento}', '{$i}', $data_abertura_vaga, '{$alocacao}', '{$posicao}', '{$recrutador}', '{$empresa}', '{$status_vaga}', '{$previsao}')";
                
                sql($sql, $eo);
            }
            
            // Data de abertura da Vaga
            $data_abertura = sqlValue("SELECT dta_abertura FROM tb_requerimento WHERE id = '{$requerimento}'");
            if(!$data_abertura){
                $data_abertura = date('Y-m-d');

                // Insere a data de Abertura do Requerimento
                $sql = "UPDATE tb_requerimento
                SET dta_abertura = '{$data_abertura}'
                WHERE id = '{$requerimento}'";

                sql($sql, $eo);
            }
            
        }
        
        
		return TRUE;
	}

	/**
	 * Called before executing the update query.
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values.
	 * Note: if a field is set as read-only or hidden in detail view, it can't be modified through $data. You should use a direct SQL statement instead.
	 * For this table, the array items are: 
	 *     $data['id'], $data['str_posicao'], $data['int_n_vagas'], $data['bool_reposicao'], $data['str_recurso'], $data['time_horario_entrada'], $data['time_horario_saida'], $data['empresa_id'], $data['contato_id'], $data['str_gestor'], $data['str_telefone'], $data['str_email'], $data['float_salario'], $data['int_maquinas'], $data['str_beneficios'], $data['bool_abertura'], $data['data_indicacao'], $data['str_descricao']
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

	function tb_requerimento_before_update(&$data, $memberInfo, &$args){
        // ID do requerimento
        $requerimento = $data['selectedID'];
        
        // Status do Requerimento
        $status = $data['str_status'];
        
        // Se o requerimento está aprovado, atualiza ou cria as vagas
        if($status == "Aprovado"){
            
            $query = sql("SELECT requerimento_id FROM tb_vaga WHERE requerimento_id = '{$requerimento}'", $eo);
            
            // Se as vagas já existem, atualiza as mesmas
            if(db_fetch_assoc($query)){
                
                // Quantidade de Vagas // ID da vaga
                $quantidade = $data['int_n_vagas'];
                // Data de previsão de fechamento
                $previsao = $data['dta_prev_fechamento'];

                // Cargo da vaga
                $posicao = $data['str_posicao'];
                // Empresa solicitante
                $empresa = $data['empresa_id'];
                // Local de alocação na empresa
                $alocacao = $data['str_alocacao'];

                // Recrutador responsável
                $recrutador = $data['recrutador_id'];

                // Status de abertura da vaga
                if($data['bool_abertura'] == 'Abertura imediata'){
                    $status_vaga = 'Aberta';
                    $data_abertura_vaga = date('Y-m-d');
                    $data_abertura_vaga = "'$data_abertura_vaga'";
                } else{
                    $status_vaga = 'Congelada';
                    $data_abertura_vaga = 'NULL';
                }

                // Atualiza a quantidade de vagas
                $quantidade_old = intval(sqlValue("SELECT COUNT(int_vaga_numero) FROM tb_vaga WHERE requerimento_id = '{$requerimento}'"));
                
                // Se a quantidade for maior, deleta o excesso de vagas
                if($quantidade < $quantidade_old){
                        
                    // $quantidade_old = 10 ==> Última vaga era R01-10
                    // $quantidade = 3 ==> Última vaga será R01-3
                    // $quantidade < i <= $quantidade_old ==> O que for maior que $squantidade será apagado
                    sql("DELETE FROM tb_vaga WHERE int_vaga_numero > '{$quantidade}' AND requerimento_id = '{$requerimento}'", $eo);

                // Se for menor, cria mais linhas na tabela
                }
                
                if($quantidade > $quantidade_old){
                        
                    // $quantidade_old = 3 => Última vaga era R01-3
                    // $quantidade = 10 => Última vaga será R01-10
                    // $i = 4 => Primeira vaga a iterar será R01-4
                    for($i = $quantidade_old + 1; $i <= $quantidade; $i++){
                        $j = $i - 1;
                        
                        $sql = "
                        INSERT INTO tb_vaga(requerimento_id, int_vaga_numero, dta_abertura, str_alocacao, str_posicao, recrutador_id, empresa_id, str_status, dta_prev_fechamento)
                        SELECT requerimento_id, '{$i}', dta_abertura, str_alocacao, str_posicao, recrutador_id, empresa_id, str_status, dta_prev_fechamento
                        FROM tb_vaga
                        WHERE requerimento_id = '{$requerimento}' AND int_vaga_numero = '{$j}'";
                        
                        sql($sql, $eo);
                    }
                    
                }
                
                // Atualiza as vagas
                for($i = 1; $i <= $quantidade; $i++){
                    $sql = "UPDATE tb_vaga
                    SET str_alocacao = '{$alocacao}', str_posicao = '{$posicao}', recrutador_id = '{$recrutador}', empresa_id = '{$empresa}', str_status = '{$status_vaga}', dta_prev_fechamento = '{$previsao}'
                    WHERE requerimento_id = '{$requerimento}' AND int_vaga_numero = '{$i}'";

                    sql($sql, $eo);
                }
                
                // Data de abertura do Requerimento
                $data_abertura = sqlValue("SELECT dta_abertura FROM tb_requerimento WHERE id = '{$requerimento}'");
                if(!$data_abertura){
                    $data_abertura = date('Y-m-d');

                    // Insere a data de Abertura do Requerimento
                    $sql = "UPDATE tb_requerimento
                    SET dta_abertura = '{$data_abertura}'
                    WHERE id = '{$requerimento}'";

                    sql($sql, $eo);
                }
                
            // Senão, cria as vagas   
            } else{        
                // Quantidade de Vagas // ID da vaga
                $quantidade = $data['int_n_vagas'];
                // Data de previsão de fechamento
                $previsao = $data['dta_prev_fechamento'];

                // Cargo da vaga
                $posicao = $data['str_posicao'];
                // Empresa solicitante
                $empresa = $data['empresa_id'];
                // Local de alocação na empresa
                $alocacao = $data['str_alocacao'];

                // Recrutador responsável
                $recrutador = $data['recrutador_id'];

                // Status de abertura da vaga
                if($data['bool_abertura'] == 'Abertura imediata'){
                    $status_vaga = 'Aberta';
                    $data_abertura_vaga = date('Y-m-d');
                    $data_abertura_vaga = "'$data_abertura_vaga'";
                } else{
                    $status_vaga = 'Congelada';
                    $data_abertura_vaga = 'NULL';
                }

                // Cria as vagas de acordo com a quantidade proposta
                for($i = 1; $i <= $quantidade; $i++){
                    $sql = "INSERT INTO tb_vaga(requerimento_id, int_vaga_numero, dta_abertura, str_alocacao, str_posicao, recrutador_id, empresa_id, str_status, dta_prev_fechamento)
                    VALUES ('{$requerimento}', '{$i}', $data_abertura_vaga, '{$alocacao}', '{$posicao}', '{$recrutador}', '{$empresa}', '{$status_vaga}', '{$previsao}')";

                    sql($sql, $eo);
                }
                
                
                // Data de abertura do Requerimento
                $data_abertura = sqlValue("SELECT dta_abertura FROM tb_requerimento WHERE id = '{$requerimento}'");
                if(!$data_abertura){
                    $data_abertura = date('Y-m-d');

                    // Insere a data de Abertura do Requerimento
                    $sql = "UPDATE tb_requerimento
                    SET dta_abertura = '{$data_abertura}'
                    WHERE id = '{$requerimento}'";

                    sql($sql, $eo);
                }
                
            }
        }
        
        return TRUE;
	}

	/**
	 * Called after executing the update query and before executing the ownership update query.
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values.
	 * For this table, the array items are: 
	 *     $data['id'], $data['str_posicao'], $data['int_n_vagas'], $data['str_status'], $data['bool_reposicao'], $data['str_recurso'], $data['time_horario_entrada'], $data['time_horario_saida'], $data['empresa_id'], $data['contato_id'], $data['str_gestor'], $data['str_telefone'], $data['str_email'], $data['float_salario'], $data['int_maquinas'], $data['str_beneficios'], $data['bool_abertura'], $data['data_indicacao'], $data['str_descricao']
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

	function tb_requerimento_after_update($data, $memberInfo, &$args){
        
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

	function tb_requerimento_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){
        $requerimento = $selectedID;
        
        sql("DELETE FROM tb_vaga WHERE requerimento_id = '{$requerimento}'", $eo);
        
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

	function tb_requerimento_after_delete($selectedID, $memberInfo, &$args){

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
	 * the code before displaying it using regular expressions, … etc.
	 * 
	 * @param $args
	 * An empty array that is passed by reference. It's currently not used but is reserved for future uses.
	 * 
	 * @return
	 * None.
	*/

	function tb_requerimento_dv($selectedID, $memberInfo, &$html, &$args){

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

	function tb_requerimento_csv($query, $memberInfo, &$args){

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

	function tb_requerimento_batch_actions(&$args){

		return array();
	}
