 <?
$codFiltro = isset($_GET['codCli']) ? $_GET['codCli'] : '';
$tipoAnuncio = isset($_GET['tipoAnuncio']) ? $_GET['tipoAnuncio'] : '1';
$planoFiltro = isset($_GET['codPlano']) ? $_GET['codPlano'] : '';
?>
<tr>
    <td>
    	<table width="100%" cellpadding="0" border="0" cellspacing="0">
            <tr>
            	<td width="170" height="60" align="center" valign="middle" class="topo_lista_branco" bgcolor="#666666">AN&Uacute;NCIOS <?=$tipoAnuncio == '1' ? 'PARTICULAR' : 'REVENDA';?></td>
                
                <td width="2" align="center" valign="bottom" bgcolor="#666666">
                    <img src="http://<?=ADMIN_IMG_URL;?>/traco.jpg" width="2" />
                </td>
              <td colspan="2" align="right" style="padding:4px" valign="top" bgcolor="#666666" class="topo_lista_categoria">
              <script type="text/javascript">
                $(document).ready(function()
                {
                    $('select#codCli').change(function()
                    {
                        $('form#filtroCliente').submit();
                    });
                    
                    $('select#codPlano').change(function()
                    {
                        $('form#filtroCliente').submit();
                    });
                });
                </script>
               
                <form name="filtroCliente" id="filtroCliente" action="" method="get" style="width:100%; height:100%; ">
                    <input type="hidden" name="id" id="id" value="10" />
                    <input type="hidden" name="subid" id="subid" value="1" />
                    <input type="hidden" name="tipoAnuncio" id="tipoAnuncio" value="<?=$tipoAnuncio;?>" />
                    <label>Clientes: </label>
                    <select name="codCli" id="codCli" title="Clientes">
                        <option value="">Todos</option>
                        <?
                        $sqlClientes = mysql_query("SELECT * FROM clientes WHERE tipoAnuncio = '$tipoAnuncio' ORDER BY razaoSocialNome");
                        $numClientes = mysql_num_rows($sqlClientes);
                        for($x = 0;$x < $numClientes;$x++)
                        {
                            $tpClientes = mysql_fetch_assoc($sqlClientes);
                        ?>
                            <option value="<?=$tpClientes['cod'];?>" <?=$tpClientes['cod'] == $codFiltro ? 'selected="selected"' : '';?>><?=$tpClientes['razaoSocialNome'];?>&nbsp;<?=$tpClientes['sobrenome'];?></option>
                        <?
                        }
                        ?>
                    </select>
                    <br /><br />
                    <label>Plano: </label>
                    <select name="codPlano" id="codPlano" title="Planos">
                        <option value="">Todos</option>
                        <?
                        if($tipoAnuncio == '2')
                        {
                            $sqlPlanos = mysql_query("SELECT p.codTipoVeiculo, p.plano, tv.tipoVeiculo, p.cod 
                                                        FROM planosRevenda AS p
                                                        INNER JOIN tipoVeiculo AS tv ON tv.cod = p.codTipoVeiculo 
                                                        ORDER BY p.plano");
                        }
                        else
                        {
                            $sqlPlanos = mysql_query("SELECT * FROM planosParticular ORDER BY plano");
                        }                            
                        $numPlanos = mysql_num_rows($sqlPlanos);
                        for($x = 0;$x < $numPlanos;$x++)
                        {
                            $tpPlanos = mysql_fetch_assoc($sqlPlanos);
                            if($tipoAnuncio == '2')
                                $imprimePlanos = $tpPlanos['plano'].' - '.$tpPlanos['tipoVeiculo'];
                            else
                                $imprimePlanos = $tpPlanos['plano'];
                        ?>
                            <option value="<?=$tpPlanos['cod'];?>" <?=$tpPlanos['cod'] == $planoFiltro ? 'selected="selected"' : '';?>><?=$imprimePlanos;?></option>
                        <?
                        }
                        ?>
                    </select>
                </form>
              </td>
            </tr>
            <tr>
            	<td align="right">&nbsp;
                    
                </td>
                <td colspan="2">&nbsp;
                    
                </td>
                
                <td align="right" valign="top">
                <?
                if($subid != "1")
                {
                ?>
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=10&subid=1<?=$codFiltro != '' ? '&codCli='.$codFiltro : '';?><?=$planoFiltro != '' ? '&codPlano='.$planoFiltro : '';?><?=$tipoAnuncio != '' ? '&tipoAnuncio='.$tipoAnuncio : '';?>">
                        <img src="http://<?=ADMIN_IMG_URL;?>/topo_voltar.jpg" border="0" />
                    </a>
                <?
                }
                ?>
                </td>
            </tr>
        </table>
    </td>
  </tr>