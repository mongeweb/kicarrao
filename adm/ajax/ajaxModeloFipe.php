<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = isset($_POST['cod']) ? mysql_real_escape_string($_POST['cod']) : '';
    $modelo = array();
	$sql = "SELECT *
			FROM modelo
			WHERE marca = '$cod'
			ORDER BY nome";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	if ($linhas > 0)
	{
		while ( $tupla = mysql_fetch_assoc( $query ) )
		{
			$modelo[] = array
			(
				'cod'	    => $tupla['id'],
				'modelo'    => $tupla['nome'],
			);
		}	
	}
    mysql_close();
	echo json_encode($modelo);
?>