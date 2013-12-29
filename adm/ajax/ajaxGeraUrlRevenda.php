<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH."formatting.php";
	$valor = isset($_POST['valor']) ? $_POST['valor'] : '';
    $valorUrl = mg_substituirEspacosPorTreacos($valor);
    $valorArray = array();
			$valorArray[] = array
			(
				'valor'	=> $valorUrl,
			);
	echo json_encode($valorArray);
?>