<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = mysql_real_escape_string($_POST['cod']);
    $modelo = array();
	$sql = "SELECT cod, modelo
			FROM veiculosModelos
			WHERE codMarca = '$cod'
			ORDER BY modelo";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	if ($linhas > 0)
	{
		while ( $tupla = mysql_fetch_assoc( $query ) )
		{
			$modelo[] = array
			(
				'cod'	=> $tupla['cod'],
				'modelo'			=> $tupla['modelo'],
			);
		}	
	}
	echo json_encode($modelo);
?>