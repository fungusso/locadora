<title>TELA DE LOGIN</title>
<?php
    
	include 'style.php';
	session_start();
	if(isset($_SESSION['logado'])){
		header('Location:index.php');
	} else {
		echo "
		
		</br></br></br></br></br> 
		<div align='center'>";
		if(isset($_SESSION['resposta'])){
			echo $_SESSION['resposta'];
			unset($_SESSION['resposta']); 
		}
		echo "</div></br>
		<form action='logar.php' method='post'>
			<table border='1 ' align='center'>
				
				<tr>
					<td colspan=2 align = 'center'>
						<b>TELA DE LOGIN</b>
					</td>
				</tr>
				<tr>
					<td>
						Login: 
					</td>
					<td>
						<input type='text' name='login'/>
					</td>
				</tr>
				<tr>
					<td>
						Senha: 
					</td>
					<td>
						<input type='password' name='pass'/>
					</td>
				</tr>
				<tr>
					<td>
						<button>Login</button>
					</td>
					<td>
						<button type='reset'>Limpar</button>
					</td>
				</tr>
			
			
			</table>
		</form>
		";
	}
?>

