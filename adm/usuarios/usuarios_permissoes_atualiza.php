<?php
require_once 'funcoes/conexao.php';
$conexao = conexao(); # Função Implemantada
require_once 'funcoes/ordenar.php';

$cod_user = $_SESSION[$nome_site.'_cod_user'];
$nivel_user = $_SESSION[$nome_site.'_nivel'];
$menu = $_SESSION[$nome_site.'_menu'];

if(!verifica_permissao($cod_user, $nivel_user, "usuarios"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}

$ordenado="";
if($_POST['Submit'] <> "")
{
	$ordenado = ordenar($_POST['permissoes']);
}

if($_POST['Submit'] <> "")
{
	
	$tipo = $_POST['tipo'];
	$cod_usuario = $_POST['cod'];
	$ordenado = str_replace("  "," ",$ordenado);
	if($ordenado[0] == " ")
	{
		$ordenado = substr($ordenado,1,strlen($ordenado));
	}

	echo $_POST['permissoes'];
	echo "<br>";
	echo $cod_usuario;
	$resultado = mysql_query("UPDATE usuarios SET permissoes = '".$ordenado."' WHERE cod = ".$cod_usuario);
	//echo mysql_error();
	if($resultado)
	{
		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"Permissao atualizada com sucesso!!\");\n";
		echo " location.replace('principal.php?id=1&subid=1'); \n";
		echo " //--> \n";
		echo " </script> \n";
	}
	else
	{
		//mysql_close($conexao);

		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"\tErro ao atualizar!!\n\n\");\n";
		echo " location.replace('principal.php?id=1&subid=1'); \n";
		echo " //--> \n";
		echo " </script> \n";
		
	}
}	
?>
