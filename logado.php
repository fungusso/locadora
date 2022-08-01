<?php
session_start();
 
if(!isset($_SESSION['logado'])){
	header('Location:/login.php');
	exit();
}
echo "<h2>Funcion&aacuterio: ".$_SESSION['logado']['nome']."</h2>";
?>