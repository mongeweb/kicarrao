<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    <?php
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    require_once ADMIN_FUNC_PATH.'validaCampo.php';
    require_once ADMIN_FUNC_PATH.'fotos.php';
    require_once ADMIN_FUNC_PATH.'funcoes.php';
    $msg = '';
if(!empty($_POST['enviarAnuncioLoja']))
{
    $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : array();
	$nCategorias = count($categorias);
    $empresaAnuncioLoja = isset($_POST['empresa'])? $_POST['empresa'] : '' ;
    $foto = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $cepAnuncioLoja = isset($_POST['cep'])? $_POST['cep'] : '' ;
    $enderecoAnuncioLoja = isset($_POST['enderecoAnuncioLoja'])? $_POST['enderecoAnuncioLoja'] : '' ;
    $bairroAnuncioLoja = isset($_POST['bairroAnuncioLoja'])? $_POST['bairroAnuncioLoja'] : '' ;
    $cidadeAnuncioLoja = isset($_POST['cidadeAnuncioLoja'])? $_POST['cidadeAnuncioLoja'] : '' ;
    $estadoAnuncioLoja = isset($_POST['estadoAnuncioLoja'])? $_POST['estadoAnuncioLoja'] : '' ;
    $siteAnuncioLoja = isset($_POST['site'])? $_POST['site'] : '' ;
    $foneAnuncioLoja = isset($_POST['telefone1'])? $_POST['telefone1'] : '' ;
    $celularAnuncioLoja = isset($_POST['telefone2'])? $_POST['telefone2'] : '' ;
    $emailAnuncioLoja = isset($_POST['email'])? $_POST['email'] : '' ;
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($empresaAnuncioLoja))
    {
        $msg .= '<li>O campo Empresa deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($foneAnuncioLoja))
    {
        $msg .= '<li>O campo Telefone 1 deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($emailAnuncioLoja))
    {
        $msg .= '<li>O campo E-mail deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($cepAnuncioLoja))
    {
        $msg .= '<li>O campo CEP deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    /*if (!validaCampo($emailAnuncioLoja))
    {
        $msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
    if (!validaCampo($cepAnuncioLoja))
    {
        $msg .= '<li>O campo CEP deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($enderecoAnuncioLoja))
    {
        $msg .= '<li>O campo Endereco deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($bairroAnuncioLoja))
    {
        $msg .= '<li>O campo Bairro deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($cidadeAnuncioLoja))
    {
        $msg .= '<li>O campo Cidade deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($estadoAnuncioLoja))
    {
        $msg .= '<li>O campo Estado deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }*/
    
    if($foto != '')
    {
        $formato = $_FILES['file']['name'];
        $formato = strrev($formato);
        $formato = explode('.',$formato);
        $formato = $formato[0];
        $formato = strrev($formato);
    	$formato = strtolower($formato);
        $extensoesvalidas = array("jpg","jpeg","png");
        if(!in_array($formato,$extensoesvalidas))
    	{
    		$msg .= '<li>Formato de imagem inválido!</li>';
    		$erro = 1;
        }
    }
    
    $msg .= '</ul>';
    
    if($erro == 0)
    {
        $conexao = conexao();
        $dataCadastro = date('Y-m-d H:i:s');  
        $ordem = reordenarAuto();
        $sql = "INSERT INTO guiaAutomotivo (dataCadastro, empresa, cep, endereco, cidade, estado, bairro, email, site, fone1, fone2, ordem, mostrar, destaque)
                VALUES(
                '{$dataCadastro}', '{$empresaAnuncioLoja}', '{$cepAnuncioLoja}', '{$enderecoAnuncioLoja}', '{$cidadeAnuncioLoja}', '{$estadoAnuncioLoja}', '{$bairroAnuncioLoja}', '{$emailAnuncioLoja}', '{$siteAnuncioLoja}', '{$foneAnuncioLoja}', '{$celularAnuncioLoja}', '{$ordem}', '0', '0');";
    	$resultado = mysql_query($sql);
    	
		$codGuia = mysql_insert_id();
		
	   	for($b = 0; $b < $nCategorias; $b++)
		{
			if($categorias[$b] != '')
				$sqlCategorias = mysql_query("INSERT INTO guiasRelacao (codGuia, codCat) VALUES ('{$codGuia}','{$categorias[$b]}')");
		}
    	
        if($foto != '')
        {
            $foto_temp = $_FILES['file']['tmp_name'];
            $token = rand(1,99999).date('dmYHis');
            $pasta = PROJECT_PATH."arquivos/guia-automotivo";;
            $fileG = insere_foto($foto, $foto_temp, $pasta,'115','86');
    		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                    VALUES ('guiaAutomotivo', '{$codGuia}','1', '{$fileG}','$token')";
    		$resultadoG = mysql_query($sqlG);
        }
		
		require_once PROJECT_FUNC_PATH . 'cadastroEmail.php'; 
		
		$nomeRemetente = "Kicarrão";
		$assunto = "Cadastro Guia Automotivo - Kicarrão";
		$conteudoEmail = array(
			'empresa'      => $empresaAnuncioLoja,
			'fone'     => $foneAnuncioLoja,
			'e-mail'     => $emailAnuncioLoja,
			'cidade'     => $cidadeAnuncioLoja,
			'estado'     => $estadoAnuncioLoja,

		);
	
		$emailDestinatario = array();
		$emailRemetente = 'noreply@kicarrao.com.br';
		$emailResposta  = 'noreply@kicarrao.com.br';
		$twitter = '';
		$facebook = 'kicarrao';
		
		$conf = cadastroGuia($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);
		
		if($resultado)
		{
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
			echo "<script type='text/javascript'>
					alert('Dados cadastrados com sucesso!');
					location.replace('".$link."');
				  </script>";
                  die(); 
		}
		else
		{
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';		  
			echo "<script type='text/javascript'>
				   alert(\"Erro ao cadastrar dados, tente novamente mais tarde.\");
                   location.replace('".$link."');
				 </script> \n";
                 die();
		}
        mysql_close();
    }
}
else
{
    $empresaAnuncioLoja = '' ;
    $cepAnuncioLoja = '' ;
    $estadoAnuncioLoja = '' ;
    $cidadeAnuncioLoja = '' ;
    $bairroAnuncioLoja = '' ;
    $enderecoAnuncioLoja = '' ;
    $emailAnuncioLoja = '' ;
    $siteAnuncioLoja = '' ;
    $foneAnuncioLoja = '' ;
    $celularAnuncioLoja = '' ;
}
?>
    <script type="text/javascript" src="<?=sslRedir().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=sslRedir().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    
</head>
<script type="text/javascript">
                
function atualiza(_cep)
{
  _cep = (_cep == null) || (_cep == 'undefined') ? $("#cep").val() : _cep;
  //Requisição Ajax
  $.ajax(
  {
     type: "GET",
     url: "<?=ssl().PROJECT_URL;?>/ajaxCep.php", //URL de destino
     data:{ cep: _cep},
     dataType: "json", //Tipo de Retorno
     success: function(correio)
     { //Se ocorrer tudo certo
        if(correio.erro == 0)
        {
            _end = correio.logradouro;
			_endereco = _end.split(" - ");
			
			$("#enderecoAnuncioLoja").val(_endereco[0]).focus();
            $("#bairroAnuncioLoja").val(correio.bairro);
            $("#cidadeAnuncioLoja").val(correio.cidade);
            $("#estadoAnuncioLoja").val(correio.estado);
            $("#cepAnuncioLoja").val(correio.cep);
        }
        else
        {
            alert(correio.erro);
        }
     }
  });
}
function enable()
{
    $("#cidadeAnuncioLoja").removeAttr("disabled");
    $("#estadoAnuncioLoja").removeAttr("disabled");
}
$(document).ready(function()
{
    $("#atualizaCep").click(function(){
        atualiza();
    });    
//<![CDATA[
	objValidadorCadastro = new xform('#dadosAnuncioLoja',{
	   callbackTrue:function(){
	       enable();
	   }
    });
    objValidadorCadastro.adicionar('input#empresa');
    objValidadorCadastro.adicionar('input#site','url',true);
    objValidadorCadastro.adicionar('input#email','email');
    objValidadorCadastro.adicionar('input#cep','cep');
    objValidadorCadastro.adicionar('input#telefone1', 'fone5');
    objValidadorCadastro.adicionar('input#telefone2', 'fone5', true);
//]]>
})
</script>
<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie sua Loja</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <form name="dadosAnuncioLoja" id="dadosAnuncioLoja" method="post" action="" enctype="multipart/form-data" onsubmit="">
                    <div class="dadosrevenda">
                        <div class="planotitulogeral">Anuncie sua Loja</div>
                        <?=$msg;?>
                        <div class="inputbloco">
                            <div class="anunciocheckbloco">
                                <? 
                                $conexao = conexao();
                			 	$sqlCategorias = mysql_query("SELECT cod, categoria FROM guiaAutomotivoCategorias order by categoria");
                			  	$nCategorias = mysql_num_rows($sqlCategorias);
                			  	
                				if($nCategorias > 0)
                			  	{
                              		for ($i = 0; $i < $nCategorias; $i++)
                					{
                						$tpCategorias = mysql_fetch_assoc($sqlCategorias);	
                			  			?> 
                                        <div class="garantiaradio"> 
                						  <input type="checkbox" class="uncheck" name="categorias[]" id="categorias" title="<?=$tpCategorias['categoria']?>" value="<?=$tpCategorias['cod']?>"  />
                                            <span><?=$tpCategorias['categoria']?></span>
                                        </div>
                			  			<?						
                					}
                			  	}
                                mysql_close();
                			    ?>
                            </div>
                        </div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="empresaAnuncioLoja">Empresa <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="empresa" id="empresa" title="Empresa" value="<?=$empresaAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label style="float:left;" for="cepAnuncioLoja">CEP <span class="obrigatorio">*</span></label>
                            <input style="float:left; clear:none;" type="text" class="inputmenor" name="cep" id="cep" title="CEP" value="<?=$cepAnuncioLoja;?>"/>
                            <a class="atualizarCadastro" id="atualizaCep">Atualizar</a>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="estadoAnuncioLoja">Estado </label>
                            <select class="selectgranderevenda" name="estadoAnuncioLoja" id="estadoAnuncioLoja" title="Estado" disabled="disabled">
                                <option value="">-</option>
                                <option value="AC" <?=$estadoAnuncioLoja == 'AC' ? 'selected="selected"' : '';?>>AC</option>
                                <option value="AL" <?=$estadoAnuncioLoja == 'AL' ? 'selected="selected"' : '';?>>AL</option>
                                <option value="AM" <?=$estadoAnuncioLoja == 'AM' ? 'selected="selected"' : '';?>>AM</option>
                                <option value="AP" <?=$estadoAnuncioLoja == 'AP' ? 'selected="selected"' : '';?>>AP</option>
                                <option value="BA" <?=$estadoAnuncioLoja == 'BA' ? 'selected="selected"' : '';?>>BA</option>
                                <option value="CE" <?=$estadoAnuncioLoja == 'CE' ? 'selected="selected"' : '';?>>CE</option>
                                <option value="DF" <?=$estadoAnuncioLoja == 'DF' ? 'selected="selected"' : '';?>>DF</option>
                                <option value="ES" <?=$estadoAnuncioLoja == 'ES' ? 'selected="selected"' : '';?>>ES</option>
                                <option value="GO" <?=$estadoAnuncioLoja == 'GO' ? 'selected="selected"' : '';?>>GO</option>
                                <option value="MA" <?=$estadoAnuncioLoja == 'MA' ? 'selected="selected"' : '';?>>MA</option>
                                <option value="MT" <?=$estadoAnuncioLoja == 'MT' ? 'selected="selected"' : '';?>>MT</option>
                                <option value="MS" <?=$estadoAnuncioLoja == 'MS' ? 'selected="selected"' : '';?>>MS</option>
                                <option value="MG" <?=$estadoAnuncioLoja == 'MG' ? 'selected="selected"' : '';?>>MG</option>
                                <option value="PA" <?=$estadoAnuncioLoja == 'PA' ? 'selected="selected"' : '';?>>PA</option>
                                <option value="PB" <?=$estadoAnuncioLoja == 'PB' ? 'selected="selected"' : '';?>>PB</option>
                                <option value="PR" <?=$estadoAnuncioLoja == 'PR' ? 'selected="selected"' : '';?>>PR</option>
                                <option value="PE" <?=$estadoAnuncioLoja == 'PE' ? 'selected="selected"' : '';?>>PE</option>
                                <option value="PI" <?=$estadoAnuncioLoja == 'PI' ? 'selected="selected"' : '';?>>PI</option>
                                <option value="RJ" <?=$estadoAnuncioLoja == 'RJ' ? 'selected="selected"' : '';?>>RJ</option>
                                <option value="RN" <?=$estadoAnuncioLoja == 'RN' ? 'selected="selected"' : '';?>>RN</option>
                                <option value="RO" <?=$estadoAnuncioLoja == 'RO' ? 'selected="selected"' : '';?>>RO</option>
                                <option value="RS" <?=$estadoAnuncioLoja == 'RS' ? 'selected="selected"' : '';?>>RS</option>
                                <option value="RR" <?=$estadoAnuncioLoja == 'RR' ? 'selected="selected"' : '';?>>RR</option>
                                <option value="SC" <?=$estadoAnuncioLoja == 'SC' ? 'selected="selected"' : '';?>>SC</option>
                                <option value="SE" <?=$estadoAnuncioLoja == 'SE' ? 'selected="selected"' : '';?>>SE</option>
                                <option value="SP" <?=$estadoAnuncioLoja == 'SP' ? 'selected="selected"' : '';?>>SP</option>
                                <option value="TO" <?=$estadoAnuncioLoja == 'TO' ? 'selected="selected"' : '';?>>TO</option>
                            </select>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cidadeAnuncioLoja">Cidade</label>
                            <input type="text" class="inputgranderevenda" name="cidadeAnuncioLoja" id="cidadeAnuncioLoja" title="Cidade" value="<?=$cidadeAnuncioLoja;?>"  disabled="disabled" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="bairroAnuncioLoja">Bairro</label>
                            <input type="text" class="inputgranderevenda" name="bairroAnuncioLoja" id="bairroAnuncioLoja" title="Bairro" value="<?=$bairroAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="enderecoAnuncioLoja">Endereço</label>
                            <input type="text" class="inputgranderevenda" name="enderecoAnuncioLoja" id="enderecoAnuncioLoja" title="Endereço" value="<?=$bairroAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="emailAnuncioLoja">E-mail <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="email" id="email" title="E-mail" value="<?=$emailAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label style="float:left;" for="siteAnuncioLoja">Site</label>
                            <input type="text" class="inputgranderevenda" name="site" id="site" title="Site" value="<?=$siteAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="foneAnuncioLoja">Telefone 1<span class="obrigatorio">*</span></label>
                            <input style="width: 185px;" type="text" class="inputpequeno" name="telefone1" id="telefone1" title="Telefone 1" value="<?=$foneAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="celularAnuncioLoja">Telefone 2</label>
                            <input style="width: 185px;" type="text" class="inputpequeno" name="telefone2" id="telefone2" title="Telefone 2" value="<?=$celularAnuncioLoja;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label style="float:left;" class="composto" for="file">Logo da Empresa</label>
                            <input style="float:left; clear:none;" type="file" name="file" id="file" title="Logo da Empresa" />
                            <div class="revendaenviar">
                                <input type="submit" name="enviarAnuncioLoja" id="enviarAnuncioLoja" title="Enviar" value="Enviar" />
                            </div>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="valorEntradaVeiculo">&nbsp;</label>
                            <span class="anunciolegenda">* Campos obrigatórios</span>
                        </div>
                    </div>
                </form>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>