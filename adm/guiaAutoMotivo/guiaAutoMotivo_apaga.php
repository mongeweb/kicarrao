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
$resultadoFotos = mysql_query("SELECT * FROM arquivos WHERE referencia = 'guiaAutomotivo' AND codReferencia = '{$cod}'");
$linhasFotos = mysql_num_rows($resultadoFotos);
for ($z = 0;$z < $linhasFotos;$z++)
{
    $tpFotos = mysql_fetch_assoc($resultadoFotos);
    @unlink(PROJECT_PATH."arquivos/guia-automotivo/".$tpFotos['arquivo']);
}
$resultadoStats = mysql_query("DELETE FROM guiaAutomotivoStats WHERE codGuiaAutomotivo='{$cod}'",$conexao);
$resultadoRelacao = mysql_query("DELETE FROM guiasRelacao WHERE codGuia='{$cod}'",$conexao);
$resultado = mysql_query("DELETE FROM guiaAutomotivo WHERE cod='{$cod}'",$conexao);

if(!$resultado)
{	
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Erro ao excluir!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=3&subid=1'); \n";
	echo " //--> \n";
	echo " </script> \n";
}
else
{
	reordenarAuto();
    echo " <script language=\"JavaScript\"> \n";
	echo " <!-- \n";
	echo " alert(\"Registro excluido!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=3&subid=1'); \n";
	echo " //--> \n ";
	echo " </script> \n";
}
?>