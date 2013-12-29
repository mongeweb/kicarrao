<?php
    require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$tipo = isset($_POST['tipo']) ? mysql_real_escape_string($_POST['tipo']) : '';
    $marca = array();
	$sql = "SELECT *
			FROM marca
			WHERE tipo = '$tipo'
			ORDER BY nome ASC";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	if ($linhas > 0)
	{
		while($tupla = mysql_fetch_assoc( $query ))
		{
			$marca[] = array
			(
				'cod'	  => $tupla['id'],
				'marca'	  => $tupla['nome'],
			);
		}	
	}
    mysql_close();
	echo json_encode($marca);
?>