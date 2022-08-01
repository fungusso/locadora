<html>

<title>Locações - Sistema de Locadora de Filmes</title>
<<meta name="description" content="Como usar charset na <meta> tag">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<title>Filmes Locados - Locadora Gerson de Filmes</title> 
<h1 align="center">Filmes Locados - Sistema de Locadora de Filmes<h1>
<?php
include '../style.php';
include '../conexao.php';

include '../menu.php'; 
	$cod_locacao = $_GET['cod'];
	echo "<table>";
	 			if($conecta){
					$sql = "SELECT fl.cod_filme,f.nome FROM filme_locado as fl
						INNER JOIN filmes as f
						ON fl.cod_filme = f.cod
						WHERE fl.cod_locacao = '$cod_locacao'";
					
					$query_select = $conecta->prepare($sql);
 					$query_select->execute();
					echo "<table border=1>
							<tr>
								<td colspan='2' align='center'>
									<b>Filmes da Locação $cod_locacao</b>
								</td>
							</tr>
							<tr>
								<td>
									<b>C&oacutedigo</b>
								</td>
								<td>
									<b>	Nome</b>
								</td>
							</tr>";
					if($query_select){
						
						while($row = $query_select->fetchAll(PDO::FETCH_ASSOC)){
						
							echo "
							<tr>
								<td>
									".$row['cod_filme']."
								</td>
								<td>
									".$row['nome']."
								</td>
							</tr>";
						
						}
						
					} else {
						$_SESSION['resposta'] = $conecta->errorInfo() . '<br/>' . $sql;
						header('Location:locacoes.php');
						exit();
					}
					echo "</table>";
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".$conecta->errorInfo()."</font>";
					header('Location:locacoes.php');
					exit();
				}
				 
	echo "</table>";
	
?>
</body>
</html>