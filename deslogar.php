<?php
require_once 'configRoot.php';
$_SESSION['restrita'] = 0;
unset($_SESSION['usuario']);
unset($_SESSION['codCliente']);
unset($_SESSION['nome']);
unset($_SESSION['tipoAnuncio']);
unset($_SESSION['tipoRevenda']);
unset($_SESSION['id_anuncio']);
unset($_SESSION['tipoLogin']);
unset($_SESSION['plano']);
unset($_SESSION['boleto']);
$link = $MG_MR_Settings['active'] ? "http://".PROJECT_URL.'/home' : "http://".PROJECT_URL.'/home.php';
printf("<script type='text/javascript'>
			document.location.replace('".$link."');
		</script>");
exit();
?>