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
$cod = isset($_GET['cod']) ? $_GET['cod'] : '';
$resultado = mysql_query("SELECT * FROM usuarios WHERE cod = {$cod}", $conexao);
$tupla = mysql_fetch_assoc($resultado);

?>
<table width="850" border="0" cellspacing="1" cellpadding="0">
  <tr> 
    <td><span class="titulo">Visualizando Usu&aacute;rio: <?php echo $tupla['nome']; ?>  </span></td>
  </tr>
  <tr>
    <td> 
    	<table width="100%" border="0" cellpadding="0" cellspacing="6">
        <tr> 
          <td align="right" ><strong>Nome:</strong></td>
          <td width="614" align="left" class="txtpreto"><?php echo $tupla['nome'];?></td>
        </tr>
        <tr> 
          <td align="right" ><strong>Email:</strong></td>
          <td align="left" class="txtpreto"><?php echo $tupla['email']; ?> </td>
        </tr>
        <tr> 
          <td align="right" ><strong>Login:</strong></td>
          <td align="left" class="txtpreto"><?php echo $tupla['login']; ?> </td>
        </tr>
        <tr>
          <td width="148" align="right" >&nbsp;</td>
          <td align="left" class="txtpreto">&nbsp;</td>
        </tr>
    </table>
    </td>
  </tr>
</table>
