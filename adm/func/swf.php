<?php

/**
 * codeToMessage()
 *
 * Retorna a mensagem de erro gerada
 * pelo método uploadArquivo.
 *
 * Pode-se escolher o idioma da
 * mensagem de erro no parâmetro $idioma.
 *
 * @author Luis Fernando Gomes
 * @copyright 9/2009
 * @version 1.1
 *
 * Histórico:
 *
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 09/03/2010	|  1.1 	 | Adicionado parâmetro $tipoRetorno.
 * ------------------------------------------------------------------------------------------------
 *
 * @param integer $code
 * @param string $tipoRetorno
 * @param string $idioma
 * @return string
 *
 */
function codeToMessage($code, $tipoRetorno = 'js', $idioma = 'pt-br')
{
    switch ($code) {
        case UPLOAD_ERR_OK:
            /** 0 **/
            $message['en-us']['js'] = 'There is no error, the file uploaded with success.';
            $message['en-us']['html'] = 'There is no error, the file uploaded with success.';
            $message['pt-br']['js'] = 'N\u00E3o h\u00E1 nenhum erro, o arquivo enviado com sucesso.';
            $message['pt-br']['html'] = 'Não há nenhum erro, o arquivo enviado com sucesso.';
            break;
        case UPLOAD_ERR_INI_SIZE:
            /** 1 **/
            $message['en-us']['js'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            $message['en-us']['html'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            $message['pt-br']['js'] = 'O arquivo no upload \u00E9 maior do que o limite definido em upload_max_filesize no php.ini.';
            $message['pt-br']['html'] = 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.';
            break;
        case UPLOAD_ERR_FORM_SIZE:
            /** 2 **/
            $message['en-us']['js'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            $message['en-us']['html'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            $message['pt-br']['js'] = 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formul\u00E1rio HTML.';
            $message['pt-br']['html'] = 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML.';
            break;
        case UPLOAD_ERR_PARTIAL:
            /** 3 **/
            $message['en-us']['js'] = 'The uploaded file was only partially uploaded';
            $message['en-us']['html'] = 'The uploaded file was only partially uploaded';
            $message['pt-br']['js'] = 'O upload do arquivo foi feito parcialmente.';
            $message['pt-br']['html'] = 'O upload do arquivo foi feito parcialmente.';
            break;
        case UPLOAD_ERR_NO_FILE:
            /** 4 **/
            $message['en-us']['js'] = 'No file was uploaded';
            $message['en-us']['html'] = 'No file was uploaded';
            $message['pt-br']['js'] = 'N\u00E3o foi feito o upload do arquivo.';
            $message['pt-br']['html'] = 'Não foi feito o upload do arquivo.';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            /** 6 **/
            $message['en-us']['js'] = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
            $message['en-us']['html'] = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
            $message['pt-br']['js'] = 'Faltando uma pasta tempor\u00E1ria. Introduzido no PHP 5.0.3.';
            $message['pt-br']['html'] = 'Faltando uma pasta temporária. Introduzido no PHP 5.0.3.';
            break;
        case UPLOAD_ERR_CANT_WRITE:
            /** 7 **/
            $message['en-us']['js'] = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
            $message['en-us']['html'] = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
            $message['pt-br']['js'] = 'Falha ao gravar arquivo em disco. Introduzido no PHP 5.1.0.';
            $message['pt-br']['html'] = 'Falha ao gravar arquivo em disco. Introduzido no PHP 5.1.0.';
            break;
        case UPLOAD_ERR_EXTENSION:
            /** 8 **/
            $message['en-us']['js'] = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
            $message['en-us']['html'] = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
            $message['pt-br']['js'] = 'O upload do arquivo foi interrompido por extens\u00E3o. Introduzido no PHP 5.2.0.';
            $message['pt-br']['html'] = 'O upload do arquivo foi interrompido por extensão. Introduzido no PHP 5.2.0.';
            break;

        case 9:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'O arquivo falhou na verifica\u00E7\u00E3o de valida\u00E7\u00E3o b\u00E1sica.';
            $message['pt-br']['html'] = 'O arquivo falhou na verificação de validação básica.';
            break;

        case 10:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'O arquivo no upload \u00E9 maior do que o limite definido pelo administrador.';
            $message['pt-br']['html'] = 'O arquivo no upload é maior do que o limite definido pelo administrador.';
            break;

        case 11:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'O arquivo n\u00E3o possui uma extens\u00E3o permitida pelo administrador.';
            $message['pt-br']['html'] = 'O arquivo não possui uma extensão permitida pelo administrador.';
            break;

        case 12:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'O administrador definiu somente imagens Verticais.';
            $message['pt-br']['html'] = 'O administrador definiu somente imagens Verticais.';
            break;

        case 13:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'O administrador definiu somente imagens Horizontais.';
            $message['pt-br']['html'] = 'O administrador definiu somente imagens Horizontais.';
            break;

        case 14:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'O diret\u00E13rio de destino n\u00E3o \u00E9 um diret\u00E13rio ou possui permiss\u00E3o de escrita.';
            $message['pt-br']['html'] = 'O diretório de destino não é um diretório ou possui permissão de escrita.';
            break;

        default:
            $message['en-us']['js'] = '';
            $message['en-us']['html'] = '';
            $message['pt-br']['js'] = 'Unknown upload error';
            $message['pt-br']['html'] = 'Erro de upload Desconhecido.';
            break;
    }
    switch ($idioma) {
        case 'en-us':
            $menssagem = $message['en-us'];
            break;

        case 'pt-br':
        default:
            $menssagem = $message['pt-br'];
    }
    switch ($tipoRetorno) {
        case 'html':
            $retorno = htmlentities($menssagem['html']);
            break;

        case 'js':
        default:
            $retorno = utf8_encode($menssagem['html']);
    }

    return $retorno;
}

/**
 * uploadArquivo()
 *
 * Método que faz upload de um arquivo e retorna
 * o nome do arquivo armazenado em caso de sucesso
 * ou código de erro em caso de falha.
 *
 * Para interpretar o código de erro usa-se a
 * função codeToMessage().
 *
 * exemplo:
 * $extensoesPermitidas = array("doc", "pdf");
 *
 * $arquivo = uploadArquivo('arquivo', -1, $pasta, 'NomeArquivo', null, $extensoesPermitidas);
 *
 * if (is_int($arquivo)) {
 * 		error_message = codeToMessage($arquivo);
 *		echo " 	<script language=\"JavaScript1.2\"> \n
 *        		<!-- \n
 *        			alert(\"" . $error_message . "!\");\n
 *        		//--> \n
 *       		</script> \n";
 * }
 *
 * @author Luis Fernando Gomes
 * @copyright 9/2009
 * @version 1.1
 *
 * Histórico:
 *
 * Data			| Versão | Modificação
 * ------------------------------------------------------------------------------------------------
 * 29/09/2009	|  1.1 	 | Substituido a função ereg por preg_match.
 * 				|   	 | ------------------------------------------------------------------------
 * 				|   	 | Consertado bug de redimensionamento.
 * 				|   	 | ------------------------------------------------------------------------
 * 12/04/2010	|   	 | Consertado bug de upload de imagens com formato diferente de jpg.
 * ------------------------------------------------------------------------------------------------
 *
 * @param string $campoDoForm 					o nome do campo de formulário de upload de arquivo
 * @param string $chaveMulti 					a chave do do array $_FILES do arqivo a fazer upload
 * @param string $caminhoNoServidor 			o caminho relativo para o qual armazenar o arquivo (sem barra final)
 * @param string $nomeFinalDoArquivo 			o nome final desejado por no arquivo
 * @param integer $tamanhoMaximo 				o tamanho máximo do arquivo (medido em bytes)
 * @param array $extensoesPermitidas 			uma matriz contendo todos as extensões permitidas de arquivo
 * @param integer $larguraMaxima				limite de largura de uma imagem (use null para valor padrão)
 * @param integer $alturaMaxima					limite de altura de uma imagem (use null para valor padrão)
 * @param string $orientacao					permite somente imegens verticais ou horizontais ('V' para vertical ou 'H' para horizontal)
 * @param integer $raio							tamanho da borda da imagem
 * @param string $bgcolor						cor da borda da imagem hexadecimal (ex. #3FE5AA)
 * @return string | false 						nome do arquivo armazenado em caso de sucesso ou código de erro em caso de falha.
 */
function uploadArquivo($campoDoForm = '', $chaveMulti = -1, $caminhoNoServidor = '', $nomeFinalDoArquivo = '', $tamanhoMaximo = null, $extensoesPermitidas = array(), $larguraMaxima = 500, $alturaMaxima = 500, $orientacao = '', $raio = 0, $bgcolor = '')
{
    if (!is_dir($caminhoNoServidor) || (!is_writable($caminhoNoServidor) && !chmod($caminhoNoServidor, 0777))) {
        return 14;
    }
    if (!function_exists('formatFilesArray')) {
        /**
         * formatFilesArray()
         *
         * Reformata o array $_FILES de:
         *
         * Array
         *	(
         *	    [name] => Array
         *	        (
         *	            [0] =>
         *	        )
         * 		[type] => Array
         *	        (
         *	            [0] =>
         *	        )
         *
         *	    [tmp_name] => Array
         *	        (
         *	            [0] =>
         *	        )
         *
         *	    [error] => Array
         *	        (
         *	            [0] =>
         *	        )
         *
         *	    [size] => Array
         *	        (
         *	            [0] =>
         *	        )
         *
         *	}
         *
         * Array
         *	(
         *	    [0] => Array
         *	        (
         *	            [name] =>
         * 	            [type] =>
         *	            [tmp_name] =>
         *	            [error] =>
         *	            [size] =>
         *	        )
         *
         *	)
         *
         *
         * @param array $files		O array $_FILES.
         * @param array $name		Uso interno.
         * @param bool $new			Uso interno.
         * @param bool $path		Uso interno.
         * @return 					O array $_FILES reformatado.
         */
        //        function formatFilesArray($files, $name = null, &$new = false, $path = false)
        //        {
        //            $names = array('name' => 'name', 'type' => 'type', 'tmp_name' => 'tmp_name', 'error' => 'error', 'size' => 'size');
        //
        //            foreach ($files as $key => &$part) {
        //                $key = (string )$key;
        //                if (in_array($key, $names)) {
        //                    $name = $key;
        //                }
        //                if (!in_array($key, $names)) {
        //                    $path[] = $key;
        //                }
        //                if (is_array($part)) {
        //                    $part = formatFilesArray($part, $name, $new, $path);
        //                } elseif (!is_array($part)) {
        //                    $current = &$new;
        //                    foreach ($path as $p) {
        //                        $current = &$current[$p];
        //                    }
        //                    $current[$name] = $part;
        //                    unset($path);
        //                    $name = null;
        //                }
        //            }
        //            return $new;
        //        }
        function formatFilesArray($files)
        {
            $i = 0;
            foreach ($files as $chaves => $valores) {
                foreach ($valores as $key => $value) {
                    $array[$i][$chaves] = $value;
                    $i++;
                }
                $i = 0;
            }
            return $array;
        }
    }

    if (!function_exists('hex2dec')) {
        /**
         * hex2dec()
         *
         * Retorna um array associativo (keys: R,G,B)
         * de um codigo html hexadecimal (ex. #3FE5AA).
         *
         * @param string $cor
         * @return array
         */
        function hex2dec($cor = '#000000')
        {
            $R = substr($cor, 1, 2);
            $red = hexdec($R);
            $G = substr($cor, 3, 2);
            $green = hexdec($G);
            $B = substr($cor, 5, 2);
            $blue = hexdec($B);
            $tbl_cor = array();
            $tbl_cor['R'] = $red;
            $tbl_cor['G'] = $green;
            $tbl_cor['B'] = $blue;
            return $tbl_cor;
        }
    }

    /** Teste pra saber se são multiplos arquivos **/
    if ($chaveMulti > -1) {
        $array = formatFilesArray($_FILES[$campoDoForm]);

        /** Cria variaveis com nome das chaves do array $_FILES **/
        foreach ($array[$chaveMulti] as $key => $val) {
            $$key = $val;
        }
    } else {
        /** Cria variaveis com nome das chaves do array $_FILES **/
        foreach ($_FILES[$campoDoForm] as $key => $val) {
            $$key = $val;
        }
    }

    if ($tamanhoMaximo === null) {
        $tamanhoMaximo = $size;
    }

    if ($error != UPLOAD_ERR_OK) {
        return $error;
    }

    if ((!is_uploaded_file($tmp_name)) || ($size == 0)) {
        /** arquivo falhou nas verificações de validação básica **/
        return 9;
    }

    if ($size > $tamanhoMaximo) {
        return 10;
    }

    if ((is_array($extensoesPermitidas)) && (!empty($extensoesPermitidas))) {
        $pattern = '/';
        /** Monta a expressão regular **/
        foreach ($extensoesPermitidas as $ext) {
            $pattern .= '(' . $ext . ')';
            if (next($extensoesPermitidas)) {
                $pattern .= '|';
            }
        }
        $pattern .= '/i';
        $arrName = explode('.', $name);
        $ext = end($arrName);
        if (!preg_match($pattern, $ext)) {
            //die("morri:".$pattern .":". end(explode(".", $name)));
            /** Não é uma extensão permitida **/
            return 11;
        }
    }

    $arrName = explode('.', $name);
    $ext = end($arrName);
    $finalName = strtolower($nomeFinalDoArquivo . rand(1, 9999) . '.' . $ext);

    $path = $caminhoNoServidor . DIRECTORY_SEPARATOR . $finalName;

    $copy = copy($tmp_name, $path);
    //if (move_uploaded_file($tmp_name, $path)) {
    if ($copy) {
        chmod($path, 0777);
        //echo(basename($path)) . '<br />';
    } else {
        return 15; // não conseguiu copiar
    }

    /** se for imagem **/
    if (preg_match('/image\//i', $type)) {
        $arch = $caminhoNoServidor . DIRECTORY_SEPARATOR . $finalName;

        if (preg_match('/^jpe?g$/i', $ext)) {
            $img = imagecreatefromjpeg($arch);
        } elseif (preg_match('/^gif$/i', $ext)) {
            $img = imagecreatefromgif($arch);
        } elseif (preg_match('/^png$/i', $ext)) {
            $img = imagecreatefrompng($arch);
        }

        /** Teste para ver se quer borda **/
        if ($raio !== 0 && $bgcolor !== '') {
            $largura = $raio * 2;
            $i_x = imagesx($img);
            $i_y = imagesy($img);

            //transforma cor hex para dec
            if (preg_match('/#[[:digit:]a-f]{4}/i', $bgcolor)) {
                $cor = hex2dec($bgcolor);
            } else {
                $cor = hex2dec('#000000');
                die(print_r($cor) . $bgcolor);
            }

            $color = imagecolorallocate($img, $cor['R'], $cor['G'], $cor['B']);

            for ($i = 0; $i <= 100; $i++) {
                //superior direita
                imagefilledarc($img, ($i_x - (($raio - 2) - 0)), ($raio - 2), $largura + $i, $largura + $i, -90, 0, $color, IMG_ARC_NOFILL);

                //superior esquerda
                imagefilledarc($img, (($raio - 2) - $i), (($raio - 2) - $i), $largura - $i, $largura - $i, 180, -90, $color, IMG_ARC_NOFILL);

                //inferior direita
                imagefilledarc($img, ($i_x - (($raio - 2) - $i)), ($i_y - (($raio - 2) - $i)), $largura - $i, $largura - $i, 0, -270, $color, IMG_ARC_NOFILL);

                //inferior esquerda
                imagefilledarc($img, ($raio - 2), (($i_y) - ($raio - 2)), $largura + $i, $largura + $i, -270, 180, $color, IMG_ARC_NOFILL);
            }

            //filtro para remover o serrilhado da imagem PHP5
            imagefilter($img, IMG_FILTER_SMOOTH, 8);

        }

        $larguraO = imagesx($img); // pegar a largura da amostra
        $alturaO = imagesy($img);
        //echo 'i: ' . $larguraO . ' - i: ' . $alturaO . '<br />';

        if ($orientacao == 'H' || $orientacao == 'V') {
            if ($larguraO > $alturaO) {
                $codOrientacao = 'H';
            } else {
                $codOrientacao = 'V';
            }
            if ($codOrientacao == 'H' && $orientacao != 'H') {
                unlink($arch);
                return 12;
            }

            if ($codOrientacao == 'V' && $orientacao != 'V') {
                unlink($arch);
                return 13;
            }
        }

        /** Teste para redimensionar **/
        if ($larguraMaxima != null && $alturaMaxima != null) {
            if (($larguraO > $larguraMaxima) || ($alturaO > $alturaMaxima)) {
                //se for maior do q ta pedindo nao redimensiona
                if ($larguraO > $alturaO) {
                    $larguraCopia = $larguraMaxima;
                    $alturaCopia = ($alturaO * $larguraCopia) / $larguraO;

                } else {
                    $alturaCopia = $alturaMaxima;
                    $larguraCopia = ($larguraO * $alturaCopia) / $alturaO;
                }
            } else {
                $larguraCopia = $larguraO;
                $alturaCopia = $alturaO;
            }
        } else {
            $larguraCopia = $larguraO;
            $alturaCopia = $alturaO;
        }

        $novaCopia = imagecreatetruecolor($larguraCopia, $alturaCopia);
        imagecopyresampled($novaCopia, $img, 0, 0, 0, 0, $larguraCopia, $alturaCopia, $larguraO, $alturaO); //copia

        imagejpeg($novaCopia, $arch, 92);
        imagedestroy($novaCopia);
    }

    return $finalName;
}

/**
 * apagaArquivos()
 *
 * Apaga um ou mais arquivos do servidor.
 *
 * Ex: apagaArquivos(string $arquivo1 [, string $...  ])
 *
 * @return bool
 */
function apagaArquivos()
{
    $args = func_get_args();
    foreach ($args as $a) {
        if (is_file($a)) {
            if (!unlink($a)) {
                throw new Exception("ERRO NO M&Eacute;TODO APAGA ARQUIVO " . $a);
            }
        }
    }
    return true;
}

function insere_foto_fixa($caminho, $tamanho_max, $disposicao)
{
    //// disposicao lar ou alt
    $foto = $_FILES['file']['name'];
    $arquivo_temporario = $_FILES['file']['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('dmy');
    $foto = "foto_" . $hoje . "_" . rand(0, 10000) . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES['file']['name'] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if ((($disposicao == "lar") && ($largurao > $tamanho_max)) || (($disposicao == "alt") && ($alturao > $tamanho_max))) { //se for maior do q ta pedindo nao redimensiona

                if (strtolower($disposicao) == "lar") {
                    $largura_copia = $tamanho_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $tamanho_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            /*echo "Largura_copia:".$largura_copia;
            echo "<br>Altura_copia:".$altura_copia;
            echo "<br>Tamanho_max:".$tamanho_max;*/
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto($file_name, $arquivo_temporario, $caminho, $largura_max, $altura_max)
{
    $foto = $file_name;
    $arquivo_temporario = $arquivo_temporario;

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('YmdHis');
    $foto = "foto_" . $hoje . "_" . rand(1, 10000) . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($foto != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagealphablending($nova_copia, false);
			imagesavealpha($nova_copia, true);  
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia
            
            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                imagejpeg($nova_copia, $arch, 100);
            } elseif ($ext == "gif" || $ext == "GIF") {
                imagegif($nova_copia, $arch, 100);
            } elseif ($ext == "png" || $ext == "PNG") {
                imagepng($nova_copia, $arch);
            }
            //imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_media($caminho, $largura_max, $altura_max, $nome)
{
    $foto = $_FILES['file']['name'];
    $arquivo_temporario = $_FILES['file']['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "media_" . $nome;

    $diret = $caminho;

    if ($foto != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if ($largurao > $alturao) {
                $largura_copia = $largura_max;
                $altura_copia = ($alturao * $largura_copia) / $largurao;

            } else {
                $altura_copia = $altura_max;
                $largura_copia = ($largurao * $altura_copia) / $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_mini($caminho, $largura_max, $altura_max, $nome)
{
    $foto = $_FILES['file']['name'];
    $arquivo_temporario = $_FILES['file']['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = $hoje . $nome . "." . $ext;

    $diret = $caminho;

    if ($foto != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if ($largurao > $alturao) {
                $largura_copia = $largura_max;
                $altura_copia = ($alturao * $largura_copia) / $largurao;

            } else {
                $altura_copia = $altura_max;
                $largura_copia = ($largurao * $altura_copia) / $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_galeria($caminho, $largura_max, $altura_max, $array)
{
    $foto = $_FILES['fotos']['name'][$array];
    $arquivo_temporario = $_FILES['fotos']['tmp_name'][$array];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "foto_" . $hoje . "_" . $array . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES['fotos']['name'][$array] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_galeria_mini($caminho, $largura_max, $altura_max, $array)
{
    $foto = $_FILES['fotos']['name'][$array];
    $arquivo_temporario = $_FILES['fotos']['tmp_name'][$array];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "mini_" . $hoje . "_" . $array . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES['fotos']['name'][$array] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_wall($caminho, $largura_max, $altura_max, $campo, $prefixo)
{
    $foto = $_FILES[$campo]['name'];
    $arquivo_temporario = $_FILES[$campo]['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "wall_" . $prefixo . "_" . $hoje . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES[$campo]['name'] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_wall_mini($caminho, $largura_max, $altura_max, $nome, $campo)
{
    $foto = $_FILES[$campo]['name'];
    $arquivo_temporario = $_FILES[$campo]['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "mini_" . $nome;

    $diret = $caminho;

    if ($foto != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if ($largurao > $alturao) {
                $largura_copia = $largura_max;
                $altura_copia = ($alturao * $largura_copia) / $largurao;

            } else {
                $altura_copia = $altura_max;
                $largura_copia = ($largurao * $altura_copia) / $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_2($caminho, $largura_max, $altura_max, $nome, $campo)
{
    $foto = $_FILES[$campo]['name'];
    $arquivo_temporario = $_FILES[$campo]['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "mini_" . $nome;

    $diret = $caminho;

    if ($foto != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if ($largurao > $alturao) {
                $largura_copia = $largura_max;
                $altura_copia = ($alturao * $largura_copia) / $largurao;

            } else {
                $altura_copia = $altura_max;
                $largura_copia = ($largurao * $altura_copia) / $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_borda($caminho, $largura_max, $altura_max, $raio, $bgcolor)
{
    $foto = $_FILES['file2']['name'];
    $arquivo_temporario = $_FILES['file2']['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "foto_" . $hoje . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES['file2']['name'] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largura = $raio * 2;
            $i_x = imagesx($img);
            $i_y = imagesy($img);

            //transforma cor hex para dec
            $color = imagecolorallocate($img, hexdec(substr($bgcolor, 0, 2)), hexdec(substr($bgcolor, 2, 2)), hexdec(substr($bgcolor, 4, 2)));

            for ($i = 0; $i <= 100; $i++) {
                //superior direita
                imagefilledarc($img, ($i_x - (($raio - 2) - 0)), ($raio - 2), $largura + $i, $largura + $i, -90, 0, $color, IMG_ARC_NOFILL);

                //superior esquerda
                imagefilledarc($img, (($raio - 2) - $i), (($raio - 2) - $i), $largura - $i, $largura - $i, 180, -90, $color, IMG_ARC_NOFILL);

                //inferior direita
                imagefilledarc($img, ($i_x - (($raio - 2) - $i)), ($i_y - (($raio - 2) - $i)), $largura - $i, $largura - $i, 0, -270, $color, IMG_ARC_NOFILL);

                //inferior esquerda
                imagefilledarc($img, ($raio - 2), (($i_y) - ($raio - 2)), $largura + $i, $largura + $i, -270, 180, $color, IMG_ARC_NOFILL);
            }

            //filtro para remover o serrilhado da imagem PHP5
            imagefilter($img, IMG_FILTER_SMOOTH, 8);

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }

            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 100);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_borda_novo($campo, $caminho, $largura_max, $altura_max, $raio, $bgcolor)
{
    $foto = $_FILES[$campo]['name'];
    $arquivo_temporario = $_FILES[$campo]['tmp_name'];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = "foto_" . $hoje . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES[$campo]['name'] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largura = $raio * 2;
            $i_x = imagesx($img);
            $i_y = imagesy($img);

            //transforma cor hex para dec
            $color = imagecolorallocate($img, hexdec(substr($bgcolor, 0, 2)), hexdec(substr($bgcolor, 2, 2)), hexdec(substr($bgcolor, 4, 2)));

            for ($i = 0; $i <= 100; $i++) {
                //superior direita
                imagefilledarc($img, ($i_x - (($raio - 2) - 0)), ($raio - 2), $largura + $i, $largura + $i, -90, 0, $color, IMG_ARC_NOFILL);

                //superior esquerda
                imagefilledarc($img, (($raio - 2) - $i), (($raio - 2) - $i), $largura - $i, $largura - $i, 180, -90, $color, IMG_ARC_NOFILL);

                //inferior direita
                imagefilledarc($img, ($i_x - (($raio - 2) - $i)), ($i_y - (($raio - 2) - $i)), $largura - $i, $largura - $i, 0, -270, $color, IMG_ARC_NOFILL);

                //inferior esquerda
                imagefilledarc($img, ($raio - 2), (($i_y) - ($raio - 2)), $largura + $i, $largura + $i, -270, 180, $color, IMG_ARC_NOFILL);
            }

            //filtro para remover o serrilhado da imagem PHP5
            imagefilter($img, IMG_FILTER_SMOOTH, 8);

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }

            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 100);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_noticias($caminho, $largura_max, $altura_max, $nome, $array)
{
    $foto = $_FILES['file']['name'][$array];
    $arquivo_temporario = $_FILES['file']['tmp_name'][$array];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = $nome . $hoje . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES['file']['name'][$array] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

function insere_foto_conteudo_exclusivo($caminho, $largura_max, $altura_max, $nome, $array)
{
    $foto = $_FILES['file']['name'][$array];
    $arquivo_temporario = $_FILES['file']['tmp_name'][$array];

    $ext = strrev($foto);
    $ext = explode(".", $ext);
    $ext = $ext[0];
    $ext = strrev($ext);
    $hoje = date('his_dmy');
    $foto = $nome . $hoje . "." . $ext;

    //echo $foto;
    $diret = $caminho;

    if ($_FILES['file']['name'][$array] != "") {
        $copy = copy($arquivo_temporario, $diret . "/" . $foto);
        if ($copy) {
            $fileerr = 0;
        } else {
            $fileerr = $fileerr + 1;
        }

        if ($fileerr != 0) {
            echo " <script language=\"JavaScript1.2\"> \n";
            echo " <!-- \n";
            //	echo " alert('Erro no envio da imagem. Foto não enviada.'); \n";
            //	echo " location.replace('fotos_lista.php'); \n";
            echo " //--> \n";
            echo " </script> \n";

            $foto = "";

        } else {
            $arch = $diret . "/" . $foto . "";

            if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG") {
                $img = imagecreatefromjpeg($arch);
            } elseif ($ext == "gif" || $ext == "GIF") {
                $img = imagecreatefromgif($arch);
            } elseif ($ext == "png" || $ext == "PNG") {
                $img = imagecreatefrompng($arch);
            }

            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);

            if (($largurao > $largura_max) || ($alturao > $altura_max)) { //se for maior do q ta pedindo nao redimensiona
                if ($largurao > $alturao) {
                    $largura_copia = $largura_max;
                    $altura_copia = ($alturao * $largura_copia) / $largurao;

                } else {
                    $altura_copia = $altura_max;
                    $largura_copia = ($largurao * $altura_copia) / $alturao;
                }
            } else {
                $largura_copia = $largurao;
                $altura_copia = $alturao;
            }
            $nova_copia = imagecreatetruecolor($largura_copia, $altura_copia);
            imagecopyresampled($nova_copia, $img, 0, 0, 0, 0, $largura_copia, $altura_copia, $largurao, $alturao); //copia

            imagejpeg($nova_copia, $arch, 92);
            imagedestroy($nova_copia);
        }
    }
    return $foto;
}

?>