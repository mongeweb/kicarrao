<?php
require_once '../../configRoot.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
require_once ADMIN_FUNC_PATH.'funcoes.php';
$conexao = conexao();

$cod_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_cod_user'])) ? $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] : '' ;
$nivel_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_nivel'])) ? $_SESSION[ADMIN_SESSION_NAME.'_nivel'] : '' ;
$menu = (isset($_SESSION[ADMIN_SESSION_NAME.'_menu'])) ? $_SESSION[ADMIN_SESSION_NAME.'_menu'] : '' ;

if(!verifica_permissao($cod_user, $nivel_user, "guiaAutomotivo"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}

$cod = isset($_GET['cod']) ? $_GET['cod'] : '';

$resultadoGuia = mysql_query("SELECT * FROM guiaAutomotivo WHERE codCategoria='{$cod}'");
$linhasGuia = mysql_num_rows($resultadoGuia);
$resultadoFotosCat = mysql_query("SELECT * FROM arquivos WHERE referencia = 'guiaAutomotivoCategorias' AND codReferencia = '{$cod}'");
$linhasFotosCat= mysql_num_rows($resultadoFotosCat);
if($linhasFotosCat > 0)
{
    $tpFotosCat = mysql_fetch_assoc($resultadoFotosCat);
	@unlink(PROJECT_PATH."arquivos/guia-automotivo-categorias/".$tpFotosCat['arquivo']);
    $ApagaFotosCat = mysql_query("DELETE FROM arquivos WHERE referencia = 'guiaAutomotivoCategorias' AND codReferencia = '{$cod}'",$conexao);
}
if ($linhasGuia > 0)
{
	for ($x = 0;$x < $linhasGuia;$x++)
	{
		$tpGuia= mysql_fetch_assoc($resultadoGuia); 
		$resultadoFotos = mysql_query("SELECT * FROM arquivos WHERE referencia = 'guiaAutomotivo' AND codReferencia = '{$tpGuia['cod']}'");
		$linhasFotos = mysql_num_rows($resultadoFotos);
		 for ($z = 0;$z < $linhasFotos;$z++)
		 {
			 $tpFotos = mysql_fetch_assoc($resultadoFotos);
			 @unlink(PROJECT_PATH."arquivos/guia-automotivo/".$tpFotos['arquivo']);
		 }
	}
}
	

$ApagaGuias = mysql_query("DELETE FROM guiaAutomotivo WHERE codCategoria='{$cod}'",$conexao);
$resultado = mysql_query("DELETE FROM guiaAutomotivoCategorias WHERE cod='{$cod}'",$conexao);

	
if(!$resultado)
{	
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Erro ao excluir!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=4&subid=1'); \n";
	echo " //--> \n";
	echo " </script> \n";
}
else
{
	reordenarAuto();
    reordenarAutoCat();
    echo " <script language=\"JavaScript\"> \n";
	echo " <!-- \n";
	echo " alert(\"Registro excluido!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=4&subid=1'); \n";
	echo " //--> \n ";
	echo " </script> \n";
}
?>