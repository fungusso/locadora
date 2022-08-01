<?php 
include '../style.php';
include '../conexao.php';       
 ?>
<html>

<title>Editar Filme - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	<h1 align="center">Editar Filme - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
 	
		$cod = '';
		$nome = '';
		$qtd = '';
		$cod_categoria1 = '';
		$cod_categoria2 = '';
		$cod_categoria3 = '';
		
		if(isSet($_GET['cod'])){
			$cod = $_GET['cod'];
			$nome = $_GET['nome'];
			$qtd = $_GET['qtd'];
			$cod_categoria1 = $_GET['cod_categoria1'];
			$cod_categoria2 = $_GET['cod_categoria2'];
			$cod_categoria3 = $_GET['cod_categoria3'];
			
		}
		if(isSet($_GET['alterar'])){
			
			$sql = "UPDATE filmes SET nome='$nome',qtd='$qtd',categoria1='$cod_categoria1',categoria2='$cod_categoria2',categoria3='$cod_categoria3' WHERE cod='$cod'";
			if($conecta){
				$query_select = $conecta->prepare($sql);
				$query_select->execute();
				 
				if($query_select){
					echo "<font color='lime'>Filme $nome atualizado com sucesso!</font> <br/><br/>";
				} else {
					echo "<font color='red'>Filme $nome não pode ser atualizado! ERROR = ".$conecta->errorInfo()."</font><br/><br/>";
					echo $sql;
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
					Quantidade
				</td>
				<td>
					<input type='text' name='qtd' value = '$qtd'/>
				</td>
			</tr>";
			
			$categorias = array();
			
			$result = "SELECT cod,nome FROM categorias";
			$query_select = $conecta->prepare($result);
			$query_select->execute();
			while(list($cod,$nome) = $query_select->fetchAll(PDO::FETCH_ASSOC)){
				$categorias[] = $cod;
				$categorias[] = $nome;
			}
			if($conexao && $result){
			echo "
				<tr>
					<td>
						Categoria1
					</td>
					<td>
						<select name='cod_categoria1'>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								if($cod_categoria1 == $categorias[$i]){
									echo "<option value=$categorias[$i] selected>$categorias[$j]</option>";
								} else {
									echo "<option value=$categorias[$i]>$categorias[$j]</option>";
								}
							}
							
						echo "</select>
					</td>
				</tr>
			";
			echo "
				<tr>
					<td>
						Categoria 2
					</td>
					<td>
						<select name='cod_categoria2'>
							<option value=null>selecione</option>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								if($cod_categoria2 == $categorias[$i]){
									echo "<option value=$categorias[$i] selected>$categorias[$j]</option>";
								} else {
									echo "<option value=$categorias[$i]>$categorias[$j]</option>";
								}
							}
							
						echo "</select>
					</td>
				</tr>
			";
			echo "
				<tr>
					<td>
						Categoria 3
					</td>
					<td>
						<select name='cod_categoria3'>
							<option value=null>selecione</option>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								if($cod_categoria3 == $categorias[$i]){
									echo "<option value=$categorias[$i] selected>$categorias[$j]</option>";
								} else {
									echo "<option value=$categorias[$i]>$categorias[$j]</option>";
								}
							}
							
						echo "</select>
					</td>
				</tr>
			";
			} else {
				echo "<font color='red'>SQL ERROR = ".$conecta->errorInfo()."</font>";
			}
		

			
			echo "<tr>
				<td>
				</td>
				<td>
					<input type='hidden' name='categoria1' value='$cod_categoria1'/>
					<input type='hidden' name='categoria2' value='$cod_categoria2'/>
					<input type='hidden' name='categoria3' value='$cod_categoria3'/>
					<input type='hidden' name='alterar' value='true'/>
					<button>Salvar</button>
				</td>
			</tr>
		</table>
		</form>";
		 
	?>
</body>
</html>