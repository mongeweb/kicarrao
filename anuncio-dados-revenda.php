<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php

require_once PROJECT_INC_PATH.'head.php';
require_once PROJECT_FUNC_PATH.'enviarEmail.php';
require_once ADMIN_FUNC_PATH . 'verifica.php';
require_once ADMIN_FUNC_PATH.'validaCampo.php';
require_once ADMIN_FUNC_PATH.'fotos.php';
require_once ADMIN_FUNC_PATH.'funcoes.php';
require_once ADMIN_FUNC_PATH."formatting.php";

if($restrita == 1)
{
	$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
	printf("<script type='text/javascript'>
				document . location . replace('%s');
			</script>", $link);
	exit();
}
$_SESSION['boleto'] = 0;
	
if(isset($_POST['planoInput']) || isset($_SESSION['plano']))
{
    if(isset($_POST['planoInput']))
        $_SESSION['plano'] = $_POST['planoInput'];
    
    $planoRevenda = $_SESSION['plano'];
}
elseif(!isset($_POST['planoInput']) && !isset($_SESSION['plano']) && $cod == '')
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/planos' : sslRedir().PROJECT_URL.'/anuncio-planos.php';
    echo " <script>";
	echo " location.replace('".$link."'); \n";
	echo " </script>";
    die();   
}

$msg = '';
	
