<?php

/**
 * returnResourceImage()
 * 
 * Retorna o resource de uma imagem a partir de uma existente.
 *  
 * Ex.: header("Content-Type: image/png");
 *		$img = returnResourceImage('botao.png', 'Futuramc.ttf', 20, 'Enviar');
 *		imagepng($img, '', 100);	
 *		imagedestroy($img);
 * 
 * Ex.: 
 * header('Content-Type: image/jpg');
 * 
 * $text = isset($_REQUEST['text']) ? $_REQUEST['text'] : 'Texto Padrão';
 * $img = returnResourceImage('../img/tituloPadrao.jpg', '../fonts/tahoma.ttf', 16, $text, 13, 20);
 * 
 * //// Envia uma imagem PNG para o browser ou para um arquivo
 * imagejpeg($img, '', 100);
 * imagedestroy($img);
 * 
 * @return resource
 */
function returnResourceImage($imgFile = '', $fontFile = '', $fontSize = 5, $text = '', $hAlign = 'center', $vAlign = 'middle')
{
    if (!function_exists('hex2dec')) {
        /**
         * hex2dec()
         *
         * Retorna um array associativo (keys: R,G,B) 
         * de um codigo html hexadecimal (ex. #3FE5AA).
         *  
         * @return array
         */
        function hex2dec()
        {
            //transforma cor hex para dec
            $hexPattern = '[0-9a-fA-F]{2}';

            $R = $G = $B = '00';
            $red = hexdec($R);
            $green = hexdec($G);
            $blue = hexdec($B);

            $numArgs = func_num_args();
            $args = func_get_args();
            if ($numArgs > 0) {
                if ($numArgs == 1) {
                    $pattern = sprintf('/^#?(?P<R>%s)(?P<G>%s)(?P<B>%s)$/i', $hexPattern, $hexPattern, $hexPattern);

                    $retorno = preg_match($pattern, $args[0], $parts);
                    if ($retorno) {
                        $R = isset($parts['R']) ? $parts['R'] : $R;
                        $red = hexdec($R);

                        $G = isset($parts['G']) ? $parts['G'] : $G;
                        $green = hexdec($G);

                        $B = isset($parts['B']) ? $parts['B'] : $B;
                        $blue = hexdec($B);
                    }
                }
                if ($numArgs == 3) {
                    $pattern = sprintf('/^(?P<C>%s)$/i', $hexPattern);

                    $retorno = preg_match($pattern, $args[0], $parts);
                    if ($retorno) {
                        $R = isset($parts['C']) ? $parts['C'] : $R;
                        $red = hexdec($R);
                    }

                    unset($retorno, $parts);
                    $retorno = preg_match($pattern, $args[1], $parts);
                    if ($retorno) {
                        $G = isset($parts['C']) ? $parts['C'] : $G;
                        $green = hexdec($G);
                    }

                    unset($retorno, $parts);
                    $retorno = preg_match($pattern, $args[2], $parts);
                    if ($retorno) {
                        $B = isset($parts['C']) ? $parts['C'] : $B;
                        $blue = hexdec($B);
                    }
                }
            }

            return array('R' => $red, #
                'G' => $green, #
                'B' => $blue);
        }
    }
    $err = '';
    $stopOnError = false;

    if (!is_file($fontFile)) {
        $fontSize = is_numeric($fontSize) && $fontSize <= 5 && $fontSize >= 1 ? $fontSize : 5;
    } else {
        $fontSize = is_numeric($fontSize) && $fontSize >= 1 ? $fontSize : 20;
    }

    $im = imagecreatetruecolor(600, 500); // Cria uma imagem em branco

    $cor = hex2dec('000000');
    $branco = imagecolorallocate($im, 255, 255, 255); // branco
    $preto = imagecolorallocate($im, $cor['R'], $cor['G'], $cor['B']); // preto
    //$preto = imagecolorallocate($im, 0, 0, 0); // preto
    $verde = imagecolorallocate($im, 0, 255, 0); //verde
    $laranja = imagecolorallocate($im, 220, 210, 60); // laranja
    $azul_claro = imagecolorallocate($im, 0, 156, 255); // azul claro
    
    $cor = hex2dec('600F16');
    $bordo = imagecolorallocate($im, $cor['R'], $cor['G'], $cor['B']); // bordo

    $bg_color = $branco;
    $text_color = $bordo;

    imagefilledrectangle($im, 0 + 1, 0 + 1, imagesx($im) - 2, imagesy($im) - 2, $bg_color); //desenha um retângulo

    $px = (imagesx($im) / 2) - (4.5 * strlen($text)); // posicao x do texto
    $py = (imagesy($im) / 2) - 7; // posicao y do texto

    if (is_file($imgFile)) {
        $arrName = explode('.', $imgFile);
        $ext = end($arrName);
        //testa a extensão do arquivo
        if (preg_match('/^jpe?g$/i', $ext)) {
            $im = imagecreatefromjpeg($imgFile);
        } elseif (preg_match('/^gif$/i', $ext)) {
            $im = imagecreatefromgif($imgFile);
        } elseif (preg_match('/^png$/i', $ext)) {
            $im = imagecreatefrompng($imgFile);
        } else {
            if (!empty($err)) {
                $err .= ' >> ';
            }
            $err .= 'Extensão (' . $ext . ') inválida(jpg, gif, png).';
        }
    } else {
        if (!empty($err)) {
            $err .= '|';
        }
        $err .= '>> Falta imagem base ' . $imgFile . '.';
    }
    if (!is_file($fontFile)) {
        if (!empty($err)) {
            $err .= ' >> ';
        }
        $err .= 'Falta fonte ' . $fontFile . '.';
    }

    if (!empty($err) && $stopOnError) {
        $px = 5; // posicao x
        $py = $fontSize + (is_file($fontFile) ? 5 : 0); // posicao y
        $text = $err;
    } else {
        switch ($hAlign) {
            case 'left':
                $px = 5; // posicao x
                break;
            case 'center':
            default:
                $px = (imagesx($im) / 2) - (4.5 * strlen($text)); // posicao x
        }
        switch ($vAlign) {
            case 'top':
                $py = $fontSize + (is_file($fontFile) ? 5 : 0); // posicao y
                break;
            case 'middle':
            default:
                $py = (imagesy($im) / 2) - 7; // posicao y
        }
        // teste para posição exata do texto
        $px = is_numeric($hAlign) && $hAlign >= 0 && $hAlign <= imagesx($im) ? $hAlign : $px; // posicao x
        $py = is_numeric($vAlign) && $vAlign >= 0 && $vAlign <= imagesy($im) ? $vAlign : $py; // posicao y
    }
    if (is_file($fontFile)) {
        imagettftext($im, $fontSize, 0, $px, $py, $text_color, $fontFile, $text); // poe o texto na imagem
    } else {
        imagestring($im, $fontSize, $px, $py, $text, $text_color);
    }

//    echo 'x: ' . $px . '<br />';
//    echo 'y: ' . $py . '<br />';
//    echo 'fontSize: ' . $fontSize . '<br />';

    $img = imagecreatetruecolor(imagesx($im), imagesy($im)); // Cria uma imagem em branco

    imagecopy($img, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
    return $im;
}


//header('Content-Type: image/jpg');
////header('Content-Type: text/html');
//
//$img = returnResourceImage('img/banner_maior_leg_beauty1..jpg', 'fontes/Futuramc.ttf', 30, 'Luis Fernando Gomes T', 295, 57);
////$img = mostraBotao('', '');
//
//// Envia uma imagem PNG para o browser ou para um arquivo
//imagejpeg($img, '', 100);
//imagedestroy($img);

/**
 * mostraBotao()
 * 
 * Usada para criar uma imagem a partir de uma existente.
 *  
 * Ex.: header("Content-Type: image/png");
 *		$imagem = mostraBotao('botao.png', 'Enviar');
 *		imagepng($img);	
 *		imagedestroy($img);
 * 
 * @param mixed $imgname
 * @param mixed $text
 * @return void
 */
function mostraBotao($imgname, $text)
{
    $im = imagecreatefrompng($imgname);
    if (!$im) {
        /* Ve se ele falhou */
        $im = imagecreatetruecolor(150, 30);
        /* Cria uma imagem em branco */
        $bg_color = imagecolorallocate($im, 255, 255, 255); // branco
        $text_color = imagecolorallocate($im, 0, 0, 0); // preto
        imagefilledrectangle($im, 0 + 1, 0 + 1, imagesx($im) - 2, imagesy($im) - 2, $bg_color);
        /* Saída de uma mensagem de erro */
        imagestring($im, 1, 5, 5, "Erro ao carregar $imgname", $text_color);
    }
    $verde = imagecolorallocate($im, 0, 255, 0); //verde
    $laranja = imagecolorallocate($im, 220, 210, 60); // laranja
    $azul_claro = imagecolorallocate($im, 0, 156, 255); // azul claro
    $branco = imagecolorallocate($im, 255, 255, 255); // branco
    $px = imagesx($im) / 2 - (4.5 * strlen($text)); // posicao x
    $py = imagesy($im) / 2 - 7; // posicao y
    imagestring($im, 5, $px, $py, $text, $branco);
    return $im;
}

?>