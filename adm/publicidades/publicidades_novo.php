<?php
if(!verifica_permissao($cod_user, $nivel_user, 'publicidades'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."publicidades_topo.php";
require_once ADMIN_FUNC_PATH.'fotos.php';

$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";

if($submit != '')
{    
    $empresa = isset($_POST['empresa'])? escape($_POST['empresa']) : '' ;
	$tipoArquivo = isset($_POST['extensao'])? escape($_POST['extensao']) : '' ;
	$link = isset($_POST['link'])? escape($_POST['link']) : '' ;
    $pagina = isset($_POST['pagina'])? escape($_POST['pagina']) : '' ;
    $tipo = isset($_POST['tipo'])? escape($_POST['tipo']) : '' ;
    $dataInicio = $_POST['dataInicio'] != '' ? $_POST['dataInicio'] : '' ;
    $dataFim = $_POST['dataFim'] != '' ? $_POST['dataFim'] : '' ;
    $mostrar = isset($_POST['mostrar']) ? escape($_POST['mostrar']) : 0;
    $arquivo = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    
	$extensaoArquivo = pathinfo($arquivo, PATHINFO_EXTENSION);
	
	$erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
	
    if (!validaCampo($empresa))
    {
        $msg .= '<li>O campo Empresa deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($pagina))
    {
        $msg .= '<li>O campo Página deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($tipo))
    {
        $msg .= '<li>O campo Tipo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
	
	$tamanhoW = 0;
	$tamanhoH = 0;
	
	if($tipo == '1'){
		$tamanhoW = 346;
		$tamanhoH = 220;
	}elseif($tipo == '2'){
		$tamanhoW = 796;
		$tamanhoH = 68;
	}elseif($tipo == '3'){
		$tamanhoW = 260;
		$tamanhoH = 89;
	}elseif($tipo == '4'){
		$tamanhoW = 634;
		$tamanhoH = 167;
	}elseif($tipo == '5'){
		$tamanhoW = 153;
		$tamanhoH = 243;
	}elseif($tipo == '6'){
		$tamanhoW = 153;
		$tamanhoH = 128;
	}
		
	if($arquivo != '')
	{
		$formato = $_FILES['file']['name'];
		$formato = strrev($formato);
		$formato = explode('.',$formato);
		$formato = $formato[0];
		$formato = strrev($formato);
		$formato = strtolower($formato);
		$extensoesvalidas = array("jpg","jpeg","png","gif","swf");
		if(!in_array($formato,$extensoesvalidas))
		{
			$msg .= '<li>Formato de imagem inválido!</li>';
			$erro = 1;
		}
		
		$tamImg = getimagesize($_FILES['file']['tmp_name']);
		$w = $tamImg[0];
		$h = $tamImg[1];
		
		if($w != $tamanhoW || $h != $tamanhoH)
		{
			$msg .= '<li>Tamanho da imagem deve ser '.$tamanhoW.' x '.$tamanhoH.' px !</li>';
			$erro = 1;
		}
	}
	else
	{
		$msg .= '<li>O campo Arquivo deve ser preenchido corretamente!</li>';
		$erro = 1;    
	}
	
    $msg .= '</ul>';
    
    
    if($erro == 0)
    {
		$dataInicio = dataEn($dataInicio);
        $dataFim = dataEn($dataFim);
        $sql = "INSERT INTO publicidades (empresa, link, codPagina,  codTipo, tipoArquivo, dataInicio, dataFim, mostrar)
                VALUES(
                '{$empresa}', '{$link}', '{$pagina}', '{$tipo}', '{$tipoArquivo}','{$dataInicio}', '{$dataFim}', '{$mostrar}');";
    	//echo $sql;
		//die();
		$resultado = mysql_query($sql);
    	 
		 
		    	
		if($arquivo != '')
		{
			$codRef = mysql_insert_id();
			$arquivo_temp = $_FILES['file']['tmp_name'];
			$token = rand(1,99999).date('dmYHis');
			$pasta = PROJECT_PATH."arquivos/publicidades";
					 //uploadArquivo('file', $i, $diretorio, 'gd_', null, $extensoesPermitidas, 426, 320);
			$fileG = uploadArquivo('file', -1, $pasta,  'flash_', null, 'swf', $tamanhoW ,$tamanhoH);
			$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
					VALUES ('publicidade', '{$codRef}','1', '{$fileG}','$token')";
			$resultadoG = mysql_query($sqlG);
		}
		
    	
		if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=11&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=11&subid=1'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{        
    $empresa = '';
	$link = '';
    $pagina = '';
    $tipo = '';
    $dataInicio = '';
    $dataFim = '';
    $mostrar = 0;
    $foto = '';
	$tipoArquivo = '';
}
?>

<script type="text/javascript">
$(document).ready(function()
{
    $('#extensao').change(function()
    {
        if($(this).val() == 2)
        {
            $(".link").hide(500);
		}
		else
		{
			$(".link").show(500);
		}
		
	});
	
	$('#pagina').change(function()
    {
        if($(this).val())
        {
            $('#tipo').hide();
            $('.carregando').show();
            
            $.ajax(
            {
                type: "POST",
                url: "ajax/ajaxPubliTipo.php",
                data:
                {
                    cod: $(this).val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">Selecione</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '">' + j[i].tipo + '</option>';
                    }	
                    $('#tipo').html(options).show();
                    $('.carregando').hide();
                }
            });              
        }
        else
        {
            $('#tipo').html('<option value="">Selecione</option>');
        }
    })
    
    objValidador = new xform('form#cadastro');
    objValidador . adicionar('input#empresa');
    objValidador . adicionar('select#pagina');
    objValidador . adicionar('select#tipo');
	objValidador . adicionar('select#extensao');
    objValidador . adicionar('input#file');
    objValidador.adicionar('input#dataInicio','dataBr', true);
    objValidador.adicionar('input#dataFim','dataBr', true);
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Nova Publicidade</legend>
        <div><?=$msg;?></div>
        
        <div id="esquerda" style="width:530px; float:left">        
            <div>
                <label for="extensao"><span class="obrigatorio">*</span> Tipo de arquivo: </label>
                <select name="extensao" id="extensao" title="Extensão">
                    <option <?=$tipoArquivo == 1 ? 'selected="selected"' : ''?> value="1">.jpg, .jpeg, .png, .gif</option>
                    <option <?=$tipoArquivo == 2 ? 'selected="selected"' : ''?>value="2">.swf</option>
                </select>
            </div>
            <div>
                <label for="empresa"><span class="obrigatorio">*</span> Empresa: </label>
                <input type="text" name="empresa" id="empresa" title="Empresa" value="<?=$empresa;?>" />
            </div>
            <div class="link">
                <label for="link"> Link: </label>
                <input type="text" name="link" id="link" title="Link" value="<?=$link;?>" />
            </div>
            <div>
                <label for="pagina"><span class="obrigatorio">*</span> Página: </label>
                <select name="pagina" id="pagina" title="Página" >
                    <option value="" >Selecione</option>
                <?
                $sqlPag = mysql_query("SELECT * FROM publiPaginas ORDER BY pagina");
                $numPag = mysql_num_rows($sqlPag);
                for($x = 0;$x < $numPag;$x++)
                {
                    $tpPag = mysql_fetch_assoc($sqlPag);
                ?>
                    <option value="<?=$tpPag['cod'];?>" <?=$pagina == $tpPag['cod'] ? 'selected="selected"' : '';?>><?=$tpPag['pagina'];?></option>
                <?
                }
                ?>
                </select>
            </div>
            <div>
                <label for="tipo"><span class="obrigatorio">*</span> Tipo: </label>
                <select name="tipo" id="tipo" title="Tipo">
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label for="dataInicio">Data de inicio do anúncio: </label>
                <input type="text" name="dataInicio" id="dataInicio" title="Data de inicio do anúncio" value="<?=$dataInicio;?>" />
            </div>
            <div>
                <label for="dataFim">Data de fim do anúncio: </label>
                <input type="text" name="dataFim" id="dataFim" title="Data de fim do anúncio" value="<?=$dataFim;?>" />
            </div>
            <div>
                <label for="Arquivo">Arquivo: </label><input type="file" name="file" id="file" title="Arquivo" />
            </div>
            <div>
                <label for="mostrar"> Mostrar: </label><input type="checkbox" name="mostrar" id="mostrar" title="Mostrar" value="1" <?=remEscape($mostrar) == 1 ? "checked" : '';?> />
            </div>
            <div class="contentButton">
                <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
            </div>
            <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </div>
    <div id="direita" style="width:400px; float:left">
    	Orientações: <br><br>
        &bull; Arquivos .SWF:<br />
        &nbsp;&nbsp;&nbsp;- A animação deverá ter no máximo 10 segundos.<br />
        &nbsp;&nbsp;&nbsp;- O link deverá ser inserido no arquivo flash e com target blank.<br />
        &nbsp;&nbsp;&nbsp;- O arquivo deverá ter as dimensões conforme o campo tipo no formulário.<br /><br />
        &bull; Arquivos .GIF Animado:<br />
        &nbsp;&nbsp;&nbsp;- A animação deverá ter no máximo 10 segundos.<br />
        &nbsp;&nbsp;&nbsp;- O arquivo deverá ter as dimensões conforme o campo tipo no formulário.<br />
    </div>
    </fieldset>
    </form>
</div>