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
$cod = isset($_GET['cod']) ? $_GET['cod'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
if($submit != "")
{
	$codLable = isset($_POST['lable']) ? $_POST['lable'] : '';
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
    if ($erro == 0)
    {
        $dataen = dataEn($data);
        $cleanTitulo = mg_substituirEspacosPorTreacos($titulo);
        $dataAlteracao = date('Y-m-d H:i:s');
		$sql = "UPDATE noticias SET
							codLable = ('{$codLable}'),
							titulo = ('{$titulo}'),
                            cleanTitulo = ('{$cleanTitulo}'),
							data = ('{$dataen}'),
                            dataAlteracao = ('{$dataAlteracao}'),
							resumo = ('{$resumo}'),	
							texto = ('{$texto}'),
                            videoDestaque = ('{$videoDestaque}'),
                            video = ('{$video}'),
							fonte = ('{$fonte}')
							WHERE cod = ('{$cod}')";
		$resultado = mysql_query($sql);
		
		$resultadoArquivo = mysql_query("SELECT * FROM arquivos WHERE codReferencia = {$cod} AND tipo = '3' AND referencia = 'noticias'", $conexao);
		$objsFotosNum = mysql_num_rows($resultadoArquivo);
		
		if ($objsFotosNum > 0)
		{
			for ($ac = 0;$ac < $objsFotosNum; $ac++)
			{	
				$codigo = isset($_POST['codfile'][$ac]) ? $_POST['codfile'][$ac] : '';
				$legenda1 = isset($_POST['legenda1'][$ac]) ? $_POST['legenda1'][$ac] : '';		
				$sql3 = "UPDATE arquivos SET
				legenda = ('{$legenda1}') WHERE 
				codigo = ('{$codigo}') AND 
				codReferencia = ('{$cod}') AND
				referencia = 'noticias'";
			
				$resultado = mysql_query($sql3);
			}
		}
		if ($objsFotosNum > 0)
			{
				
				$sqlDestaque = "UPDATE arquivos SET
							capa = '0'
							WHERE codReferencia = '$cod' AND referencia = 'noticias'";
				$resultadoDestaque = mysql_query($sqlDestaque);
				
				for ($i = 0; $i < $objsFotosNum; $i++)
				{
					$destaque = isset($_POST['destaque'][$i]) ? $_POST['destaque'][$i] : '' ;
		
					$sqlDestaque = "UPDATE arquivos SET
								capa = '1'
								WHERE codReferencia = '$cod' AND codigo = '$destaque' AND referencia = 'noticias'";
					$resultadoDestaque = mysql_query($sqlDestaque);
				}
		
			}
			$rn = count(isset($_POST['apagarArquivos']) ? $_POST['apagarArquivos'] : array());
	 
			if ($rn > 0)
			{
			for ($ab = 0;$ab < $rn;$ab++)
				{
						$exclusoes = isset($_POST['apagarArquivos'][$ab]) ? $_POST['apagarArquivos'][$ab] : '' ;
						 if ($exclusoes !="") 
					{	
							$objsArquivo = mysql_query("SELECT arquivo FROM arquivos WHERE codigo ='$exclusoes' AND referencia = 'noticias' AND codReferencia = '{$cod}'");
							$qtdObjsArquivo = mysql_num_rows($objsArquivo);
							
							for ($j = 0; $j < $qtdObjsArquivo; $j++)
						 {
							$exc = mysql_fetch_assoc($objsArquivo);
							unlink(PROJECT_PATH."arquivos/noticias/".$exc['arquivo']);
						 }
						$sql_apaga = "DELETE FROM arquivos WHERE codigo = '$exclusoes' AND referencia = 'noticias' AND codReferencia = '{$cod}'";
						$resultadoapaga = mysql_query($sql_apaga);
						
                        $sqlSelectCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND referencia = 'noticias' AND capa = '1'");
						$linhasSelectCapa = mysql_num_rows($sqlSelectCapa);
						
						if($linhasSelectCapa == 0)
						{
							$sqlMarcaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND referencia = 'noticias' AND capa = '0' LIMIT 1");
							$tpMarcaCapa = mysql_fetch_assoc($sqlMarcaCapa);
							$sqlUpCapa = "UPDATE arquivos SET
                                    capa = '1'
                                    WHERE codReferencia = '$cod' AND codigo = '{$tpMarcaCapa['codigo']}' AND referencia = 'noticias'";
        	            	$resultadoUpCapa = mysql_query($sqlUpCapa);
						}
					}
				}
			}
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
				$qFotosBanco = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$cod' AND referencia = 'noticias'");
    			$nFotosBanco = mysql_num_rows($qFotosBanco);
				
				for ($ab = 0;$ab < $numfotos; $ab++)
				{
					if ($foto != "")
					{
                        if ($nFotosBanco > 0)
                        {
                            $capa = 0;
							
                        }
                        elseif ($numfotos == 1 && $nFotosBanco < 1)
                        {
                            $capa = 1;
							
                        }
                        elseif ($numfotos > 1 && $ab == 0)
                        {
                            $capa = 1;
							
                        }
                        else
                        {
                            $capa = 0;
                        } 
					
					$foto = $_FILES['file']['name'][$ab];
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
						$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$cod}', '{$dataCadastro}', '1', '{$ncodigo}', '{$fotoG}', '{$legenda}', '$capa')";
						$resultado = mysql_query($sql);					
						$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$cod}', '{$dataCadastro}', '2', '{$ncodigo}', '{$fotoM}', '{$legenda}', '$capa')";
						$resultado = mysql_query($sql);					
						$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$cod}', '{$dataCadastro}', '3', '{$ncodigo}', '{$fotoP}', '{$legenda}', '$capa')";
						$resultado = mysql_query($sql);
					    /*$sql = "INSERT INTO arquivos (referencia, codReferencia, dataCadastro, tipo, codigo, arquivo, legenda, capa) VALUES ('noticias', '{$cod}', '{$dataCadastro}', '4', '{$ncodigo}', '{$fotoPP}', '{$legenda}', '$capa')";
						$resultado = mysql_query($sql);*/
					}
				}
			}
		}
	}
        //echo mysql_errno() . ": " . mysql_error() . "\n";
        if($resultado)
    	{
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
 	$resultado2 = mysql_query("SELECT * FROM noticias WHERE cod = {$cod}", $conexao);
	$tupla = mysql_fetch_assoc($resultado2);
	$codLable = $tupla['codLable'];
	$titulo = $tupla['titulo'];
	$fonte = $tupla['fonte'];
	$resumo = $tupla['resumo'];
	$texto = $tupla['texto'];
    $videoDestaque = $tupla['videoDestaque'];
	$video = $tupla['video'];
	$data = $tupla["data"];
	$data2 = explode('-', $data);
	$data5 = $data2[2].'/'.$data2[1].'/'.$data2[0];  
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
                    $sqlLables = mysql_query("SELECT * FROM noticiasLables ORDER BY titulo");
                    $numLables = mysql_num_rows($sqlLables);
                    for($x = 0;$x < $numLables; $x++)
                    {
                        $tpLable = mysql_fetch_assoc($sqlLables);
                    ?>
                        <option value="<?=$tpLable['cod'];?>" <?=$tpLable['cod'] == $codLable ? 'selected="selected"' : '';?>><?=$tpLable['titulo'];?></option>
                    <?
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="titulo"><span class="obrigatorio">*</span> T&iacute;tulo: </label><input type="text" name="titulo" id="titulo" title="Título" value="<?=$titulo;?>" />
            </div>
            <div>
                <label for="data"><span class="obrigatorio">*</span> Data: </label><input type="text" name="data" id="data" title="Data" value="<?=$data5;?>" />
            </div>
            <div>
                <label for="resumo"><span class="obrigatorio">*</span> Resumo: </label><textarea name="resumo" id="resumo" title="Resumo"/><?=$resumo;?></textarea>
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
            <div>
                <script type="text/javascript" src="./js/noticias_novo_edita.js"></script>   
                <label for="numFotos">N&ordm; de Fotos: </label></td>
                <input type="button" value="-" name="menosFotos" id="menosFotos" class="estiloBotao1"/>
                &nbsp;<input type="text" name="numFotos" id="numFotos" class="tiny" />&nbsp;
                <input type="button" value="+" name="maisFotos" id="maisFotos" class="estiloBotao1"/>
            </div>    
            <div id="groupDivs" >
                <!-- AQUI VÃO OS INPUTS PRA UPLOAD DE ARQUIVO -->
            </div> 
        <?
    		$resultadoArquivo = mysql_query("SELECT * FROM arquivos WHERE codReferencia = {$cod} AND tipo = '3' AND referencia = 'noticias'", $conexao);
    		
    		$linhas = mysql_num_rows($resultadoArquivo);
    		if($linhas > 0)
    		{
    			echo "<br /><hr /><b>Fotos Já Cadastradas</b><hr /><br />";
                for($ab = 0;$ab < $linhas; $ab++)
    			{
                    $tupla2 = mysql_fetch_assoc($resultadoArquivo);
		?>
                    <div style="border: 1px solid; padding: 5px; width: 191px; margin-bottom: 5px; float: left; margin-right: 5px;;">
                        <div style="height: 142px;">
                            <td class="txtpreto"><img src="http://<?=PROJECT_URL;?>/arquivos/noticias/<?=$tupla2['arquivo'];?>" /></td>
                        </div>
                        <div>
                            <label style="width: 56px;" for="legenda">Legenda:</label>
                            <input name="legenda1[]" type="text" style="width: 122px;" id="legenda1" title="Legenda" value="<?=$tupla2['legenda'];?>"/>
                            <input name="codfile[]" type="hidden" id="file" size="50" value="<?=$tupla2['codigo'];?>" />
                        </div>
                        <div> 
                            <label style="width: 56px; margin-right: 6px">Apagar: </label>
                            <input type="checkbox" name="apagarArquivos[]" title="Apagar Foto" value="<?=$tupla2['codigo'];?>" />
                        </div>
                        <div>
                            <label style="width: 48px; margin-right: 12px">Destaque: </label>
                            <input type="radio" id="destaque<?=$ab;?>" <?=$tupla2['capa'] == "1" ? "checked='true'" : '' ;?> name="destaque[]" title="Foto Destaque" value="<?=$tupla2['codigo'];?>" />
                        </div>
                    </div>
        <?
    			}
    		}
        ?>   
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