<?php
    
    $vogais = array("/Á/", "/á/", "/Ã/", "/ã/", "/Â/", "/â/", "/É/", "/é/", "/Ê/", "/ê/", "/Í/", "/í/", "/Ó/", "/ó/", "/Ô/", "/ô/", "/Õ/", "/õ/", "/Ú/", "/ú/");
    $subs = array("A", "a", "A", "a", "A", "a", "E", "e", "E", "e", "I", "i", "O", "o", "O", "o", "O", "o", "U", "u");

    function empresa($id){
        $nome_empresa = sqlValue("SELECT `str_nome_fantasia` FROM `tb_empresa` WHERE id='{$id}'", $eo);
    
        return $nome_empresa;
    }

    function relacao($id){
        $rel = sqlValue("SELECT `str_nome` FROM `tb_contato_tipo` WHERE id='{$id}'", $eo);
        return $rel;
    }

    function valida_empresa($nome_empresa){
        require 'mautic-conn.php';
                
        $sql = "SELECT companyname FROM companies WHERE companyname LIKE '{$nome_empresa}'";
        
        $query = $conn -> query($sql);
            
        // Se a empresa existe, retorna o nome da mesma de acordo com o Mautic
        if($res = $query -> fetch_array(MYSQLI_BOTH)){
            $conn -> close();
            
            return $res["companyname"];

        // Senão, cria a empresa no Mautic
        } else{

            // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
            $empt = array();
            $empt = serialize($empt);

            $timestamp = date('Y-md H:i:s', time());

            // Inicio da Query
            $sql = "INSERT INTO `companies` (`owner_id`,`is_published`,`date_added`,`created_by`,`created_by_user`,`checked_out`,`checked_out_by`,`checked_out_by_user`,`social_cache`,`score`,`companyname`) VALUES (1, 1, '{$timestamp}', 1, 'admin admin', '{$timestamp}', 1, 'admin admin', '{$empt}', 0, '{$nome_empresa}')";

            $conn -> query($sql);
            $conn -> close();

            return $nome_empresa;
        }
    }

    function empresa_id($nome_empresa){
        require 'mautic-conn.php';
        
        $sql = "SELECT id FROM companies WHERE companyname LIKE '{$nome_empresa}'";
        
        $query = $conn -> query($sql);
            
        // Se a Empresa existe, retorna o ID da mesma de acordo com o Mautic
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $conn -> close();
        
        return $res["id"];
    }

    function funcionario_id($nome_func, $snome_func, $empr_func){
        require 'mautic-conn.php';
        
        $sql = "SELECT id FROM leads WHERE firstname LIKE '{$nome_func}' AND lastname LIKE '{$snome_func}' AND company LIKE '{$empr_func}'";
        
        $query = $conn -> query($sql);
            
        // Se o Funcionário existe, retorna o ID do mesmo de acordo com o Mautic
        $res = $query -> fetch_array(MYSQLI_BOTH);
        $conn -> close();
        
        return $res["id"];
    }
    
    function estado($uf){
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

?>