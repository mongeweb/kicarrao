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
require_once ADMIN_TOP_PATH."versoes_topo.php";

$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";
if($submit != '')
{
    $versao = isset($_POST['versao'])? $_POST['versao'] : '' ;
    $modelo = isset($_POST['modelo'])? escape($_POST['modelo']) : '' ;
    $anos = isset($_POST['anos'])? escape($_POST['anos']) : '' ;
    
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($versao))
    {
        $msg .= '<li>O campo Versão deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($modelo))
    {
        $msg .= '<li>O campo Modelo deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($anos))
    {
        $msg .= '<li>O campo Anos de Fabricação deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    $msg .= '</ul>';
    
    
    if($erro == 0)
    {
        
        $anosArray = explode(",",$anos);
        $anoIni = count($anosArray) > 0 ? $anosArray[0] : $anos;
        $anoFim = count($anosArray) > 1 ? array_pop($anosArray) : $anoIni;
                
        $sql = "UPDATE veiculosVersoes SET
                codModelo = '{$modelo}',
                versao = '{$versao}',
                anos = '{$anos}',
                anoIni = '{$anoIni}',
                anoFim = '{$anoFim}'
                WHERE cod = {$cod}";
    	$resultado = mysql_query($sql);
        echo mysql_error();
    	if($resultado)
        {
            echo " <script>";
    		echo " alert(\"Cadastro atualizado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=9&subid=1'); \n";
    		echo " </script>";
            die();
    	}
        else
    	{
            echo " <script>";
    		echo " alert(\"Erro ao cadastrar!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=9&subid=1'); \n";
    		echo " </script>";
            die();
    	}
    }
}
else
{
        $sqlVersao = mysql_query("SELECT * FROM veiculosVersoes WHERE cod = '$cod'");
        $tpVersao = mysql_fetch_assoc($sqlVersao);
        $versao = $tpVersao['versao'];
        $modelo = $tpVersao['codModelo'];
        $anos = $tpVersao['anos'];
}
?>

<script type="text/javascript">
$(document).ready(function()
{
    objValidador = new xform('form#cadastro');
    objValidador . adicionar('select#modelo');
    objValidador . adicionar('input#versao');
    objValidador . adicionar('textarea#anos');
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Editando Versão - <?=remEscape($versao);?></legend>
        <div><?=$msg;?></div>
        <div>
            <label for="modelo"><span class="obrigatorio">*</span> Modelo: </label>
            <select name="modelo" id="modelo" title="Modelo">
                <option value="">Selecione</option>
                <?
                $sqlModelo = mysql_query("SELECT * FROM veiculosModelos ORDER BY modelo");
                $numModelo = mysql_num_rows($sqlModelo);
                for($x = 0;$x < $numModelo;$x++)
                {
                    $tpModelo = mysql_fetch_assoc($sqlModelo);
                ?>
                    <option value="<?=$tpModelo['cod'];?>" <?=$tpModelo['cod'] == $modelo ? 'selected="selected"' : '';?>><?=$tpModelo['modelo'];?></option>
                <?
                }
                ?>
            </select>
        </div>
        <div>
            <label for="versao"><span class="obrigatorio">*</span> Versão: </label><input type="text" name="versao" id="versao" title="Versão" value="<?=remEscape($versao);?>" />
        </div>
        <div>
            <label for="anos"><span class="obrigatorio">*</span> Anos de Fabricação: </label><textarea name="anos" id="anos" title="Anos de Fabricação" ><?=remEscape($anos);?></textarea>
            <div style="color:#F00;width:255px;margin-left:184px">Separe os anos com vírgula sem espaço.</div>
        </div>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>