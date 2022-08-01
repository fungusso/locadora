<?php
	session_start();
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	
	//$sql = "SELECT login,nome FROM funcionario WHERE login = ".$login." AND  pass = ".$pass;
	
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
	
	//if(!$conn){
//		die("Falha na conexao: " . mysqli_connect_error());
//	}else{
//		echo "Conexao realizada com sucesso";
	
	
	//$conexao = mysql_connect('localhost:3306','root','');
	//mysql_select_db('locadora',$conexao);
	// check if connection failed
	 
		//$result = mysql_query($sql);
		$result = "SELECT login,nome FROM funcionario WHERE login = '$login' AND  pass = '$pass'";
		$query_select = $conecta->prepare($result);
//		echo "select construido 1 ".$sql_select;
		$query_select->execute();
		
		$rowcount = $query_select->rowCount();
				
	    if ($rowcount > 0) {
  	       $found = $query_select->fetchAll(PDO::FETCH_ASSOC);
		   var_dump($found);
		 
		 
			$_SESSION['logado']['login'] = $found[0];
			$_SESSION['logado']['nome'] = $found[1];
			
		} else {
			$_SESSION['resposta'] = "<font color='red'>Login ou Senha incorreto!</font>";
		}
	
	 
	
	header('Location:.');

?>