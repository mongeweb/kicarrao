<?
/*$qEstoque = mysql_query("SELECT *, CASE
			WHEN estoque <= estoqueMinimo THEN 0
			ELSE 1 END as statusEstoque
			FROM produtos");
$nEstoque = mysql_num_rows($qEstoque);*/

?>
<script type="text/javascript">
function aprovar(h, tipo)
{
	if(tipo == 1)
    {
        _cod = $(h).val();
	}
    else
    {
        _cod = $(h).attr('rel');
    }
    
    $.ajax(
	{
		
		type: "POST",
		url: "http://<?=ADMIN_URL;?>/ajax/ajaxAprovarCancelar.php", //URL de destino
		data:
		{
			codAnuncio: _cod,
            tipo: tipo 
		},
		dataType: "json", //Tipo de Retorno
		success: function(tp)
		{ //Se ocorrer tudo certo
			if(tp.retorno == '1')
			{
			   $(h).parent().parent().remove();
			   _n = $(".numeroAnuncio").size();
			   if(_n < 1)
			   {
				   $('#listaAnuncio > tbody').append("<tr><td colspán='8' style='padding-bottom:5px; padding-left:5px; width: 10%;'>Nenhum registro encontrado!</td></tr>");             //    add tr com msg
			   }
			}
			else
			{
				return;
			}
		}
	});
}
$(document).ready(function()
{
	$("input#aprovar").click(function()
    {
        aprovar(this, 1);
    })
    
    $(".apagar").click(function()
    {
        aprovar(this, 2);
    })
});
</script>
 <table width="960" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;" id="listaAnuncio">
 	<tr>
		<td colspan="8" width="90%" style="padding-bottom:5px; padding-left:1px;"><h3 style="margin:0px;"><b>Anúncios não publicados:</b></h3></td>
	</tr>
    <tr>
    	<td colspan="8" ><hr /></td>
    </tr>
    <tr>
    	<td style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Cliente</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Plano</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Tipo de pagamento</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Status do pagamento</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Marca/Modelo</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Data Cadastro</td>
        <td align="center" style="padding-bottom:5px;" class="txtpreto">Aprovar</td>
        <td align="center" style="padding-bottom:5px;" class="txtpreto">Ações</td>
    </tr>
    <?php
   	$sqlAnuncios = mysql_query("SELECT ca.cod, c.cod AS codCliente, ca.plano, ca.combustivel, ca.dataCadastro, vm.marca, vmd.modelo, c.razaoSocialNome,
                                c.sobrenome
                                FROM clientesAnuncios AS ca
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                LEFT JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                WHERE ca.status = 0 AND c.tipoAnuncio = 1");
	$numAnuncios = mysql_num_rows($sqlAnuncios);
	if($numAnuncios > 0)
	{ 
		for($x = 0;$x < $numAnuncios;$x++)
		{
			$tpAnuncios = mysql_fetch_assoc($sqlAnuncios);
            $tipoPag = '-';
            $statusPag = '-';
            $qBoletos = mysql_query("SELECT cod FROM boletos WHERE codAnuncio = '{$tpAnuncios['cod']}' AND codCliente = '{$tpAnuncios['codCliente']}'");
            $nBoletos = mysql_num_rows($qBoletos);
            if($nBoletos > 0)
            {
                $tipoPag = 'Boleto';
            }
            else
            {
                $qPag = mysql_query("SELECT cod, tipoTransacao FROM pagamentos WHERE codAnuncio = '{$tpAnuncios['cod']}' AND codCliente = '{$tpAnuncios['codCliente']}'");
                $nPag = mysql_num_rows($qPag);
                if($nPag > 0)
                {
                    $tpPag = mysql_fetch_assoc($qPag); 
                    $tipoPag = 'Cartão de '.($tpPag['tipoTransacao'] == 'debito' ? "Débito" : "Crédito");
                    $statusPag = "Pago";
                }
            }
            
            if ( ($x/2) == (ceil($x/2)) )
			{
				echo "\n  <tr class=\"numeroAnuncio\">";
			}	
			else
			{
				echo  "<tr class=\"linhacinza numeroAnuncio\">";
			}
    			echo "	<td style='padding-bottom:5px; padding-left:5px; padding-top:2px;'>".$tpAnuncios['razaoSocialNome']."</td>
    					<td style='padding-bottom:5px;' align='center'>".$tpAnuncios['plano']."</td>
                        <td style='padding-bottom:5px;' align='center'>".$tipoPag."</td>
                        <td style='padding-bottom:5px;' align='center'>".$statusPag."</td>
                        <td style='padding-bottom:5px;' align='center'>".$tpAnuncios['marca']." ".$tpAnuncios['modelo']."</td>
                        <td style='padding-bottom:5px;' align='center'>".dataBr($tpAnuncios['dataCadastro'])."</td>
    					<td style='padding-bottom:2px; padding-top:2px;' align='center'> <input type='checkbox' name='aprovar' id='aprovar' value='".$tpAnuncios['cod']."'></td>
					    <td style='padding-bottom:2px; padding-top:2px;' align='center'> <a href='http://".ADMIN_URL."/principal.php?id=10&subid=3&cod=".$tpAnuncios['cod']."' class='botaoDourado'>&nbsp;Editar&nbsp;</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style='cursor:pointer;' class='apagar' rel='".$tpAnuncios['cod']."'> X </a></td>
                    </tr>";
		}
	}
	else
	{
		echo "<tr><td colspan='8' style='padding-bottom:5px; padding-left:5px; padding-top:2px;'>Nenhum registro encontrado!</td></tr>";
	}
    ?>
 </table>
 <table width="960" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;" id="listaAnuncio">
    <tr>
    	<td colspan="4" height="30px;">&nbsp;</td>
    </tr>
    <tr>
		<td colspan="4" width="90%" style="padding-bottom:5px; padding-left:1px;"><h3 style="margin:0px;"><b>Clientes Inativos:</b></h3></td>
	</tr>
    <tr>
    	<td colspan="4" ><hr /></td>
    </tr>
    <tr>
    	<td style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Cliente</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Plano</td>
        <td align="center" style="padding-bottom:5px; padding-left:5px;" class="txtpreto">Data Cadastro</td>
        <td align="center" style="padding-bottom:5px;" class="txtpreto">Ações</td>
    </tr>
    <?php
   	$sqlClientes = mysql_query("SELECT cod, dataCadastro, tipoAnuncio, razaoSocialNome, sobrenome 
                                FROM clientes 
                                WHERE situacao = 0 ORDER BY cod DESC");
	$numClientes = mysql_num_rows($sqlClientes);
	if($numClientes > 0)
	{ 
		for($i = 0;$i < $numClientes;$i++)
		{
			$tpClientes = mysql_fetch_assoc($sqlClientes);
            if ( ($i/2) == (ceil($i/2)) )
			{
				echo "\n  <tr class=\"numeroAnuncio\">";
			}	
			else
			{
				echo  "<tr class=\"linhacinza numeroAnuncio\">";
			}
    			echo "	<td style='padding-bottom:5px; padding-left:5px; padding-top:2px;'>".$tpClientes['razaoSocialNome']." - ".$tpClientes['sobrenome']."</td>
    					<td style='padding-bottom:5px;' align='center'>".($tpClientes['tipoAnuncio'] == 1 ? "Particular" : "Revenda")."</td>
                        <td style='padding-bottom:5px;' align='center'>".dataBr($tpClientes['dataCadastro'])."</td>
    					<td style='padding-bottom:2px; padding-top:2px;' align='center'>
							<a href='http://".ADMIN_URL."/principal.php?id=6&subid=3&cod=".$tpClientes['cod']."&tipoAnuncio=".$tpClientes['tipoAnuncio']."' class='botaoDourado'>&nbsp;Editar&nbsp;</a>
						</td>
                    </tr>";
		}
	}
	else
	{
		echo "<tr><td style='padding-bottom:5px; padding-left:5px; padding-top:2px;'>Nenhum registro encontrado!</td></tr>";
	}
	
    ?>

 </table>