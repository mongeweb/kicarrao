<?php
    require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = mysql_real_escape_string($_POST['cod']);
    $marca = array();
	$sql = "SELECT cod, marca, destaque
			FROM veiculosMarcas
			WHERE codTipoVeiculo = '$cod'
			ORDER BY destaque DESC, marca ASC";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	
	if ($linhas > 0)
	{
		while($tupla = mysql_fetch_assoc( $query ))
		{
			$marca[] = array
			(
				'cod'	    => $tupla['cod'],
				'marca'		=> $tupla['marca'],
				'destaque'  => $tupla['destaque']
			);
		}	
	}
	
	echo json_encode($marca);
?>