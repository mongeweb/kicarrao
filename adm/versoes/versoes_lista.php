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
require_once ADMIN_TOP_PATH.'versoes_topo.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td class="txtpreto" style="padding-left:10px">Modelo</td>
          <td width="70%" class="txtpreto">Versão</td>
          <td width="8%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="5" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        $resultado = mysql_query("SELECT v.*, mo.modelo FROM veiculosVersoes AS v
                                INNER JOIN veiculosModelos AS mo ON mo.cod = v.codModelo
                                ORDER BY mo.modelo");
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
        		
				echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong> ". $tupla['modelo'] ."</td>";
                echo "<td>". $tupla['versao'] ."</td>";
        		?>
                
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=9&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>                    
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
