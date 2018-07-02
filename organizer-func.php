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
        return rel;
    }

    function valida_empresa($nome_empresa){
        require 'mautic-conn.php';
                
        $stmt = $conn->prepare("SELECT companyname FROM companies WHERE companyname LIKE ?");
        $stmt -> bind_param('s', $nome_emp);
        
        $nome_emp = $nome_empresa;
        
        $stmt -> execute();
        $stmt -> bind_result($empresa_existe);
        $stmt -> fetch();
        
        $stmt -> close();
        
        // Se a empresa existe, retorna o nome da mesma de acordo com o Mautic
        if($empresa_existe){
            return $empresa_existe["companyname"];
            echo "Compania já existe<br/>";
        // Senão, cria a empresa no Mautic
        } else{            
            // Tempo para timestamp e array vazio serializado para funcionamento correto do Mautic
            $timestamp = new DateTime();
            $timestamp -> format('Y-m-d H:i:s');

            $empt = array();
            $empt = serialize($empt);
            
            // Inicio da Query
            $insert = $conn->prepare("INSERT INTO `companies` (`owner_id`,`is_published`,`date_added`,`created_by`,`created_by_user`,`checked_out`,`checked_out_by`,`checked_out_by_user`,`social_cache`,`score`,`companyname`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $insert -> bind_param("iisississis", $owner_id, $is_published, $date_added, $created_by, $created_by_user, $checked_out, $checked_out_by, $checked_out_by_user, $social_cache, $score, $comapanyname);
                        
            $owner_id = 1;
            $is_published = 1;
            $date_added = $timestamp;
            $created_by = 1;
            $created_by_user = 'admin admin';
            $checked_out = $timestamp;
            $checked_out_by = 1;
            $checked_out_by_user = 'admin admin';
            $social_cache = $empt;
            $score = 0;
            $companyname = $nome_empresa;
            var_dump($insert);
            $insert -> execute();
            echo "Executou<br/>";
            
            $insert -> close();
            
            echo $nome_empresa."<br/>";
            return $nome_empresa;
        }
    }
        
        
<<<<<<< HEAD
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


=======
>>>>>>> parent of 6551978... Primeira integração funcional
?>