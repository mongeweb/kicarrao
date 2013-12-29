<?php
require_once 'configRoot.php';

$codAnuncio = isset($_GET['codAnuncio']) ? base64_decode($_GET['codAnuncio']) : 0;
$tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : 0;
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : 0;

if($codCliente == 0 || ($tipoAnuncio != 1 && $tipoAnuncio != 2))
{
    //echo 1;
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL."/home" : sslRedir().PROJECT_URL."/home.php";
    printf("<script type='text/javascript'>
					location.replace('".$link."');
				</script>");
    die();
}
$n = 0;
$conexao = conexao();
if($tipoAnuncio == 1)
{
    echo $codAnuncio;
    $q = mysql_query("SELECT ca.cod,ca.planoValor FROM clientesAnuncios AS ca
                      INNER JOIN clientes AS c ON c.cod = ca.codCliente
                      WHERE ca.cod = '$codAnuncio' AND c.cod = '$codCliente' AND c.tipoAnuncio = '1'");
    //echo mysql_error();
    $n = mysql_num_rows($q);
}
else if($tipoAnuncio == 2)
{
    $q = mysql_query("SELECT @cod:=0 AS cod,pr.valor AS planoValor FROM clientes AS c
                      INNER JOIN planosRevenda AS pr ON pr.cod = c.codPlanoRevenda
                      WHERE c.cod = '$codCliente' AND c.tipoAnuncio = '2' AND c.tipoRevenda = '1' GROUP BY c.cod");
    //echo mysql_error();
    $n = mysql_num_rows($q);
}
    
if($n > 0)
{
    $tp = mysql_fetch_assoc($q);
    mysql_close();
    $_SESSION['boleto']['codAnuncio'] = $tp['cod'];
    $_SESSION['boleto']['valor'] = $tp['planoValor'];
    $_SESSION['boleto']['codCliente'] = $codCliente;
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL."/boleto/boleto.php" : sslRedir().PROJECT_URL."/boleto/boleto.php";
    printf("<script type='text/javascript'>
					location.replace('".$link."');
				</script>");
}
else
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL."/home" : sslRedir().PROJECT_URL."/home.php";
    printf("<script type='text/javascript'>
				location.replace('".$link."');
			</script>");
}
die();


?>
