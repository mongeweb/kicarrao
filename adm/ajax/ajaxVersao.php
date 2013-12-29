<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = mysql_real_escape_string($_POST['cod']);
    $versao = array();
	$sql = "SELECT cod, versao
			FROM veiculosVersoes
			WHERE codModelo = '$cod'
			ORDER BY versao";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	if ($linhas > 0)
	{
		while ( $tupla = mysql_fetch_assoc( $query ) )
		{
			$versao[] = array
			(
				'cod'	=> $tupla['cod'],
				'versao'			=> $tupla['versao'],
			);
		}	
	}
	echo json_encode($versao);
?>