<?php
session_start();
include '../conexao.php';
if(!$conecta){
	$_SESSION['resposta'] = "<font color='red'>SQL ERROR = ".$conecta->errorInfo()."</font>";
} else {
	
	if(isSet($_GET['pesqCpf']) && $_GET['pesqCpf'] != ''){
		$pesqCpf = $_GET['pesqCpf'];
		$sql = "SELECT cpf,nome FROM clientes WHERE cpf = '$pesqCpf';
		$query_select = $conecta->prepare($sql);
		$query_select->execute();
		if($query_select){
			$_SESSION['cliente'] = $query_select->fetchAll(PDO::FETCH_ASSOC);
			if(strlen($_SESSION['cliente'][0]) == 0){
				$_SESSION['resposta'] = '<font color=red>CPF n�o � v�lido</font>';
			}
		}
				
	} else {
		$_SESSION['resposta'] = '<font color=red>O campo CPF � obrigat�ria</font>';
	}
}
 
header('Location:../control/cadastrarLocacao.php');
?>