if(!empty($_POST['enviarDadosRevenda']))
{
    $tipoAnuncio = 2;
    $razaoRevenda = isset($_POST['razaoRevenda'])? $_POST['razaoRevenda'] : '' ;
    $nomeFantasia = isset($_POST['nomeRevenda'])? $_POST['nomeRevenda'] : '' ;
    $cnpjRevenda = isset($_POST['cnpjRevenda'])? $_POST['cnpjRevenda'] : '' ;
    $foto = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $cepRevenda = isset($_POST['cepRevenda'])? $_POST['cepRevenda'] : '' ;
    $enderecoRevenda = isset($_POST['enderecoRevenda'])? $_POST['enderecoRevenda'] : '' ;
    $numeroRevenda = isset($_POST['numeroRevenda'])? $_POST['numeroRevenda'] : '' ;
    $bairroRevenda = isset($_POST['bairroRevenda'])? $_POST['bairroRevenda'] : '' ;
    $cidadeRevenda = isset($_POST['cidadeRevenda'])? $_POST['cidadeRevenda'] : '' ;
    $estadoRevenda = isset($_POST['estadoRevenda'])? $_POST['estadoRevenda'] : '' ;
    $complementoRevenda = isset($_POST['complementoRevenda'])? $_POST['complementoRevenda'] : '' ;
    $siteRevenda = isset($_POST['siteRevenda'])? $_POST['siteRevenda'] : '' ;
    $foneRevenda = isset($_POST['foneRevenda'])? $_POST['foneRevenda'] : '' ;
    $foneComRevenda = isset($_POST['foneComRevenda'])? $_POST['foneComRevenda'] : '' ;
    $celularRevenda = isset($_POST['celularRevenda'])? $_POST['celularRevenda'] : '' ;
    $emailRevenda = isset($_POST['emailRevenda'])? $_POST['emailRevenda'] : '' ;
    $codPlanoRevenda = isset($planoRevenda)? $planoRevenda : '';
    $responsavelRevenda = isset($_POST['responsavelRevenda'])? $_POST['responsavelRevenda'] : '' ;
    $situacao = isset($_POST['situacao'])? $_POST['situacao'] : 0 ;
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($razaoRevenda))
    {
        $msg .= '<li>O campo Razão Social / Nome deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($nomeFantasia))
    {
        $msg .= '<li>O campo Nome Fantasia deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($foneRevenda))
    {
        $msg .= '<li>O campo Telefone Fixo 1 deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($cnpjRevenda))
    {
        $msg .= '<li>O campo CNPJ deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
    if (!validaCampo($responsavelRevenda))
    {
        $msg .= '<li>O campo Responsável  deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
    if (!validaCampo($emailRevenda))
    {
        $msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
        
    if (!validaCampo($codPlanoRevenda))
    {
        $msg .= '<li>O campo Plano da Revenda deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
    if (!validaCampo($cepRevenda))
    {
        $msg .= '<li>O campo CEP deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($enderecoRevenda))
    {
        $msg .= '<li>O campo Endereco deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($numeroRevenda))
    {
        $msg .= '<li>O campo Número deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($bairroRevenda))
    {
        $msg .= '<li>O campo Bairro deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($cidadeRevenda))
    {
        $msg .= '<li>O campo Cidade deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($estadoRevenda))
    {
        $msg .= '<li>O campo Estado deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    
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
        $sqlFiltro = "SELECT email FROM clientes WHERE email = '$emailRevenda'";
		$queryFiltro = mysql_query($sqlFiltro);
		$linhasFiltro = mysql_num_rows($queryFiltro);
        
        $sqlFiltro2 = mysql_query("SELECT documento FROM clientes WHERE documento = '$cnpjRevenda'");
		$linhasFiltro2 = mysql_num_rows($sqlFiltro2);
        
		if($linhasFiltro > 0)
		{
		  ?>
			<script type='text/javascript'>
			$(document).ready(function()
			{
				alert('Email já cadastrado!');
				$('#emailRevenda').focus();
			
			});
			</script>
		  <?php
		}
        elseif($linhasFiltro2 > 0)
		{
		  ?>
			<script type='text/javascript'>
			$(document).ready(function()
			{
				alert('CNPJ já cadastrado!');
				$('#cnpjRevenda').focus();
			
			});
			</script>
		  <?php
		}
        else
        {
            $dataCadastro = date('Y-m-d');
            $tipoRevenda = 1;
            $emailAtivacao = '0';
            $md5 = new md5();
            
            $senhacript = isset($_SESSION['senhacript']) ? $_SESSION['senhacript'] : '';
            $senhaRevenda = isset($_SESSION['senhacript']) ? $md5->decode($_SESSION['senhacript']) : '';
            $ordem = reordenarClientes();
            $cleanTitulo = mg_substituirEspacosPorTreacos($nomeFantasia);
			
            $sql = "INSERT INTO clientes (dataCadastro, tipoAnuncio, codPlanoRevenda, razaoSocialNome, nomeFantasia, cleanTitulo, documento, senha, cep, endereco, numero, bairro, complemento, cidade, estado, telRes, telCel, telCom, email, tipoRevenda, responsavel, site, situacao, emailAtivacao, ordem)
                    VALUES(
                    '{$dataCadastro}', '{$tipoAnuncio}', '{$codPlanoRevenda}', '{$razaoRevenda}', '{$nomeFantasia}', '{$cleanTitulo}', '{$cnpjRevenda}', '{$senhacript}', '{$cepRevenda}', '{$enderecoRevenda}', '{$numeroRevenda}', '{$bairroRevenda}', '$complementoRevenda', '{$cidadeRevenda}', '{$estadoRevenda}', '{$foneRevenda}', '{$celularRevenda}', '{$foneComRevenda}', '{$emailRevenda}', '{$tipoRevenda}', '{$responsavelRevenda}', '{$siteRevenda}', '{$situacao}', '{$emailAtivacao}', '{$ordem}');";
        	$resultado = mysql_query($sql);
            $codRef = mysql_insert_id();
            
			if($foto != '')
            {  
                $foto_temp = $_FILES['file']['tmp_name'];
                $token = rand(1,99999).date('dmYHis');
                $pasta = PROJECT_PATH."arquivos/clientesRevendas";
                $fileG = insere_foto($foto, $foto_temp, $pasta,'115','84');
        		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                        VALUES ('clienteRevenda', '{$codRef}','1', '{$fileG}','$token')";
        		$resultadoG = mysql_query($sqlG);
            }
    	
    		if($resultado)
    		{
                require_once PROJECT_FUNC_PATH . 'cadastroEmail.php';
                
                $nomeRemetente = "Kicarrão";
				$assunto = "Cadastro de Revenda - Kicarrão";
				$conteudoEmail = array(
                    'nome'      => $razaoRevenda,
                    'email'     => $emailRevenda,
                    'senha'     => $senhaRevenda,
                    'tipoAnuncio'     => 2
                );
			
				$emailDestinatario = array('financeiro@kicarrao.com.br','programacao@monge.com.br');//array($emailRevenda,'arturbalestro@hotmail.com','ammbalestro@gmail.com');
                $emailRemetente = 'noreply@kicarrao.com.br';
                $emailResposta  = 'noreply@kicarrao.com.br';
                $twitter = '';
                $facebook = 'kicarrao';
				
				$conf = cadastroEmail($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);            
                
                unset($_SESSION['codTipoVeiculo']);
                unset($_SESSION['plano']);
                unset($_SESSION['cnpjRevenda']);
                unset($_SESSION['emailRevenda']);
                unset($_SESSION['senhacript']);
                
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/login' : sslRedir().PROJECT_URL.'/login.php';
    			echo "<script type='text/javascript'>
    					alert('Revenda cadastrada com sucesso!');
    				  </script>";
                ?> 
                <form name="loginCadastro" id="loginCadastro" action="<?=$link;?>" method="post">
					<input type="hidden" name="emailUsuario" value="<?=$emailRevenda;?>"/>
					<input type="hidden" name="senhaUsuario" value="<?=$senhaRevenda;?>"/>
                    <input type="hidden" name="tipoLogin" value="4" />
				</form>
				<script type="text/javascript">
					$(document).ready(function()
					{
						$("#loginCadastro").submit();
					});
				</script>
				<?php
                die();
    		}
    		else
    		{
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados-revenda' : sslRedir().PROJECT_URL.'/anuncio-dados-revenda.php';		  
    			echo "<script type='text/javascript'>
    				   alert(\"Erro ao cadastrar revenda, tente novamente mais tarde.\");
                       location.replace('".$link."');
    				 </script> \n";
                     die();
    		}
        }
        mysql_close();
    }
}
else
{
    $razaoRevenda = '' ;
    $nomeFantasia = '' ;
    $cnpjRevenda = isset($_SESSION['cnpjRevenda']) ? $_SESSION['cnpjRevenda'] : '';
    $cepRevenda = '' ;
    $enderecoRevenda = '' ;
    $numeroRevenda = '' ;
    $bairroRevenda = '' ;
    $complementoRevenda = '' ;
    $cidadeRevenda = '' ;
    $estadoRevenda = '' ;
    $siteRevenda = '' ;
    $foneRevenda = isset($_SESSION['foneRevenda']) ? $_SESSION['foneRevenda'] : '';
    $foneComRevenda = '';
    $celularRevenda = '' ;
    $emailRevenda = isset($_SESSION['emailRevenda']) ? $_SESSION['emailRevenda'] : '';
    $tipoRevenda = '';
    $codPlanoRevenda = isset($planoRevenda) ? $planoRevenda : '';
    $responsavelRevenda = '' ;
}
?>
    <script type="text/javascript" src="<?=sslRedir().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=sslRedir().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
</head>
<script type="text/javascript">
                
function atualiza(_cep)
{
  _cep = (_cep == null) || (_cep == 'undefined') ? $("#cepRevenda").val() : _cep;
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
			
			$("#enderecoRevenda").val(_endereco[0]).focus();
            $("#bairroRevenda").val(correio.bairro);
            $("#cidadeRevenda").val(correio.cidade);
            $("#estadoRevenda").val(correio.estado);
            $("#cepRevenda").val(correio.cep);
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
    $("#cidadeRevenda").removeAttr("disabled");
    $("#estadoRevenda").removeAttr("disabled");
}
$(document).ready(function()
{
    $("#atualizaCep").click(function(){
        atualiza();
    });    
//<![CDATA[
    $("#celularRevenda")
        .keyup(function()
        {
            
            tel = $(this).val();
            
            //console.log(tel);
            v = tel;
            v += '';
            //console.log(v);
            v = v . replace(/\D/g, ''); //Remove tudo o que não é dígito
            //console.log(v);
            v = v . replace(/^(\d{2})(\d)/g, '($1) $2');
            //console.log(v);
            v = v . replace(/(\d{1})?(\d{4})(\d{4})$/, '$1$2-$3');
            //console.log(v);
            return this.value = v;
            /*
            exp = /^(\(\d{2}\))\s([9]{1})?(\d{4})-(\d{4})$/;
        	if (exp . test(v))
        	{
                
                
            }*/
            
            
        })
        .keypress(function(e)
        {
            return validaTecla(e, 'inteiro');
        })
    $('#foneComRevenda').mask('(99) 9999-9999');
	objValidadorCadastro = new xform('#dadosRevenda',{
	   callbackTrue:function(){
	       enable();
	   }
    });
    
    objValidadorCadastro . adicionar('#nomeRevenda','nome');
	objValidadorCadastro . adicionar('#razaoRevenda');
    objValidadorCadastro . adicionar('#cnpjRevenda');
    $('input#cnpj').mask('99.999.999/9999-99');
    objValidadorCadastro . adicionar('#cepRevenda','cep');
    objValidadorCadastro . adicionar('#estadoRevenda');
    objValidadorCadastro . adicionar('#cidadeRevenda');
    objValidadorCadastro . adicionar('#bairroRevenda');
    objValidadorCadastro . adicionar('#enderecoRevenda');
	objValidadorCadastro . adicionar('#numeroRevenda','inteiro');
    objValidadorCadastro . adicionar('#foneRevenda','fone5');
    //objValidadorCadastro . adicionar('#celularRevenda','fone5');
    //objValidadorCadastro . adicionar('#file');
    objValidadorCadastro . adicionar('#responsavelRevenda');
    objValidadorCadastro . adicionar('#siteRevenda', 'url', true);
    objValidadorCadastro . adicionar('#emailRevenda','email');
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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Dados da Revenda</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <form name="dadosRevenda" id="dadosRevenda" method="post" action="" enctype="multipart/form-data" onsubmit="">
                    <div class="dadosrevenda">
                        <div class="planotitulogeral">Dados da Revenda</div>
                        <?=$msg;?>
                        <div class="inputbloco">
                            <label for="planoRevenda">Plano <span class="obrigatorio">*</span></label>
                            <?
                            $conexao = conexao();
                            $sqlPlanos = mysql_query("SELECT * FROM planosRevenda WHERE cod = '$planoRevenda'");
                            $numPlanos = mysql_num_rows($sqlPlanos);
                            if($numPlanos > 0)
                            {
                                $tpPlanos = mysql_fetch_assoc($sqlPlanos);
                                $sqlTipoVeiculo = mysql_query("SELECT tipoVeiculo FROM tipoVeiculo WHERE cod = '{$tpPlanos['codTipoVeiculo']}'");  
                                $tpTipoVeiculo = mysql_fetch_assoc($sqlTipoVeiculo);                              
                            ?>
                                <span><?=$tpPlanos['plano'];?> - <?=$tpTipoVeiculo['tipoVeiculo'];?></span>
                                <input type="hidden" value="<?=$tpPlanos['plano'];?> - <?=$tpTipoVeiculo['tipoVeiculo'];?>" name="planoRevenda" id="planoRevenda" />
                            <?
                            }
                            mysql_close();
                            ?>
                        </div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="nomeRevenda">Nome Fantasia</label>
                            <input type="text" class="inputgranderevenda" name="nomeRevenda" id="nomeRevenda" title="Nome Fantasia" value="<?=$nomeFantasia;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="razaoRevenda">Razão Social <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="razaoRevenda" id="razaoRevenda" title="Razão Social" value="<?=$razaoRevenda;?>"/>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cnpjRevenda">CNPJ <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="cnpjRevenda" id="cnpjRevenda" title="CNPJ" value="<?=$cnpjRevenda;?>"/>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cepRevenda">CEP <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="cepRevenda" id="cepRevenda" title="CEP" value="<?=$cepRevenda;?>"/>
                            <a class="atualizarCadastro" id="atualizaCep">Buscar</a>
                        </div>
                        
                        <div class="inputbloco">
                            <div class="inputleft">
                                <label for="enderecoRevenda">Endereço <span class="obrigatorio">*</span></label>
                                <input style="width: 185px;" type="text" class="inputpequeno" name="enderecoRevenda" id="enderecoRevenda" title="Endereço" value="<?=$enderecoRevenda;?>" />
                            </div>
                            <div class="inputright">
                                <label for="numeroRevenda" style="width: auto;">N&deg; <span class="obrigatorio">*</span></label>
                                <input type="text" class="inputmenor" name="numeroRevenda" id="numeroRevenda" title="Número" value="<?=$numeroRevenda;?>" />
                            </div>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="complementoRevenda">Complemento </label>
                            <input type="text" class="inputgranderevenda" name="complementoRevenda" id="complementoRevenda" title="Complemento" value="<?=$complementoRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="bairroRevenda">Bairro <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="bairroRevenda" id="bairroRevenda" title="Bairro" value="<?=$bairroRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cidadeRevenda">Cidade <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="cidadeRevenda" id="cidadeRevenda" title="Cidade" value="<?=$cidadeRevenda;?>"  disabled="disabled" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="estadoRevenda">Estado <span class="obrigatorio">*</span></label>
                            <select class="selectgranderevenda" name="estadoRevenda" id="estadoRevenda" title="Estado" disabled="disabled">
                                <option value="">-</option>
                                <option value="AC" <?=$estadoRevenda == 'AC' ? 'selected="selected"' : '';?>>AC</option>
                                <option value="AL" <?=$estadoRevenda == 'AL' ? 'selected="selected"' : '';?>>AL</option>
                                <option value="AM" <?=$estadoRevenda == 'AM' ? 'selected="selected"' : '';?>>AM</option>
                                <option value="AP" <?=$estadoRevenda == 'AP' ? 'selected="selected"' : '';?>>AP</option>
                                <option value="BA" <?=$estadoRevenda == 'BA' ? 'selected="selected"' : '';?>>BA</option>
                                <option value="CE" <?=$estadoRevenda == 'CE' ? 'selected="selected"' : '';?>>CE</option>
                                <option value="DF" <?=$estadoRevenda == 'DF' ? 'selected="selected"' : '';?>>DF</option>
                                <option value="ES" <?=$estadoRevenda == 'ES' ? 'selected="selected"' : '';?>>ES</option>
                                <option value="GO" <?=$estadoRevenda == 'GO' ? 'selected="selected"' : '';?>>GO</option>
                                <option value="MA" <?=$estadoRevenda == 'MA' ? 'selected="selected"' : '';?>>MA</option>
                                <option value="MT" <?=$estadoRevenda == 'MT' ? 'selected="selected"' : '';?>>MT</option>
                                <option value="MS" <?=$estadoRevenda == 'MS' ? 'selected="selected"' : '';?>>MS</option>
                                <option value="MG" <?=$estadoRevenda == 'MG' ? 'selected="selected"' : '';?>>MG</option>
                                <option value="PA" <?=$estadoRevenda == 'PA' ? 'selected="selected"' : '';?>>PA</option>
                                <option value="PB" <?=$estadoRevenda == 'PB' ? 'selected="selected"' : '';?>>PB</option>
                                <option value="PR" <?=$estadoRevenda == 'PR' ? 'selected="selected"' : '';?>>PR</option>
                                <option value="PE" <?=$estadoRevenda == 'PE' ? 'selected="selected"' : '';?>>PE</option>
                                <option value="PI" <?=$estadoRevenda == 'PI' ? 'selected="selected"' : '';?>>PI</option>
                                <option value="RJ" <?=$estadoRevenda == 'RJ' ? 'selected="selected"' : '';?>>RJ</option>
                                <option value="RN" <?=$estadoRevenda == 'RN' ? 'selected="selected"' : '';?>>RN</option>
                                <option value="RO" <?=$estadoRevenda == 'RO' ? 'selected="selected"' : '';?>>RO</option>
                                <option value="RS" <?=$estadoRevenda == 'RS' ? 'selected="selected"' : '';?>>RS</option>
                                <option value="RR" <?=$estadoRevenda == 'RR' ? 'selected="selected"' : '';?>>RR</option>
                                <option value="SC" <?=$estadoRevenda == 'SC' ? 'selected="selected"' : '';?>>SC</option>
                                <option value="SE" <?=$estadoRevenda == 'SE' ? 'selected="selected"' : '';?>>SE</option>
                                <option value="SP" <?=$estadoRevenda == 'SP' ? 'selected="selected"' : '';?>>SP</option>
                                <option value="TO" <?=$estadoRevenda == 'TO' ? 'selected="selected"' : '';?>>TO</option>
                            </select>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="foneRevenda">Telefone 1<span class="obrigatorio">*</span></label>
                            <input style="width: 185px;" type="text" class="inputpequeno" name="foneRevenda" id="foneRevenda" title="Telefone 1" value="<?=$foneRevenda;?>" />
                        </div>
                        <div class="inputbloco">
                            <label for="celularRevenda">Telefone 2</label>
                            <input style="width: 185px;" type="text" class="inputpequeno" name="foneComRevenda" id="foneComRevenda" title="Telefone 2" value="<?=$foneComRevenda;?>" />
                        </div>
                        <div class="inputbloco">
                            <label for="celularRevenda">Telefone Cel.</label>
                            <input style="width: 185px;" type="text" class="inputpequeno" maxlength="15" name="celularRevenda" id="celularRevenda" title="Telefone Cel." value="<?=$celularRevenda;?>" />
                        </div>
                        <div class="inputbloco">
                            <label class="composto" for="marcaRevenda">Marca da Empresa</label>
                            <input type="file" name="file" id="file" title="Marca da Empresa" /><br />
                            <label for="marcaRevenda">&nbsp;</label>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="responsavelRevenda">Responsável <span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="responsavelRevenda" id="responsavelRevenda" title="Responsável" value="<?=$responsavelRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="emailRevenda">E-mail<span class="obrigatorio">*</span></label>
                            <input type="text" class="inputgranderevenda" name="emailRevenda" id="emailRevenda" title="E-mail" value="<?=$emailRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label style="float:left;" for="siteRevenda">Site</label>
                            <input style="float:left; clear:none;" type="text" class="inputgranderevenda" name="siteRevenda" id="siteRevenda" title="Site" value="<?=$siteRevenda;?>" />
                            <div class="revendaenviar">
                                <input type="submit" name="enviarDadosRevenda" id="enviarDadosRevenda" title="Enviar" value="Enviar" />
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