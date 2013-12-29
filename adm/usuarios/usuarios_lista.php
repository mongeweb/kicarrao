<?php
if(!verifica_permissao($cod_user, $nivel_user, "usuarios"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'usuarios_topo.php';
?>
<table width="100%">
    <tr>	
    	<td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" class="txtpreto">Nome:</td>
      <td width="30%" align="center" class="txtpreto">E-mail</td>
      <td width="30%" align="center" class="txtpreto" >A&ccedil;&otilde;es</td>
      <td width="10%" align="center" class="txtpreto">Excluir</td>
    </tr>
    <tr>
    	<td colspan="6"><hr /></td>
    </tr>
    <!-- linha em loop INICIO-->
<?php

$resultado2 = mysql_query("SELECT * FROM usuarios ORDER BY nome", $conexao);
$linhas = mysql_num_rows($resultado2);

if ($linhas>0)
{
	for($n=0;$n<$linhas;$n++)
	{
		#<!-- linha impar branca | linha par cinza -->
		$tupla = mysql_fetch_assoc($resultado2);
		if ( ($n/2) == (ceil($n/2)) )
		{
			echo "\n  <tr>";
		}
		else
        {
			echo  "<tr class=\"linhacinza\">";
		}	
		?>
                <td align="left" style="padding-left:10px;">
                    <strong>>&nbsp;&nbsp;</strong>
                    <?=$tupla['nome'];?>&nbsp;
                </td> 
                <td align="center">
                    <?=$tupla['email'];?>
                </td>                
                <td align="center">
                    <a href="principal.php?id=1&subid=4&cod=<?=$tupla['cod'];?>" class="botaoDourado" align="center">
                        &nbsp;&nbsp;Visualizar&nbsp;&nbsp;
                    </a>
					<?
						if($tupla['cod'] != 1 || $_SESSION[ADMIN_SESSION_NAME.'_user'] == "admin")
						{
					?>
                            &nbsp; | &nbsp;
                            <a href="principal.php?id=1&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado" align="center">
                                &nbsp;&nbsp;Editar&nbsp;&nbsp;
                            </a>
                    <?
						}
    				if($tupla['cod'] != 1)
    				{
    				?>
				        &nbsp; | &nbsp;
                        <a href="principal.php?id=90&cod_user=<?=$tupla['cod'];?>" class="botaoDourado" align="center">
                            &nbsp;&nbsp;Editar Permiss&otilde;es&nbsp;&nbsp;
                        </a>
                    <?
                    }
    				?>
                </td>

                <?
                if($tupla['cod'] != 1 && $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] != $tupla['cod'])
				{
				?>
                        <td align="center">
                            <a onclick="return confirm('Tem certeza que deseja excluir esse registro?');" href="http://<?=ADMIN_URL?>/usuarios/usuarios_apaga.php?cod=<?=$tupla['cod'];?>" class="botaoDourado" >
                                &nbsp;&nbsp;Excluir&nbsp;&nbsp;
                            </a>
                        </td>
                <?
                }
				else
				{
				?>
			        <td align="center">&nbsp;</td>
                <?
                }
                ?>
			</tr>
<?
	}
}
else
{
?>
<tr>
    <td colspan="6" align="left" class="texto">
        Nenhum Registro Encontrado
    </td>
</tr>
    <?
}	
?>
</table>