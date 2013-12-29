<?php
if(!verifica_permissao($cod_user, $nivel_user, 'clientes'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."clientes_topo.php";
require_once ADMIN_FUNC_PATH.'fotos.php';
require_once ADMIN_FUNC_PATH."formatting.php";
$submit = isset($_POST['submit']) ? $_POST['submit'] : '' ;
$msg = "";
$md5 = new md5();
if($submit != '')
{    
    $tipoAnuncio = isset($_POST['tipoAnuncio'])? escape($_POST['tipoAnuncio']) : '' ;
	$nomeFantasia = isset($_POST['nomeFantasia'])? escape($_POST['nomeFantasia']) : '' ;
    $cleanTitulo = isset($_POST['cleanTitulo'])? escape($_POST['cleanTitulo']) : '' ;
    $razaoSocialNome = isset($_POST['razaoSocialNome'])? escape($_POST['razaoSocialNome']) : '' ;
    $sobrenome = isset($_POST['sobrenome'])? escape($_POST['sobrenome']) : '' ;
    $documento = isset($_POST['documento'])? escape($_POST['documento']) : '' ;
    $cep = isset($_POST['cep'])? escape($_POST['cep']) : '' ;
    $endereco = isset($_POST['endereco'])? escape($_POST['endereco']) : '' ;
    $numero = isset($_POST['numero'])? escape($_POST['numero']) : '' ;
    $complemento = isset($_POST['complemento'])? escape($_POST['complemento']) : '' ;
    $bairro = isset($_POST['bairro'])? escape($_POST['bairro']) : '' ;
    $cidade = isset($_POST['cidade'])? escape($_POST['cidade']) : '' ;
    $estado = isset($_POST['estado'])? escape($_POST['estado']) : '' ;
    $pais = isset($_POST['pais'])? escape($_POST['pais']) : '' ;
    $site = isset($_POST['site'])? escape($_POST['site']) : '' ;
    $telRes = isset($_POST['telRes'])? escape($_POST['telRes']) : '' ;
    $telCel = isset($_POST['telCel'])? escape($_POST['telCel']) : '' ;
    $telCom = isset($_POST['telCom'])? escape($_POST['telCom']) : '' ;
    $email = isset($_POST['email'])? escape($_POST['email']) : '' ;
    $senha = isset($_POST['senha'])? escape($_POST['senha']) : '' ;
    $senhacript = $md5->code($senha); 
    $tipoRevenda = isset($_POST['tipoRevenda'])? escape($_POST['tipoRevenda']) : '';
    $codPlanoRevenda = isset($_POST['codPlanoRevenda'])? $_POST['codPlanoRevenda'] : '';
    $responsavel = isset($_POST['responsavel'])? escape($_POST['responsavel']) : '' ;
    $situacao = isset($_POST['situacao'])? escape($_POST['situacao']) : 0 ;
    $emailAtivacaoAux = isset($_POST['emailAtivacao'])? escape($_POST['emailAtivacao']) : 0 ;
	$foto = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $fotoBanner = isset($_FILES['fileBanner']['name']) ? $_FILES['fileBanner']['name'] : '';
    
    $erro = 0;
    
    $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
    if (!validaCampo($tipoAnuncio))
    {
        $msg .= '<li>O campo Tipo de Anúncio deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($razaoSocialNome))
    {
        $msg .= '<li>O campo Razão Social / Nome deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($telRes))
    {
        $msg .= '<li>O campo Telefone 1 deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($documento))
    {
        $msg .= '<li>O campo Documento deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($email))
    {
        $msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if (!validaCampo($senha))
    {
        $msg .= '<li>O campo Senha deve ser preenchido corretamente!</li>';
        $erro = 1;   
    }
    if($tipoAnuncio == '2')
    {
        if (!validaCampo($nomeFantasia))
        {
            $msg .= '<li>O campo Nome Fantasia deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        
        if (!validaCampo($cleanTitulo))
        {
            $msg .= '<li>O campo Url Revenda deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($tipoRevenda))
        {
            $msg .= '<li>O campo Tipo de Revenda deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        
        if (!validaCampo($codPlanoRevenda))
        {
            $msg .= '<li>O campo Plano da Revenda deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
    }
    else
    {
        if (!validaCampo($sobrenome))
        {
            $msg .= '<li>O campo Sobrenome deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        $tipoRevenda = 0;
        $codPlanoRevenda = 0;
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
    if($fotoBanner != '')
    {
        $formato = $_FILES['fileBanner']['name'];
        $formato = strrev($formato);
        $formato = explode('.',$formato);
        $formato = $formato[0];
        $formato = strrev($formato);
    	$formato = strtolower($formato);
        $extensoesvalidas = array("jpg","jpeg","png");
        if(!in_array($formato,$extensoesvalidas))
    	{
    		$msg .= '<li>Formato de imagem do Banner inválido!</li>';
    		$erro = 1;
        }
    }
    $msg .= '</ul>';
    
    if($erro == 0)
    {
        $sqlFiltro = "SELECT email FROM clientes WHERE email = '$email' AND cod != '$cod'";
		$queryFiltro = mysql_query($sqlFiltro);
		$linhasFiltro = mysql_num_rows($queryFiltro);
        
        $sqlFiltro2 = mysql_query("SELECT documento FROM clientes WHERE documento = '$documento' AND cod != '$cod'");
		$linhasFiltro2 = mysql_num_rows($sqlFiltro2);
		if($linhasFiltro > 0)
		{
		  ?>
			<script type='text/javascript'>
			$(document).ready(function()
			{
				alert('Email já cadastrado!');
				$('#email').focus();
			
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
				alert('Documento já cadastrado!');
				$('#documento').focus();
			
			});
			</script>
		  <?php
		}
		else
		{
            $dataAlteracao = date('Y-m-d');
            if($situacao == '1' && $emailAtivacaoAux == '0')
            {
                $emailAtivacao = '1';
                //Envia o email
            }
            else
            {
                $emailAtivacao = isset($_POST['emailAtivacao'])? escape($_POST['emailAtivacao']) : 0 ;
            }
            $cleanTitulo = mg_substituirEspacosPorTreacos($cleanTitulo);
            $sql = "UPDATE clientes SET
                    dataAlteracao = '{$dataAlteracao}',
                    tipoAnuncio = '{$tipoAnuncio}',
    				nomeFantasia = '{$nomeFantasia}',
                    cleanTitulo = '{$cleanTitulo}',
                    razaoSocialNome = '{$razaoSocialNome}',
                    sobrenome = '{$sobrenome}',
                    documento = '{$documento}',
                    cep = '{$cep}',
                    endereco = '{$endereco}',
                    numero = '{$numero}',
                    complemento = '{$complemento}',
                    bairro = '{$bairro}',
                    cidade = '{$cidade}',
                    estado = '{$estado}',
                    pais = '{$pais}',
                    telRes = '{$telRes}',
                    telCel = '{$telCel}',
                    telCom = '{$telCom}',
                    email = '{$email}',
                    senha = '{$senhacript}',
                    tipoRevenda = '{$tipoRevenda}',
                    codPlanoRevenda = '{$codPlanoRevenda}',
                    responsavel = '{$responsavel}',
                    site = '{$site}',
                    situacao = '{$situacao}',
                    emailAtivacao = '{$emailAtivacao}'
                    WHERE cod = {$cod}";
        	$resultado = mysql_query($sql);
            
    		if ($foto != "")
            {
                $foto_temp = $_FILES['file']['tmp_name'];
                $exclusoes = isset($_POST['codigo']) ? $_POST['codigo'] : '' ;
                $objsArquivo = mysql_query("SELECT * FROM arquivos WHERE codigo='$exclusoes' AND referencia = 'clienteRevenda'");
                $qtdObjsArquivo = mysql_num_rows($objsArquivo) ;
                $pasta = PROJECT_PATH."arquivos/clientesRevendas";
                
                if($qtdObjsArquivo > 0)
                {
                    for ($j = 0; $j < $qtdObjsArquivo; $j++)
                    {
                        $exc = mysql_fetch_assoc($objsArquivo);
                        unlink($pasta.DIRECTORY_SEPARATOR.$exc['arquivo']);
                    }
                    $fileG = insere_foto($foto, $foto_temp, $pasta,'115','86');
        			$sqlG = "UPDATE arquivos SET
                            arquivo = '{$fileG}'
                            WHERE codigo='$exclusoes' AND referencia = 'clienteRevenda'";
        			for($a=0;$a<5;$a++)
                    {
                        $resultadoG = mysql_query($sqlG);
                        if($resultadoG)
                        {
                            break;
                        }
                    }
                }
                else
                {
                    $token = rand(1,99999).date('dmYHis');
                    $pasta = PROJECT_PATH."arquivos/clientesRevendas";;
                    $fileG = insere_foto($foto, $foto_temp, $pasta,'115','86');
            		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                            VALUES ('clienteRevenda', '{$cod}','1', '{$fileG}','$token')";
            		for($a=0;$a<5;$a++)
                    {
                        $resultadoG = mysql_query($sqlG);
                        if($resultadoG)
                        {
                            break;
                        }
                    }
                }
    		}
    		if ($fotoBanner != "")
            {
                $foto_tempBanner = $_FILES['fileBanner']['tmp_name'];
                $exclusoesBanner = isset($_POST['codigoBanner']) ? $_POST['codigoBanner'] : '' ;
                $objsArquivoBanner = mysql_query("SELECT * FROM arquivos WHERE codigo='$exclusoesBanner' AND referencia = 'bannerRevenda'");
                $qtdObjsArquivoBanner = mysql_num_rows($objsArquivoBanner) ;
                $pasta = PROJECT_PATH."arquivos/clientesRevendas";
                
                if($qtdObjsArquivoBanner > 0)
                {
                    for ($j = 0; $j < $qtdObjsArquivoBanner; $j++)
                    {
                        $exc = mysql_fetch_assoc($objsArquivoBanner);
                        unlink($pasta.DIRECTORY_SEPARATOR.$exc['arquivo']);
                    }
                    $fileG = insere_foto($fotoBanner, $foto_tempBanner, $pasta,'667','267');
        			$sqlG = "UPDATE arquivos SET
                            arquivo = '{$fileG}'
                            WHERE codigo='$exclusoesBanner' AND referencia = 'bannerRevenda'";
        			for($a=0;$a<5;$a++)
                    {
                        $resultadoG = mysql_query($sqlG);
                        if($resultadoG)
                        {
                            break;
                        }
                    }
                }
                else
                {
                    $token = rand(1,99999).date('dmYHis');
                    $pasta = PROJECT_PATH."arquivos/clientesRevendas";;
                    $fileG = insere_foto($fotoBanner, $foto_tempBanner, $pasta,'667','267');
            		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                            VALUES ('bannerRevenda', '{$cod}','1', '{$fileG}','$token')";
            		for($a=0;$a<5;$a++)
                    {
                        $resultadoG = mysql_query($sqlG);
                        if($resultadoG)
                        {
                            break;
                        }
                    }
                }
    		}
    		if($resultado)
            {
                echo " <script>";
        		echo " alert(\"Cadastro realizado com sucesso!\");\n";
        		if(isset($_GET['redir']) && $_GET['redir'] == "pagamentos")
                {
                    echo " location.replace('http://".ADMIN_URL."/principal.php?id=15&subid=1'); \n";
                }
                else
                {
                    echo " location.replace('http://".ADMIN_URL."/principal.php?id=6&subid=1&tipoAnuncio=$tipoAnuncio'); \n";
                }
        		echo " </script>";
                die();
        	}
            else
        	{
                echo " <script>";
        		echo " alert(\"Erro ao cadastrar!\");\n";
        		echo " location.replace('http://".ADMIN_URL."/principal.php?id=6&subid=2&tipoAnuncio=$tipoAnuncio'); \n";
        		echo " </script>";
                die();
        	}
        }
    }
}
else
{        
    $sqlClientes = mysql_query("SELECT * FROM clientes WHERE cod = '$cod'");
    $tpClientes = mysql_fetch_assoc($sqlClientes);
    $tipoAnuncio = $tpClientes['tipoAnuncio'];
	$nomeFantasia = $tpClientes['nomeFantasia'];
    $cleanTitulo = $tpClientes['cleanTitulo'];
    $razaoSocialNome = $tpClientes['razaoSocialNome'];
    $sobrenome = $tpClientes['sobrenome'];
    $documento = $tpClientes['documento'];
    $cep = $tpClientes['cep'];
    $endereco = $tpClientes['endereco'];
    $numero = $tpClientes['numero'];
    $complemento = $tpClientes['complemento'];
    $bairro = $tpClientes['bairro'];
    $cidade = $tpClientes['cidade'];
    $estado = $tpClientes['estado'];
    $pais = $tpClientes['pais'];
    
    $site = $tpClientes['site'];
    $telRes = $tpClientes['telRes'];
    $telCel = $tpClientes['telCel'];
    $telCom= $tpClientes['telCom'];
    $email = $tpClientes['email'];
    $senhacript = $tpClientes['senha'];
    $senha = $md5->decode($senhacript);
    $tipoRevenda = $tpClientes['tipoRevenda'];
    $codPlanoRevenda = $tpClientes['codPlanoRevenda'];
    $responsavel = $tpClientes['responsavel'];
    $situacao = $tpClientes['situacao'];
    $emailAtivacao = $tpClientes['emailAtivacao'];
}
?>

<script type="text/javascript">
function atualiza()
{
  _cep = $("#cep").val();
  //Requisição Ajax
  $.ajax(
  {
     type: "GET",
     url: "http://<?=PROJECT_URL;?>/ajaxCep.php", //URL de destino
     data:{ cep: _cep },
     dataType: "json", //Tipo de Retorno
     success: function(correio)
     { //Se ocorrer tudo certo
        if(correio.erro == "0")
        {
            _end = correio.logradouro;
			_endereco = _end.split(" - ");
			
			$("#endereco").val(_endereco[0]).focus();
            $("#cidade").val(correio.cidade);
            $("#estado").val(correio.estado);
            $("#cep").val(correio.cep);
        }
        else
        {
            alert(correio.erro);
        }   
     }     
  });
}
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
    
    $("#gerarUrlRevenda").click(function(){
        _valor = $("#nomeFantasia").val();
        if(_valor != '')
        {
            $.ajax(
              {
                 type: "POST",
                 url: "http://<?=PROJECT_URL;?>/adm/ajax/ajaxGeraUrlRevenda.php", //URL de destino
                 data:{ valor: _valor },
                 dataType: "json", //Tipo de Retorno
                 success: function(j)
                 { //Se ocorrer tudo certo
                    $("#cleanTitulo").val(j[0].valor); 
                 }     
              });
        }
        else
        {
            alert("Digite o Nome Fantasia primeiro.");
        }
    })
    $("input#cep").blur(function(){
        atualiza();
    });
    
    objValidador = new xform('form#cadastro');
    objValidador.adicionar('select#tipoAnuncio');
    objValidador.adicionar('input#razaoSocialNome');
    objValidador.adicionar('input#senha');
    
    objValidador.adicionar('input#site','url',true);
    objValidador.adicionar('input#email','email');
    objValidador.adicionar('input#cep','cep',true);
    objValidador.adicionar('input#telRes','fone5');
    
    $('select#tipoAnuncio').change(function()
    { 
		$('input#documento').unmask();
        _val = $(this).val();
		if (_val == '1')
        {
            $(".sobrenome").show(500);
            $(".tipoRevenda").hide(500);
			$(".nomeFantasia").hide(500);
            objValidador . remover('input#cleanTitulo');
			objValidador . remover('input#nomeFantasia');
			objValidador . remover('select#tipoRevenda');
            objValidador . remover('select#codPlanoRevenda');
            objValidador . adicionar('input#sobrenome');
            $('input#documento').removeAttr('disabled');
            $('input#documento').mask('999.999.999-99');	
		}
		else if (_val == '2')
        {
            $(".tipoRevenda").show(500);
			$(".nomeFantasia").show(500);
            $(".sobrenome").hide(500);
            objValidador . adicionar('input#cleanTitulo');
			objValidador . adicionar('input#nomeFantasia');
            objValidador . adicionar('select#tipoRevenda');
            objValidador . adicionar('select#codPlanoRevenda');
            objValidador . remover('input#sobrenome');
            $('input#documento').removeAttr('disabled');
    		$('input#documento').mask('99.999.999/9999-99');
		}
        else
        {
            $(".tipoRevenda").hide(500);
			$(".nomeFantasia").hide(500);
            $(".sobrenome").hide(500);
            objValidador . remover('input#cleanTitulo');
			objValidador . remover('input#nomeFantasia');
            objValidador . remover('select#tipoRevenda');
            objValidador . remover('select#codPlanoRevenda');
            objValidador . remover('input#sobrenome');
            $('input#documento').attr('disabled','true');
        }
    });
    
    if ($('select#tipoAnuncio').val() == '' || $('select#tipoAnuncio').val() == null || $('select#tipoAnuncio').val() == undefined)
    {
    	$('input#documento').attr('disabled','true');	
    }
    
    if($('select#tipoAnuncio').val() == '2')
    {
        $(".tipoRevenda").show(500);
		$(".nomeFantasia").show(500);
        $(".sobrenome").hide(500);
        objValidador . remover('input#sobrenome');
        objValidador . adicionar('input#cleanTitulo');
		objValidador . adicionar('input#nomeFantasia');
        objValidador . adicionar('select#tipoRevenda');
        objValidador . adicionar('select#codPlanoRevenda');
    }
    else
    {
        $(".tipoRevenda").hide(500);
		$(".nomeFantasia").hide(500);
        $(".sobrenome").show(500);
        objValidador . remover('input#cleanTitulo');
		objValidador . remover('input#nomeFantasia');
        objValidador . adicionar('input#sobrenome');
        objValidador . remover('select#tipoRevenda');
        objValidador . remover('select#codPlanoRevenda');
    }
    
    $('input#telCom').mask('(99) 9999-9999');
    $('input#telCel').mask('(99) 9999-9999');
});
</script>
	
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Editando Cliente - <?=remEscape($razaoSocialNome);?></legend>
        <div><?=$msg;?></div>
        <input type="hidden" name="emailAtivacao" id="emailAtivacao" value="<?=$emailAtivacao;?>" />
        <div>
            <label for="tipoAnuncio"><span class="obrigatorio">*</span> Tipo de anúncio: </label>
            <select name="tipoAnuncio" id="tipoAnuncio" title="Tipo de anúncio">
                <option value="" <?=$tipoAnuncio == '' || $tipoAnuncio == '0' ? 'selected="selected"' : '';?>>Selecione</option>
                <option value="1" <?=$tipoAnuncio == '1' ? 'selected="selected"' : '';?>>Particular</option>
                <option value="2" <?=$tipoAnuncio == '2' ? 'selected="selected"' : '';?>>Revenda</option>
            </select>
        </div>
        <div style="display:none;" class="nomeFantasia">
            <div>
                <label for="nomeFantasia"><span class="obrigatorio">*</span> Nome Fantasia:</label>
                <input type="text" name="nomeFantasia" id="nomeFantasia" title="Nome Fantasia" value="<?=remEscape($nomeFantasia);?>" />
                &nbsp;&nbsp;<a class="botaoDourado" id="gerarUrlRevenda">&nbsp;Gerar Url Revenda&nbsp;</a>
            </div>
            <div>
                <label for="cleanTitulo"><span class="obrigatorio">*</span> Url Revenda:</label>
                <input type="text" name="cleanTitulo" id="cleanTitulo" title="Url Revenda" value="<?=remEscape($cleanTitulo);?>" />
            </div>
        </div>
        <div>
            <label for="razaoSocialNome"><span class="obrigatorio">*</span> Razão Social / Nome: </label>
            <input type="text" name="razaoSocialNome" id="razaoSocialNome" title="Razao Social / Nome" value="<?=remEscape($razaoSocialNome);?>" />
        </div>
        <div style="display:none;" class="sobrenome">
            <label for="sobrenome"><span class="obrigatorio">*</span> Sobrenome: </label>
            <input type="text" name="sobrenome" id="sobrenome" title="Sobrenome" value="<?=remEscape($sobrenome);?>" />
        </div>
        <div>
            <label for="documento"><span class="obrigatorio">*</span> Documento: </label><input type="text" name="documento" id="documento" title="Documento" value="<?=remEscape($documento);?>" />
        </div>
        <div>
            <label for="cep">CEP: </label>
            <input type="text" name="cep" id="cep" title="CEP" value="<?=$cep;?>" />
        </div>
        <div>
            <label for="estado">Estado: </label>
            <input type="text" name="estado" id="estado" title="Estado" value="<?=$estado;?>" />
        </div>
        <div>
            <label for="cidade">Cidade: </label>
            <input type="text" name="cidade" id="cidade" title="Cidade" value="<?=$cidade;?>" />
        </div>
        <div>
            <label for="bairro">Bairro: </label>
            <input type="text" name="bairro" id="bairro" title="Bairro" value="<?=$bairro;?>" />
        </div>
        <div>
            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco" id="endereco" title="Endereço" value="<?=$endereco;?>" />
        </div>
        <div>
            <label for="numero">Número: </label>
            <input type="text" name="numero" id="numero" title="Número" value="<?=$numero;?>" />
        </div>
        <div>
            <label for="complemento">Complemento: </label>
            <input type="text" name="complemento" id="complemento" title="Complemento" value="<?=$complemento;?>" />
        </div>
        <div>
            <label for="telRes"><span class="obrigatorio">*</span> Telefone 1: </label>
            <input type="text" name="telRes" id="telRes" title="Telefone 1" value="<?=$telRes;?>" />&nbsp;Divulgado
        </div>
        <div>
            <label for="telCel">Telefone 2: </label>
            <input type="text" name="telCel" id="telCel" title="Telefone 2" value="<?=$telCel;?>" />&nbsp;Divulgado
        </div>
        <div>
            <label for="telCom">Telefone 3: </label>
            <input type="text" name="telCom" id="telCom" title="Telefone 3" value="<?=$telCom;?>" />&nbsp;Não divulgado
        </div>
        
        <div>
            <label for="email"><span class="obrigatorio">*</span> E-mail: </label>
            <input type="text" name="email" id="email" title="E-mail" value="<?=$email;?>" />
        </div>
        <div>
            <label for="senha"><span class="obrigatorio">*</span> Senha: </label>
            <input type="password" name="senha" id="senha" title="Senha" value="<?=$senha;?>" />
        </div>
        <div style="display:none;" class="tipoRevenda">
            <div>
                <label for="tipoRevenda"><span class="obrigatorio">*</span> Tipo de revenda: </label>
                <select name="tipoRevenda" id="tipoRevenda" title="Tipo de revenda">
                    <option value="" <?=$tipoRevenda == '' || $tipoRevenda == '0' ? 'selected="selected"' : '';?>>Selecione</option>
                    <option value="1" <?=$tipoRevenda == '1' ? 'selected="selected"' : '';?>>Normal</option>
                    <option value="2" <?=$tipoRevenda == '2' ? 'selected="selected"' : '';?>>Auto Gestor</option>
                </select>
            </div>
            <div>
                <label for="codPlanoRevenda">Plano da revenda: </label>
                <select name="codPlanoRevenda" id="codPlanoRevenda" title="Plano da revenda">
                    <option value="">Selecione</option>
                    <?php
                    	$sqlPlanoRev = mysql_query("SELECT * FROM planosRevenda ORDER BY cod DESC");
                        $numPlanoRev = mysql_num_rows($sqlPlanoRev);
                        for($x = 0;$x < $numPlanoRev;$x++)
                        {
                            $tpPlanoRev = mysql_fetch_assoc($sqlPlanoRev);
                            $sqlTipoVeiculo = mysql_query("SELECT tipoVeiculo FROM tipoVeiculo WHERE cod = '{$tpPlanoRev['codTipoVeiculo']}'");  
                            $tpTipoVeiculo = mysql_fetch_assoc($sqlTipoVeiculo);
                    ?>
                            <option value="<?=$tpPlanoRev['cod'];?>" <?=$tpPlanoRev['cod'] == $codPlanoRevenda ? "selected = 'selected'" : "";?>><?=$tpPlanoRev['plano'];?> - <?=$tpTipoVeiculo['tipoVeiculo'];?></option>
                    <?php
                    	}
                    ?>
                </select>
            </div>
            <div>
                <label for="responsavel">Responsável: </label>
                <input type="text" name="responsavel" id="responsavel" title="Responsável" value="<?=$responsavel;?>" />
            </div>
            <div>
                <label for="site">Site: </label>
                <input type="text" name="site" id="site" title="Site" value="<?=$site;?>" />
            </div>
            <?
			$qFotos = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$cod' AND tipo = '1' AND referencia = 'clienteRevenda' ORDER BY cod ASC");
			$numFotos = mysql_num_rows($qFotos);
			if($numFotos > 0)
			{
				$tpFotos = mysql_fetch_assoc($qFotos);
			?>
				<div class="contentEditor">
					<label>Logo da Empresa Atual: </label>
					<img src="http://<?=PROJECT_URL.'/arquivos/clientesRevendas/'.remEscape($tpFotos['arquivo']);?>" title="<?=remEscape($tpFotos['legenda']);?>" />
					<input type="hidden" name="codigo" value="<?=$tpFotos['codigo'];?>" />
				</div>
			<?
			}
			?>
			<div>
				<label for="imagem">Logo da Empresa: </label><input type="file" name="file" id="file" title="Foto" />
			</div>
            <?
			$qFotosBanner = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$cod' AND tipo = '1' AND referencia = 'bannerRevenda' ORDER BY cod ASC");
			$numFotosBanner = mysql_num_rows($qFotosBanner);
			if($numFotosBanner > 0)
			{
				$tpFotosBanner = mysql_fetch_assoc($qFotosBanner);
			?>
				<div class="contentEditor">
					<label>Banner Atual: </label>
					<img src="http://<?=PROJECT_URL.'/arquivos/clientesRevendas/'.remEscape($tpFotosBanner['arquivo']);?>" title="<?=remEscape($tpFotosBanner['legenda']);?>" />
					<input type="hidden" name="codigoBanner" value="<?=$tpFotosBanner['codigo'];?>" />
				</div>
			<?
			}
			?>
            <div>
				<label for="imagem">Banner: </label><input type="file" name="fileBanner" id="fileBanner" title="Banner" />
			</div>
			
        </div>
        <div>
            <label for="situacao">Situação: </label>
            <input type="radio" name="situacao" id="situacao" value="1" title="Ativo" <?=$situacao == '1' ? 'checked="checked"' : '';?> /> Ativo
            <input type="radio" name="situacao" id="situacao" value="0" title="Inativo" <?=$situacao == '0' ? 'checked="checked"' : '';?> /> Inativo
        </div>
        <div class="contentButton">
            <input class="botaoDourado" type="submit" name="submit" value="Enviar"/>
        </div>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>