<?php
session_start();
unset($_SESSION['cliente']);
unset($_SESSION['filmesLocados']);
unset($_SESSION['pesqFilme']);
header('Location:cadastrarLocacao.php');
?>