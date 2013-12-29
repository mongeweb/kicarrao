<?
$tipoClienteFiltro = isset($_GET['tipoAnuncio']) ? $_GET['tipoAnuncio'] : '1';
$letraFiltrovoltar = isset($_GET['letra']) ? $_GET['letra'] : '';
?>
<tr>
    <td>
    	<table width="100%" cellpadding="0" border="0" cellspacing="0">
            <tr>
            	<td width="170" height="60" align="center" valign="middle" class="topo_lista_branco" bgcolor="#666666">CLIENTES <?=$subid == "1" ? ($tipoClienteFiltro == '1' ? 'PARTICULAR' : 'REVENDA') : '';?></td>
                
                <td width="2" align="center" valign="bottom" bgcolor="#666666">
                    <img src="http://<?=ADMIN_IMG_URL;?>/traco.jpg" width="2" />
                </td>
              <td colspan="2" align="right" style="padding:4px" valign="top" bgcolor="#666666" class="topo_lista_categoria">
                <a href="principal.php?id=6&subid=1&letra=A&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;A&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=B&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;B&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=C&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;C&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=D&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;D&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=E&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;E&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=F&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;F&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=G&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;G&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=H&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;H&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=I&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;I&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=J&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;J&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=K&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;K&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=L&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;L&nbsp;</a><br /><br />
                <a href="principal.php?id=6&subid=1&letra=M&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;M&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=N&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;N&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=O&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;O&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=P&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;P&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=Q&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;Q&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=R&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;R&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=S&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;S&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=T&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;T&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=U&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;U&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=V&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;V&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=W&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;W&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=X&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;X&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=Y&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;Y&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=Z&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;Z&nbsp;</a>&nbsp;|&nbsp;
                <a href="principal.php?id=6&subid=1&letra=&tipoAnuncio=<?=$tipoClienteFiltro;?>" class="botaoDourado" >&nbsp;Todos&nbsp;</a>
              </td>
            </tr>
            <tr>
            	<td align="right">
                    <?      
                	if($subid == "1")
                    {
                    ?>
                        <a href="http://<?=ADMIN_URL;?>/principal.php?id=6&subid=2&tipoAnuncio=<?=$tipoClienteFiltro;?>">
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
                <a href="http://<?=ADMIN_URL;?>/principal.php?id=6&subid=1&tipoAnuncio=<?=$tipoClienteFiltro;?><?=$letraFiltrovoltar != '' ? '&letra='.$letraFiltrovoltar : '';?>">
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