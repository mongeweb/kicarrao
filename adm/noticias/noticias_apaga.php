<?php
require_once '../../configRoot.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
$conexao = conexao(); # Função Implemantada

$cod_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_cod_user'])) ? $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] : '' ;
$nivel_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_nivel'])) ? $_SESSION[ADMIN_SESSION_NAME.'_nivel'] : '' ;
$menu = (isset($_SESSION[ADMIN_SESSION_NAME.'_menu'])) ? $_SESSION[ADMIN_SESSION_NAME.'_menu'] : '' ;

if(!verifica_permissao($cod_user, $nivel_user, "noticias"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}

	$cod = $_GET['cod'];
	$resultadoFoto = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$cod}' AND referencia = 'noticias'");
	$linhasFotos = mysql_num_rows($resultadoFoto);
	
	
	for ($x=0;$x<$linhasFotos;$x++)
		{
			$tuplaFoto = mysql_fetch_assoc($resultadoFoto);
			unlink(PROJECT_PATH."arquivos/noticias/".$tuplaFoto['arquivo']);
		}
	
	$resultadoApaga = mysql_query("DELETE FROM noticias WHERE cod='{$cod}'",$conexao);
	$apagaFoto = mysql_query("DELETE FROM arquivos WHERE codReferencia ='{$cod}' AND referencia = 'noticias'",$conexao);
	
	if($resultadoApaga)
	{	
		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"Registro excluido com sucesso!\");\n";
		echo " location.replace('http://".ADMIN_URL."/principal.php?id=2&subid=1'); \n";
		echo " //--> \n";
		echo " </script> \n";
	}
	else
	{
		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"Erro ao excluir!\");\n";
		echo " location.replace('http://".ADMIN_URL."/principal.php?id=2&subid=1'); \n";
		echo " //--> \n";
		echo " </script> \n";
	}


?>