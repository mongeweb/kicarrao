<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    require_once ADMIN_FUNC_PATH . 'verifica.php';
    require_once ADMIN_FUNC_PATH . 'validaCampo.php';
    $tipoLogin = isset($_SESSION['tipoLogin']) ? $_SESSION['tipoLogin'] : 1;
    if($restrita == 1)
    {
        if($tipoLogin > 1)
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos-dev' : sslRedir().PROJECT_URL.'/anuncio-fotos-dev.php';
        }
        else
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        }
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        exit();
    }
	?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    
</head>

<body>
<?
$msg = '';						
$submit = isset($_POST['enviarCadastroNovo']) ? $_POST['enviarCadastroNovo'] : '' ;
if($submit != '')
{
    $conexao = conexao();
	$dataCadastro = date('Y-m-d');
    $md5 = new md5();
	
    $email = isset($_POST['emailUsuarioNovo']) ? $_POST['emailUsuarioNovo'] : '';
    $senha = isset($_POST['senhaUsuarioNovo']) ? $_POST['senhaUsuarioNovo'] : '' ;
    $confsenha = isset($_POST['confirmarSenhaUsuarioNovo']) ? $_POST['confirmarSenhaUsuarioNovo'] : '' ;
    $senhacript = $md5->code($senha);
	$documento = isset($_POST['documentoUsuarioNovo']) ? $_POST['documentoUsuarioNovo'] : '' ;
	$nome = isset($_POST['nomeUsuarioNovo']) ? $_POST['nomeUsuarioNovo'] : '';
    $sobrenome = isset($_POST['sobrenomeUsuarioNovo']) ? $_POST['sobrenomeUsuarioNovo'] : '';
    $telRes = isset($_POST['telResUsuarioNovo']) ? $_POST['telResUsuarioNovo'] : '' ;
    $estadoCad = isset($_POST['estadoCad']) ? $_POST['estadoCad'] : '';
    $cidadeCad = isset($_POST['cidadeCad']) ? $_POST['cidadeCad'] : '';
    $enderecoCad = isset($_POST['enderecoCad']) ? $_POST['enderecoCad'] : '';
    $bairroCad = isset($_POST['bairroCad']) ? $_POST['bairroCad'] : '';
    $numeroCad = isset($_POST['numeroCad']) ? $_POST['numeroCad'] : '';
    $complementoCad = isset($_POST['complementoCad']) ? $_POST['complementoCad'] : '';
    $cepCad = isset($_POST['cepCad']) ? $_POST['cepCad'] : '';
    
    $msg = '<ul>';
    $erro = 0;
	
	if (validaCampo($_POST['emailUsuarioNovo'], 'email', false) == 0) 
	{
		$msg .= '<li>O campo Email deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	if (validaCampo($_POST['senhaUsuarioNovo'],'', false) == 0) 
	{
		$msg .= '<li>O campo Senha deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	if (validaCampo($_POST['confirmarSenhaUsuarioNovo'], '', false) == 0) 
	{
		$msg .= '<li>O campo Confirme sua senha deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	if ($_POST['senhaUsuarioNovo'] != $_POST['confirmarSenhaUsuarioNovo']) 
	{
		$msg .= '<li>O campo Senha e Confirme sua senha devem ser iguais!</li>';
		$erro = 1;
	}
	if (validaCampo($_POST['nomeUsuarioNovo'], 'nome', false) == 0) 
	{
		$msg .= '<li>O campo Nome deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['sobrenomeUsuarioNovo'], 'nome', false) == 0) 
	{
		$msg .= '<li>O campo Sobrenome deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['documentoUsuarioNovo'], '', false) == 0) 
	{
		$msg .= '<li>O campo CPF deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['telResUsuarioNovo'], '', false) == 0) 
	{
		$msg .= '<li>O campo Telefone Fixo deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	if (validaCampo($_POST['estadoCad'], '', false) == 0) 
	{
		$msg .= '<li>O campo Estado deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['cidadeCad'], '', false) == 0) 
	{
		$msg .= '<li>O campo Cidade deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	if (validaCampo($_POST['enderecoCad'], '', false) == 0) 
	{
		$msg .= '<li>O campo Endereço deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['numeroCad'], '', false) == 0) 
	{
		$msg .= '<li>O campo Número deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['cepCad'], '', false) == 0) 
	{
		$msg .= '<li>O campo CEP deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['bairroCad'], '', false) == 0) 
	{
		$msg .= '<li>O campo Bairro deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	$msg .= '</ul>';
		
	if ($erro == 0)
	{
		$sqlFiltro = "SELECT email FROM clientes WHERE email = '$email'";
		$queryFiltro = mysql_query($sqlFiltro);
		$linhasFiltro = mysql_num_rows($queryFiltro);
        
        $sqlFiltro2 = mysql_query("SELECT documento FROM clientes WHERE documento = '$documento'");
		$linhasFiltro2 = mysql_num_rows($sqlFiltro2);
		if($linhasFiltro > 0)
		{
		  ?>
			<script type='text/javascript'>
			$(document).ready(function()
			{
				alert('Email já cadastrado!');
				$('#emailUsuarioNovo').focus();
			
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
				alert('CPF já cadastrado!');
				$('#documentoUsuarioNovo').focus();
			
			});
			</script>
		  <?php
		}
		else
		{
            $dataCadastro = date('Y-m-d');
            $sqlCliente = "INSERT INTO clientes
							(dataCadastro, tipoAnuncio, razaoSocialNome, sobrenome, documento, email, estado, cidade, cep, endereco, numero, bairro, complemento, telRes, senha, situacao)
							VALUES
							('{$dataCadastro}','1', '{$nome}', '{$sobrenome}', '{$documento}', '{$email}', '{$estadoCad}', '{$cidadeCad}', '{$cepCad}', '{$enderecoCad}', '{$numeroCad}', '{$bairroCad}', '{$complementoCad}', '{$telRes}', '{$senhacript}','1')";
			$queryCliente = mysql_query($sqlCliente);
			//echo mysql_error();
			if($queryCliente)
			{
				$codCliente = mysql_insert_id();
                $codAnuncio = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : '';
                if($codAnuncio != '')
                {
    				$sqlAnuncio = "UPDATE clientesAnuncios SET
                                    codCliente = '{$codCliente}'
                                    WHERE cod = '{$codAnuncio}'";
    				$queryAnuncio = mysql_query($sqlAnuncio);
                }
				require_once PROJECT_FUNC_PATH . 'cadastroEmail.php';
		
				/*$nomeRemetente = "Kicarrão";
				$assunto = "Cadastro - Kicarrão";
				$emailDestinatario = array($email);
        		$emailRemetente = 'noreply@kicarrao.com.br';
                $emailResposta  = 'noreply@kicarrao.com.br';
                $conteudoEmail = array(
                    'nome'      => $nome,
                    'email'     => $email,
                    'senha'     => $senha
                );
                $twitter = '';
                $facebook = 'kicarrao';
    
                $conf = cadastroEmail($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);*/                
			
				$nomeRemetente = "Kicarrão";
				$assunto = "Cadastro - Kicarrão";
				$conteudoEmail = array(
                    'nome'      => $nome,
                    'email'     => $email,
                    'senha'     => $senha,
                    'tipoAnuncio'     => 1
                );
			
				$emailDestinatario = array($email);//array('arturbalestro@hotmail.com','ammbalestro@gmail.com');
                $emailRemetente = 'noreply@kicarrao.com.br';
                $emailResposta  = 'noreply@kicarrao.com.br';
                $twitter = '';
                $facebook = 'kicarrao';
				
				$conf = cadastroEmail($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);		
				
				if($conf)
				{
					echo " <script language=\"JavaScript1.2\"> \n";
					echo " <!-- \n";
					echo " alert(\"Cadastro realizado com sucesso!\");\n";
					//echo " location.replace('principal.php?id=5&subid=1'); \n";
					echo " //--> \n";
					echo " </script> \n";
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/login' : sslRedir().PROJECT_URL.'/login.php';
					?>
					<form name="loginCadastro" id="loginCadastro" action="<?=$link;?>" method="post">
						<input type="hidden" name="emailUsuario" value="<?=$email;?>"/>
						<input type="hidden" name="senhaUsuario" value="<?=$senha;?>"/>
                        <input type="hidden" name="tipoLogin" value="<?=$tipoLogin;?>"/>
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
			}	
			else
			{
				echo " <script language=\"JavaScript1.2\"> \n";
				echo " <!-- \n";
				echo " alert(\"Erro ao cadastrar!\");\n";
				echo " //--> \n";
				echo " </script> \n";
			}			
		}
	}
    mysql_close();
}	
else
{
    $nome = '';
    $sobrenome = '';
    $email = '';
    $senha = '';
    $confsenha = '';
    $estadoCad = '';
    $cidadeCad = '';
    $enderecoCad = '';
    $bairroCad = '';
    $numeroCad = '';
    $complementoCad = '';
    $cepCad = '';
    $documento = '';
    $telRes = '';
}
?>
<script type="text/javascript">
        function atualiza(_cep)
        {
          _cep = (_cep == null) || (_cep == 'undefined') ? $("#cepCad").val() : _cep;
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
        			
					$("#enderecoBloco").show(500);
        			$("#enderecoCad").val(_endereco[0]).focus();
                    $("#bairroCad").val(correio.bairro);
                    $("#cidadeCad").val(correio.cidade);
                    $("#estadoCad").val(correio.estado);
                    $("#cepCad").val(correio.cep);
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
            $("#cidadeCad").removeAttr("disabled");
            $("#estadoCad").removeAttr("disabled");
        }
        
        $(document).ready(function()
        {
            $("a.esqueci").click(function(){
                $("div.esquecibloco").show();
            })
            
            $("div.esquecifechar").click(function(){
                $("div.esquecibloco").hide();
            })
            
            $("#atualizaCepCad").click(function(){
                atualiza();
            });
            
            objValidadorCadastro = new xform('#usuarioCadastrado');
            objValidadorCadastro . adicionar('#emailUsuario','email');
        	objValidadorCadastro . adicionar('#senhaUsuario');
            
            objValidadorCadastro = new xform('#novoCadastro',{
        	   callbackTrue:function(){
        	       enable();
                   var termos = $("input#termosUso[type='checkbox']").attr("checked");
                    if(termos != "checked"){ 
                        alert('Você precisa aceitar os termos de uso para completar o cadastro.');
                        return false;
                    }
                   return true;
        	   }
            });
            objValidadorCadastro . adicionar('#nomeUsuarioNovo','nome');
            objValidadorCadastro . adicionar('#sobrenomeUsuarioNovo');
            objValidadorCadastro . adicionar('#emailUsuarioNovo','email');
            objValidadorCadastro . adicionar('#telResUsuarioNovo','fone5');
            objValidadorCadastro . adicionar('#documentoUsuarioNovo', 'cpf');
        	//objValidadorCadastro . adicionar('#loginUsuarioNovo');
            objValidadorCadastro . adicionar('#estadoCad');
            objValidadorCadastro . adicionar('#cidadeCad');
            objValidadorCadastro . adicionar('#bairroCad');
            //objValidadorCadastro . adicionar('#complementoCad');
            objValidadorCadastro . adicionar('#numeroCad');
            objValidadorCadastro . adicionar('#cepCad', 'cep');
            objValidadorCadastro . adicionar('#enderecoCad');
            objValidadorCadastro . adicionar('#senhaUsuarioNovo','tudo', false, true, "#confirmarSenhaUsuarioNovo");
            objValidadorCadastro . adicionar('#confirmarSenhaUsuarioNovo');
            
        })
    </script>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Identificação</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="anunciewrap">
                    <div class="anunciemenu">
                        <div class="anunciemenuitem" id="dados">
                            <a href="#">Dados do Anúncio</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight separarighthover"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem anunciemenuhover" id="identificacao">
                            <a href="#">Identificação</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft separalefthover"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="fotos">
                            <a href="#">Fotos</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="finalizacao">
                            <a href="#">Finalização</a>
                        </div>
                    </div>
                    <div class="anunciedadosbloco">
                        <div class="identform identesq">
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/login-dev' : sslRedir().PROJECT_URL.'/login-dev.php';
                        ?>
                            <form name="usuarioCadastrado" id="usuarioCadastrado" method="post" action="<?=$link;?>" enctype="multipart/form-data">
                                <p class="formtitulo">Já sou cadastrado</p>
                                <p class="formtexto">Se você já possui cadastro, insira seu login e senha.</p>
                                
                                <div class="inputbloco">
                                    <label for="emailUsuario">E-mail <span class="obrigatorio">*</span></label>
                                    <input tabindex="1" type="text" class="inputgrande" name="emailUsuario" id="emailUsuario" title="E-mail" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="senhaUsuario">Senha <span class="obrigatorio">*</span></label>
                                    <input tabindex="2" type="password" class="inputgrande" name="senhaUsuario" id="senhaUsuario" title="Senha" />
                                </div>
                                <div class="inputbloco">
                                    <span class="anunciolegenda">* Campos obrigatórios</span>
                                    <a class="esqueci">Esqueci minha senha</a>
                                </div>
                                <input type="hidden" name="tipoLogin" id="tipoLogin" value="<?=$tipoLogin;?>" />
                                <div class="identenviar">
                                    <input tabindex="3" type="submit" name="enviarCadastrado" id="enviarCadastrado" title="Login" value="Login" />
                                </div>
                            </form>
                            <div class="esquecibloco">
                                <div class="esqueciblocoborda">
                                    <div class="esquecifechar"><img src="http://<?=PROJECT_URL;?>/img/esquecifechar.png" alt="Fechar" /></div>
                                    <?
                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/recuperarsenha' : sslRedir().PROJECT_URL.'/home.php';
                                    ?>
                                    <form name="esqueciSenha" id="esqueciSenha" action="<?=$link;?>" method="post" enctype="multipart/form-data">
                                        <p class="esquecititulo">Esqueci minha senha</p>
                                        <label for="emailEsqueciSenha">E-mail</label>
                                        <input type="text" name="emailEsqueciSenha" id="emailEsqueciSenha" title="E-mail" />
                                        <input type="submit" name="enviarEsqueciSenha" id="enviarEsqueciSenha" title="Enviar" value="Enviar" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="identform identdir">
                            <form name="novoCadastro" id="novoCadastro" method="post" action="" enctype="multipart/form-data">
                                <p class="formtitulo">Não sou cadastrado</p>
                                <p class="formtexto">Faça seu cadastro para anunciar no site.</p>
                                <?=$msg;?>
                                <div class="inputbloco">
                                    <label for="nomeUsuarioNovo">Nome <span class="obrigatorio">*</span></label>
                                    <input tabindex="4" type="text" class="inputgrande" name="nomeUsuarioNovo" id="nomeUsuarioNovo" title="Nome" value="<?=$nome;?>" />
                                </div>
                                <div class="inputbloco">
                                    <label for="sobrenomeUsuarioNovo">Sobrenome <span class="obrigatorio">*</span></label>
                                    <input tabindex="5" type="text" class="inputgrande" name="sobrenomeUsuarioNovo" id="sobrenomeUsuarioNovo" title="Sobrenome" value="<?=$sobrenome;?>" />
                                </div>
                                <div class="inputbloco">
                                    <label for="documentoUsuarioNovo">CPF: <span class="obrigatorio">*</span></label>
                                    <input tabindex="6" type="text" name="documentoUsuarioNovo" id="documentoUsuarioNovo" title="CPF" value="<?=$documento;?>" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="emailUsuarioNovo">E-mail <span class="obrigatorio">*</span></label>
                                    <input tabindex="7" type="text" class="inputgrande" name="emailUsuarioNovo" id="emailUsuarioNovo" title="E-mail" value="<?=$email;?>" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="senhaUsuarioNovo">Senha <span class="obrigatorio">*</span></label>
                                    <input tabindex="8" type="password" class="inputgrande" name="senhaUsuarioNovo" id="senhaUsuarioNovo" title="Senha" value="<?=$senha;?>" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="senhaUsuarioNovo" class="composto">Confirmar Senha <span class="obrigatorio">*</span></label>
                                    <input tabindex="9" type="password" class="inputgrande" name="confirmarSenhaUsuarioNovo" id="confirmarSenhaUsuarioNovo" title="Confirmar Senha" value="<?=$confsenha;?>" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="telResUsuarioNovo" class="composto">Telefone: <span class="obrigatorio">*</span></label>
                                    <input tabindex="10" type="text" name="telResUsuarioNovo" id="telResUsuarioNovo" title="Telefone Fixo" value="<?=$telRes;?>" /> 
                                    <span class="obrigatorio">Divulgado</span>
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="cepCad">CEP <span class="obrigatorio">*</span></label>
                                    <input tabindex="11" type="text" class="inputgrande" name="cepCad" id="cepCad" title="CEP" value="<?=$cepCad;?>"/>
                                    <a class="atualizarCadastro" id="atualizaCepCad">Buscar</a>
                                    <br />
                                    <div id="orientaCep">
                                    	<span class="obrigatorio">Digite seu CEP e clique em buscar.<br /><br />Caso não saiba seu CEP clique <a class="cep" href="http://www.buscacep.correios.com.br/" target="_blank">aqui</a>.</span> 
                                	</div>
                                </div>
                                
                                <div id="enderecoBloco" style="display:none">
                                    <div class="inputbloco">
                                        <label for="enderecoCad">Endereço <span class="obrigatorio">*</span></label>
                                        <input tabindex="12" type="text" class="inputgrande" name="enderecoCad" id="enderecoCad" title="Endereço" value="<?=$enderecoCad;?>" />
                                    </div>
                                    <div class="inputbloco">
                                        <label for="numeroCad">N&deg; <span class="obrigatorio">*</span></label>
                                        <input tabindex="13" type="text" class="inputgrande" name="numeroCad" id="numeroCad" title="Número" value="<?=$numeroCad;?>" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="complementoCad" >Complemento </label>
                                        <input tabindex="14" type="text" class="inputgrande" name="complementoCad" id="complementoCad" title="Complemento" value="<?=$complementoCad;?>" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="bairroCad">Bairro <span class="obrigatorio">*</span></label>
                                        <input tabindex="15" type="text" class="inputgrande" name="bairroCad" id="bairroCad" title="Bairro" value="<?=$bairroCad;?>" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="cidadeCad">Cidade <span class="obrigatorio">*</span></label>
                                        <input tabindex="16" type="text" class="inputgrande" name="cidadeCad" id="cidadeCad" title="Cidade" value="<?=$cidadeCad;?>"  disabled="disabled" />
                                    </div>
                                    
                                    <div class="inputbloco">
                                        <label for="estadoCad">Estado <span class="obrigatorio">*</span></label>
                                        <select tabindex="17" class="selectgrande" name="estadoCad" id="estadoCad" title="Estado" disabled="disabled">
                                            <option value="">-</option>
                                            <option value="AC" <?=$estadoCad == 'AC' ? 'selected="selected"' : '';?>>AC</option>
                                            <option value="AL" <?=$estadoCad == 'AL' ? 'selected="selected"' : '';?>>AL</option>
                                            <option value="AM" <?=$estadoCad == 'AM' ? 'selected="selected"' : '';?>>AM</option>
                                            <option value="AP" <?=$estadoCad == 'AP' ? 'selected="selected"' : '';?>>AP</option>
                                            <option value="BA" <?=$estadoCad == 'BA' ? 'selected="selected"' : '';?>>BA</option>
                                            <option value="CE" <?=$estadoCad == 'CE' ? 'selected="selected"' : '';?>>CE</option>
                                            <option value="DF" <?=$estadoCad == 'DF' ? 'selected="selected"' : '';?>>DF</option>
                                            <option value="ES" <?=$estadoCad == 'ES' ? 'selected="selected"' : '';?>>ES</option>
                                            <option value="GO" <?=$estadoCad == 'GO' ? 'selected="selected"' : '';?>>GO</option>
                                            <option value="MA" <?=$estadoCad == 'MA' ? 'selected="selected"' : '';?>>MA</option>
                                            <option value="MT" <?=$estadoCad == 'MT' ? 'selected="selected"' : '';?>>MT</option>
                                            <option value="MS" <?=$estadoCad == 'MS' ? 'selected="selected"' : '';?>>MS</option>
                                            <option value="MG" <?=$estadoCad == 'MG' ? 'selected="selected"' : '';?>>MG</option>
                                            <option value="PA" <?=$estadoCad == 'PA' ? 'selected="selected"' : '';?>>PA</option>
                                            <option value="PB" <?=$estadoCad == 'PB' ? 'selected="selected"' : '';?>>PB</option>
                                            <option value="PR" <?=$estadoCad == 'PR' ? 'selected="selected"' : '';?>>PR</option>
                                            <option value="PE" <?=$estadoCad == 'PE' ? 'selected="selected"' : '';?>>PE</option>
                                            <option value="PI" <?=$estadoCad == 'PI' ? 'selected="selected"' : '';?>>PI</option>
                                            <option value="RJ" <?=$estadoCad == 'RJ' ? 'selected="selected"' : '';?>>RJ</option>
                                            <option value="RN" <?=$estadoCad == 'RN' ? 'selected="selected"' : '';?>>RN</option>
                                            <option value="RO" <?=$estadoCad == 'RO' ? 'selected="selected"' : '';?>>RO</option>
                                            <option value="RS" <?=$estadoCad == 'RS' ? 'selected="selected"' : '';?>>RS</option>
                                            <option value="RR" <?=$estadoCad == 'RR' ? 'selected="selected"' : '';?>>RR</option>
                                            <option value="SC" <?=$estadoCad == 'SC' ? 'selected="selected"' : '';?>>SC</option>
                                            <option value="SE" <?=$estadoCad == 'SE' ? 'selected="selected"' : '';?>>SE</option>
                                            <option value="SP" <?=$estadoCad == 'SP' ? 'selected="selected"' : '';?>>SP</option>
                                            <option value="TO" <?=$estadoCad == 'TO' ? 'selected="selected"' : '';?>>TO</option>
                                        </select>
                                    </div>
                                
                                </div> 
                                <div class="inputbloco">
                                	<hr width="80%" style="border: 1px solid rgb(167, 167, 167)" />
                                	<div class="inputbloco">
                                    	<input style="margin-top:11px;" type="checkbox" name="termosUso" id="termosUso" title="Aceito termos de uso" />
                                        <label style="margin-top: 6px; text-align: left ! important; width: 280px; padding-left: 10px;" for="termosUso">
                                        	Estou ciente e de acordo com os <a class="termos" href="http://<?=PROJECT_URL;?>/arquivos/documentos/termos-de-uso.pdf" target="_blank">Termos de Uso</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="inputbloco">
                                    <label for="valorEntradaVeiculo">&nbsp;</label>
                                    <span style="margin-left:153px" class="anunciolegenda">* Campos obrigatórios</span>
                                </div>
                                
                                <div style="margin-right:5px" class="identenviar">
                                    <input tabindex="18" type="submit" name="enviarCadastroNovo" id="enviarCadastroNovo" title="Cadastrar" value="Cadastrar" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>