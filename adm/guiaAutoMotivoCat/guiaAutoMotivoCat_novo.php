<?php
if(!verifica_permissao($cod_user, $nivel_user, 'guiaAutomotivo'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."guiaAutomotivoCat_topo.php";
require_once ADMIN_FUNC_PATH.'fotos.php';

$dataCadastro = date('Y-m-d');    
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";
if($submit != '')
{
    $categoria = isset($_POST['categoria'])? escape($_POST['categoria']) : '' ;
    $mostrar = isset($_POST['mostrar']) ? escape($_POST['mostrar']) : 0;
    $foto = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($categoria))
    {
        $msg .= '<li>O campo Categoria deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if($foto != '')
    {
        $formato = $_FILES['file']['name'];
        $formato = strrev($formato);
        $formato = explode('.',$formato);
        $formato = $formato[0];
        $formato = strrev($formato);
    	$formato = strtolower($formato);
        $extensoesvalidas = array("jpg","jpeg","png");
        if(!in_array($formato,$extensoesvalidas))
    	{
    		$msg .= '<li>Formato de imagem inválido!</li>';
    		$erro = 1;
        }
    }
    else
	{
		$msg .= '<li>O campo Foto deve ser preenchido corretamente!</li>';
		$erro = 1;
    }
    $msg .= '</ul>';
    
    
    if($erro == 0)
    {
        $dataCadastro = date('Y-m-d H:i:s');  
        $ordem = reordenarAutoCat();
        $sql = "INSERT INTO guiaAutomotivoCategorias (dataCadastro, categoria, mostrar, ordem)
                VALUES(
                '{$dataCadastro}', '{$categoria}', '{$mostrar}', '{$ordem}');";
    	$resultado = mysql_query($sql);
    	//echo mysql_error();
    	
        $codRef = mysql_insert_id();
        $foto_temp = $_FILES['file']['tmp_name'];
        $token = rand(1,99999).date('dmYHis');
        $pasta = PROJECT_PATH."arquivos/guia-automotivo-categorias";;
        $fileG = insere_foto($foto, $foto_temp, $pasta,'80','60');
		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                VALUES ('guiaAutomotivoCategorias', '{$codRef}','1', '{$fileG}','$token')";
		$resultadoG = mysql_query($sqlG);
        
    	if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=4&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=4&subid=2'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{
        $categoria = '';
        $mostrar = 0;
}
?>

<script type="text/javascript">
$(document).ready(function()
{
    objValidador = new xform('form#cadastro');
    objValidador . adicionar('input#categoria');
    objValidador . adicionar('input#file');
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Nova</legend>
        <div><?=$msg;?></div>
        <div>
            <label for="categoria"><span class="obrigatorio">*</span> Categoria: </label><input type="text" name="categoria" id="categoria" title="Categoria" value="<?=remEscape($categoria);?>" />
        </div>
        <div>
            <label for="imagem"><span class="obrigatorio">*</span> Foto: </label><input type="file" name="file" id="file" title="Foto" />
        </div>
        <div>
            <label for="mostrar"> Mostrar: </label><input type="checkbox" name="mostrar" id="mostrar" title="Mostrar" value="1" <?=remEscape($mostrar) == 1 ? "checked" : '';?> />
        </div>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>