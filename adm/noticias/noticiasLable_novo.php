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
require_once ADMIN_TOP_PATH.'noticiasLables_topo.php';
require_once ADMIN_PATH.'sessao_verifica.php';
require_once ADMIN_FUNC_PATH . 'formatting.php';
//require_once ADMIN_FUNC_PATH.'validaCampo.php';

$dataCadastro = date('Y-m-d'); 
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;

if($submit != "")
{
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
	$erro = 0;
	
	echo '<ul>';
    if (validaCampo($titulo) == 0) 
    {
      echo '<li>O campo Título deve ser preenchido corretamente!</li>';
      $erro = 1;
    }
	echo '</ul>';

    if ($erro == 0)
    {
       
        $sql = "INSERT INTO noticiasLables (titulo, dataCadastro) VALUES ('{$titulo}','{$dataCadastro}')";
		$resultado = mysql_query($sql);
        //echo mysql_errno() . ": " . mysql_error() . "\n";
        if($resultado)
    	{
    		echo " <script language=\"JavaScript1.2\"> \n";
    		echo " <!-- \n";
    		echo " alert('Cadastro realizado com sucesso!'); \n";
    		echo " location.replace('principal.php?id=13&subid=1'); \n";
    		echo " //--> \n";
    		echo " </script> \n";
    	}
    	else
    	{
    		echo " <script language=\"JavaScript1.2\"> \n";
    		echo " <!-- \n";
    		echo " alert('Cadastro não efetuado.'); \n";
    		echo " location.replace('principal.php?id=13&subid=1'); \n";
    		echo " //--> \n";
    		echo " </script> \n";
    	}
    }
}
else
{
    $titulo = '';
}
?>
<script type="text/javascript" src="./js/validador1.4.js"></script>

<div id="contentFormNovoEdita" style="width: 850px;">
    <form id="cadastro" method="post" action="" enctype="multipart/form-data">
   		 <fieldset>
            <legend>Novo Lable</legend>
            <div>
                <label for="titulo"><span class="obrigatorio">*</span> T&iacute;tulo: </label><input type="text" name="titulo" id="titulo" title="Título" value="<?=$titulo;?>" />
            </div>       
            <div class="contentButton">
                <input class="botaoDourado" type="submit" name="submit" id="submit" title="Enviar" value="Enviar"/>
            </div>
            <div style="color:#F00; float:right; width:170px; margin-right:187px;">* Campos Obrigatórios</div>
		</fieldset>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        objValidador = new xform('form#cadastro');
        //adicionar(campo, tipoValidacao, branco, confirmacao, objConfirmacao)
        objValidador.adicionar('input#titulo');
		
    });
</script>
