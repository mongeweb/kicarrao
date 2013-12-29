<?php
require_once '../../configRoot.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
require_once ADMIN_FUNC_PATH.'funcoes.php';
$conexao = conexao();

$cod_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_cod_user'])) ? $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] : '' ;
$nivel_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_nivel'])) ? $_SESSION[ADMIN_SESSION_NAME.'_nivel'] : '' ;
$menu = (isset($_SESSION[ADMIN_SESSION_NAME.'_menu'])) ? $_SESSION[ADMIN_SESSION_NAME.'_menu'] : '' ;

if(!verifica_permissao($cod_user, $nivel_user, "clientes"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
$tipoClienteFiltro = isset($_GET['tipoAnuncio']) ? $_GET['tipoAnuncio'] : '1';
$letraFiltro = isset($_GET['letra']) ? '&letra='.$_GET['letra'] : '';
$cod = isset($_GET['cod']) ? $_GET['cod'] : '';

// exclui clientes anuncios
// exclui clientes anuncios fotos 
$sqlVeiculos = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '{$cod}'");
$numVeiculos = mysql_num_rows($sqlVeiculos);
for($x = 0;$x < $numVeiculos;$x++)
{
    $tpVeiculos = mysql_fetch_assoc($sqlVeiculos);
    $resultadoFotos = mysql_query("SELECT * FROM arquivos WHERE referencia = 'clientesAnuncios' AND codReferencia = '{$tpVeiculos['cod']}'");
    $linhasFotos = mysql_num_rows($resultadoFotos);
    for ($z = 0;$z < $linhasFotos;$z++)
    {
        $tpFotos = mysql_fetch_assoc($resultadoFotos);
        $detaFoto= mysql_query("DELETE FROM arquivos WHERE cod = '{$tpFotos['cod']}'",$conexao);
        unlink(PROJECT_PATH."arquivos/clientesAnuncios/".$tpFotos['arquivo']);
    }
}
$resultadoVeiculos = mysql_query("DELETE FROM clientesAnuncios WHERE codCliente ='{$cod}'",$conexao);

// exclui fotos cliente (pra revenda)
if($tipoClienteFiltro == 2)
{
	$resultadoFotos = mysql_query("SELECT * FROM arquivos WHERE referencia = 'clienteRevenda' AND codReferencia = '{$cod}'");
	$linhasFotos = mysql_num_rows($resultadoFotos);
	for ($z = 0;$z < $linhasFotos;$z++)
	{
		$tpFotos = mysql_fetch_assoc($resultadoFotos);
		unlink(PROJECT_PATH."arquivos/clientesRevendas/".$tpFotos['arquivo']);
	}
}

//Exclui cliente
$resultado = mysql_query("DELETE FROM clientes WHERE cod='{$cod}'",$conexao);

if(!$resultado)
{	
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Erro ao excluir!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=6&subid=1$letraFiltro&tipoAnuncio=$tipoClienteFiltro'); \n";
	echo " //--> \n";
	echo " </script> \n";
}
else
{
    reordenarClientes();
    echo " <script language=\"JavaScript\"> \n";
	echo " <!-- \n";
	echo " alert(\"Registro excluido!\");\n";
	echo " location.replace('http://".ADMIN_URL."/principal.php?id=6&subid=1$letraFiltro&tipoAnuncio=$tipoClienteFiltro'); \n";
	echo " //--> \n ";
	echo " </script> \n";
}
?>