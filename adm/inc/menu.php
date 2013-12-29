<?php

function menu()
{
	?>
    <script type="text/javascript">
		$(document).ready(function(){
			$("div.subcli").mouseover(function(){
				$("div#clientesMenu1").show();
				$(this).mouseout(function(){
					$("div#clientesMenu1").hide();
				})
			})
			$("div#clientesMenu1").mouseover(function(){
				$(this).show();
				$(this).mouseout(function(){
					$(this).hide();
				})
			})
			$("td#mailing").mouseover(function(){
				$("div#clientesMenu1").hide();
			})
			
			$('td#estoque').mouseover(function(){
            	$('div#menulistaProd').show();
				$(this).mouseout(function(){
					$('div#menulistaProd').hide();    
				});    
			});
			
			$('div#menulistaProd').mouseover(function(){
				$(this).show();
				$(this).mouseout(function(){
					$(this).hide();    
				});    
			});
            
            $('td#veiculos').mouseover(function(){
            	$('div#menulistaVeiculos').show();
				$(this).mouseout(function(){
					$('div#menulistaVeiculos').hide();    
				});    
			});
			
			$('div#menulistaVeiculos').mouseover(function(){
				$(this).show();
				$(this).mouseout(function(){
					$(this).hide();    
				});    
			});
            
            $('td#clientes').mouseover(function(){
            	$('div#menulistaClientes').show();
				$(this).mouseout(function(){
					$('div#menulistaClientes').hide();    
				});    
			});
			
			$('div#menulistaClientes').mouseover(function(){
				$(this).show();
				$(this).mouseout(function(){
					$(this).hide();    
				});    
			});
			
			$('td#noticias').mouseover(function(){
            	$('div#menulistaNoticias').show();
				$(this).mouseout(function(){
					$('div#menulistaNoticias').hide();    
				});    
			});
			
			$('div#menulistaNoticias').mouseover(function(){
				$(this).show();
				$(this).mouseout(function(){
					$(this).hide();    
				});    
			});
			
			
		})
	</script>
    <?
    require_once ADMIN_FUNC_PATH.'permissoes.php';

    $cod_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_cod_user'])) ? $_SESSION[ADMIN_SESSION_NAME.'_cod_user'] : '' ;
	$nivel_user = (isset($_SESSION[ADMIN_SESSION_NAME.'_nivel'])) ? $_SESSION[ADMIN_SESSION_NAME.'_nivel'] : '' ;
    $menu = (isset($_SESSION[ADMIN_SESSION_NAME.'_menu'])) ? $_SESSION[ADMIN_SESSION_NAME.'_menu'] : '' ;

?>
		<table cellpadding="0" cellspacing="0">
		  <tr class="menutr">
          	<td valign="top" style="cursor:pointer;">
                <div class="menuwrap">
                    <a class="menu_link" href="principal.php">
                    &nbsp;Home&nbsp;</a>&nbsp;|&nbsp;
                </div>
            </td>
	        <?
            if (verifica_permissao($cod_user, $nivel_user, "usuarios"))
            {
            ?>          
        		  <td valign="top" style="cursor:pointer;">
                  	<div class="menuwrap">
                    	<a class="menu_link" href="principal.php?id=1&subid=1">
                    	&nbsp;Usu&aacute;rios&nbsp;</a>&nbsp;|&nbsp;
                    </div>
                  </td>
    		<?
            } 
			if (verifica_permissao($cod_user, $nivel_user, "clientes"))
            {
            ?>
                <td valign="top" style="cursor:pointer;" id="clientes">
                    <div class="menuwrap">
                        <a class="menu_link" href="#">
                            &nbsp;Clientes</a>&nbsp;|&nbsp;
                    </div>
                </td>
    		<?
            }
			if (verifica_permissao($cod_user, $nivel_user, "planos"))
            {
            ?>          
        		  <td valign="top" style="cursor:pointer;">
                  	<div class="menuwrap">
                    	<a class="menu_link" href="principal.php?id=5&subid=1">
                    	&nbsp;Planos&nbsp;</a>&nbsp;|&nbsp;
                    </div>
                  </td>
    		<?
            }
			if (verifica_permissao($cod_user, $nivel_user, "veiculos"))
            {
            ?>
                 <td valign="top" style="cursor:pointer;" id="veiculos">
                    <div class="menuwrap">
                        <a class="menu_link" href="#">
                            &nbsp;Ve&iacute;culos
                        </a>&nbsp;|&nbsp;
                    </div>
                </td>
            <?
            }
			if (verifica_permissao($cod_user, $nivel_user, "guiaAutomotivo"))
            {
            ?>
                 <td valign="top" style="cursor:pointer;">
                  	<div class="menuwrap">
                    	<a class="menu_link" href="principal.php?id=3&subid=1">
                    	&nbsp;Guia Automotivo&nbsp;</a>&nbsp;|&nbsp;
                    </div>
                 </td>
            <?
            }
            if (verifica_permissao($cod_user, $nivel_user, "noticias"))
            {
            ?>          
        		  <td valign="top" style="cursor:pointer;" id="noticias">
                  	<div class="menuwrap">
                    	<a class="menu_link" href="#">
                    	&nbsp;Not&iacute;cias&nbsp;</a>&nbsp;|&nbsp;
                    </div>
                  </td>
    		<?
            }
            if (verifica_permissao($cod_user, $nivel_user, "publicidades"))
            {
            ?>          
        		  <td valign="top" style="cursor:pointer;">
                  	<div class="menuwrap">
                    	<a class="menu_link" href="principal.php?id=11&subid=1">
                    	&nbsp;Publicidades&nbsp;</a>&nbsp;|&nbsp;
                    </div>
                  </td>
    		<?
            }
            if (verifica_permissao($cod_user, $nivel_user, "pagamentos"))
            {
            ?>          
        		  <td valign="top" style="cursor:pointer;">
                  	<div class="menuwrap">
                    	<a class="menu_link" href="principal.php?id=15&subid=1">
                    	&nbsp;Pagamentos&nbsp;</a>&nbsp;|&nbsp;
                    </div>
                  </td>
    		<?
            }
			?>
            <td valign="top" style="cursor:pointer;">
            	<div class="menuwrap">
                    <a class="menu_link" href="logout.php">
                        &nbsp;Logout&nbsp;
                    </a>
                </div>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?
            if (verifica_permissao($cod_user, $nivel_user, "usuarios"))
            {
            ?>          
        		  <td>&nbsp;</td>
    		<?
            } 
			if (verifica_permissao($cod_user, $nivel_user, "clientes"))
            {
            ?>
                <td>
                    <div id="menulistaClientes">   
                       <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=6&subid=1&tipoAnuncio=2">
                                Cliente Revenda
                            </a>
                        </div>
                        <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=6&subid=1&tipoAnuncio=1">
                                Cliente Particular
                            </a>
                        </div>
                        <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=10&subid=1&tipoAnuncio=2">
                                An&uacute;ncios Revenda
                            </a>
                        </div>
                        <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=10&subid=1&tipoAnuncio=1">
                                An&uacute;ncios Particular
                            </a>
                        </div>
                    </div>
                </td>
    		<?
            }
			if (verifica_permissao($cod_user, $nivel_user, "planos"))
            {
            ?>          
        		  <td>&nbsp;</td>
    		<?
            }
			if (verifica_permissao($cod_user, $nivel_user, "veiculos"))
            {
            ?>
                 <td>
                    <div id="menulistaVeiculos">   
                       <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=7&subid=1">
                                Marcas
                            </a>
                        </div>
                        <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=8&subid=1">
                                Modelos
                            </a>
                        </div>
                        <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=9&subid=1">
                                Vers&otilde;es
                            </a>
                        </div>
                    </div>
                </td>
            <?
            }
			if (verifica_permissao($cod_user, $nivel_user, "guiaAutomotivo"))
            {
            ?>
                 <td>&nbsp;</td>
            <?
            }
            if (verifica_permissao($cod_user, $nivel_user, "noticias"))
            {
            ?>          
        		<td>
                    <div id="menulistaNoticias">   
                       <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=13&subid=1">
                                Lables
                            </a>
                        </div>
                        <div style="cursor:pointer;" class="menulista_link">
                            <a  href="principal.php?id=2&subid=1">
                                Noticia
                            </a>
                        </div>
                    </div>
                </td>
    		<?
            }
            if (verifica_permissao($cod_user, $nivel_user, "publicidades"))
            {
            ?>          
        		  <td>&nbsp;</td>
    		<?
            }
            if (verifica_permissao($cod_user, $nivel_user, "pagamentos"))
            {
            ?>          
        		  <td>&nbsp;</td>
    		<?
            }
			?>
            <td>&nbsp;</td>
          </tr>
		</table>
<?
}
?>