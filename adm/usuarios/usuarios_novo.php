<?php
if(!verifica_permissao($cod_user, $nivel_user, "usuarios"))
{
	echo " <script> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'usuarios_topo.php';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$msg = "";
if($submit != "")
{
	//// INSERE NOVO REGISTRO
    $md5 = new md5;
    $senha =  isset($_POST['senha']) ? escape($_POST['senha']) : "";
	$senha_cript =  isset($_POST['senha']) ? $md5->code(escape($_POST['senha'])) : "";
	$nome = isset($_POST['nome']) ? escape($_POST['nome']) : "";
    $email = isset($_POST['email']) ? escape($_POST['email']) : "";
    $login = isset($_POST['login']) ? escape($_POST['login']) : "";
    $erro = 0;
    
    
    $msg .= '<ul>';
        if (!validaCampo(remEscape($nome),"nome")) 
        {
          $msg .= '<li>O campo Nome deve ser preenchido corretamente!</li>';
          $erro = 1;
        }
        if (!validaCampo(remEscape($email),"email")) 
        {
          $msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
          $erro = 1;
        }
        if (!validaCampo(remEscape($login),"usuario")) 
        {
          $msg .= '<li>O campo Login deve ser preenchido corretamente!</li>';
          $erro = 1;
        }
        if (!validaCampo(remEscape($senha)))
        {
          $msg .= '<li>O campo Senha deve ser preenchido corretamente!</li>';
          $erro = 1;
        }
        if (strlen(remEscape($senha)) < 6) 
        {
          $msg .= '<li>O campo Senha deve ter no m&iacute;nimo 6 dig&iacute;tos!</li>';
          $erro = 1;
        }
    $msg .= '</ul>';
    if($erro == 0)
    {
    	$sql = mysql_query("INSERT INTO usuarios (nome, email, login, senha)
                                    VALUES
                                   ('{$nome}','{$email}','{$login}','{$senha_cript}')");
    	
    	if($sql)
    	{
    		echo " <script> \n";
    		echo " <!-- \n";
    		echo " alert(\"Usu\u00E1rio criado com sucesso!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=1&subid=1&cod=$cod'); \n";
    		echo " //--> \n";
    		echo " </script> \n";
    	}	
    	else
    	{
    		echo " <script> \n";
    		echo " <!-- \n";
    		echo " alert(\"Erro ao criar Usu\u00E1rio!\");\n";
    		echo " location.replace('http://".ADMIN_URL."/principal.php?id=1&subid=1&cod=$cod'); \n";
    		echo " //--> \n";
    		echo " </script> \n";
    	}
    }
}
else
{
    $nome = "";
    $email = "";
    $login = "";
    $senha = "";
}
?>
<form name="cadastro" method="post" action="" enctype="multipart/form-data"> 
<fieldset>
<legend>Novo Usu&aacute;rio</legend>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
    <td>
        <?=$msg;?>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="6">
            <tr> 
              <td align="right" >Nome</td>
              <td width="616" class="txtpreto"><input name="nome" id="nome" type="text" value="<?=remEscape($nome);?>"/></td>
            </tr>
            
            <tr> 
              <td align="right" >E-mail</td>
              <td class="txtpreto"><input name="email" type="text" id="email" value="<?=remEscape($email);?>"/></td>
            </tr>
            <tr>
              <td align="right" >Login</td>
              <td class="txtpreto"><input name="login" type="text" id="login" value="<?=remEscape($login);?>"/></td>
            </tr>
            <tr>
              <td align="right" >Senha</td>
              <td class="txtpreto"><input name="senha" type="password" id="senha" value="<?=remEscape($senha);?>"/><span style="color:red;"><em>&nbsp;Mínimo 6 caracteres.</em></span></td>
              
            </tr>
            <tr>
                <td width="146">&nbsp;</td>
                <td>
                <input class="botaoDourado" type="submit" name="submit" value="Enviar"></td>
            </tr>
        </table>
    </td>
</tr>
</table> 
</fieldset>
</form>
