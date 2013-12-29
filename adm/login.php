<?php
require_once '../configRoot.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
require_once ADMIN_FUNC_PATH.'verifica.php';
require_once ADMIN_FUNC_PATH.'redireciona.php';
$conexao = conexao();
$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
$submit = isset($_POST['Submit']) ? $_POST['Submit'] : '';
if($submit != "")
{
	
	$resultado = mysql_query("SELECT * FROM usuarios WHERE login = '{$_POST['user']}'");
	$linhas = mysql_num_rows($resultado);
	//echo mysql_errno() . ": " . mysql_error() . "\n";
	if ($linhas > 0) 
	{
		$recoba = mysql_fetch_assoc($resultado);
		$fuyutsuki = $_POST['senha'];
		$nedved = $recoba['senha'];
		$md5 = new md5;
		$arshavin = $md5->decode($nedved);
		$uia_master = date('h:i:s-d/m/Y').$recoba['cod'];
		$uia_master_cript = $md5->code($uia_master);
	    //echo "1";
		if($arshavin == $fuyutsuki)
		{
	        //echo "2";		
			$_SESSION[ADMIN_SESSION_NAME.'_cod_user'] = $recoba['cod'];	
			$_SESSION[ADMIN_SESSION_NAME.'_user'] = $_POST['user'];
			$_SESSION[ADMIN_SESSION_NAME.'_monge'] = date('d-m-Y');
			$_SESSION[ADMIN_SESSION_NAME.'_nivel'] = $recoba['nivel'];
			
			//$_SESSION['token_'.$nome_site] = $uia_master_cript;
			//$verifica = mysql_query("UPDATE usuarios SET token = '".$uia_master_cript."' WHERE cod = ".$recoba['cod']);
			
			redireciona1("http://".ADMIN_URL."/principal.php");
		}
		else 
		{
			redireciona1("index.php?erro=1");
		}		
	}
	else 
	{
		redireciona1("index.php?erro=1");
	}
}
else
{
?>
<br />
<link href="http://<?=ADMIN_CSS_URL;?>/estilo.css" rel="stylesheet" type="text/css">
   <form name="login" method="post" action="login.php">
    <table width="300" border="0" cellspacing="6" cellpadding="0">
      <tr> 
		<td width="60" height="22" align="right">Login</td>
        <td><input name="user" type="text" id="user" size="20" maxlength="20" /></td>
      </tr>
      <tr> 
        <td align="right">Senha</td>
        <td><input name="senha" type="password" id="senha"/></td>
      </tr>
      <?php
        if($erro != 0)
        {
        ?>
        <tr> 
            <td>&nbsp;</td>
            <td>Usu&aacute;rio e/ou Senha incorreto!</td>
            <td>&nbsp;</td>
        </tr>
      <?php
        }
        ?>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">
            <a href="http://<?=PROJECT_URL;?>/adm/recuperar.php">Recuperar senha</a>
        </td>
      </tr>      
      <tr> 
            <td>&nbsp;</td>
            <td>
                <input class="botaoDourado" type="submit" name="Submit" value="Entrar"/>
            </td>
      </tr>
    </table>
  </form>
<?php
}
?>