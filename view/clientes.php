<?php include '../style.php';
      include '../conexao.php';
 ?>
<html>

<title>Clientes - Locadora Gerson de Filmes</title>
<body>
	
	<h1 align="center">Clientes - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<div style="background-color:green">
	<form action = "/view/clientes.php">
		<h6>
			<b>Pesquisar por:</b>
			<?php
				$tipoPesq = '';
				$pesq = '';
				if(isSet($_GET['tipoPesq'])){
					$tipoPesq = $_GET['tipoPesq'];
				}
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
					switch($tipoPesq){
						case 'cpf':{
						echo '
							<input type="radio" name="tipoPesq" value = "nome"/>Nome
							<input type="radio" name="tipoPesq" value = "cpf" checked="checked"/>CPF 
							<input type="radio" name="tipoPesq" value = "telefone"/>Telefone <br/>';
							break;
						}
						case 'telefone':{
						echo '
							<input type="radio" name="tipoPesq" value = "nome" checked="checked"/>Nome
							<input type="radio" name="tipoPesq" value = "cpf"/>CPF 
							<input type="radio" name="tipoPesq" value = "telefone" checked="checked"/>Telefone <br/>';	
							break;
						}
						default:{
							echo '
							<input type="radio" name="tipoPesq" value = "nome" checked="checked"/>Nome
							<input type="radio" name="tipoPesq" value = "cpf"/>CPF 
							<input type="radio" name="tipoPesq" value = "telefone"/>Telefone <br/>';
							break;
						}
					}
				
				
				echo "<input type='text' name='pesq' value='$pesq' autofocus/>";
				
			?>
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	
	<a href="/control/cadastrarCliente.php"><button>Novo Cliente</button></a>
	
	<hr/>
	<?php
		 
			
		if(isSet($_GET['cpf'])){
			$cpf = $_GET['cpf'];
			$nome = $_GET['nome'];
			
			$resultExcluir = "DELETE FROM clientes WHERE cpf = '$cpf'";
			$query_select = $conecta->prepare($resultExcluir);
 			$query_select->execute();
			if($query_select){
				echo "<font color='lime'>CLIENTE $nome EXCLUIDO COM SUCESSO!</font> <br/><br/>";
			} else {
				echo "FALHA NA EXCLUSÃO! " . $conecta->errorInfo();
			}
		
		}
		
		$pesq = '';
		$tipoPesq = '';
			
		if(isSet($_GET['pesq'])){
			$pesq = $_GET['pesq'];
			$tipoPesq = $_GET['tipoPesq'];
		}
		if($conecta){
			$result;
			if($pesq == ''){
				$result = "SELECT cpf,nome,data_nascimento,endereco,telefone
				FROM clientes ORDER BY nome LIMIT 15";
			} elseif($tipoPesq == 'nome'){
				$result = "SELECT cpf,nome,data_nascimento,endereco,telefone
				FROM clientes WHERE '$tipo' Pesq like '$pesq'% ORDER BY '$tipoPesq' LIMIT 15";
			} else {
				$result = "SELECT cpf,nome,data_nascimento,endereco,telefone
				FROM clientes WHERE '$tipoPesq' = '$pesq' LIMIT 10";
			}
			$query_select = $conecta->prepare($result);
 			$query_select->execute();
			if($query_select){
							
			echo "<table border=1>
			<tr>
				<td>
					<b>CPF</b>
				</td>
				<td>
					<b>Nome</b>
				</td>
				<td>
					<b>Data Nascimento</b>
				</td>
				<td>
					<b>Endereco</b>
				</td>
				<td>
					<b>Telefone</b>
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
						".$row['cpf']."
					</td>
					<td>
						".$row['nome']."
					</td>
					<td>
						".date("d-m-Y", strtotime($row['data_nascimento']))."
					</td>
					<td>
						".$row['endereco']."
					</td>
					<td>
						".$row['telefone']."
					</td>
					<td>
						<form action='".$_SERVER['PHP_SELF']."'>
							<input type='hidden' name='cpf' value = '".$row['cpf']."'/>
							<input type='hidden' name='nome' value = '".$row['nome']."'/>
							<input type='hidden' name='pesq' value = '$pesq'/>
							<input type='hidden' name='tipoPesq' value = '$tipoPesq'/>
							<button>Delete</button>
						</form>
					</td>
					<td>
						<form action='/control/editarCliente.php'>
							<input type='hidden' name='cpf' value = '".$row['cpf']."'/>
							<input type='hidden' name='nome' value = '".$row['nome']."'/>
							<input type='hidden' name='data_nascimento' value = '".$row['data_nascimento']."'/>
							<input type='hidden' name='endereco' value = '".$row['endereco']."'/>
							<input type='hidden' name='telefone' value = '".$row['telefone']."'/>
							
							<button>Editar</button>
						</form>
					</td>
				</tr>";
				}
				echo '</table>';
				} else {
					echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
				}
			} else {
				echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
			}
		
	?>
</body>
</html>