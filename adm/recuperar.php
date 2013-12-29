<?php
require_once '../configRoot.php';
require_once ADMIN_FUNC_PATH.'verifica.php';
session_destroy();

$submit = isset($_POST['Submit']) ? $_POST['Submit'] : '';
if($submit != "")
{
	$email = isset($_POST['email']) ? $_POST['email'] : '';
    $resultado = mysql_query("SELECT * FROM usuarios WHERE email = '{$email}'");
	$linhas = mysql_num_rows($resultado);
	//echo mysql_errno() . ": " . mysql_error() . "\n";
	if($linhas > 0) 
	{
		$tp = mysql_fetch_assoc($resultado);
		$md5 = new md5;
        $senha = $md5->decode($tp['senha']);
        $usuario = $tp['login'];
	    //echo "1";
		
        require_once PROJECT_FUNC_PATH . 'recuperarSenhaAdm.php';
			
		$nomeRemetente = "Kicarrão";
		$assunto = "Recuperar Senha ADM - Kicarrão";
		$emailDestinatario = array($email);
		$emailRemetente = 'noreply@kicarrao.com.br';
        $emailResposta  = 'noreply@kicarrao.com.br';
        $conteudoEmail = array(
            'usuario'    => $usuario,
            'email'      => $email,
            'senha'      => $senha
        );
        $twitter = '';
        $facebook = '';

        $conf = recuperarSenhaAdm($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);
		
        if($conf)
		{
            echo " <script language=\"JavaScript1.2\"> \n";
			echo " <!-- \n";
			echo " alert(\"Sua senha e usuário foram enviadas para o email $email \");\n";
			echo " location.replace('http://".ADMIN_URL."/index.php'); \n";
			echo " //--> \n";
			echo " </script> \n";
		}
		else 
		{
            echo " <script language=\"JavaScript1.2\"> \n";
			echo " <!-- \n";
			echo " alert(\"Erro ao enviar email! Tente novamente mais tarde.\");\n";
			echo " location.replace('http://".ADMIN_URL."/index.php'); \n";
			echo " //--> \n";
			echo " </script> \n";
		}		
	}
	else 
	{
		echo " <script language=\"JavaScript1.2\"> \n";
		echo " <!-- \n";
		echo " alert(\"Email não cadastrado!\");\n";
		echo " location.replace('http://".ADMIN_URL."/index.php'); \n";
		echo " //--> \n";
		echo " </script> \n";
	}
}
?>
<html>
<head>
<title><?=ADMIN_TITLE;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://<?=ADMIN_CSS_URL;?>/estilo.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" scroll=no>
<table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
        <img width="960" src="http://<?=ADMIN_IMG_URL;?>/cartola.jpg" />
    </td>
  </tr>
</table>

<div class="login"> 
  <br />
  <link href="http://<?=ADMIN_CSS_URL;?>/estilo.css" rel="stylesheet" type="text/css" />
  <form name="login" method="post" action="">
    <table width="300" border="0" cellspacing="6" cellpadding="0">
      <tr> 
		<td width="60" height="22" align="right">Email</td>
        <td><input name="email" type="text" id="email" size="25" /></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>
            <input class="botaoDourado" type="submit" name="Submit" value="Enviar"/>
        </td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>
