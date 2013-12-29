<?php



if(!verifica_permissao($cod_user, $nivel_user, "noticias"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'noticias_topo.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH.'fotos.php';
require_once ADMIN_FUNC_PATH . 'formatting.php';
//require_once ADMIN_FUNC_PATH.'validaCampo.php';

$dataCadastro = date('Y-m-d'); 
$texto = "";
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
if($submit != "")
{
	$codLable = isset($_POST['lable'])? $_POST['lable'] : '' ;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $data = isset($_POST['data']) ? $_POST['data'] : '';
    $resumo = isset($_POST['resumo']) ? $_POST['resumo'] : '';
    $texto = isset($_POST['texto']) ? $_POST['texto'] : '';
    $fonte = isset($_POST['fonte']) ? $_POST['fonte'] : '';
    $legenda = isset($_POST['legenda']) ? $_POST['legenda'] : '';
	$video = isset($_POST['video']) ? $_POST['video'] : '';
    $videoDestaque = isset($_POST['videoDestaque']) ? $_POST['videoDestaque'] : 0;
    
    
	$erro = 0;
	
	echo '<ul>';
    if (validaCampo($titulo) == 0) 
    {
      echo '<li>O campo Título deve ser preenchido corretamente!</li>';
      $erro = 1;
    }
    
    if (validaCampo($data) == 0) 
    {
      echo '<li>O campo Data deve ser preenchido corretamente!</li>';
      $erro = 1;
    }
    
    if (validaCampo($resumo) == 0) 
    {
      echo '<li>O campo Resumo deve ser preenchido corretamente!</li>';
      $erro = 1;
    }
    
    if ($texto == '<br />') 
    {
      echo '<li>O campo Texto deve ser preenchido corretamente!</li>';
      $erro = 1;
    }
    
    $numfotos = count($_FILES['file']['name']);
    for ($x = 0;$x < $numfotos; $x++)
    {
        $foto = $_FILES['file']['name'][$x];
        if($foto != '')
        {
            $formato = $_FILES['file']['name'][$x];
            $formato = strrev($formato);
            $formato = explode('.',$formato);
            $formato = $formato[0];
            $formato = strrev($formato);
            $formato = strtolower($formato);
        }
        $extensoesvalidas = array("jpg","jpeg","png");
        
        if($foto != '' && !in_array($formato,$extensoesvalidas))
        {
            echo '<li>Formato de arquivo inválido!</li>';
            $erro = 1;
            break;
        }
    }

	echo '</ul>';

    if ($erro == 0)
    {
        $dataen = dataEn($data);
        $cleanTitulo = mg_substituirEspacosPorTreacos($titulo);
        $dataCadastro = date('Y-m-d H:i:s');
        if ($foto != "")
		{
		    if (!in_array($formato,$extensoesvalidas))
            {
                echo "<script>
                              alert('Extensão de foto inválida para upload.');
                              $('#submit').focus();
                              return false;
                      </script>";
                exit();
            }
            else
            {
                $sql = "INSERT INTO noticias (codlable, titulo, cleanTitulo, data, dataCadastro, resumo, texto, fonte, videoDestaque, video) VALUES ('{$codLable}','{$titulo}','{$cleanTitulo}','{$dataen}','{$dataCadastro}','{$resumo}','{$texto}','{$fonte}', '{$videoDestaque}', '{$video}')";
            }
        }
		else
		{
			$sql = "INSERT INTO noticias (codlable, titulo, cleanTitulo, data, dataCadastro, resumo, texto, fonte, videoDestaque, video) VALUES ('{$codLable}','{$titulo}','{$cleanTitulo}','{$dataen}','{$dataCadastro}','{$resumo}','{$texto}','{$fonte}', '{$videoDestaque}', '{$video}')";
        }	
		$resultado = mysql_query($sql);
        //echo mysql_errno() . ": " . mysql_error() . "\n";
        if($resultado)
    	{
			for ($ab = 0;$ab < $numfotos; $ab++)
			{
				$sql = "SELECT cod FROM noticias ORDER BY cod DESC LIMIT 1";
				//echo mysql_errno() . ": " . mysql_error() . "\n<br>";	
				$resultado = mysql_query($sql);
				$noticias = mysql_fetch_assoc($resultado);
				
				$foto = $_FILES['file']['name'][$ab];
				
				if($foto != "")
				{
					if ($numfotos == 1)
                   {
                       $destaque = 1;
                   }
                   elseif ($numfotos > 1 && $ab == 0)
                   {
                       $destaque = 1;
                   }
                   else
                   {
                       $destaque = 0;
                   } 
				   	$legenda = $_POST['legenda'][$ab];	
					$nomefototemp = $_FILES['file']['tmp_name'][$ab];
					$pasta = PROJECT_PATH."arquivos/noticias/";
					//$nomearquivo = insere_foto($pasta);
					$ncodigo = date('dmyHis').rand(0,9999999999);
					$fotoG = insere_foto($foto,$nomefototemp,$pasta,800,600);
					$fotoM = insere_foto($foto,$nomefototemp,$pasta,361,265);
					$fotoP = insere_foto($foto,$nomefototemp,$pasta,138,95);
					//$fotoPP = insere_foto($foto,$nomefototemp,$pasta,153,115);			
					if($foto != "")
					{
						$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$noticias['cod']}', '{$dataCadastro}', '1', '{$ncodigo}', '{$fotoG}', '{$legenda}', '{$destaque}')";
						$resultado = mysql_query($sql);
						$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$noticias['cod']}', '{$dataCadastro}', '2', '{$ncodigo}', '{$fotoM}', '{$legenda}', '{$destaque}')";
						$resultado = mysql_query($sql);
						$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$noticias['cod']}', '{$dataCadastro}', '3', '{$ncodigo}', '{$fotoP}', '{$legenda}', '{$destaque}')";
						$resultado = mysql_query($sql);
                        //$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$noticias['cod']}', '{$dataCadastro}', '4', '{$ncodigo}', '{$fotoPP}', '{$legenda}', '{$destaque}')";
						//$resultado = mysql_query($sql);
					}
				}
			}
    		echo " <script language=\"JavaScript1.2\"> \n";
    		echo " <!-- \n";
    		echo " alert('Cadastro realizado com sucesso!'); \n";
    		echo " location.replace('principal.php?id=2&subid=1'); \n";
    		echo " //--> \n";
    		echo " </script> \n";
    	}
    	else
    	{
    		echo " <script language=\"JavaScript1.2\"> \n";
    		echo " <!-- \n";
    		echo " alert('Cadastro não efetuado.'); \n";
    		echo " location.replace('principal.php?id=2&subid=1'); \n";
    		echo " //--> \n";
    		echo " </script> \n";
    	}
    }
}
else
{
	$lable = '';
    $titulo = '';
    $data = '';
    $resumo = '';
    $texto = '';
    $fonte = '';
    $legenda = '';
    $foto = '';
    $video = '';
    $videoDestaque = 0;
}
?>
<script type="text/javascript" src="./js/validador1.4.js"></script>

