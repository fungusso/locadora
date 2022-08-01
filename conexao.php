<?php 
	define('HOST','localhost');
    define('DB', 'locadora');
    define('USER','root');
    define('PASS','');

    $conexao = 'mysql:host='.HOST.';dbname='.DB.';';

	try{
		$conecta = new PDO($conexao,USER,PASS);
		$conecta->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		}catch(PDOException $error_conexao){
		echo 'Erro ao tentar estabelecer a conexao: '.$error_conexao->getMessage();
		}	
?>