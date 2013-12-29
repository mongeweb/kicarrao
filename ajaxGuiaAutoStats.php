<?php
    require_once 'configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = isset($_POST['cod']) ? $_POST['cod'] : '';
    $hoje = date("Y-m-d");
    $retorno = array();
	$conexao = conexao();
    $sql = "INSERT INTO guiaAutomotivoStats (codGuiaAutomotivo, dataVisualizacao) VALUES ('{$cod}', '{$hoje}')";
	$query = mysql_query($sql);
    mysql_close();
	echo json_encode($retorno);
?>