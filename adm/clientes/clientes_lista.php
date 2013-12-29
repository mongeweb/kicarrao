<?php
if(!verifica_permissao($cod_user, $nivel_user, "clientes"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'clientes_topo.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td class="txtpreto" style="padding-left:10px">Razão Social / Nome</td>
          <td width="50%" align="center" class="txtpreto">Tipo</td>
          <td width="10%" align="center" class="txtpreto">Ordem</td>
          <td width="15%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="5" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        $letra = isset($_GET['letra']) ? $_GET['letra'] : '' ;
        if ($letra != "")
        {
        	if($tipoClienteFiltro == '1')
                $parametros = " AND razaoSocialNome LIKE '$letra%' "; 
            else
                $parametros = " AND  nomeFantasia LIKE '$letra%' "; 
        }
        else
        {
        	$parametros = "";
        }
        
        $resultado = mysql_query("SELECT * FROM clientes WHERE tipoAnuncio = '{$tipoClienteFiltro}' $parametros ORDER BY ordem ASC, razaoSocialNome");
        $linhas = mysql_num_rows($resultado);
        
        if ($linhas>0)
        {
        	for($n=0;$n<$linhas;$n++)
        	{
        	   $tupla = mysql_fetch_assoc($resultado);
        		if($tupla['tipoAnuncio'] == '2')
                {
                    $sqlPlanoRev = mysql_query("SELECT p.codTipoVeiculo, p.tempo, p.plano, tv.tipoVeiculo FROM planosRevenda AS p
                                                INNER JOIN tipoVeiculo AS tv ON tv.cod = p.codTipoVeiculo
                                                WHERE p.cod = '{$tupla['codPlanoRevenda']}'");
                    $tpPlanoRev = mysql_fetch_assoc($sqlPlanoRev);
                    $plano = ($tupla['tipoRevenda'] == '1' ? 'Normal ' : 'Autogestor ').' - '.$tpPlanoRev['tipoVeiculo'];
                }
                else
                {
                    $plano = ' - ';
                }
                
                #<!-- linha impar branca | linha par cinza -->
        		
                if ( ($n/2) == (ceil($n/2)) )
                {
                    echo "\n  <tr>";
                }	
                else
                {
                    echo  "<tr class=\"linhacinza\">";
                }
        
                echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong> ". ($tupla['nomeFantasia'] != '' ? $tupla['nomeFantasia'] : $tupla['razaoSocialNome']) . ($tupla['sobrenome'] != '' ? ' '.$tupla['sobrenome'] : '') ."</td>";
        		?>
                <td align="center">
                    <?=$plano;?>
                </td>
                <td align="center">
                    <?
                    if($tupla['tipoAnuncio'] == '2')
                    {
                    ?>
                        <a href="http://<?=ADMIN_URL;?>/principal.php?id=6&subid=5&cod=<?=$tupla['cod'];?>" class="botaoDourado"><?=$tupla['ordem'];?></a>
                    <?
                    }
                    else
                    {
                        echo " - ";
                    }
                    ?>
                </td>
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=10&subid=1&codCli=<?=$tupla['cod'];?>&tipoAnuncio=<?=$tupla['tipoAnuncio'];?>" class="botaoDourado">&nbsp;An&uacute;ncios&nbsp;</a>
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=6&subid=3&cod=<?=$tupla['cod'];?>&tipoAnuncio=<?=$tupla['tipoAnuncio'];?><?=$letra != '' ? '&letra='.$letra : '';?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>
                    <a onclick="return confirm('Tem certeza que deseja excluir <?=$tupla['nomeFantasia'] != '' ? $tupla['nomeFantasia'] : $tupla['razaoSocialNome'];?>?');" href="http://<?=ADMIN_URL;?>/clientes/clientes_apaga.php?cod=<?=$tupla['cod'];?>&tipoAnuncio=<?=$tupla['tipoAnuncio'];?><?=$letra != '' ? '&letra='.$letra : '';?>">&nbsp;&nbsp;X&nbsp;&nbsp;</a>
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
