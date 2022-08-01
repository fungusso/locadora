<?php
	
	
	//setlocale(LC_TIME, 'pt_BR', 'pt_BR iso-8859-1', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');	
    ini_set('default_charset','UTF-8');
?>
<div style="background-color:green">
	<h5>
		<a href="/">Início</a>
		<a href="/view/clientes.php">Clientes</a>
		<a href="/view/filmes.php">Filmes</a>
		<a href="/view/categorias.php">Categorias</a>
		<a href="/view/locacoes.php">Locações</a>
	</h5>
</div>
<?php include 'logado.php'; ?>