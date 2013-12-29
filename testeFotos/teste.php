<?php
require_once '../configRoot.php';
function insere_foto_com_marca_dagua($file_name, $arquivo_temporario, $caminho, $largura_max, $altura_max, $marcaDagua, $posicao = 3)
{
    $foto = $file_name;
    $arquivo_temporario = $arquivo_temporario;
    
    $marcaDagua = $marcaDagua;
    $extMarcaDagua = strrev($marcaDagua);
    $extMarcaDagua = explode(".", $extMarcaDagua);
    $extMarcaDagua = $extMarcaDagua[0];
    $extMarcaDagua = strrev($extMarcaDagua);
    
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
            
            $imgMarcaDagua = imagecreatefrompng($marcaDagua);
            
            
            $largurao = imagesx($img); // pegar a largura da amostra
            $alturao = imagesy($img);
            $marcadaguaLargura = imagesx($imgMarcaDagua); // pegar a largura da imagem
            $marcadaguaAltura = imagesy($imgMarcaDagua);
            
            switch ($posicao) 
            {
                case 1: // Topo Esquerdo
                    $destX = 0;
                    $destY = 0;
                    break;
                case 2: // Topo Direito
                    $destX = $largurao - $marcadaguaLargura;
                    $destY = 0;
                    break;
                case 3: // Rodapé Direito
                    $destX = ($largurao - $marcadaguaLargura) - 15;
                    $destY = ($alturao - $marcadaguaAltura) - 15;
                    break;
                case 4: // Rodapé Esquerdo
                    $destX = 0;
                    $destY = $alturao - $marcadaguaAltura;
                    break;
                case 5: // Topo Centralizado
                    $destX = (($largurao - $marcadaguaLargura) / 2);
                    $destY = 0;
                    break;
                case 6: // Centro Direito
                    $destX = $largurao - $marcadaguaLargura;
                    $destY = ($alturao / 2) - ($marcadaguaAltura / 2);
                    break;
                case 7: // Rodapé Centralizado
                    $destX = (($largurao - $marcadaguaLargura) / 2);
                    $destY = $alturao - $marcadaguaAltura;
                    break;
                case 8: // Centro Esquerdo
                    $destX = 0;
                    $destY = ($alturao / 2) - ($marcadaguaAltura / 2);
                    break;
                case 0: // Centralizado
                default:
                    $destX = ($largurao / 2) - ($marcadaguaLargura / 2);
                    $destY = ($alturao / 2) - ($marcadaguaAltura / 2);
            }
            
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
            
            echo $arch;
            imagecopy($img, $imgMarcaDagua, $destX, $destY, 0, 0, $marcadaguaLargura, $marcadaguaAltura);  
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
            
        }
    }
    return $foto;
}
$submit = isset($_POST['envia']) ? $_POST['envia'] : '';
if($submit != '')
{
    $pasta = PROJECT_PATH.'testeFotos';
    $arquivo = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $foto_temp = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
    if($arquivo != '' && $foto_temp != '')
        insere_foto_com_marca_dagua($arquivo, $foto_temp, $pasta,'400','200', 'logo.png',3);
    else
        echo "Selecione uma foto<br /><br />";
}
?>
<form name="form" id="form" action="" method="post" enctype="multipart/form-data">
    <label>Foto:</label>
    <input type="file" name="file" id="file" title="Foto" /><br /><br />
    <input type="submit" name="envia" id="envia" value="Enviar" />
</form>