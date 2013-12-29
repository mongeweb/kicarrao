<?php
  
	require_once '../../configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
	$conexao = conexao(); # Função Implemantada
	$cod = mysql_real_escape_string($_POST['cod']);
    $tipo = array();
	$sql = "SELECT pt.cod, pt.tipo FROM publiRelacao AS pr
            INNER JOIN publiTipos AS pt ON pt.cod = pr.codPubliTipos 
			WHERE pr.codPubliPaginas = '$cod'
			GROUP BY pt.cod";
	$query = mysql_query($sql);
	$linhas = mysql_num_rows($query);
	if ($linhas > 0)
	{
		while ( $tupla = mysql_fetch_assoc( $query ) )
		{
			$tipo[] = array
			(
				'cod'	=> $tupla['cod'],
				'tipo'			=> $tupla['tipo'],
			);
		}	
	}
	echo json_encode($tipo);
?>