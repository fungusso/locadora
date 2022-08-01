<?php 
include '../style.php'; 
include '../js.php';
include '../conexao.php';
?>

<html>

<title>Cadastrar Filmes - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	<h1 align="center">Cadastrar Filmes - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		if(isSet($_GET['nome'])){
			$nome = $_GET['nome'];
			$qtd = $_GET['qtd'];
			$cod_categoria1 = $_GET['cod_categoria1'];
			$cod_categoria2 = $_GET['cod_categoria2'];
			$cod_categoria3 = $_GET['cod_categoria3'];
			$sql = "INSERT INTO filmes (nome,qtd,categoria1,categoria2,categoria3) VALUES ('$nome','$qtd','$cod_categoria1','$cod_categoria2','$cod_categoria3')";
			
			if($nome != ''){
				 
				if($conecta){
					$query_select = $conecta->prepare($sql);
				    $query_select->execute();
					if($query_select){
						echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
					} else {
						echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
					}
				} else {
					echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
				}
				 
			} else {
				echo "<font color='red'>Nome é obrigat&oacuterio!!!</font>";
			}
			
		}
	?>
	</div>
	<hr/>
	<form action='/control/cadastrarFilme.php'>
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
				Quantidade
			</td>
			<td>
				<input type='text' name='qtd' onkeypress="return mascara(this, '####')" maxlength="4"/>
			</td>
		</tr>
		<?php
			$categorias = array();
			$teste;
			 
			$result =  "SELECT cod,nome FROM categorias";
			$query_select = $conecta->prepare($result);
			$query_select->execute();
			while(list($cod,$nome) = $query_select->fetchAll(PDO::FETCH_ASSOC)){
				$categorias[] = $cod;
				$categorias[] = $nome;
			}
			if($conecta && $query_select){
			echo "
				<tr>
					<td>
						Categoria1
					</td>
					<td>
						<select name='cod_categoria1'>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
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
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
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
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			} else {
				echo "<font color='red'>SQL ERROR = ".$conecta->errorInfo()."</font>";
			}
		?>
		
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