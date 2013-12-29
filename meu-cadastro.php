<?php require_once 'configRoot.php';
if($restrita != '1')
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    printf("<script type='text/javascript'>
                document . location . replace('%s');
            </script>", $link);
    exit();
}
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : '';
$tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    <?php require_once PROJECT_FUNC_PATH.'enviarEmail.php';
          require_once ADMIN_FUNC_PATH . 'verifica.php';
          require_once ADMIN_FUNC_PATH . 'validaCampo.php';
          require_once ADMIN_FUNC_PATH.'fotos.php';
          require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
</head>
<?
$submitRevenda = isset($_POST['enviarDadosRevenda']) ? $_POST['enviarDadosRevenda'] : '';
$submitParticular = isset($_POST['enviarDadosParticular']) ? $_POST['enviarDadosParticular'] : '';
$md5 = new md5();
$msg = '';
if($submitRevenda != '' || $submitParticular != '')
{
    $conexao = conexao();
    if($tipoAnuncio == '1')
    {
        $nomeParticular = isset($_POST['nomeParticular'])? $_POST['nomeParticular'] : '' ;
        $sobrenome = isset($_POST['sobrenome'])? $_POST['sobrenome'] : '' ;
        $cpfParticular = isset($_POST['cpfParticular'])? $_POST['cpfParticular'] : '' ;
        $cepParticular = isset($_POST['cepParticular'])? $_POST['cepParticular'] : '' ;
        $enderecoParticular = isset($_POST['enderecoParticular'])? $_POST['enderecoParticular'] : '' ;
        $numeroParticular = isset($_POST['numeroParticular'])? $_POST['numeroParticular'] : '' ;
        $complementoParticular = isset($_POST['complementoParticular'])? $_POST['complementoParticular'] : '' ;
        $bairroParticular = isset($_POST['bairroParticular'])? $_POST['bairroParticular'] : '' ;
        $cidadeParticular = isset($_POST['cidadeParticular'])? $_POST['cidadeParticular'] : '' ;
        $estadoParticular = isset($_POST['estadoParticular'])? $_POST['estadoParticular'] : '' ;
        $foneParticular = isset($_POST['foneParticular'])? $_POST['foneParticular'] : '' ;
        $celularParticular = isset($_POST['celularParticular'])? $_POST['celularParticular'] : '' ;
        $emailParticular = isset($_POST['emailParticular'])? $_POST['emailParticular'] : '' ;
        $senhaParticular = isset($_POST['senhaParticular'])? $_POST['senhaParticular'] : '' ;
        $confirmacaoSenhaParticular = isset($_POST['confirmacaoSenhaParticular'])? $_POST['confirmacaoSenhaParticular'] : '' ;
        $senhaCript = isset($_POST['senhaParticular'])? $md5->code($_POST['senhaParticular']) : '' ;
        
        $erro = 0;
        $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
        if (!validaCampo($nomeParticular))
        {
            $msg .= '<li>O campo Nome deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }  
        if (!validaCampo($sobrenome))
        {
            $msg .= '<li>O campo Sobrenome deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }        
        if (!validaCampo($emailParticular))
        {
            $msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($senhaParticular))
        {
            $msg .= '<li>O campo Senha deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($confirmacaoSenhaParticular))
        {
            $msg .= '<li>O campo Confirmação de Senha deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if ($confirmacaoSenhaParticular != $senhaParticular)
        {
            $msg .= '<li>O campo Confirmação de Senha deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($estadoParticular))
        {
            $msg .= '<li>O campo Estado deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($cidadeParticular))
        {
            $msg .= '<li>O campo Cidade deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($cepParticular))
        {
            $msg .= '<li>O campo CEP deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($enderecoParticular))
        {
            $msg .= '<li>O campo Endereço deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($bairroParticular))
        {
            $msg .= '<li>O campo Bairro deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        $msg .= '</ul>';
        
        if($erro == '0')
        {
            $dataAlteracao = date("Y-m-d");
            $sql = "UPDATE clientes SET
                dataAlteracao = '{$dataAlteracao}',
                razaoSocialNome = '{$nomeParticular}',
                sobrenome = '{$sobrenome}',
                documento = '{$cpfParticular}',
                cep = '{$cepParticular}',
                endereco = '{$enderecoParticular}',
                numero = '{$numeroParticular}',
                complemento = '{$complementoParticular}',
                bairro = '{$bairroParticular}',
                cidade = '{$cidadeParticular}',
                estado = '{$estadoParticular}',
                telRes = '{$foneParticular}',
                telCel = '{$celularParticular}',
                email = '{$emailParticular}',
                senha = '{$senhaCript}'
                WHERE cod = {$codCliente}";
        	$resultado = mysql_query($sql);
            echo mysql_error();
            if($resultado)
            {
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    			echo "<script type='text/javascript'>
    					alert('Cadastro atualizado com sucesso!');
    					location.replace('".$link."');
    				  </script>";
                      die(); 
        	}
            else
        	{
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    			echo "<script type='text/javascript'>
    					alert('Erro ao atualizar cadastro!');
    					location.replace('".$link."');
    				  </script>";
                      die(); 
        	}
        }
    }
    else
    {
        $razaoRevenda = isset($_POST['razaoRevenda'])? $_POST['razaoRevenda'] : '' ;
        $nomeRevenda = isset($_POST['nomeRevenda'])? $_POST['nomeRevenda'] : '' ;
        $cnpjRevenda = isset($_POST['cnpjRevenda'])? $_POST['cnpjRevenda'] : '' ;
        $foto = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
        $cepRevenda = isset($_POST['cepRevenda'])? $_POST['cepRevenda'] : '' ;
        $enderecoRevenda = isset($_POST['enderecoRevenda'])? $_POST['enderecoRevenda'] : '' ;
        $numeroRevenda = isset($_POST['numeroRevenda'])? $_POST['numeroRevenda'] : '' ;
        $bairroRevenda = isset($_POST['bairroRevenda'])? $_POST['bairroRevenda'] : '' ;
        $cidadeRevenda = isset($_POST['cidadeRevenda'])? $_POST['cidadeRevenda'] : '' ;
        $estadoRevenda = isset($_POST['estadoRevenda'])? $_POST['estadoRevenda'] : '' ;
        $siteRevenda = isset($_POST['siteRevenda'])? $_POST['siteRevenda'] : '' ;
        $foneRevenda = isset($_POST['foneRevenda'])? $_POST['foneRevenda'] : '' ;
        $telComRevenda = isset($_POST['telComRevenda'])? $_POST['telComRevenda'] : '' ;
        $celularRevenda = isset($_POST['celularRevenda'])? $_POST['celularRevenda'] : '' ;
        $emailRevenda = isset($_POST['emailRevenda'])? $_POST['emailRevenda'] : '' ;
        $responsavelRevenda = isset($_POST['responsavelRevenda'])? $_POST['responsavelRevenda'] : '' ;
        $senhaRevenda = isset($_POST['senhaRevenda'])? $_POST['senhaRevenda'] : '' ;
        $confirmacaoSenhaRevenda = isset($_POST['confirmacaoSenhaRevenda'])? $_POST['confirmacaoSenhaRevenda'] : '' ;
        $senhaCript = isset($_POST['senhaRevenda'])? $md5->code($_POST['senhaRevenda']) : '' ;
        
        $erro = 0;
        $msg .= '<ul style="color:red; size:10px;font-style:italic;">';
        if (!validaCampo($nomeRevenda))
        {
            $msg .= '<li>O campo Nome Fantasia deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($cepRevenda))
        {
            $msg .= '<li>O campo CEP deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }          
        if (!validaCampo($enderecoRevenda))
        {
            $msg .= '<li>O campo Endeço deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        
        if (!validaCampo($numeroRevenda))
        {
            $msg .= '<li>O campo Numero deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($cidadeRevenda))
        {
            $msg .= '<li>O campo Cidade deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($bairroRevenda))
        {
            $msg .= '<li>O campo Bairro deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($estadoRevenda))
        {
            $msg .= '<li>O campo Estado deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($foneRevenda))
        {
            $msg .= '<li>O campo Telefone Fixo 1 deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($emailRevenda))
        {
            $msg .= '<li>O campo Email da Empresa deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($responsavelRevenda))
        {
            $msg .= '<li>O campo Responsável de Senha deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($senhaRevenda))
        {
            $msg .= '<li>O campo Confirmação de Senha deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if (!validaCampo($confirmacaoSenhaRevenda))
        {
            $msg .= '<li>O campo Confirmação de Senha deve ser preenchido corretamente!</li>';
            $erro = 1;   
        }
        if ($confirmacaoSenhaRevenda != $senhaRevenda)
        {
            $msg .= '<li>O campo Confirmação de Senha deve ser preenchido corretamente!</li>';
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
        
        if($erro == '0')
        {
            $dataAlteracao = date("Y-m-d");
            $sql = "UPDATE clientes SET
                dataAlteracao = '{$dataAlteracao}',
                nomeFantasia = '{$nomeRevenda}',
                cep = '{$cepRevenda}',
                endereco = '{$enderecoRevenda}',
                numero = '{$numeroRevenda}',
                bairro = '{$bairroRevenda}',
                cidade = '{$cidadeRevenda}',
                estado = '{$estadoRevenda}',
                telRes = '{$foneRevenda}',
                telCel = '{$celularRevenda}',
                telCom = '{$telComRevenda}',
                email = '{$emailRevenda}',
                responsavel = '{$responsavelRevenda}',
                site = '{$siteRevenda}',
                senha = '{$senhaCript}'
                WHERE cod = {$codCliente}";
        	$resultado = mysql_query($sql);
            echo mysql_error();
            if ($foto != "")
            {
                $foto_temp = $_FILES['file']['tmp_name'];
                $exclusoes = isset($_POST['codigo']) ? $_POST['codigo'] : '' ;
                $objsArquivo = mysql_query("SELECT * FROM arquivos WHERE cod='$exclusoes' AND referencia = 'clienteRevenda'");
                $qtdObjsArquivo = mysql_num_rows($objsArquivo) ;
                $pasta = PROJECT_PATH."arquivos/clientesRevendas";
                
                if($qtdObjsArquivo > 0)
                {
                    for ($j = 0; $j < $qtdObjsArquivo; $j++)
                    {
                        $exc = mysql_fetch_assoc($objsArquivo);
                        unlink($pasta.DIRECTORY_SEPARATOR.$exc['arquivo']);
                    }
                    $fileG = insere_foto($foto, $foto_temp, $pasta,'115','84');
        			$sqlG = "UPDATE arquivos SET
                            arquivo = '{$fileG}'
                            WHERE cod='$exclusoes' AND referencia = 'clienteRevenda'";
        			$resultadoG = mysql_query($sqlG);
                }
                else
                {
                    $token = rand(1,99999).date('dmYHis');
                    $pasta = PROJECT_PATH."arquivos/clientesRevendas";;
                    $fileG = insere_foto($foto, $foto_temp, $pasta,'115','84');
            		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo)
                            VALUES ('clienteRevenda', '{$codCliente}','1', '{$fileG}','$token')";
            		$resultadoG = mysql_query($sqlG);
                }
    		}
            
            
            if($resultado)
            {
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    			echo "<script type='text/javascript'>
    					alert('Cadastro atualizado com sucesso!');
    					location.replace('".$link."');
    				  </script>";
                      die(); 
        	}
            else
        	{
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    			echo "<script type='text/javascript'>
    					alert('Erro ao atualizar cadastro!');
    					location.replace('".$link."');
    				  </script>";
                      die(); 
        	}
        }
    }
    mysql_close();
}
else
{
    $conexao = conexao();
    $sqlDadosCliente = mysql_query("SELECT * FROM clientes WHERE cod = '$codCliente'");
    $tpDadosCliente = mysql_fetch_assoc($sqlDadosCliente);
    mysql_close();
    if($tipoAnuncio == '1')
    {        
        $nomeParticular = $tpDadosCliente['razaoSocialNome'];
        $sobrenome = $tpDadosCliente['sobrenome'];
        $cpfParticular = $tpDadosCliente['documento'];
        $cepParticular = $tpDadosCliente['cep'];
        $enderecoParticular = $tpDadosCliente['endereco'];
        $numeroParticular = $tpDadosCliente['numero'];
        $complementoParticular = $tpDadosCliente['complemento'];
        $bairroParticular = $tpDadosCliente['bairro'];
        $cidadeParticular = $tpDadosCliente['cidade'];
        $estadoParticular = $tpDadosCliente['estado'];
        $foneParticular = $tpDadosCliente['telRes'];
        $celularParticular = $tpDadosCliente['telCel'];
        $emailParticular = $tpDadosCliente['email'];
        $senhaParticular = $md5->decode($tpDadosCliente['senha']);
        $confirmacaoSenhaParticular = $md5->decode($tpDadosCliente['senha']);
    }
    else
    {
        $razaoRevenda = $tpDadosCliente['razaoSocialNome'];
        $nomeRevenda = $tpDadosCliente['nomeFantasia'];
        $cnpjRevenda = $tpDadosCliente['documento'];
        $cepRevenda = $tpDadosCliente['cep'];
        $enderecoRevenda = $tpDadosCliente['endereco'];
        $numeroRevenda = $tpDadosCliente['numero'];
        $bairroRevenda = $tpDadosCliente['bairro'];
        $cidadeRevenda = $tpDadosCliente['cidade'];
        $estadoRevenda = $tpDadosCliente['estado'];
        $siteRevenda = $tpDadosCliente['site'];
        $foneRevenda = $tpDadosCliente['telRes'];
        $celularRevenda = $tpDadosCliente['telCel'];
        $telComRevenda = $tpDadosCliente['telCom'];
        $emailRevenda = $tpDadosCliente['email'];
        $responsavelRevenda = $tpDadosCliente['responsavel'];
        $senhaRevenda = $tpDadosCliente['senha'] != '' ? $md5->decode($tpDadosCliente['senha']) : $tpDadosCliente['senha'];
        $confirmacaoSenhaRevenda = $tpDadosCliente['senha'] != '' ? $md5->decode($tpDadosCliente['senha']) : $tpDadosCliente['senha'];
    }
    
}
?>
<script type="text/javascript">
                
function atualiza(_cep, _tipo = 1)
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
			
			if(_tipo == "1")
            {
                $("#enderecoParticular").val(_endereco[0]).focus();
                $("#bairroParticular").val(correio.bairro);
                $("#cidadeParticular").val(correio.cidade);
                $("#estadoParticular").val(correio.estado);
                $("#cepParticular").val(correio.cep);
            }
            else
            {
                $("#enderecoRevenda").val(_endereco[0]).focus();
                $("#bairroRevenda").val(correio.bairro);
                $("#cidadeRevenda").val(correio.cidade);
                $("#estadoRevenda").val(correio.estado);
                $("#cepRevenda").val(correio.cep);
            }
        }
        else
        {
            alert(correio.erro);
        }
     }
  });
}
function enableRev()
{
    $("#cidadeRevenda").removeAttr("disabled");
    $("#estadoRevenda").removeAttr("disabled");
}
function enablePart()
{
    $("#cidadeParticular").removeAttr("disabled");
    $("#estadoParticular").removeAttr("disabled");
}
$(document).ready(function()
{
    <?
    if($tipoAnuncio == '1')
    {
    ?>
        $("#atualizaCepPar").click(function(){
            atualiza($("#cepParticular").val(), "1");
        });
        
        $("#celularParticular")
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
            })
            .keypress(function(e)
            {
                return validaTecla(e, 'inteiro');
            })
        
        objValidadorCadastro = new xform('#dadosParticular',{
    	   callbackTrue:function(){
    	       enablePart();
    	   }
        });
        objValidadorCadastro . adicionar('#nomeParticular','nome');
        objValidadorCadastro . adicionar('#sobrenome');
        objValidadorCadastro . adicionar('#cepParticular','cep');
        objValidadorCadastro . adicionar('#cpfParticular','cpf', true);
        objValidadorCadastro . adicionar('#cidadeParticular');
		objValidadorCadastro . adicionar('#estadoParticular');
        objValidadorCadastro . adicionar('#bairroParticular');
        objValidadorCadastro . adicionar('#enderecoParticular');
        objValidadorCadastro . adicionar('#numeroParticular','inteiro');
        objValidadorCadastro . adicionar('#foneParticular','fone5', true);
        objValidadorCadastro . adicionar('#emailParticular','email');
        objValidadorCadastro . adicionar('#senhaParticular','tudo', false, true, "#confirmacaoSenhaParticular");
        objValidadorCadastro . adicionar('#confirmacaoSenhaParticular');
    <?
    }
    else
    {
    ?>
        $("#atualizaCepRev").click(function(){
            atualiza($("#cepRevenda").val(), "2");
        });
        
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
            })
            .keypress(function(e)
            {
                return validaTecla(e, 'inteiro');
            })
        $('#telComRevenda').mask('(99) 9999-9999');
        objValidadorCadastro = new xform('#dadosRevenda',{
    	   callbackTrue:function(){
    	       enableRev();
    	   }
        });
        objValidadorCadastro . adicionar('#nomeRevenda');
        objValidadorCadastro . adicionar('#cepRevenda','cep');
        objValidadorCadastro . adicionar('#enderecoRevenda');
		objValidadorCadastro . adicionar('#numeroRevenda','inteiro');
        objValidadorCadastro . adicionar('#bairroRevenda');
        objValidadorCadastro . adicionar('#cidadeRevenda');
		objValidadorCadastro . adicionar('#estadoRevenda');
        objValidadorCadastro . adicionar('#foneRevenda','fone5');
        objValidadorCadastro . adicionar('#responsavelRevenda');
        objValidadorCadastro . adicionar('#siteRevenda', 'url', true);
        objValidadorCadastro . adicionar('#emailRevenda','email');
        objValidadorCadastro . adicionar('#senhaRevenda','tudo', false, true, "#confirmacaoSenhaRevenda");
        objValidadorCadastro . adicionar('#confirmacaoSenhaRevenda');
    <?
    }
    ?>
})
</script>
<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <a href="#">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Dados do Anúncio</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
        <?
        if($tipoAnuncio == "2")
        {
        ?>
            <div class="planobloco" id="revenda">
                <form name="dadosRevenda" id="dadosRevenda" method="post" action="" enctype="multipart/form-data">
                    <div class="dadosrevenda">
                        <div class="planotitulogeral">Dados da Revenda</div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="nomeRevenda">Nome Fantasia</label>
                            <input type="text" class="inputgranderevenda" name="nomeRevenda" id="nomeRevenda" title="Nome Fantasia" value="<?=$nomeRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="razaoRevenda">Razão Social</label>
                            <input type="text" disabled="disabled" class="inputgranderevenda" name="razaoRevenda" id="razaoRevenda" title="Razão Social" value="<?=$razaoRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cnpjRevenda">CNPJ</label>
                            <input type="text" disabled="disabled" class="inputgranderevenda" name="cnpjRevenda" id="cnpjRevenda" title="CNPJ" value="<?=$cnpjRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cepRevenda">CEP</label>
                            <input type="text" class="inputgranderevenda" name="cepRevenda" id="cepRevenda" title="CEP" value="<?=$cepRevenda;?>" />
                            <a class="atualizarCadastro" id="atualizaCepRev">Atualizar</a>
                        </div>
                        
                        <div class="inputbloco">
                            <div class="inputleft">
                                <label for="enderecoRevenda">Endereço</label>
                                <input style="width: 185px;" type="text" class="inputpequeno" name="enderecoRevenda" id="enderecoRevenda" title="Endereço" value="<?=$enderecoRevenda;?>" />
                            </div>
                            <div class="inputright">
                                <label for="numeroRevenda" style="width: auto;">Nº</label>
                                <input type="text" class="inputpequeno" name="numeroRevenda" id="numeroRevenda" title="Número" value="<?=$numeroRevenda;?>" />
                            </div>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="bairroRevenda">Bairro</label>
                            <input type="text" class="inputgranderevenda" name="bairroRevenda" id="bairroRevenda" title="Bairro" value="<?=$bairroRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cidadeRevenda">Cidade</label>
                            <input type="text" class="inputgranderevenda" name="cidadeRevenda" id="cidadeRevenda" title="Cidade" value="<?=$cidadeRevenda;?>"  disabled="disabled" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="estadoRevenda">Estado</label>
                            <select class="selectgranderevenda" name="estadoRevenda" id="estadoRevenda" title="Estado" disabled="disabled">
                                <option value="" <?=$estadoRevenda == '' ? 'selected="selected"' : '';?>>-</option>
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
                            <label for="foneRevenda">Telefone Fixo 1</label>
                            <input type="text" class="inputgranderevenda" name="foneRevenda" id="foneRevenda" title="Telefone Fixo 1" value="<?=$foneRevenda;?>" />
                        </div>
                        <div class="inputbloco">
                            <label for="telComRevenda">Telefone Fixo 2</label>
                            <input type="text" class="inputgranderevenda" name="telComRevenda" id="telComRevenda" title="Telefone Fixo 2" value="<?=$telComRevenda;?>" />
                        </div>
                        <div class="inputbloco">
                            <label for="celularRevenda">Telefone Cel.</label>
                            <input type="text" class="inputgranderevenda" name="celularRevenda" maxlength="15" id="celularRevenda" title="Celular" value="<?=$celularRevenda;?>" />
                        </div>
                        
                        
                        
                        <div class="inputbloco">
                            <label class="composto" for="marcaRevenda">Marca da Empresa</label>
                            <input type="file" name="file" id="file" title="Marca da Empresa" /><br />
                            <label for="marcaRevenda">&nbsp;</label>
                        </div>
                        <?
                        $conexao = conexao();
                        $sqlLogoEmpresa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codCliente' AND referencia = 'clienteRevenda' AND tipo = '1'");
                        $numLogoEmpresa = mysql_num_rows($sqlLogoEmpresa);
                        if($numLogoEmpresa > 0)
                        {
                            $tpLogoEmpresa = mysql_fetch_assoc($sqlLogoEmpresa)
                        ?>
                            <div class="inputbloco">
                                <label class="composto" for="marcaRevenda">Atual Marca da Empresa</label>
                                <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesRevendas/<?=$tpLogoEmpresa['arquivo'];?>" title="Marca" />
                                <input type="hidden" name="codigo" value="<?=$tpLogoEmpresa['cod'];?>" />
                            </div>
                        <?
                        }
                        mysql_close();
                        ?>
                        <div class="inputbloco">
                            <label for="responsavelRevenda">Responsável</label>
                            <input type="text" class="inputgranderevenda" name="responsavelRevenda" id="responsavelRevenda" title="Responsável" value="<?=$responsavelRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="siteRevenda">Site</label>
                            <input type="text" class="inputgranderevenda" name="siteRevenda" id="siteRevenda" title="Site" value="<?=$siteRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="emailRevenda">E-mail<br /> da Empresa</label>
                            <input type="text" class="inputgranderevenda" name="emailRevenda" id="emailRevenda" title="E-mail da Empresa" value="<?=$emailRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="senhaRevenda">Senha</label>
                            <input type="password" class="inputgranderevenda" name="senhaRevenda" id="senhaRevenda" title="Senha" value="<?=$senhaRevenda;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="confirmacaoSenhaRevenda">Confirmação de Senha</label>
                            <input type="password" class="inputgranderevenda" name="confirmacaoSenhaRevenda" id="confirmacaoSenhaRevenda" title="Confirmação de Senha" value="<?=$confirmacaoSenhaRevenda;?>" />
                        </div>
                        
                        <div class="revendaenviar">
                            <input type="submit" name="enviarDadosRevenda" id="enviarDadosRevenda" title="Salvar" value="Salvar" />
                        </div>
                    </div>
                </form>
            </div>
            <?
            }
            else
            {
            ?>
            <div class="planobloco" id="particular">
                <form name="dadosParticular" id="dadosParticular" method="post" action="" enctype="multipart/form-data">
                    <div class="dadosrevenda">
                        <div class="planotitulogeral">Dados do Proprietário</div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="nomeParticular">Nome</label>
                            <input type="text" class="inputgranderevenda" name="nomeParticular" id="nomeParticular" title="Nome" value="<?=$nomeParticular;?>" />
                        </div>
                        <div class="inputbloco">
                            <label class="composto" for="sobrenome">Sobrenome</label>
                            <input type="text" class="inputgranderevenda" name="sobrenome" id="sobrenome" title="Sobrenome" value="<?=$sobrenome;?>" />
                        </div>
                        <div class="inputbloco">
                            <label for="cpfParticular">CPF</label>
                            <input type="text" class="inputgranderevenda" name="cpfParticular" id="cpfParticular" title="CPF" value="<?=$cpfParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cepParticular">CEP</label>
                            <input type="text" class="inputgranderevenda" name="cepParticular" id="cepParticular" title="CEP" value="<?=$cepParticular;?>" />
                            <a class="atualizarCadastro" id="atualizaCepPar">Atualizar</a>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="enderecoParticular">Endereço</label>
                            <input type="text" class="inputgranderevenda" name="enderecoParticular" id="enderecoParticular" title="Endereço" value="<?=$enderecoParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <div class="inputleft">
                                <label for="numeroParticular">Número</label>
                                <input style="width: 129px;" type="text" class="inputpequeno" name="numeroParticular" id="numeroParticular" title="Número" value="<?=$numeroParticular;?>" />
                            </div>
                            <div class="inputright">
                                <label for="complementoParticular" style="width: auto;">Complemento</label>
                                <input type="text" class="inputpequeno" name="complementoParticular" id="complementoParticular" title="Complemento" value="<?=$complementoParticular;?>" />
                            </div>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="bairroParticular">Bairro</label>
                            <input type="text" class="inputgranderevenda" name="bairroParticular" id="bairroParticular" title="Bairro" value="<?=$bairroParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="cidadeParticular">Cidade</label>
                            <input type="text" class="inputgranderevenda" name="cidadeParticular" id="cidadeParticular" title="Cidade" value="<?=$cidadeParticular;?>" disabled="disabled"/>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="estadoParticular">Estado</label>
                            <select class="selectgranderevenda" name="estadoParticular" id="estadoParticular" title="Estado" disabled="disabled">
                                <option value="" <?=$estadoParticular == '' ? 'selected="selected"' : '';?>>-</option>
                                <option value="AC" <?=$estadoParticular == 'AC' ? 'selected="selected"' : '';?>>AC</option>
                                <option value="AL" <?=$estadoParticular == 'AL' ? 'selected="selected"' : '';?>>AL</option>
                                <option value="AM" <?=$estadoParticular == 'AM' ? 'selected="selected"' : '';?>>AM</option>
                                <option value="AP" <?=$estadoParticular == 'AP' ? 'selected="selected"' : '';?>>AP</option>
                                <option value="BA" <?=$estadoParticular == 'BA' ? 'selected="selected"' : '';?>>BA</option>
                                <option value="CE" <?=$estadoParticular == 'CE' ? 'selected="selected"' : '';?>>CE</option>
                                <option value="DF" <?=$estadoParticular == 'DF' ? 'selected="selected"' : '';?>>DF</option>
                                <option value="ES" <?=$estadoParticular == 'ES' ? 'selected="selected"' : '';?>>ES</option>
                                <option value="GO" <?=$estadoParticular == 'GO' ? 'selected="selected"' : '';?>>GO</option>
                                <option value="MA" <?=$estadoParticular == 'MA' ? 'selected="selected"' : '';?>>MA</option>
                                <option value="MT" <?=$estadoParticular == 'MT' ? 'selected="selected"' : '';?>>MT</option>
                                <option value="MS" <?=$estadoParticular == 'MS' ? 'selected="selected"' : '';?>>MS</option>
                                <option value="MG" <?=$estadoParticular == 'MG' ? 'selected="selected"' : '';?>>MG</option>
                                <option value="PA" <?=$estadoParticular == 'PA' ? 'selected="selected"' : '';?>>PA</option>
                                <option value="PB" <?=$estadoParticular == 'PB' ? 'selected="selected"' : '';?>>PB</option>
                                <option value="PR" <?=$estadoParticular == 'PR' ? 'selected="selected"' : '';?>>PR</option>
                                <option value="PE" <?=$estadoParticular == 'PE' ? 'selected="selected"' : '';?>>PE</option>
                                <option value="PI" <?=$estadoParticular == 'PI' ? 'selected="selected"' : '';?>>PI</option>
                                <option value="RJ" <?=$estadoParticular == 'RJ' ? 'selected="selected"' : '';?>>RJ</option>
                                <option value="RN" <?=$estadoParticular == 'RN' ? 'selected="selected"' : '';?>>RN</option>
                                <option value="RO" <?=$estadoParticular == 'RO' ? 'selected="selected"' : '';?>>RO</option>
                                <option value="RS" <?=$estadoParticular == 'RS' ? 'selected="selected"' : '';?>>RS</option>
                                <option value="RR" <?=$estadoParticular == 'RR' ? 'selected="selected"' : '';?>>RR</option>
                                <option value="SC" <?=$estadoParticular == 'SC' ? 'selected="selected"' : '';?>>SC</option>
                                <option value="SE" <?=$estadoParticular == 'SE' ? 'selected="selected"' : '';?>>SE</option>
                                <option value="SP" <?=$estadoParticular == 'SP' ? 'selected="selected"' : '';?>>SP</option>
                                <option value="TO" <?=$estadoParticular == 'TO' ? 'selected="selected"' : '';?>>TO</option>
                            </select>
                        </div>
                        
                        <div class="inputbloco">
                            <label for="foneParticular">Telefone Fixo</label>
                            <input type="text" class="inputgranderevenda" name="foneParticular" id="foneParticular" title="Telefone Fixo" value="<?=$foneParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="celularParticular">Celular</label>
                            <input type="text" class="inputgranderevenda" name="celularParticular" id="celularParticular" title="Celular" value="<?=$celularParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="emailParticular">E-mail</label>
                            <input type="text" class="inputgranderevenda" name="emailParticular" id="emailParticular" title="E-mail" value="<?=$emailParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label for="senhaParticular">Senha</label>
                            <input type="password" class="inputgranderevenda" name="senhaParticular" id="senhaParticular" title="Senha" value="<?=$senhaParticular;?>" />
                        </div>
                        
                        <div class="inputbloco">
                            <label class="composto" for="confirmacaoSenhaParticular">Confirmação de Senha</label>
                            <input type="password" class="inputgranderevenda" name="confirmacaoSenhaParticular" id="confirmacaoSenhaParticular" title="Confirmação de Senha" value="<?=$confirmacaoSenhaParticular;?>" />
                        </div>
                        
                        <div class="revendaenviar">
                            <input type="submit" name="enviarDadosParticular" id="enviarDadosParticular" title="Salvar" value="Salvar" />
                        </div>
                    </div>
                </form>
            </div>
            <?
            }
            ?>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>