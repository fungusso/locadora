<?php 
include '../style.php';
include '../conexao.php';
 ?>
<html>

<title>Cadastrar Categoria - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	<h1 align="center">Cadastrar Categoria - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		if(isSet($_GET['nome'])){
			$nome = $_GET['nome'];
			
			if($nome != ''){
				 
				if($conecta){
					
					$result = "INSERT INTO categorias (nome) VALUES ('$nome')";
					
					$query_select = $conecta->prepare($result);
				    $query_select->execute();
					if($query_select){
						echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
						
					} else {
						if("Duplicate entry" == substr($conecta->errorInfo(),0, strlen('Duplicate entry'))){
							echo "<font color='red'> A categoria ".$_GET['nome']." já existe</font>";
						} else {	
							echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
						}
						
					}
				} else {
					echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
				}
				 
			} else {
				echo "<font color='red'>Campo nome é obrigat&oacuterio!!!</font>";
			}
			
		}
	?>
	
	<form action='/control/cadastrarCategoria.php'>
	<table>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type='text' name='nome' autofocus/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<button>Cadastrar</button>
				<button type='reset'>Limpar</button>
			</td>
		</tr>
	</table>
	</form>
	
</body>
</html>