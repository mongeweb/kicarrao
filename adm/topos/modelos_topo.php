<tr>
    <td>
    	<table width="100%" cellpadding="0" border="0" cellspacing="0">
            <tr>
            	<td width="170" height="60" align="center" valign="middle" class="topo_lista_branco" bgcolor="#666666">MODELOS</td>
                
                <td width="2" align="center" valign="bottom" bgcolor="#666666">
                    <img src="http://<?=ADMIN_IMG_URL;?>/traco.jpg" width="2" />
                </td>
              <td colspan="2" align="right" style="padding:4px" valign="top" bgcolor="#666666" class="topo_lista_categoria">
                &nbsp;
              </td>
            </tr>
            <tr>
            	<td align="right">
                    <?      
                	if($subid == "1")
                    {
                    ?>
                        <a href="http://<?=ADMIN_URL;?>/principal.php?id=8&subid=2">
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
                <a href="http://<?=ADMIN_URL;?>/principal.php?id=8&subid=1">
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