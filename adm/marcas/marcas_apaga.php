<?php
require_once '../../configRoot.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
$conexao = conexao();

$cod_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_cod_user'])) ? $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] : '' ;
$nivel_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_nivel'])) ? $_SESSION[ADMIN_SESSION_NAME.'_nivel'] : '' ;
$menu = (isset($_SESSION[ADMIN_SESSION_NAME.'_menu'])) ? $_SESSION[ADMIN_SESSION_NAME.'_menu'] : '' ;

if(!verifica_permissao($cod_user, $nivel_user, "veiculos"))
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

$resultadoModelos = mysql_query("SELECT * FROM veiculosModelos WHERE codMarca='{$cod}'");
$linhasModelos = mysql_num_rows($resultadoModelos);
for($x = 0;$x < $linhasModelos;$x++)
{
    $tpModelos = mysql_fetch_assoc($resultadoModelos);
    $ApagaVersoes = mysql_query("DELETE FROM veiculosVersoes WHERE codModelo='{$tpModelos['cod']}'",$conexao);
}
$ApagaModelos = mysql_query("DELETE FROM veiculosModelos WHERE codMarca='{$cod}'",$conexao);
$resultado = mysql_query("DELETE FROM veiculosMarcas WHERE cod='{$cod}'",$conexao);

	
if(!$resultado)
{	
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Erro ao excluir!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=7&subid=1'); \n";
	echo " //--> \n";
	echo " </script> \n";
}
else
{
	echo " <script language=\"JavaScript\"> \n";
	echo " <!-- \n";
	echo " alert(\"Registro excluido!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=7&subid=1'); \n";
	echo " //--> \n ";
	echo " </script> \n";
}
?>