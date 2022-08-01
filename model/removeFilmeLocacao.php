<?php

session_start();

	$position = $_GET['position'];
	$size = $_SESSION['filmesLocados']['size'];
	
	for($i = $position; $i < $size; $i++){
		$_SESSION['filmesLocados'][$i]['nome'] = $_SESSION['filmesLocados'][$i + 1]['nome'];
	}
	$_SESSION['filmesLocados']['size'] = $size - 1;
	if($_SESSION['filmesLocados']['size'] < 1){
		unset($_SESSION['filmesLocados']);
	}
header('Location:../control/cadastrarLocacao.php');
		
?>