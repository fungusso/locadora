<?php 
include '../style.php'; 
include '../js.php';
include '../conexao.php';
?>

<html>
<title>Cadastrar Locação - Locadora Gerson de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	<h1 align="center">Cadastrar Locação - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';

		
		// exibe qualquer erro gerado durante qualquer evento
		if(isset($_SESSION['resposta'])){
			echo $_SESSION['resposta'].'<br/>';
			unset($_SESSION['resposta']);
		}
		
		
		 
		if(!$conecta){
			echo "<font color='red'>SQL ERROR = ".$conecta->errorInfo()."</font>";
		}
		
		$cpf_cliente = '';
		$nome_cliente = '';
		$data_locacao = date('d-m-Y H:i:s');
		$data_entrega_prevista = date('d-m-Y',strtotime($data_locacao.'+2 day'));
		$dia_entrega_prevista = date('d',strtotime($data_entrega_prevista));
		$mes_entrega_prevista = date('m',strtotime($data_entrega_prevista));
		$ano_entrega_prevista = date('Y',strtotime($data_entrega_prevista));
		
		$qtd_filmes = 0;
		$valor = 0;
		
		$pesqCpf = '';
		$pesqFilme = '';
		
		if(isset($_SESSION['cliente'])){
			$cpf_cliente = $_SESSION['cliente'][0];
			$nome_cliente = $_SESSION['cliente'][1];
		}
		if(isset($_SESSION['filmesLocados']['size'])){
			$qtd_filmes = $_SESSION['filmesLocados']['size'];
			$valor = $qtd_filmes * 2;
		}
		// alerta caso o usuario tente adicionar um filme sem adicionar o cliente
		if(isSet($_GET['pesqFilme']) && $cpf_cliente == 'xxx.xxx.xxx-xx'){
			echo "<font color='red'>Selecione o cliente primeiro!</font>";
		} 
		
		
		echo "<div id='pesquisa'>
		<table>
			<tr>
				<td>
					<form action = '../model/selecionaCliente.php'>
							
						<b>CPF do Cliente:</b>";
							// formulario de pesquisar cpf
							if(isset($_SESSION['cliente'])){
								echo "<input type='text' name='pesqCpf' value='$cpf_cliente' onkeypress=\"return mascara(this,'###.###.###-##')\" maxlength = '14'/>";
							} else {
								echo "<input type='text' name='pesqCpf' onkeypress=\"return mascara(this,'###.###.###-##')\" maxlength = '14' autofocus/>";
							}
						echo "
						<button>Selecionar</button>
					</form>
				</td>
				<td width=36>
				</td>
				<td>
					<form action = '../model/selecionaFilme.php'>
							<b>Pesquisar Filme por:</b>";
							// formulario de pesquisar filmes
								$tipoPesq = '';
								$pesqFilme = '';
								
								if(isSet($_SESSION['cliente']) && isSet($_SESSION['pesqFilme'])){
										
									$tipoPesq = $_SESSION['pesqFilme']['tipoPesq'];
								
									switch($tipoPesq){
										case 'cod':{
										echo "
										<input type='radio' name='tipoPesq' value = 'nome'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod' checked='checked'/>C&oacutedigo 
										<input type='radio' name='tipoPesq' value = 'categoria'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme' autofocus/>";
											break;
										}
										case 'categoria':{
										echo "
										<input type='radio' name='tipoPesq' value = 'nome'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod'/>C&oacutedigo 
										<input type='radio' name='tipoPesq' value = 'categoria' checked='checked'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme' autofocus/>";	
											break;
										}
										default:{
											echo "
										<input type='radio' name='tipoPesq' value = 'nome' checked='checked'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod'/>C&oacutedigo 
										<input type='radio' name='tipoPesq' value = 'categoria'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme' autofocus/>";
											break;
										}
									}
								} else {
									echo "
										<input type='radio' name='tipoPesq' value = 'nome' checked='checked'/>Nome
										<input type='radio' name='tipoPesq' value = 'cod'/>C&oacutedigo 
										<input type='radio' name='tipoPesq' value = 'categoria'/>Categoria <br/>
										<input type='text' name='pesqFilme' value='$pesqFilme'/>";
								}
								
								echo "
								<button>Pesquisar</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
	
		<div id='dados_locacao'>";
			
				// dados da locação
				echo "<form action='registrarLocacao.php'>
				<table>
					<tr>
						<td>
							CPF do Cliente
						</td>
						<td>
							<b><font size=5>$cpf_cliente</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Nome do Cliente
						</td>
						<td>
							<b><font size=5>$nome_cliente</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Data da Locação
						</td>
						<td>
							<b><font size=5>$data_locacao</font></b>
							<input type='hidden' name='data_locacao' value='$data_locacao'>
						</td>
					</tr>
					<tr>
						<td>
							Data da Entrega
						</td>
						<td>";
							
							echo "<select name='dia_entrega'>";
								for($i = 1;$i<=31;$i++){
									if($i == $dia_entrega_prevista){
										echo "<option value='$i' selected>$i</option>";
									} else {
										echo "<option value='$i'>$i</option>";
									}
								}
							echo '</select>';
							echo "<select name='mes_entrega'>";
								for($i = 1;$i<=12;$i++){
									if($i == $mes_entrega_prevista){
										echo "<option value='$i' selected>$i</option>";
									} else {
										echo "<option value='$i'>$i</option>";
									}
								}
							echo '</select>';	
							echo "<select name='ano_entrega'>";
								for($i = date(Y);$i<=(date(Y)+1);$i++){
									echo "<option value='$i'>$i</option>";
								}
							echo "
							</select>";
						echo "</td>
					</tr>
					<tr>
						<td>
							Quantidade de Filmes
						</td>
						<td>
							<b><font size=5>$qtd_filmes</font></b>
						</td>
					</tr>
					<tr>
						<td>
							Valor R$
						</td>
						<td><b><font size=5>";
							echo number_format($valor,2,',','.');
						echo "</font></b></td>
						<input type='hidden' name='valor' value='$valor'/>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<button>Registrar</button>
							<button type='reset'>Limpar</button>
						</td>
					</tr>
				</table>
				</form>";
				
		// FILMES PESQUISADOS
		echo "</div>
		<div id='pesquisa_filmes' height=550px;>
			<b>Filme</b>";
			
			echo "<table border=1>
					<tr>
						<td>
							<b>C&oacutedigo</b>
						</td>
						<td>
							<b>Nome</b>
						</td>
						<td>
							<b>Quantidade</b>
						</td>
						<td>
							<b>Categoria1</b>
						</td>
						<td>
							<b>Categoria2</b>
						</td>
						<td>
							<b>Categoria3</b>
						</td>
						<td>
							<b>Adicionar</b>
						</td>
					</tr>";
			if(isSet($_SESSION['pesqFilme']['result'])){
				$size = $_SESSION['pesqFilme']['size'];
				for($i = 0; $i < $size = $_SESSION['pesqFilme']['size']; $i++){
				
					$filmes = $_SESSION['pesqFilme']['result'][$i];
						
					echo "<tr>
							<td>
								".$filmes[0]."
							</td>
							<td>
								".$filmes[1]."
							</td>
							<td>
								".$filmes[2]."
							</td>
							<td>
								".$filmes[3]."
							</td>
							<td>
								".$filmes[4]."
							</td>
							<td>
								".$filmes[5]."
							</td>
							<td>
								<form action='../model/addFilmeLocacao.php' method='get'>
									<input type='hidden' name='codFilme' value = '".$filmes[0]."'/>
									<button>Adicionar</button>
								</form>
							</td>
							
						</tr>";
						
					}
					echo '</table>';
					
				}
					
		echo "</table>
		</div>
	</div>
	Filmes Selecionado
	<div id='filmes_locados'>
		<table border=1>";
			
			echo "<tr>
					<td>
						<b>C&oacutedigo</b>
					</td>
					<td>
						<b>Filme</b>
					</td>
					<td>
						<b>Remover</b>
					</td>
				</tr>";	
			if(isset($_SESSION['filmesLocados'])){
				for($i = 0; $i < $_SESSION['filmesLocados']['size']; $i++){
					echo "<tr>
							<td>".
								$_SESSION['filmesLocados'][$i]['cod']
							."</td>
							<td>".
								$_SESSION['filmesLocados'][$i]['nome']
							."</td>
							<td>
								<form action='../model/removeFilmeLocacao.php'>
									<input type='hidden' name='position' value='$i'/>
									<button>Remover</button>
								</form>
							</td>
						</tr>";	
				}
			}			
			
			 
		?>
		</table>
	</div>
	
</body>
</html>