<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = isset($_POST['cod']) ? $_POST['cod'] : '';
    $destaque = isset($_POST['destaque']) ? $_POST['destaque'] : '';
	$sql = "UPDATE guiaAutomotivo SET destaque = '$destaque' WHERE cod = '$cod'";
	$query = mysql_query($sql);
    $retorno[] = array
	(
		'resultado'	=> '1',
	);
	echo json_encode($retorno);
?>