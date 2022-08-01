<?php
session_start();
unset($_SESSION['pesqFilme']);
include '../conexao.php';
// check if connection failed
if(!$conecta){
	$_SESSION['resposta'] = "<font color='red'>SQL ERROR = ".$conecta->errorInfo()."</font>";
} else {
	
	// check if client was selected
	if(strlen($_SESSION['cliente'][0]) > 0){
		$_SESSION['pesqFilme']['size'] = 0;
		$_SESSION['pesqFilme']['tipoPesq'] = $_GET['tipoPesq'];
		$pesqFilme = $_GET['pesqFilme'];
		$tipoPesq = $_GET['tipoPesq'];
		// check if search movie is empty
		if($pesqFilme != ''){
			switch($tipoPesq){
				case 'nome':{
					$sql = "
						SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3, f.categoria1 as cod_categoria1,
						f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3
						FROM filmes as f 
						INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
						LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
						LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
						WHERE f.nome like '$pesqFilme'+'%' AND f.status = 'A' ORDER BY f.nome LIMIT 4";
						break;
				}
				case 'cod':{
					$sql = "
						SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3, f.categoria1 as cod_categoria1,
						f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3 
						FROM filmes as f 
						INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
						LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
						LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
						WHERE f.cod = '$pesqFilme' AND f.status = 'A'";
						break;
				}
				case 'categoria':{
					$sql = "
						SELECT f.cod,f.nome,f.qtd,c1.nome as categoria1,c2.nome as categoria2,c3.nome as categoria3 , f.categoria1 as cod_categoria1,
						f.categoria2 as cod_categoria2, f.categoria3 as cod_categoria3
						FROM filmes as f 
						INNER JOIN categorias as c1 ON f.categoria1 = c1.cod
						LEFT OUTER JOIN categorias as c2 ON f.categoria2 = c2.cod
						LEFT OUTER JOIN categorias as c3 ON f.categoria3 = c3.cod
						WHERE (c1.nome like '$pesqFilme'+'%' or c2.nome like '$pesqFilme'+'%' or c3.nome like '$pesqFilme'+'%') AND f.status = 'A' ORDER BY f.nome LIMIT 4";
						break;
				}
					
			}
			$query_select = $conecta->prepare($sql);
			$query_select->execute();
			$i = 0;
			
			while($_SESSION['pesqFilme']['result'][$i] = $query_select->fetchAll(PDO::FETCH_ASSOC)) //guarda todos os filmes no vetor cada posição um campo tem 9 campos entao do 0 ate 8
			{
				$_SESSION['pesqFilme']['size'] = ($i + 1);	//guarda a quantidade de filmes adicionados
				$i++;					
				
			}
			
		} else {
			$_SESSION['resposta'] = '<font color=red>Preencha o campo para pesquisar o filme.</font>';
		}
	} else {
		$_SESSION['resposta'] = '<font color=red>Selecione primeiro o Cliente.</font>';
	}
}
 
header('Location:../control/cadastrarLocacao.php');
		
?>