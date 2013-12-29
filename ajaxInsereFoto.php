<?php
  
	require_once 'configRoot.php';
	require_once ADMIN_FUNC_PATH.'conexao.php';
    require_once ADMIN_FUNC_PATH.'fotos.php';
    
	$conexao = conexao(); # Função Implemantada
	$foto = isset($_POST['foto']) ? mysql_real_escape_string($_POST['foto']) : '';
    $codAnuncio = isset($_POST['codAnuncio']) ? mysql_real_escape_string($_POST['codAnuncio']) : '';
    $capa = isset($_POST['capa']) ? mysql_real_escape_string($_POST['capa']) : 0;
    $foto = array();
    $msg = '';
    
    ##Inicio Valida Extensão e Tamanho
    $formato = $foto['name'];
    $formato = strrev($formato);
    $formato = explode('.',$formato);
    $formato = $formato[0];
    $formato = strrev($formato);
	$formato = strtolower($formato);
    $extensoesvalidas = array("jpg","jpeg","png");
    if(!in_array($formato,$extensoesvalidas))
	{
		$msg .= 'Formato de imagem inválido!\n';
    }
    
    $tamImg = getimagesize($foto['tmp_name']);
    $w = $tamImg[0];
    $h = $tamImg[1];
    
    if($w > '640' || $h > '480')
    {
        $msg .= 'Tamanho da imagem deve ter no maximo 640 x 480 px !\n';
    }
    ##Fim Valida Extensão e Tamanho
    
    if($msg == '')
    {
    	$conexao = conexao();
        $foto_temp = $_FILES['file']['tmp_name'];
        $token = rand(1,99999).date('dmYHis');
        $pasta = PROJECT_PATH."arquivos/clientesAnuncios";
        $file = insere_foto($foto, $foto_temp, $pasta,'640','480');
		$sql = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                VALUES ('clientesAnuncios', '{$codAnuncio}','1', '{$file}','$token', '$capa')";
		$resultado = mysql_query($sql);
        mysql_close();
        $foto[] = array
		(
			'arquivo'		=> $file,
            'erro'			=> $msg
		);
	}
    else
    {
        $foto[] = array
		(
			'arquivo'		=> '',
            'erro'			=> $msg
		);
    }
    echo json_encode($foto);
?>