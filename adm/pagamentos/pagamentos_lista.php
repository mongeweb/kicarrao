<?php
if(!verifica_permissao($cod_user, $nivel_user, "pagamentos"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'pagamentos_topo.php';
?>
<table width="100%">
    <tr>	
    	<td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" class="txtpreto">Cliente</td>
      <td align="center" class="txtpreto">Tipo cliente</td>
      <td align="center" class="txtpreto">Plano</td>
      <td align="center" class="txtpreto">Nº Boleto</td>
      <td align="center" class="txtpreto">A&ccedil;&otilde;es</td>
    </tr>
    <tr>
    	<td colspan="5"><hr /></td>
    </tr>
    <!-- linha em loop INICIO-->
<?php
$boletos = array();
$qPart = mysql_query("SELECT b.nDoc, c.razaoSocialNome, ca.cod AS codAnuncio, ca.plano FROM boletos AS b
                    INNER JOIN clientes AS c ON c.cod = b.codCliente
                    INNER JOIN clientesAnuncios AS ca ON ca.cod = b.codAnuncio
                    WHERE c.tipoAnuncio = '1' AND ca.status = '0'
                    GROUP BY ca.cod");
while($tpPart = mysql_fetch_assoc($qPart))
{
    $boletos[] = array
                (
                    "nome" => $tpPart['razaoSocialNome']
                    ,"tipoCliente" => "Particular"
                    ,"plano" => $tpPart['plano']
                    ,"nDoc" => $tpPart['nDoc']
                    ,"link" => "http://".ADMIN_URL."/principal.php?id=10&subid=3&cod=".$tpPart['codAnuncio']."&tipoAnuncio=1&redir=pagamentos"
                );
}

$qRev = mysql_query("SELECT b.nDoc, c.nomeFantasia, c.cod AS codCliente, p.plano, tv.tipoVeiculo FROM boletos AS b
                    INNER JOIN clientes AS c ON c.cod = b.codCliente
                    INNER JOIN planosRevenda AS p ON p.cod = c.codPlanoRevenda
                    INNER JOIN tipoVeiculo AS tv ON tv.cod = p.codTipoVeiculo
                    WHERE c.tipoAnuncio = '2' AND c.tipoRevenda = '1' AND situacao = '0'
                    GROUP BY b.cod");
while($tpRev = mysql_fetch_assoc($qRev))
{
    $boletos[] = array
                (
                    "nome" => $tpRev['nomeFantasia']
                    ,"tipoCliente" => "Revenda"
                    ,"plano" => $tpRev['plano']." - ".$tpRev['tipoVeiculo']
                    ,"nDoc" => $tpRev['nDoc']
                    ,"link" => "http://".ADMIN_URL."/principal.php?id=6&subid=3&cod=".$tpRev['codCliente']."&tipoAnuncio=2&redir=pagamentos"
                );
}

$linhas = count($boletos);
if ($linhas>0)
{
	foreach($boletos AS $n => $tupla)
    {
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
                <?=$tupla['tipoCliente'];?>
            </td>
            <td align="center">
                <?=$tupla['plano'];?>
            </td>
            <td align="center">
                <?=$tupla['nDoc'];?>
            </td>
            <td align="center">
			    <a href="<?=$tupla['link'];?>" class="botaoDourado" align="center">
                &nbsp;&nbsp;Visualizar&nbsp;&nbsp;
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
    <td colspan="5" align="left" class="texto">
        Nenhum Registro Encontrado
    </td>
</tr>
    <?
}
?>

</table>