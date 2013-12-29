<?
$estadoGuia = isset($_GET['estado']) ?$_GET['estado'] : '';
$cidadeGuia = isset($_GET['cidade']) ? $_GET['cidade'] : '';
$catGuia = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$letra = isset($_GET['letra']) ? $_GET['letra'] : '';
?>
<tr>
    <td>
    	<table width="100%" cellpadding="0" border="0" cellspacing="0">
            <tr>
            	<td width="170" height="60" align="center" valign="middle" class="topo_lista_branco" bgcolor="#666666">Guia Automotivo</td>
                
                <td width="2" align="center" valign="bottom" bgcolor="#666666">
                    <img src="http://<?=ADMIN_IMG_URL;?>/traco.jpg" width="2" />
                </td>
              <td colspan="2" align="right" style="padding:4px" valign="top" bgcolor="#666666" class="topo_lista_categoria">
                
                <script type="text/javascript">
                $(document).ready(function()
                {
                    $('select#estado').change(function()
                    {
                        $('form#filtroGuia').submit();
                    });
                    
                    $('select#cidade').change(function()
                    {
                        $('form#filtroGuia').submit();
                    });
                    
                    $('select#categoria').change(function()
                    {
                        $('form#filtroGuia').submit();
                    });
                });
                </script>
               
                <form name="filtroGuia" id="filtroGuia" action="" method="get" style="width:32%;  float:left; text-align:left;">
                    <input type="hidden" name="id" id="id" value="3" />
                    <input type="hidden" name="subid" id="subid" value="1" />
                    <input type="hidden" name="letra" id="letra" value="<?=$letra;?>" />
                    <label>Estado: </label>
                    <select style="margin-bottom:5px;" name="estado" id="estado" title="Estado">
                        <option value="">Todos</option>
                        <?
                        $sqlEstados = mysql_query("SELECT estado FROM guiaAutomotivo WHERE estado != '' GROUP BY estado ORDER BY estado");
                        $numEstados = mysql_num_rows($sqlEstados);
                        for($x = 0;$x < $numEstados;$x++)
                        {
                            $tpEstados = mysql_fetch_assoc($sqlEstados);
                        ?>
                            <option value="<?=$tpEstados['estado'];?>" <?=$estadoGuia == $tpEstados['estado'] ? 'selected="selected"' : '';?> ><?=$tpEstados['estado'];?></option>
                        <?
                        }
                        ?>
                    </select>
                    <br />
                    <label>Cidade: </label>
                    <select style="margin-bottom:5px;" class="selectgrande" name="cidade" id="cidade" title="Cidade">
                        <option value="" >-</option>
                        <?
                        if($estadoGuia != '')
                        {
                            $sqlCidades = mysql_query("SELECT cidade FROM guiaAutomotivo WHERE estado = '{$estadoGuia}' AND cidade != '' GROUP BY cidade ORDER BY cidade");
                            $numCidades = mysql_num_rows($sqlCidades);
                            for($x = 0;$x < $numCidades;$x++)
                            {
                                $tpCidades = mysql_fetch_assoc($sqlCidades);
                        ?>
                                <option value="<?=$tpCidades['cidade'];?>" <?=$cidadeGuia == $tpCidades['cidade'] ? 'selected="selected"' : '';?> ><?=$tpCidades['cidade'];?></option>
                        <?
                            }
                        }
                        ?>
                    </select>
                    <br />
                    <label>Categoria: </label>
                    <select style="margin-bottom:5px;" class="selectgrande" name="categoria" id="categoria" title="Categoria">
                        <option value="" >-</option>
                        <?
                            $sqlCat = mysql_query("SELECT * FROM guiaAutomotivoCategorias ORDER BY ordem");
                            $numCat = mysql_num_rows($sqlCat);
                            for($x = 0;$x < $numCat;$x++)
                            {
                                $tpCat = mysql_fetch_assoc($sqlCat);
                        ?>
                                <option value="<?=$tpCat['cod'];?>" <?=$catGuia == $tpCat['cod'] ? 'selected="selected"' : '';?> ><?=$tpCat['categoria'];?></option>
                        <?
                            }
                        ?>
                    </select>
                </form>
                <a href="principal.php?id=3&subid=1&letra=A<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;A&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=B<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;B&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=C<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;C&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=D<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;D&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=E<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;E&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=F<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;F&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=G<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;G&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=H<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;H&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=I<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;I&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=J<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;J&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=K<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;K&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=L<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;L&nbsp;</a><br /><br />
                <a href="principal.php?id=3&subid=1&letra=M<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;M&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=N<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;N&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=O<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;O&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=P<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;P&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=Q<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;Q&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=R<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;R&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=S<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;S&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=T<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;T&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=U<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;U&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=V<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;V&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=W<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;W&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=X<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;X&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=Y<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;Y&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=Z<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;Z&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=3&subid=1&letra=<?=$estadoGuia != '' ? '&estado='.$estadoGuia : '';?><?=$cidadeGuia != '' ? '&cidade='.$cidadeGuia : '';?><?=$catGuia != '' ? '&categoria='.$catGuia : '';?>" class="botaoDourado" >&nbsp;Todos&nbsp;</a>
                
                
              </td>
            </tr>
            <tr>
            	<td align="right">
                    <?      
                	if($subid == "1")
                    {
                    ?>
                        <a href="http://<?=ADMIN_URL;?>/principal.php?id=3&subid=2">
                            <img src="http://<?=ADMIN_IMG_URL;?>/topo_novo.jpg" border="0" />
                        </a>
                    <?
                    }
                    ?>
                </td>
                <td colspan="2">
                    &nbsp;
                </td>
                
                <td align="right" valign="top">
                <?
                if($subid != "1")
                {
                ?>
                <a href="http://<?=ADMIN_URL;?>/principal.php?id=3&subid=1">
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