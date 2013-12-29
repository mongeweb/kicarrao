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
require_once ADMIN_TOP_PATH."modelos_topo.php";

$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";
if($submit != '')
{
    $marca = isset($_POST['marca'])? $_POST['marca'] : '' ;
    $modelo = isset($_POST['modelo'])? escape($_POST['modelo']) : '' ;
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($marca))
    {
        $msg .= '<li>O campo Marca deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($modelo))
    {
        $msg .= '<li>O campo Modelo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    $msg .= '</ul>';
    
    
    if($erro == 0)
    {
        $sql = "UPDATE veiculosModelos SET
                codMarca = '{$marca}',
                modelo = '{$modelo}'
                WHERE cod = {$cod}";
    	$resultado = mysql_query($sql);
        
    	if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro realizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=8&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=8&subid=1'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{
        $sqlModelo = mysql_query("SELECT * FROM veiculosModelos WHERE cod = '$cod'");
        $tpModelo = mysql_fetch_assoc($sqlModelo);
        $marca = $tpModelo['codMarca'];
        $modelo = $tpModelo['modelo'];
}
?>

<script type="text/javascript">
$(document).ready(function()
{
    objValidador = new xform('form#cadastro');
    objValidador . adicionar('select#marca');
    objValidador . adicionar('input#modelo');
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Editando Modelo - <?=remEscape($modelo);?></legend>
        <div><?=$msg;?></div>
        <div>
            <label for="marca"><span class="obrigatorio">*</span> Marca: </label>
            <select name="marca" id="marca" title="Marca">
                <option value="">Selecione</option>
                <?
                $sqlMarca = mysql_query("SELECT * FROM veiculosMarcas ORDER BY marca");
                $numMarca = mysql_num_rows($sqlMarca);
                for($x = 0;$x < $numMarca;$x++)
                {
                    $tpMarca = mysql_fetch_assoc($sqlMarca);
                ?>
                    <option value="<?=$tpMarca['cod'];?>" <?=$tpMarca['cod'] == $marca ? 'selected="selected"' : '';?>><?=$tpMarca['marca'];?></option>
                <?
                }
                ?>
            </select>
        </div>
        <div>
            <label for="modelo"><span class="obrigatorio">*</span> Modelo: </label><input type="text" name="modelo" id="modelo" title="Modelo" value="<?=remEscape($modelo);?>" />
        </div>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>