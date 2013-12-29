<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $cidade = array();
	$sql = "SELECT cod, cidade
			FROM clientes
			WHERE estado = '$estado'
			GROUP BY cidade ORDER BY cidade";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	if ($linhas > 0)
	{
		while ( $tupla = mysql_fetch_assoc( $query ) )
		{
			$cidade[] = array
			(
				'cod'	=> $tupla['cod'],
				'cidade'			=> $tupla['cidade'],
			);
		}	
	}
	echo json_encode($cidade);
?>