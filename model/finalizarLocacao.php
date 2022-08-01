<?php
	include '../menu.php';
	include '../conexao.php';
	session_start();
	$data_entrega = date('Y-m-d H:i:s');
	$cod_locacao = $_GET['cod'];
	 
				if($conecta){
					$sql = "UPDATE locacoes SET data_entrega = '$data_entrega' WHERE cod = '$cod_locacao';
					$query_select = $conecta->prepare($sql);
					$query_select->execute();
					 
					if($query_select){
						$_SESSION['resposta'] = "<font color='lime'>Locação $cod_locacao entrege as $data_entrega com sucesso!</font>";
					} else {
						$_SESSION['resposta'] = mysql_error() . '<br/>' . $sql;
				 		header('Location:../view/locacoes.php');
						exit();
					}
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
					 
					header('Location:../view/locacoes.php');
					exit();
				}
				$_SESSION['resposta'] = $sql;
				 
	
	header('Location:../view/locacoes.php');
?>