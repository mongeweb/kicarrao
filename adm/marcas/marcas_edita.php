<?php
if(!verifica_permissao($cod_user, $nivel_user, 'veiculos'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."marcas_topo.php";

$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$cod = isset($_GET['cod']) ? $_GET['cod'] : "";
$msg = "";

if($submit != '')
{
    $marca = isset($_POST['marca'])? escape($_POST['marca']) : '' ;
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($marca))
    {
        $msg .= '<li>O campo Marca deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
    $msg .= '</ul>';

    if($erro == 0)
    {
    	$sql = "UPDATE veiculosMarcas SET
                marca = '{$marca}'
                WHERE cod = {$cod}";
    	$resultado = mysql_query($sql);
    	//echo mysql_error();
        
    	if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=7&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=7&subid=3&cod=$cod'); \n";
    		echo " </script>";
            die();
    	}
        
    }
}
else
{
        $sql = mysql_query("SELECT * FROM veiculosMarcas WHERE cod = $cod", $conexao);
        $tp = mysql_fetch_assoc($sql);
        
        $marca = $tp['marca'];
}
?>

<script type="text/javascript">
$(document).ready(function()
{
    objValidador = new xform('form#cadastro');
    objValidador . adicionar('input#marca');
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Editando Marca - <?=remEscape($marca);?></legend>
        <div><?=$msg;?></div>
        <div>
            <label for="marca"><span class="obrigatorio">*</span> Marca: </label><input type="text" name="marca" id="marca" title="Marca" value="<?=remEscape($marca);?>" />
        </div>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>