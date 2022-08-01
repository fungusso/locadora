<?php 
include '../style.php';
include '../js.php'; 
include '../conexao.php';

?>


<html>

<title>Locaç&otildees - Sistema de Locadora de Filmes</title>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<body>
	
	<h1 align="center">Loca&ccedil&otildees - Locadora Gerson de Filmes<h1>
	
	<?php 
		include '../menu.php';

		if(isset($_SESSION['resposta'])){
			echo $_SESSION['resposta'].'<br/>';
			unset($_SESSION['resposta']);
		}
		
		echo "<div style='background-color:green'>
		<form action = '".$_SERVER['PHP_SELF']."'>
		<h6>";
			if(isset($_GET['fechados']) && $_GET['fechados'] == true){
				echo "<input type='checkbox' name='fechados' value='true' checked/>Incluir Loca&ccedil&atildeo Encerradas</br></br>";
			} else {
				echo "<input type='checkbox' name='fechados' value='true'/>Incluir Loca&ccedil&atildeo Encerradas</br></br>";
			}
		echo "<b>CPF do cliente:</b>";
			
				$pesq = '';
				
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
			echo "<input type='text' name='pesq' value='$pesq' onkeypress=\"return mascara(this,'###.###.###-##')\" maxlength = '14' autofocus/>
				
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	
	<a href='/control/novaLocacao.php'><button>Nova Loca&ccedil&atildeo</button></a>";
	
		if(isset($_SESSION['cliente'])){
			echo "<a href='/control/cadastrarLocacao.php'><button>Continuar Loca&ccedil&atildeo Anterior</button></a>";
		}
		echo "<hr/>";
	
	
		
			
		$pesq = '';
		
		if(isSet($_GET['pesq'])){
			$pesq = $_GET['pesq'];
		}
		if($pesq == ''){
			$sql = "SELECT cod,cpf_cliente,data_locacao,data_entrega_prevista,data_entrega,qtd_filmes,valor FROM locacoes WHERE data_entrega is null ORDER BY data_entrega_prevista, data_locacao LIMIT 20";
		} else {
			if(isset($_GET['fechados']) && $_GET['fechados'] == true){
				$sql = "SELECT cod,cpf_cliente,data_locacao,data_entrega_prevista,data_entrega,qtd_filmes,valor FROM locacoes WHERE cpf_cliente = '$pesq' ORDER BY data_entrega_prevista, data_locacao";
			} else {
				$sql = "SELECT cod,cpf_cliente,data_locacao,data_entrega_prevista,data_entrega,qtd_filmes,valor FROM locacoes WHERE cpf_cliente = '$pesq' AND data_entrega is null ORDER BY data_entrega_prevista, data_locacao";
			}
			
		}
		$query_select = $conecta->prepare($sql);
//		echo "select construido 1 ".$sql_select;
		$query_select->execute();
				
				if($query_select){
					$hoje = date('Y-m-d');
					
					$hoje = strtotime($hoje);
					
					$amanha = $hoje + 86400;
						echo "<table border=1>
					<tr>
						<td>
							<b>C&oacutedigo</b>
						</td>
						<td>
							<b>Cpf do Cliente</b>
						</td>
						<td>
							<b>Data Loca&ccedil&atildeo</b>
						</td>
						<td>
							<b>Data Prevista de Entrega</b>
						</td>
						<td>
							<b>Data Entrega</b>
						</td>
						<td>
							<b>Quantidade</b>
						</td>
						<td>
							<b>Valor</b>
						</td>
						<td>
							<b>Filmes</b>
						</td>
						<td>
							<b>Finalizar</b>
						</td>
					</tr>";
					while($row = $query_select->fetchAll(PDO::FETCH_ASSOC)){
						echo "
						<tr>
							<td>
								".$row['cod']."
							</td>
							<td>
								".$row['cpf_cliente']."
							</td>
							<td>
								".$row['data_locacao']."
							</td>
							<td>";
								$prevista = strtotime($row['data_entrega_prevista']);
								$dataPrevista = $row['data_entrega_prevista'];
								
								if($prevista < $hoje){
									echo "<font color='red'>$dataPrevista</font>";
								} elseif($prevista == $hoje) {
									echo "<font color='orange'>$dataPrevista</font>";
								} else {
									echo "<font color='lime'>$dataPrevista</font>";
								}
						echo "
							</td>
							<td>
								";
								$entrega = strtotime($row['data_entrega']);
				// verificado dia previsto de entrega e o dia da entrega
				// cobrado 3% por dia de atraso sobre o valor da loca&ccedilão
								$dataEntrega = $row['data_entrega'];
								
								if($entrega > ($prevista + 86399)){
									$diferenca = $entrega - ($prevista + 86399);
									$dias = floor($diferenca / (60 * 60 * 24)) * -1;
									$multa = (($row['valor'] * 0.03)* $dias)+ $row['valor'];
									echo "<font color='red'>$dataEntrega.' VALOR A COBRAR COM MULTA '.$multa</font>";
								} else {
									echo "<font color='lime'>$dataEntrega</font>";
								}
						echo "
							</td>
							<td>
								".$row['qtd_filmes']."
							</td>
							<td>
								".$row['valor']."
							</td>
							<td>
								<form action='filmesLocados.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<button>Filmes</button>
								</form>
							</td>
							<td>
								<form action='../model/finalizarLocacao.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>";
									if($row['data_entrega'] == ''){
										echo "<button onclick=\"return confirm('Tem certeza que deseja finalizar esta loca&ccedil&atildeo?')\">Finalizar</button>";
									} else {
										echo 'Finalizada!';
									}
								echo "</form>
							</td>
						</tr>";
					}
					echo '</table>';
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
					header('Location:locacoes.php');
				}
		
		?>
</body>
</html>