<?php
	session_start();
	include '../conexao.php';
	$cpf_cliente = $_SESSION['cliente'][0];
	$data_locacao = $_GET['data_locacao'];
	$data_locacao = date('Y-m-d H:i:s',strtotime($data_locacao));
	$dia_entrega_prevista = $_GET['dia_entrega'];
	$mes_entrega_prevista = $_GET['mes_entrega'];
	$ano_entrega_prevista = $_GET['ano_entrega'];
	$entrega_prevista = $ano_entrega_prevista . '-' . $mes_entrega_prevista . '-' . $dia_entrega_prevista;
	$qtdFilmes = $_SESSION['filmesLocados']['size'];
	$valor = $_GET['valor'];
	
	if(!(isset($_SESSION['cliente']) && isset($_SESSION['filmesLocados']))){
		$_SESSION['resposta'] = "<font color='red'>Para finalizar a locação tem que selecionar o cliente e pelo menos um filme!!!</font>";
		header('Location:cadastrarLocacao.php');
		exit();
	}
	if(strtotime($data_locacao) > strtotime($entrega_prevista)){
		$_SESSION['resposta'] = "<font color='red'>A data da entrega não pode ser menor que a data da locação.</font>";
		header('Location:cadastrarLocacao.php');
		exit();
	}
	
				if($conecta){
					$sql = "INSERT INTO locacoes (cpf_cliente,data_locacao,data_entrega_prevista,qtd_filmes,valor) 
						VALUES ('$cpf_cliente','$data_locacao','$entrega_prevista','$qtdFilmes','$valor')";
					$query_select = $conecta->prepare($sql);
			        $query_select->execute();
					if($query_select){
						
						$cod_locacao = $query_select->lastInsertId();
						
						for($i = 0; $i < $qtdFilmes; $i++){
							$cod_filme = $_SESSION['filmesLocados'][$i]['cod'];
							$sql = "INSERT INTO filme_locado (cod_locacao,cod_filme) VALUES ('$cod_locacao','$cod_filme')";
							$query_select = $conecta->prepare($sql);
			                $query_select->execute();
							if($query_select){
								$_SESSION['resposta'] = "<font color='lime'>Locação efetuada com sucesso!!!</font>";
							} else {
								$_SESSION['resposta'] = $conecta->errorInfo() . '<br/>' . $sql;
							}
						}
						
					} else {
						$_SESSION['resposta'] = $conecta->errorInfo() . '<br/>' . $sql;
							} . '<br/>' . $sql;
					}
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".$conecta->errorInfo() . '<br/>' . $sql;
							}."</font>";
				}
				 
				
	unset($_SESSION['cliente']);
	unset($_SESSION['filmesLocados']);
	unset($_SESSION['pesqFilme']);

	header('Location:../view/locacoes.php');
?>