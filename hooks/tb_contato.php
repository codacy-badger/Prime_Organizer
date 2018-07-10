<?php

	/**
	 * @file
	 * This file contains hook functions that get called when data operations are performed on 'tb_contato' table. 
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

	function tb_contato_init(&$options, $memberInfo, &$args){

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

	function tb_contato_header($contentType, $memberInfo, &$args){
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

	function tb_contato_footer($contentType, $memberInfo, &$args){
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
	 *     $data['empresa_id'], $data['str_primeiro_nome'], $data['str_sobrenome'], $data['str_nivel'], $data['tipo_id'], $data['str_email1'], $data['str_email2'], $data['str_telefone1'], $data['str_telefone2'], $data['str_telefone3'], $data['cidade'], $data['uf']
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

	function tb_contato_before_insert(&$data, $memberInfo, &$args){
		return TRUE;
	}

	/**
	 * Called after executing the insert query (but before executing the ownership insert query).
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values that were inserted into the new record.
	 * For this table, the array items are: 
	 *     $data['empresa_id'], $data['str_primeiro_nome'], $data['str_sobrenome'], $data['str_nivel'], $data['tipo_id'], $data['str_email1'], $data['str_email2'], $data['str_telefone1'], $data['str_telefone2'], $data['str_telefone3'], $data['cidade'], $data['uf'], $data['dta_cadastro']
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

	function tb_contato_after_insert($data, $memberInfo, &$args){
        $email = $data['str_email1'];
        
        // Se o contato existe, atualiza o mesmo
        if($lead_id = get_lead_id_by_email_mautic($email)){
            require 'organizer-func.php';
        
            $empresa_old = get_companyname_by_lead_id_mautic($lead_id);
            $relacionamento_old = get_lead_tag_by_lead_id_mautic($lead_id);

            // Captura dos dados do Organizer
            $nome = retira_caracter_especial($data['str_primeiro_nome']);
            $sobrenome = retira_caracter_especial($data['str_sobrenome']);

            $empresa_org = get_empresa_nome_organizer($data['empresa_id']);
            $empresa_nome = retira_caracter_especial($empresa_org);
            $empresa = check_company_existe_mautic($empresa_nome);

            $cargo = retira_caracter_especial($data['str_nivel']);
            $relacionamento = check_tag_mautic($data['tipo_id']);

            $tel1 = $data['str_telefone1'];
            $tel2 = $data['str_telefone2'];

            $cidade = retira_caracter_especial($data['cidade']);
            $estado = get_estado($data["uf"]);

            // Inicio da Query
            require 'mautic-conn.php';

            $sql = "UPDATE leads
            SET firstname = '{$nome}', lastname = '{$sobrenome}', company = '{$empresa}', position = '{$cargo}', email = '{$email}', phone = '{$tel1}', mobile = '{$tel2}', city = '{$cidade}', state = '{$estado}'
            WHERE id = '{$lead_id}';";

            // Revisa se o contato trocou de empresa e atualiza no Mautic        
            if($empresa_old != $empresa){
                $nova_empresa = get_company_id_mautic($empresa);

                $sql .= "UPDATE companies_leads
                SET company_id = '{$nova_empresa}'
                WHERE lead_id = '{$lead_id}';";

            }

            // Revisa se o contato trocou de relacionamento e atualiza no Mautic        
            if($relacionamento_old != $relacionamento){

                $sql .= "UPDATE lead_tags_xref
                SET tag_id = '{$relacionamento}'
                WHERE lead_id = '{$lead_id}'";

            }

            $conn -> multi_query($sql);
            
        // Senão, cria o contato no Mautic   
        } else{
            
            // Funções para a integração Organizer-Mautic
            require 'organizer-func.php';

            // Captura dos dados do Organizer
            $nome = retira_caracter_especial($data['str_primeiro_nome']);
            $sobrenome = retira_caracter_especial($data['str_sobrenome']);

            $empresa_org = get_empresa_nome_organizer($data['empresa_id']);
            $empresa_nome = retira_caracter_especial($empresa_org);
            $empresa = check_company_existe_mautic($empresa_nome);

            $cargo = retira_caracter_especial($data['str_nivel']);
            $relacionamento = check_tag_mautic($data['tipo_id']);

            $tel1 = $data['str_telefone1'];
            $tel2 = $data['str_telefone2'];

            $cidade = retira_caracter_especial($data['cidade']);
            $estado = get_estado($data["uf"]);

            // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
            $hora = date('Y-m-d H:i:s', time());
            $vazio = array();
            $vazio = serialize($vazio);

            // Inicio da Query
            require('mautic-conn.php');

            // Insere o contato como lead no Mautic
            $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, date_identified, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
            VALUES (1,1,'{$hora}',1,'admin admin','{$hora}',1,'admin admin',0,'{$vazio}','{$vazio}', '{$hora}' ,'gravatar','{$nome}','{$sobrenome}','{$empresa}','{$cargo}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

            $conn -> query($sql);

            // Recupera o id no Mautic do contato criado
            $lead_id = get_lead_id_by_email_mautic($email);
            $company_id = get_company_id_mautic($empresa);

            // Insere o relacionamento do Organizer como uma tag no Mautic
            $sql = "INSERT INTO lead_tags_xref (lead_id, tag_id)
            VALUES ('{$lead_id}','{$relacionamento}');";

            // Faz o link do contato com uma empresa no Mautic para que o mesmo seja exibido
            $sql .= "INSERT INTO companies_leads (company_id, lead_id, date_added, is_primary, manually_removed, manually_added)
            VALUES ('{$company_id}','{$lead_id}', '{$hora}', 1, 0, 0);";

            $conn -> multi_query($sql);
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
	 *     $data['id'], $data['empresa_id'], $data['str_primeiro_nome'], $data['str_sobrenome'], $data['str_nivel'], $data['tipo_id'], $data['str_email1'], $data['str_email2'], $data['str_telefone1'], $data['str_telefone2'], $data['str_telefone3'], $data['cidade'], $data['uf']
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

	function tb_contato_before_update(&$data, $memberInfo, &$args){
        $email = $data['str_email1'];
        
        // Se o contato existe, atualiza o mesmo
        if($lead_id = get_lead_id_by_email_mautic($email)){
            require 'organizer-func.php';
        
            $empresa_old = get_companyname_by_lead_id_mautic($lead_id);
            $relacionamento_old = get_lead_tag_by_lead_id_mautic($lead_id);

            // Captura dos dados do Organizer
            $nome = retira_caracter_especial($data['str_primeiro_nome']);
            $sobrenome = retira_caracter_especial($data['str_sobrenome']);

            $empresa_org = get_empresa_nome_organizer($data['empresa_id']);
            $empresa_nome = retira_caracter_especial($empresa_org);
            $empresa = check_company_existe_mautic($empresa_nome);

            $cargo = retira_caracter_especial($data['str_nivel']);
            $relacionamento = check_tag_mautic($data['tipo_id']);

            $tel1 = $data['str_telefone1'];
            $tel2 = $data['str_telefone2'];

            $cidade = retira_caracter_especial($data['cidade']);
            $estado = get_estado($data["uf"]);

            // Inicio da Query
            require 'mautic-conn.php';

            $sql = "UPDATE leads
            SET firstname = '{$nome}', lastname = '{$sobrenome}', company = '{$empresa}', position = '{$cargo}', email = '{$email}', phone = '{$tel1}', mobile = '{$tel2}', city = '{$cidade}', state = '{$estado}'
            WHERE id = '{$lead_id}';";

            // Revisa se o contato trocou de empresa e atualiza no Mautic        
            if($empresa_old != $empresa){
                $nova_empresa = get_company_id_mautic($empresa);

                $sql .= "UPDATE companies_leads
                SET company_id = '{$nova_empresa}'
                WHERE lead_id = '{$lead_id}';";

            }

            // Revisa se o contato trocou de relacionamento e atualiza no Mautic        
            if($relacionamento_old != $relacionamento){

                $sql .= "UPDATE lead_tags_xref
                SET tag_id = '{$relacionamento}'
                WHERE lead_id = '{$lead_id}'";

            }

            $conn -> multi_query($sql);
            
        // Senão, cria o contato no Mautic   
        } else{
            
            // Funções para a integração Organizer-Mautic
            require 'organizer-func.php';

            // Captura dos dados do Organizer
            $nome = retira_caracter_especial($data['str_primeiro_nome']);
            $sobrenome = retira_caracter_especial($data['str_sobrenome']);

            $empresa_org = get_empresa_nome_organizer($data['empresa_id']);
            $empresa_nome = retira_caracter_especial($empresa_org);
            $empresa = check_company_existe_mautic($empresa_nome);

            $cargo = retira_caracter_especial($data['str_nivel']);
            $relacionamento = check_tag_mautic($data['tipo_id']);

            $tel1 = $data['str_telefone1'];
            $tel2 = $data['str_telefone2'];

            $cidade = retira_caracter_especial($data['cidade']);
            $estado = get_estado($data["uf"]);

            // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
            $hora = date('Y-m-d H:i:s', time());
            $vazio = array();
            $vazio = serialize($vazio);

            // Inicio da Query
            require('mautic-conn.php');

            // Insere o contato como lead no Mautic
            $sql = "INSERT INTO leads (owner_id, is_published, date_added, created_by, created_by_user, checked_out, checked_out_by, checked_out_by_user, points, internal, social_cache, date_identified, preferred_profile_image, firstname, lastname, company, position, email, phone, mobile, city, state, country)
            VALUES (1,1,'{$hora}',1,'admin admin','{$hora}',1,'admin admin',0,'{$vazio}','{$vazio}', '{$hora}' ,'gravatar','{$nome}','{$sobrenome}','{$empresa}','{$cargo}', '{$email}', '{$tel1}','{$tel2}','{$cidade}', '{$estado}','Brazil')";

            $conn -> query($sql);

            // Recupera o id no Mautic do contato criado
            $lead_id = get_lead_id_by_email_mautic($email);
            $company_id = get_company_id_mautic($empresa);

            // Insere o relacionamento do Organizer como uma tag no Mautic
            $sql = "INSERT INTO lead_tags_xref (lead_id, tag_id)
            VALUES ('{$lead_id}','{$relacionamento}');";

            // Faz o link do contato com uma empresa no Mautic para que o mesmo seja exibido
            $sql .= "INSERT INTO companies_leads (company_id, lead_id, date_added, is_primary, manually_removed, manually_added)
            VALUES ('{$company_id}','{$lead_id}', '{$hora}', 1, 0, 0);";

            $conn -> multi_query($sql);
        }
        
		return TRUE;
	}

	/**
	 * Called after executing the update query and before executing the ownership update query.
	 * 
	 * @param $data
	 * An associative array where the keys are field names and the values are the field data values.
	 * For this table, the array items are: 
	 *     $data['id'], $data['empresa_id'], $data['str_primeiro_nome'], $data['str_sobrenome'], $data['str_nivel'], $data['tipo_id'], $data['str_email1'], $data['str_email2'], $data['str_telefone1'], $data['str_telefone2'], $data['str_telefone3'], $data['cidade'], $data['uf'], $data['dta_cadastro']
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

	function tb_contato_after_update($data, $memberInfo, &$args){
        
		return FALSE;
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

	function tb_contato_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){
        require 'organizer-func.php';
        
        // Inicio da Query
        // Se o funcionário existe no Mautic, ele será apagado
        $lead_id = get_lead_id_by_selectedID_mautic($selectedID);
        $empresa = get_companyname_by_lead_id_mautic($lead_id);
        
        if($lead_id){
            require('mautic-conn.php');    

            // Deleta o registro do contato
            $sql = "DELETE FROM leads WHERE id = '{$lead_id}';";
            
            // Deleta o registro de relacionamento do contato
            $sql .= "DELETE FROM lead_tags_xref WHERE lead_id = '{$lead_id}';";

            // Retira o funcionário da tabela que liga Contato-Empresa
            $company_id = get_company_id_mautic($empresa);
            $sql .= "DELETE FROM `companies_leads` WHERE company_id = '{$company_id}' AND lead_id = '{$lead_id}';";
            
            $conn -> multi_query($sql);
        }
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

	function tb_contato_after_delete($selectedID, $memberInfo, &$args){
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

	function tb_contato_dv($selectedID, $memberInfo, &$html, &$args){
        if(isset($_REQUEST['dvprint_x'])) return;
        
        ob_start(); ?>

		<script>
            $j(function(){
                <?php if($selectedID){ ?>
                $j('#tb_contato_dv_action_buttons .btn-toolbar').append(
                    '<p></p>' +
                    '<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' +
                        '<button type="button" class="btn btn-default btn-lg" onclick="teste()">' +
                            '<i class="glyphicon glyphicon-send"></i> Mautic' +
                        '</button>' +
                    '</div>' +
                '<p></p>'
                );
                <?php } ?>
            });

            function teste(){
                var selectedID = '<?php echo $selectedID; ?>';
                window.location = 'hooks/mautic-redirect.php?SelectedID=' + selectedID;
            }
            
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

	function tb_contato_csv($query, $memberInfo, &$args){

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

	function tb_contato_batch_actions(&$args){

		return array();
	}
