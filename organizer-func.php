<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    define('PREPEND_PATH', '');
	$hooks_dir = dirname(__FILE__);
	include("$hooks_dir/defaultLang.php");
	include("$hooks_dir/language.php");
	include("$hooks_dir/lib.php");

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
        
        $estados = array(
            [0] => array('AC','Acre'),
            [1] => array('AL','Alagoas'),
            [2] => array('AP','Amapa'),
            [3]'AM'=>'Amazonas',
            [3]'BA'=>'Bahia',
            [3]'CE'=>'Ceara',
            [3]'DF'=>'Distrito Federal',
            [3]'ES'=>'Espirito Santo',
            [3]'GO'=>'Goias',
            [3]'MA'=>'Maranhao',
            [3]'MT'=>'Mato Grosso',
            [3]'MS'=>'Mato Grosso do Sul',
            [3]'MG'=>'Minas Gerais',
            [3]'PA'=>'Para',
            [3]'PB'=>'Paraiba',
            [3]'PR'=>'Parana',
            [3]'PE'=>'Pernambuco',
            [3]'PI'=>'Piaui',
            [3]'RJ'=>'Rio de Janeiro',
            [3]'RN'=>'Rio Grande do Norte',
            [3]'RS'=>'Rio Grande do Sul',
            [3]'RO'=>'Rondonia',
            [3]'RR'=>'Roraima',
            [3]'SC'=>'Santa Catarina',
            [3]'SP'=>'Sao Paulo',
            [3]'SE'=>'Sergipe',
            [3]'TO'=>'Tocantins'
        );
        
        foreach($estado as $campo => $valor){
            if($uf == $estado[$campo]){
                return $valor;
            }
        }
    }


?>