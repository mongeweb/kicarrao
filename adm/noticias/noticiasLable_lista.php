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
?>


<table width="100%">
    <tr>	
    	<td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" class="txtpreto">Titulo</td>
      <td width="11%" align="center" class="txtpreto" >A&ccedil;&otilde;es</td>
    </tr>
    <tr>
    	<td colspan="6"><hr /></td>
    </tr>
    <!-- linha em loop INICIO-->
<?php

$resultado2 = mysql_query("SELECT * FROM noticiasLables ORDER BY titulo", $conexao);
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
                    <?=$tupla['titulo'];?>&nbsp;
                </td> 
                <td align="center">
				    <a href="principal.php?id=13&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado" align="center">
                    &nbsp;&nbsp;Editar&nbsp;&nbsp;
                	</a>
                    <a onclick="return confirm('Tem certeza que deseja excluir esse registro?');" href="http://<?=ADMIN_URL?>/noticias/noticiasLable_apaga.php?cod=<?=$tupla['cod'];?>" class="botaoDourado" >
                        &nbsp;&nbsp;Excluir&nbsp;&nbsp;
                    </a>
               </td>
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