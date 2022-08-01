<?php 
include '../style.php'; 
include '../js.php';
include '../conexao.php'; 
?>
<html>
<title>Editar Cliente - Locadora Gerson de Filmes</title>
<body>
	<h1 align="center">Editar Cliente - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		 
			
		$cpf = '';
		$nome = '';
		$dia = '1';
		$mes = '1';
		$ano = '2013';
		$endereco = '';
		$telefone = '';
		if(isSet($_GET['cpf'])){
			$cpf = $_GET['cpf'];
			$nome = $_GET['nome'];
			$endereco = $_GET['endereco'];
			$telefone = '';
			if(isSet($_GET['ddd'])){
				$ddd = $_GET['ddd'];
				$fone = $_GET['fone'];
				$telefone = $_GET['ddd'] . $_GET['fone'];
			} else {
				$telefone = $_GET['telefone'];
				$ddd = substr($telefone,0,2);
				$fone = substr($telefone,2);
			}
			if(isSet($_GET['data_nascimento'])){
				$dtN = $_GET['data_nascimento'];
				$dia = date('d',strtotime($dtN));
				$mes = date('m',strtotime($dtN));
				$ano = date('Y',strtotime($dtN));
			} else {
				$dia = $_GET['dia'];
				$mes = $_GET['mes'];
				$ano = $_GET['ano'];
			}
		}
		if(isSet($_GET['alterar'])){
			
			if($conecta){
				$data_nascimento = $_GET['ano'] . '-' .$_GET['mes'] . '-' .$_GET['dia'];
				
				$result = "UPDATE clientes SET nome=".$nome.",data_nascimento=".$data_nascimento.",
					endereco=".$endereco.",telefone=".$telefone." WHERE cpf=".$cpf;
					
				$query_select = $conecta->prepare($result);
				$query_select->execute();	
				if($query_select){
					echo "<font color='lime'>CLIENTE $nome ATUALIZADO COM SUCESSO!</font> <br/><br/>";
				} else {
					echo "<font color='red'>CLIENTE $nome NÃO PODE SER ATUALIZADO! ERROR = ".$conecta->errorInfo()."</font><br/><br/>";
				}
			}
		}
		
		echo "
		<form action='".$_SERVER['PHP_SELF']."'>
		<table>
			<tr>
				<td>
					CPF
				</td>
				<td>
					<input type='text' name='cpf' value = '$cpf' readonly='readonly'/>
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
					Data de Nascimento
				</td>
				<td>
				<select name='dia'>";
							for($i = 1;$i<=31;$i++){
								if($i == $dia){
									echo "<option value='$i' selected>$i</option>";
								} else {
									echo "<option value='$i'>$i</option>";
								}
							}
						echo '</select>';
						echo "<select name='mes'>";
							for($i = 1;$i<=12;$i++){
								if($i == $mes){
									echo "<option value='$i' selected>$i</option>";
								} else {
									echo "<option value='$i'>$i</option>";
								}
							}
						echo '</select>';	
						echo "<select name='ano'>";
							for($i = 1900;$i<=2022;$i++){
								if($i == $ano){
									echo "<option value='$i' selected>$i</option>";
								} else {
									echo "<option value='$i'>$i</option>";
								}
							}
						echo "
						<option value='2023' selected>2023</option>;
						</select>
				</td>
			</tr>
			<tr>
				<td>
					Endereço
				</td>
				<td>
					<input type='text' name='endereco' value = '$endereco'/>
				</td>
			</tr>
			<tr>
				<td>
					Telefone
				</td>
				<td>
					<input type='text' name='ddd' value='$ddd' maxlength=2 size=2 onkeypress=\"return mascara(this,'##')\"/>
					<input type='text' name='fone' value='$fone' maxlength=8 size=11 onkeypress=\"return mascara(this,'########')\"/>
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
		 
</body>
</html>