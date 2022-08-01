<?php include '../style.php';
      include '../conexao.php';
 ?>
<html>

<title>Categorias - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	
	<h1 align="center">Categorias - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<div style="background-color:green">
	<form action = "/view/categorias.php">
		<h6>
			<b>Pesquisar:</b>
			<?php
				$pesq = '';
				
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
				echo "<input type='text' name='pesq' value='$pesq' autofocus/>";
				
			?>
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	
	<a href="/control/cadastrarCategoria.php"><button>Nova Categoria</button></a>
	
	<hr/>
	<?php
		 
			
		if($conecta){
			if(isSet($_GET['cod'])){
				$cod = $_GET['cod'];
				$nome = $_GET['nome'];
				
				$resultExcluir = "DELETE FROM categorias WHERE cod = ".$cod;
				if($resultExcluir){
					echo "<font color='lime'>Categoria $nome deletada com sucesso!</font> <br/><br/>";
				} else {
					$erro = $conecta->errorInfo();
					$errofk_categoria_esta_sendo_usada = "Cannot delete or update a parent row: a foreign key constraint fails (`locadora`.`filmes`, CONSTRAINT `fk_filmes_categoria1_categorias_cod` FOREIGN KEY (`categoria1`) REFERENCES `categorias` (`cod`))";
					if($erro == $errofk_categoria_esta_sendo_usada){
						echo "<font color='red'>Categoria $nome não pode ser deletada existe um ou mais filmes utilizando esta categoria</font> <br/><br/>";
					} else {
						echo "FALHA NA EXCLUSÃO! " . $conecta->errorInfo();
					}
				}
			}
			$pesq = '';
			if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
			}
				$result = "SELECT cod,nome FROM categorias WHERE nome like '$pesq'+'%' ORDER BY nome";
				$query_select = $conecta->prepare($result);
				$query_select->execute();
			//	var_dump($query_select);
				
				if($query_select){
					echo "<table border=1>
					<tr>
						<td>
							<b>C&oacutedigo</b>
						</td>
						<td>
							<b>Nome</b>
						</td>
						<td>
							<b>Delete</b>
						</td>
						<td>
							<b>Editar</b>
						</td>
					</tr>";
					while($row = $query_select->fetchAll(PDO::FETCH_ASSOC)){
						echo "
						<tr>
							<td>
								".$row['cod']."
							</td>
							<td>
								".$row['nome']."
							</td>
							<td>
								<form action='".$_SERVER['PHP_SELF']."'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<input type='hidden' name='pesq' value = '".$pesq."'/>
									<button>Delete</button>
								</form>
							</td>
							<td>
								<form action='/control/editarCategoria.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<button>Editar</button>
								</form>
							</td>
						</tr>";
					}
					echo '</table>';
				} else {
					echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
				}
				
		}else {
			echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
		}
		 
	?>
</body>
</html>