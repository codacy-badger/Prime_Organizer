<?php
    
    // Retira catracteres especial da String
    function retira_caracter_especial($texto){
        $encontre = array("/Á/", "/á/", "/Ã/", "/ã/", "/Â/", "/â/", "/É/", "/é/", "/Ê/", "/ê/", "/Í/", "/í/", "/Ó/", "/ó/", "/Ô/", "/ô/", "/Õ/", "/õ/", "/Ú/", "/ú/", "/Ç/", "/ç/");
        $corrija = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u", "C", "c");
        
        $novo_texto = preg_replace($encontre, $corrija, $texto);
        
        return $novo_texto;
    }
    
    // Retorna o nome da empresa no Organizer de acordo com a id
    function get_empresa_nome_organizer($id){
        require 'organizer-conn.php';
        
        $sql = "SELECT `str_nome_fantasia` FROM `tb_empresa` WHERE id='{$id}'";
        $query = $organizer -> query($sql);
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $nome_empresa = $res['str_nome_fantasia'];
    
        return $nome_empresa;
    }
    
    // Retorna o campo Relacionamento do Organizer de acordo com a id
    function get_relacionamento_organizer($id){
        $rel = sqlValue("SELECT `str_nome` FROM `tb_contato_tipo` WHERE id='{$id}'", $eo);
        
        return $rel;
    }
    
    // Retorna o nome da empresa no Mautic
    //   Se ela existe, retorna o nome correspondente;
    //   Se não, cria a empresa e retorna o nome correspondente
    function check_company_existe_mautic($nome_empresa){
        require 'mautic-conn.php';
                
        $sql = "SELECT companyname FROM companies WHERE companyname LIKE '{$nome_empresa}'";
        
        $query = $conn -> query($sql);
            
        // Se a empresa existe, retorna o nome da mesma de acordo com o Mautic
        if($res = $query -> fetch_array(MYSQLI_BOTH)){
            $conn -> close();
            
            return $res['companyname'];

        // Senão, cria a empresa no Mautic
        } else{

            // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
            $empt = array();
            $empt = serialize($empt);

            $timestamp = date('Y-m-d H:i:s', time());

            // Inicio da Query
            $sql = "INSERT INTO `companies` (`owner_id`,`is_published`,`date_added`,`created_by`,`created_by_user`,`checked_out`,`checked_out_by`,`checked_out_by_user`,`social_cache`,`score`,`companyname`)
            VALUES (1, 1, '{$timestamp}', 1, 'admin admin', '{$timestamp}', 1, 'admin admin', '{$empt}', 0, '{$nome_empresa}')";

            $conn -> query($sql);
            $conn -> close();

            return $nome_empresa;
        }
    }
    
    // Retorna a id da empresa correspondente no Mautic
    function get_company_id_mautic($nome_empresa){
        require 'mautic-conn.php';
        
        $sql = "SELECT id FROM companies WHERE companyname LIKE '{$nome_empresa}'";
        
        $query = $conn -> query($sql);
            
        // Se a Empresa existe, retorna o ID da mesma de acordo com o Mautic
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $conn -> close();
        
        return $res['id'];
    }
    
    // Retorna o nome da empresa no cadastro do contato antes do update no Mautic
    function get_companyname_by_lead_id_mautic($id_lead){
        require 'mautic-conn.php';
        
        $sql = "SELECT company FROM leads WHERE id = '{$id_lead}'";
        $query = $conn -> query($sql);
        $res = $query -> fetch_array(MYSQLI_BOTH);
        
        return $res['company'];
    }

    // Retorna a id do contato no Mautic de acordo com o email do contato correspondente no Organizer
    function get_lead_id_by_email_mautic($email){
        // Inicia a query
        require 'mautic-conn.php';
        
        $sql = "SELECT id FROM leads WHERE email LIKE '{$email}'";
        
        $query = $conn -> query($sql);
            
        // Se o Funcionário existe, retorna o ID do mesmo de acordo com o Mautic
        if($res = $query -> fetch_array(MYSQLI_BOTH)){
            $conn -> close();

            return $res['id'];
        } else{
            $conn -> close();
            
            return false;
        }
    }
    
    // Retorna a id do contato no Mautic de acordo com o id do contato correspondente no Organizer
    function get_lead_id_by_selectedID_mautic($id){
        // Inicia a query
        require 'organizer-conn.php';
        
        $sql = "SELECT str_email1 FROM tb_contato WHERE id = '{$id}'";
        
        $query = $organizer -> query($sql);
            
        // Se o contato existe, retorna o email do mesmo
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $organizer -> close();
        
        $email = $res['str_email1'];
        
        // Inicia a query
        require 'mautic-conn.php';
        
        $sql = "SELECT id FROM leads WHERE email LIKE '{$email}'";
        
        $query = $conn -> query($sql);
            
        // Se o Funcionário existe, retorna o ID do mesmo de acordo com o Mautic
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $conn -> close();
        
        return $res['id'];
    }

    // Retorna a tag/relacionamento do contato no Mautic de acordo com o id do contato no Mautic
    function get_lead_tag_by_lead_id_mautic($lead_id){
        // Inicia a query
        require 'mautic-conn.php';
        
        $sql = "SELECT tag FROM lead_tags WHERE id = '{$lead_id}'";
        
        $query = $conn -> query($sql);
            
        // Se o Funcionário existe, retorna o ID do mesmo de acordo com o Mautic
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $conn -> close();
        
        return $res['tag'];
    }
    
    // Retorna o nome completo do estado de acordo com a UF do contato no Organizer
    function get_estado($uf){
        $uf = strtoupper($uf);
        
        $sigla = array();
        $sigla[] = 'AC';
        $sigla[] = 'AL';
        $sigla[] = 'AP';
        $sigla[] = 'AM';
        $sigla[] = 'BA';
        $sigla[] = 'CE';
        $sigla[] = 'DF';
        $sigla[] = 'ES';
        $sigla[] = 'GO';
        $sigla[] = 'MA';
        $sigla[] = 'MT';
        $sigla[] = 'MS';
        $sigla[] = 'MG';
        $sigla[] = 'PA';
        $sigla[] = 'PB';
        $sigla[] = 'PR';
        $sigla[] = 'PE';
        $sigla[] = 'PI';
        $sigla[] = 'RJ';
        $sigla[] = 'RN';
        $sigla[] = 'RS';
        $sigla[] = 'RO';
        $sigla[] = 'RR';
        $sigla[] = 'SC';
        $sigla[] = 'SP';
        $sigla[] = 'SE';
        $sigla[] = 'TO';
        
        $nome = array();
        $nome[] = 'Acre';
        $nome[] = 'Alagoas';
        $nome[] = 'Amapa';
        $nome[] = 'Amazonas';
        $nome[] = 'Bahia';
        $nome[] = 'Ceara';
        $nome[] = 'Distrito Federal';
        $nome[] = 'Espirito Santo';
        $nome[] = 'Goias';
        $nome[] = 'Maranhao';
        $nome[] = 'Mato Grosso';
        $nome[] = 'Mato Grosso do Sul';
        $nome[] = 'Minas Gerais';
        $nome[] = 'Para';
        $nome[] = 'Paraiba';
        $nome[] = 'Parana';
        $nome[] = 'Pernambuco';
        $nome[] = 'Piaui';
        $nome[] = 'Rio de Janeiro';
        $nome[] = 'Rio Grande do Norte';
        $nome[] = 'Rio Grande do Sul';
        $nome[] = 'Rondonia';
        $nome[] = 'Roraima';
        $nome[] = 'Santa Catarina';
        $nome[] = 'Sao Paulo';
        $nome[] = 'Sergipe';
        $nome[] = 'Tocantins';
        
        for($i = 0; $i < count($nome); $i++){
            if($uf == $sigla[$i]){
                return $nome[$i];
            }
        }
    }
    
    // Retorna a id do contato no Organizer de acordo com o email correspondente
    function get_contato_id_organizer($email){
        require 'organizer-conn.php';
        
        $sql = "SELECT id FROM tb_contato WHERE str_email1 LIKE '{$email}'";
        $query = $organizer -> query($sql);
        $data = $query -> fetch_array(MYSQLI_BOTH);
        $organizer -> close();
        
        return $data['id'];
    }

    // Retorna o email do contato no Organizer de acordo com o id correspondente
    function get_contato_email_organizer($id){
        require 'organizer-conn.php';
        
        $sql = "SELECT str_email1 FROM tb_contato WHERE id = '{$id}'";
        $query = $organizer -> query($sql);
        $data = $query -> fetch_array(MYSQLI_BOTH);
        $organizer -> close();
        
        return $data['str_email1'];
    }
    
    // Retorna a tag do Mautic correspondente ao relacionamento do contato no Organizer
    //    Se a tag/relacionamento existe, retorna o id dela no Mautic
    //    Senão, cria a tag e retorna a id correspondente
    function check_tag_mautic($relacionamento){
        require 'organizer-conn.php';
        
        // Recupera o tipo de relacionamento no Organizer de acordo com o id correspondente
        $sql = "SELECT str_nome FROM tb_contato_tipo WHERE id = '{$relacionamento}'";
        $query = $organizer -> query($sql);
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $organizer -> close();
        
        $tag = $res['str_nome'];
        
        // Inicia a query
        require 'mautic-conn.php';
        
        $sql = "SELECT id FROM lead_tags WHERE tag LIKE '{$tag}'";
        $query = $conn -> query($sql);
        
        // Se a tag/relacionamento existe no Mautic
        if($res = $query -> fetch_array(MYSQLI_BOTH)){
            // Retorna a id da mesma 
            return $res['id'];
        // Senão, cria a tag/relacionamento
        } else{
            $sql = "INSERT INTO lead_tags (tag) VALUES('{$tag}')";
            $conn -> query($sql);
            
            $sql = "SELECT id FROM lead_tags WHERE tag LIKE '{$tag}'";
            $query = $conn -> query($sql);
            $res = $query -> fetch_array(MYSQLI_BOTH);
            
            return $res['id'];
        }
    }

?>