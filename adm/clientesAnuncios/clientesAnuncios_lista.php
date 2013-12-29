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
$cod = isset($_GET['codCli']) && $_GET['codCli'] != '' ? " AND ca.codCliente = '{$_GET['codCli']}' " : ""; 
$codCli = isset($_GET['codCli']) ? $_GET['codCli'] : '';
require_once ADMIN_TOP_PATH.'clientesAnuncios_topo.php';
if($planoFiltro != '')
    
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="7">&nbsp;</td>
        </tr>
        <tr>
          <td width="30%" class="txtpreto" style="padding-left:10px">Cliente</td>
          <td width="15%" class="txtpreto" style="padding-left:10px">Plano</td>
          <td width="10%" class="txtpreto" style="padding-left:10px">Data Cad.</td>
          <td width="13%" class="txtpreto" style="padding-left:10px">Data de Expiração</td>
          <td width="5%" class="txtpreto" style="padding-left:10px">Status</td>
          <td width="11%" class="txtpreto" align="center">Enviar Renovação</td>
          <td width="10%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="7" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        if($tipoAnuncio == '1')
        {
            if($planoFiltro != '')
                $planoFiltroSql = ' AND ca.codPlanoParticular = '.$planoFiltro;
            else
                $planoFiltroSql = '';
                
            $resultado = mysql_query("SELECT ca.*, c.razaoSocialNome, c.nomeFantasia, c.sobrenome, c.tipoRevenda, c.tipoAnuncio, c.cod AS codCliente FROM clientesAnuncios AS ca
                                    INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                    WHERE c.tipoAnuncio = '1' AND status <> 3 $cod $planoFiltroSql
                                    ORDER BY ca.dataValidadeAnuncio, ca.cod DESC");
        }
        else
        {
            if($planoFiltro != '')
                $planoFiltroSql = ' AND c.codPlanoRevenda = '.$planoFiltro;
            else
                $planoFiltroSql = '';
                
            $resultado = mysql_query("SELECT ca.*, c.razaoSocialNome, c.nomeFantasia, c.tipoRevenda, c.sobrenome, c.tipoAnuncio, c.codPlanoRevenda, c.cod AS codCliente FROM clientesAnuncios AS ca
                                    INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                    WHERE c.tipoAnuncio = '2' $cod $planoFiltroSql
                                    ORDER BY c.nomeFantasia, c.razaoSocialNome");
        }
        $linhas = mysql_num_rows($resultado);
        $hoje = date('Y-m-d');
        if ($linhas>0)
        {
        	for($n=0;$n<$linhas;$n++)
        	{
        		#<!-- linha impar branca | linha par cinza -->
                $tupla = mysql_fetch_assoc($resultado);
                if($tipoAnuncio == '2')
                {
                    $sqlPlanoRev = mysql_query("SELECT p.codTipoVeiculo, p.tempo, p.plano, tv.tipoVeiculo FROM planosRevenda AS p
                                                INNER JOIN tipoVeiculo AS tv ON tv.cod = p.codTipoVeiculo
                                                WHERE p.cod = '{$tupla['codPlanoRevenda']}'");
                    $tpPlanoRev = mysql_fetch_assoc($sqlPlanoRev);
                    $plano = $tpPlanoRev['plano'].' - '.$tpPlanoRev['tipoVeiculo'];
                }
                else
                {
                    $sqlPlanoRev = mysql_query("SELECT * FROM planosParticular 
                                                WHERE cod = '{$tupla['codPlanoParticular']}'");
                    $tpPlanoRev = mysql_fetch_assoc($sqlPlanoRev);
                    $plano = $tpPlanoRev['plano'];
                }
                if ( ($n/2) == (ceil($n/2)) )
                {
                    echo "\n  <tr>";
                }	
                else
                {
                    echo  "<tr class=\"linhacinza\">";
                }
        
                echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong> ".($tupla['nomeFantasia'] != '' ? $tupla['nomeFantasia'] : $tupla['razaoSocialNome']).($tupla['sobrenome'] != '' ? ' '.$tupla['sobrenome'] : '') ."</td>";
				echo "<td style=\"padding-left:10px;\"> ". $plano ."</td>";
                echo "<td style=\"padding-left:10px;\"> ". dataBr($tupla['dataCadastro']) ."</td>";
                echo "<td style=\"padding-left:10px;\"> ". ($tipoAnuncio == '1' ? ($tupla['dataValidadeAnuncio'] == '0000-00-00' ? '<div style="text-align: center; width:100%;"> - </div>' : ($tupla['dataValidadeAnuncio'] <= $hoje ? '<span style="color: red">'.dataBr($tupla['dataValidadeAnuncio']).'<span>' : dataBr($tupla['dataValidadeAnuncio']))) : '-')."</td>";
                echo "<td style=\"padding-left:10px;\"> ". ($tupla['status'] == '0' ? 'Inativo' : ($tupla['status'] == '1' ? 'Ativo' : 'Cancelado')) ."</td>";
        		?>
                <td align="center">
                <?
                if($tipoAnuncio == '1')
                {
                ?>
                    <a href="<?='http://'.ADMIN_URL.'/clientesAnuncios/renovacao.php?c='.base64_encode($tupla['cod']).'&codCliente='.$tupla['codCliente'];?>" class="botaoDourado">&nbsp;Enviar Renovação&nbsp;</a>
                <?
                }
                else
                {
                    echo " - ";
                }
                ?>
                </td>
                <td align="center">
                <?
                if($tupla['tipoRevenda'] != '2')
                {
                ?>
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=10&subid=3&cod=<?=$tupla['cod'];?>&tipoAnuncio=<?=$tupla['tipoAnuncio'];?><?=$codFiltro != '' ? '&codCli='.$codFiltro : '';?><?=$planoFiltro != '' ? '&codPlano='.$planoFiltro : '';?><?=$tipoAnuncio != '' ? '&tipoAnuncio='.$tipoAnuncio : '';?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>
                    <a onclick="return confirm('Tem certeza que deseja excluir esse registro?');" href="http://<?=ADMIN_URL;?>/clientesAnuncios/clientesAnuncios_apaga.php?cod=<?=$tupla['cod'];?>&codCli=<?=$codCli;?>">&nbsp;&nbsp;X&nbsp;&nbsp;</a>
                <?
                }
                else
                {
                ?>
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=10&subid=4&cod=<?=$tupla['cod'];?>&tipoAnuncio=<?=$tupla['tipoAnuncio'];?>" class="botaoDourado">&nbsp;Visualizar&nbsp;</a>
                <?
                }
                ?>
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
