
<table width="850" border="0" cellspacing="0" cellpadding="0">
    <? require_once ADMIN_TOP_PATH.'permissoes_topo.php'; ?>
  <tr>
    <td> 
		<table width="850" border="0" cellpadding="0" cellspacing="6">
        <tr> 
          <td align="left" valign="top" >
          <?
		
		$permitidos = array();
		$cod_user = $_GET['cod_user'];
		$resultado = mysql_query("SELECT cod, permissoes, nome FROM usuarios WHERE cod = ".$cod_user."", $conexao);
		$linhas = mysql_num_rows($resultado);
		if($linhas>0)
		{
		///// pega a lista de permitidos
			$tupla = mysql_fetch_array($resultado);
			$permitidos =  explode(" ", $tupla['permissoes']);
		}
		echo "Usu&aacute;rio: ".$tupla['nome'];
		?>
        </td>
          </tr>
       
		<tr> 
          <td align="left" ><?
			/*$tipo = $_GET['tipo'];*/
?>
<table width="650" align="left" border="0" style="padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px">
  <tr>
<td>
      <form name="cadastro_selecao" action="http://<?=ADMIN_URL;?>/usuarios/permissoes_atualiza.php" method="post" enctype="multipart/form-data">
        <table width="95%" border="0" align="center">
          <tr class="corpo_form"> 
            <td colspan="3" align="right"><div  align="center">:: Permiss&otilde;es :: 
                <input name="tabelas" id="tabelas" value="<?=$tupla['permissoes'];?>" type="hidden">
                 <input name="cod" id="cod" value="<?=$cod_user;?>" type="hidden">
              </div></td>
          </tr>
          <tr class="corpo_form">
            <td height="14" align="left">N&atilde;o tem acesso</td>
            <td align="center">&nbsp;</td>
            <td align="left">Tem acesso</td>
          </tr>
          <tr class="corpo_form"> 
            <td width="45%" height="164" align="right"> <select name="origem" size="15" multiple class="in" id="origem" style="width:250px" >
        <?php
		
		$resultado = mysql_query("SELECT * FROM tabelas ORDER BY nome", $conexao);
		$linhas = mysql_num_rows($resultado);
		if($linhas>0)
		{
			$n=1;
			while( $n <= $linhas ) 
			{
			
				$tupla = mysql_fetch_array($resultado);
				//////// listagem
/*				if(is_array($permitidos))
				{*/
					if(!in_array($tupla['tabela'],$permitidos))
					{
						echo "\n<option value=\"".$tupla['tabela']."\">".$tupla['nome']."</option>"; // 
					}
				//}	
				$n++;
			}
		}
		else
		{
		//echo "<option class=\"titulo_form\"  value=\"0\">Nenhum Usuario Encontrado</option>";
		}

?>
            </select> </td>
            <td width="10%" align="center"><p> 
                <input name="add" type="button" 
				<?php if(!($linhas>0)) echo "disabled=\"true\"";?>
				class="botao_2" id="add" onClick="adiciona(this.form.origem,this.form.destino)" value="     &gt;&gt;   " >
              </p>
              <p> 
                <input name="rem" class="botao_2" type="button"
				<?php if(!($linhas>0)) echo "disabled=\"true\"";?>
				 id="rem" value="    &lt;&lt;    " onClick="adiciona(this.form.destino,this.form.origem)">
              </p></td>
            <td width="45%" align="left"> 
            <select name="destino" class="in" size="15" style="width:250px" multiple id="destino">
            <?
	
				$resultado = mysql_query("SELECT * FROM tabelas", $conexao);
				$linhas = mysql_num_rows($resultado);
				if($linhas>0)
				{
					$n=1;
					while( $n <= $linhas ) 
					{
						$tupla = mysql_fetch_array($resultado);
						//if(is_array($permitidos))
						//{
							if(in_array($tupla['tabela'],$permitidos))
							{
								echo "\n<option value=\"".$tupla['tabela']."\">".$tupla['nome']."</option>";
							}
						//}
						$n++;
					}
				}
				else
				{
				//echo "<option class=\"titulo_form\"  value=\"0\">Nenhum Usuario Encontrado</option>";
				}
?>
              </select>
              </input>
              </td>
          </tr>
        </table>
        <table width="95%"  border="0" align="center">
          <tr class="corpo_form"> 
            <td width="25%" height="15" align="right">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="50%"  class="aviso_form">&nbsp;</td>
          </tr>
          <tr class="corpo_form"> <br>
            <td height="22" colspan="3" align="center"><input class="botao" name="Submit" type="submit" value=" Atualizar "></td>
            </tr>
          <tr class="corpo_form">
            <td height="15" align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td  class="aviso_form">&nbsp;</td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</td>
          </tr>
      </table>
	</td>
  </tr>
</table>
<?
//}
?>