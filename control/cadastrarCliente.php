<?php 
include '../style.php'; 
include '../js.php';
include '../conexao.php';
?>
<html>

<title>Cadastrar Cliente - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	<h1 align="center">Cadastrar Cliente - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
			if(isSet($_GET['cpf'])){
				$cpf = $_GET['cpf'];
				$nome = $_GET['nome'];
				$data_nascimento = $_GET['ano'] . '-' . $_GET['mes'] . '-' . $_GET['dia'];
				$endereco = $_GET['endereco'];
				$fone = $_GET['ddd'] . "" .$_GET['telefone'];
				
				if($cpf != ''){
					 
					if($conecta){
						$result =  "INSERT INTO clientes (cpf,nome,data_nascimento,endereco,telefone)
							VALUES ('$cpf','$nome','$data_nascimento','$endereco','$fone')";
						$query_select = $conecta->prepare($result);
				        $query_select->execute();	
						if($query_select){
							echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
						} else {
							$error = $conecta->errorInfo();
							$error = substr($error,0,strlen('Duplicate entry'));
							$duplicadaPK = "Duplicate entry";	
						
							if($error == $duplicadaPK){
								echo "<font color='red'>O CPF $cpf já existe!</font>";
							} else {
								echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
							}
						}
					} else {
						echo "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
					}
					 
				} else {
					echo "<font color='red'>CPF é obrigat&oacuterio!!!</font>";
				}
				
			} 
	?>
	
	<form action='/control/cadastrarCliente.php'>
	<table>
		<tr>
			<td>
				CPF
			</td>
			<td>
				<input type='text' name='cpf' onkeypress="return mascara(this, '###.###.###-##')" maxlength="14" autofocus/>
			</td>
		</tr>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type='text' name='nome'/>
			</td>
		</tr>
		<tr>
			<td>
				Data de Nascimento
			</td>
			<td>
				<?php
					echo "<select name='dia'>";
						for($i = 1;$i<=31;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';
					echo "<select name='mes'>";
						for($i = 1;$i<=12;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';	
					echo "<select name='ano'>";
						for($i = 1900;$i<=2022;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo "
					<option value='2023' selected>2023</option>;
					</select>";
				?>
			</td>
		</tr>
		<tr>
			<td>
				Endereço
			</td>
			<td>
				<input type='text' name='endereco'/>
			</td>
		</tr>
		<tr>
			<td>
				Telefone
			</td>
			<td>
				<input type='text' name='ddd' size="2" maxlength="2" onkeypress="return mascara(this,'##')"/>
				<input type='text' name='telefone' size="11" maxlength="8" onkeypress="return mascara(this,'########')"/>
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