<?php
 include '../style.php';
 include '../conexao.php';
 ?>
<html>

<title>Editar Categoria - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	<h1 align="center">Editar Categoria - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		 		
		$cod = '';
		$nome = '';
		if(isSet($_GET['cod'])){
			$cod = $_GET['cod'];
			$nome = $_GET['nome'];
		}
		if(isSet($_GET['alterar'])){
			
			if($conecta){
				
				$result =  "UPDATE categorias SET nome='$nome' WHERE cod='$cod'";
				$query_select = $conecta->prepare($result);
				$query_select->execute();
				if($query_select){
					echo "<font color='lime'>Categoria $nome atualizada com sucesso!</font> <br/><br/>";
				} else {
					echo "<font color='red'>Categoria $nome não pode ser atualizada! ERROR = ".$conecta->errorInfo()."</font><br/><br/>";
				}
			}
		}
		
		echo "
		<form action='".$_SERVER['PHP_SELF']."'>
		<table>
			<tr>
				<td>
					C&oacutedigo
				</td>
				<td>
					<input type='text' name='cod' value = '$cod' readonly='readonly'/>
				</td>
			</tr>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type='text' name='nome' value = '$nome' autofocus/>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input type='hidden' name='alterar' value='true'/>
					<button>Salvar</button>
				</td>
			</tr>
		</table>
		</form>";
		 
	?>
</body>
</html>