<div id="contentFormNovoEdita" style="width: 850px;">
    <form id="cadastro" method="post" action="" enctype="multipart/form-data">
   		 <fieldset>
  			<legend>Dados Principais</legend>
            <div>
                <label for="lable"> Lable: </label>
                <select name="lable" id="lable" title="Lable">
                    <option value="">Selecione</option>
                    <?
                    $sqlLable = mysql_query("SELECT * FROM noticiasLables ORDER BY titulo");
                    $numLable = mysql_num_rows($sqlLable);
                    for($x = 0;$x < $numLable;$x++)
                    {
                        $tpLable = mysql_fetch_assoc($sqlLable);
                    ?>
                        <option value="<?=$tpLable['cod'];?>" <?=$tpLable['cod'] == $lable ? 'selected="selected"' : '';?>><?=$tpLable['titulo'];?></option>
                    <?
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="titulo"><span class="obrigatorio">*</span> T&iacute;tulo: </label><input type="text" name="titulo" id="titulo" title="Título" value="<?=$titulo;?>" />
            </div>       
            <div>
                <label for="data"><span class="obrigatorio">*</span> Data: </label><input type="text" name="data" id="data" title="Data" value="<?=$data;?>" />
            </div>
            <div>
                <label for="resumo"><span class="obrigatorio">*</span> Resumo: </label><textarea name="resumo" id="resumo" title="Resumo" /><?=$resumo;?></textarea>
            </div>
            <div>
                  <label for="texto"><span class="obrigatorio">*</span> Texto: </label>
                  <?php
                    require_once ADMIN_FUNC_PATH . 'imprimeTinymce.php';
        	    	imprimeTinymce('texto', stripcslashes($texto), 545);
        	      ?>    
            </div>
            <div>
                <label for="fonte"> Fonte: </label><input type="text" name="fonte" id="fonte" title="Fonte" value="<?=$fonte;?>" />
            </div>
        </fieldset>
        <fieldset>
            <legend>Video</legend>
            <div>
                <label><input type="checkbox" name="videoDestaque" id="videoDestaque" title="Utilizar video como destaque" <?=$videoDestaque > 0 ? 'checked="checked"' : '';?> value="1" /></label>Utilizar video como destaque.
            </div>
            <div>
                <label for="video">Link do Video: </label><input type="text" name="video" id="video" title="Video" value="<?=$video;?>" />
            </div>
        </fieldset> 
        <fieldset>
            <legend>Fotos</legend>
            <script type="text/javascript" src="./js/noticias_novo_edita.js"></script>   
            <div>
                <label for="numFotos">N&ordm; de Fotos: </label>
                <input type="button" value="-" name="menosFotos" id="menosFotos" class="estiloBotao1"/>
                &nbsp;<input type="text" name="numFotos" id="numFotos" class="tiny" />&nbsp;
                <input type="button" value="+" name="maisFotos" id="maisFotos" class="estiloBotao1"/>
            </div>
            <div id="groupDivs" >
                <!-- AQUI VÃO OS INPUTS PRA UPLOAD DE ARQUIVO -->
            </div> 
        </fieldset> 
          
        <div class="contentButton" style="float: right; margin-top: 5px;">
            <input class="botaoDourado" type="submit" name="submit" id="submit" title="Enviar" value="Enviar"/>
        </div>
        <div style=" margin-top: 5px;color:#F00; float:right; width:170px; margin-right:187px;">* Campos Obrigatórios</div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        objValidador = new xform('form#cadastro');
        //adicionar(campo, tipoValidacao, branco, confirmacao, objConfirmacao)
        objValidador.adicionar('input#titulo');
		objValidador.adicionar('input#data','dataBr');
        objValidador.adicionar('textarea#resumo');		
        /*objValidador.adicionar('#fonte');*/ 
    });
</script>
