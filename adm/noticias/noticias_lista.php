<?php
if(!verifica_permissao($cod_user, $nivel_user, "noticias"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'noticias_topo.php';
?>

<script type="text/javascript">
function verificaNumero(e)
{
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
$(document).ready(function()
{
    $('input[name="destaque[]"]').click(function(){
        
        obj = $(this);
        _destaque = obj.is(':checked') ? '1' : '0';
        _cod = obj.val();
        obj.css('display', 'none');
        obj.parent().append('<img title="Carregando" src="img/load16x16.gif" />');
        
        $.ajax(
        {
            type: "POST",
            url: "ajax/ajaxNoticiaDes.php", //URL de destino
            data:
            {
                cod: _cod,
                destaque: _destaque
            },
            dataType: "json", //Tipo de Retorno
            success: function(j)
            { //Se ocorrer tudo certo
                obj.css('display', '');
                obj.parent().children('img').each(function() { jQuery(this).remove() });
            }
        });
    })
})
</script>
<table width="100%">
    <tr>	
    	<td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" class="txtpreto">Titulo</td>
      <td width="25%" align="center" class="txtpreto">Lable</td>
      <td width="9%" align="center" class="txtpreto">Data</td>
      <td width="5%"  align="center" class="txtpreto">Destaque</td>
      <td width="12%" align="center" class="txtpreto" >A&ccedil;&otilde;es</td>
    </tr>
    <tr>
    	<td colspan="5"><hr /></td>
    </tr>
    <!-- linha em loop INICIO-->
	<?php
    
    $resultado2 = mysql_query("SELECT * FROM noticias ORDER BY data DESC", $conexao);
    $linhas = mysql_num_rows($resultado2);
    if ($linhas>0)
    {
        for($n=0;$n<$linhas;$n++)
        {
            #<!-- linha impar branca | linha par cinza -->
            $tupla = mysql_fetch_assoc($resultado2);
            $data = substr($tupla['data'],8,2)."/".substr($tupla['data'],5,2)."/".substr($tupla['data'],0,4);
            
            $resultadoLables = mysql_query("SELECT * FROM noticiasLables WHERE cod = '{$tupla['codLable']}' ", $conexao);
            $tuplaLable = mysql_fetch_assoc($resultadoLables);
                
            if ( ($n/2) == (ceil($n/2)) )
            {
                echo "\n<tr>";
            }
            else
            {
                echo "<tr class=\"linhacinza\">";
            }	
            ?>
                    <td align="left" style="padding-left:10px;">
                        <strong>>&nbsp;&nbsp;</strong>
                        <?=$tupla['titulo'];?>&nbsp;
                    </td> 
                    <td align="center">
                        <?=$tuplaLable['titulo'];?>
                    </td>
                    <td align="center">
                        <?=$data;?>
                    </td>
                    <td align="center">
                        <input type="checkbox" name="destaque[]" id="destaque" value="<?=$tupla['cod'];?>" <?=$tupla['destaque'] == 1 ? "checked='checked'" : "";?> />
                    </td> 
                    <td align="center">
                        <a href="principal.php?id=2&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado" align="center">
                        &nbsp;&nbsp;Editar&nbsp;&nbsp;
                        </a>
                        <a onclick="return confirm('Tem certeza que deseja excluir esse registro?');" href="http://<?=ADMIN_URL?>/noticias/noticias_apaga.php?cod=<?=$tupla['cod'];?>" class="botaoDourado" >
                            &nbsp;&nbsp;Excluir&nbsp;&nbsp;
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
        <td colspan="6" align="left" class="texto">
            Nenhum Registro Encontrado
        </td>
    </tr>
    <?
}	
?>
</table>