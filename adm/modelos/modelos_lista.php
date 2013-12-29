<?php
if(!verifica_permissao($cod_user, $nivel_user, "veiculos"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'modelos_topo.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td class="txtpreto" style="padding-left:10px">Marca</td>
          <td width="70%" class="txtpreto">Modelo</td>
          <td width="8%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="5" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        $resultado = mysql_query("SELECT mo.*, ma.marca FROM veiculosModelos AS mo
                                INNER JOIN veiculosMarcas AS ma ON ma.cod = mo.codMarca
                                ORDER BY ma.marca");
        $linhas = mysql_num_rows($resultado);
        
        if ($linhas>0)
        {
        	for($n=0;$n<$linhas;$n++)
        	{
        		#<!-- linha impar branca | linha par cinza -->
        		$tupla = mysql_fetch_assoc($resultado);
                if ( ($n/2) == (ceil($n/2)) )
                {
                    echo "\n  <tr>";
                }	
                else
                {
                    echo  "<tr class=\"linhacinza\">";
                }
        		echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong>". $tupla['marca'] ."</td>";
                echo "<td >". $tupla['modelo'] ."</td>";
        		?>
                
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=8&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>
                </td>
        		<?
        		echo "</tr>";
        	}
        }
        else
        {
        	echo "<tr><td class=\"texto\" colspan='5'>Nenhum Registro Encontrado</td></tr>";
        }	
        
        ?>
    </table>
