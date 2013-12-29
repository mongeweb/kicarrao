<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    require_once ADMIN_FUNC_PATH . 'verifica.php';
    require_once ADMIN_FUNC_PATH . 'validaCampo.php';
    if($restrita == 1)
    {
        $tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : 1;
        if($tipoAnuncio == '2')
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-planos-revenda' : sslRedir().PROJECT_URL.'/anuncio-planos-revenda.php';
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
    $codTipoVeiculo = isset($_POST['tipoPlanoRevendaNova']) ? $_POST['tipoPlanoRevendaNova'] : '';
    $dataCadastro = date('Y-m-d');
    $md5 = new md5();
	
    $email = isset($_POST['emailUsuarioNovo']) ? $_POST['emailUsuarioNovo'] : '';
    $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '' ;
    $foneRevenda = isset($_POST['foneRevenda']) ? $_POST['foneRevenda'] : '' ;
    $senha = isset($_POST['senhaUsuarioNovo']) ? $_POST['senhaUsuarioNovo'] : '' ;
    $confsenha = isset($_POST['confirmarSenhaUsuarioNovo']) ? $_POST['confirmarSenhaUsuarioNovo'] : '' ;
    $senhacript = $md5->code($senha);
    
    $msg = '<ul>';
    $erro = 0;
	
	if (validaCampo($_POST['tipoPlanoRevendaNova'],'', false) == 0) 
	{
		$msg .= '<li>O campo Tipo de Plano deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
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
    if (validaCampo($_POST['foneRevenda'],'', false) == 0) 
	{
		$msg .= '<li>O campo Telefone deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
    if (validaCampo($_POST['cnpj'], '', false) == 0) 
	{
		$msg .= '<li>O campo CNPJ deve ser preenchido corretamente!</li>';
		$erro = 1;
	}
	$msg .= '</ul>';
		
	if ($erro == 0)
	{
        $sqlFiltro = "SELECT email FROM clientes WHERE email = '$email'";
		$queryFiltro = mysql_query($sqlFiltro);
		$linhasFiltro = mysql_num_rows($queryFiltro);
        
        $sqlFiltro2 = mysql_query("SELECT documento FROM clientes WHERE documento = '$cnpj'");
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
				$('#cnpj').focus();
			
			});
			</script>
		  <?php
		}
        else
        {            
            $_SESSION['cnpjRevenda'] = $cnpj;
            $_SESSION['emailRevenda'] = $email;
            $_SESSION['senhacript'] = $senhacript;
            $_SESSION['codTipoVeiculo'] = $codTipoVeiculo;
            $_SESSION['foneRevenda'] = $foneRevenda;
            $codigoDeArea = explode(" ",$foneRevenda);
            $codigoDeArea = str_replace("(","",$codigoDeArea[0]);
            $codigoDeArea = str_replace(")","",$codigoDeArea);
            $_SESSION['codigoDeArea'] = $codigoDeArea;
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-planos-revenda' : sslRedir().PROJECT_URL.'/anuncio-planos-revenda.php';
            printf("<script type='text/javascript'>
                        document . location . replace('%s');
                    </script>", $link);
            exit();
        }
    }
    mysql_close();
}
?>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("a.esqueci").click(function(){
            $("div.esquecibloco").show();
        })
        
        $("div.esquecifechar").click(function(){
            $("div.esquecibloco").hide();
        })
        
        objValidadorCadastro = new xform('#usuarioCadastrado');
        objValidadorCadastro . adicionar('#emailUsuario','email');
    	objValidadorCadastro . adicionar('#senhaUsuario');
        
        objValidadorCadastro = new xform('#revendaNova',{
        	   callbackTrue:function(){
                   var termos = $("input#termosUso[type='checkbox']").attr("checked");
                    if(termos != "checked"){ 
                        alert('Você precisa aceitar os termos de uso para completar o cadastro.');
                        return false;
                    }
                   return true;
        	   }
            });
        objValidadorCadastro . adicionar('#tipoPlanoRevendaNova');
        objValidadorCadastro . adicionar('#emailUsuarioNovo');
        objValidadorCadastro . adicionar('#foneRevenda', 'fone5');
        objValidadorCadastro . adicionar('#cnpj');
		$('input#cnpj').mask('99.999.999/9999-99');
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
                    <div class="anunciedadosbloco">
                        <div class="identform identesq">
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/login' : sslRedir().PROJECT_URL.'/login.php';
                        ?>
                            <form name="usuarioCadastrado" id="usuarioCadastrado" method="post" action="<?=$link;?>" enctype="multipart/form-data">
                                <p class="formtitulo">Já sou uma Revenda cadastrada</p>
                                <p class="formtexto">Se você já possui cadastro, insira seu login e senha.</p>
                                
                                <div class="inputbloco">
                                    <label for="emailUsuario">E-mail <span class="obrigatorio">*</span></label>
                                    <input type="text" tabindex="1" class="inputgrande" name="emailUsuario" id="emailUsuario" title="E-mail" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="senhaUsuario">Senha <span class="obrigatorio">*</span></label>
                                    <input type="password" tabindex="2" class="inputgrande" name="senhaUsuario" id="senhaUsuario" title="Senha" />
                                </div>
                                <div class="inputbloco">
                                    <span class="anunciolegenda">* Campos obrigatórios</span>
                                    <a class="esqueci">Esqueci minha senha</a>
                                </div>
                                <input type="hidden" name="tipoLogin" id="tipoLogin" value="3" />
                                <div class="identenviar">
                                    <input tabindex="3" type="submit" name="enviarCadastrado" id="enviarCadastrado" title="Login" value="Login" />
                                </div>
                            </form>
                            <div class="esquecibloco">
                                <div class="esqueciblocoborda">
                                    <div class="esquecifechar"><img src="<?=ssl().PROJECT_URL;?>/img/esquecifechar.png" alt="Fechar" /></div>
                                    <?
                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/recuperarsenha' : sslRedir().PROJECT_URL.'/home.php';
                                    ?>
                                    <form name="esqueciSenha" id="esqueciSenha" action="<?=$link;?>" method="post" enctype="multipart/form-data">
                                        <p class="esquecititulo">Esqueci minha senha</p>
                                        <label for="emailEsqueciSenha">E-mail</label>
                                        <input type="text" name="emailEsqueciSenha" id="emailEsqueciSenha" title="E-mail" />
                                        <input type="submit" name="enviarEsqueciSenha" id="enviarEsqueciSenha" title="Enviar" value="&nbsp;" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="identform identdir">
                            <form name="revendaNova" id="revendaNova" method="post" action="" enctype="multipart/form-data">
                                <p class="formtitulo">Criar cadastro para minha Revenda</p>
                                <p class="formtexto">Faça seu cadastro para anunciar no site.</p>
                                <div class="inputbloco">
                                    <label for="">E-mail <span class="obrigatorio">*</span></label>
                                    <input tabindex="4" type="text" class="inputgrande" name="emailUsuarioNovo" id="emailUsuarioNovo" title="E-mail" value="" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="foneRevenda">Telefone <span class="obrigatorio">*</span></label>
                                    <input tabindex="8" type="text" class="inputpequeno" name="foneRevenda" id="foneRevenda" title="Telefone" value="<?=$foneRevenda;?>" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="">CNPJ <span class="obrigatorio">*</span></label>
                                    <input tabindex="5" type="text" class="inputgrande" name="cnpj" id="cnpj" title="CNPJ" value="" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="">Senha <span class="obrigatorio">*</span></label>
                                    <input tabindex="6" type="password" class="inputgrande" name="senhaUsuarioNovo" id="senhaUsuarioNovo" title="Senha" value="" />
                                </div>
                                
                                <div class="inputbloco">
                                    <label for="" class="composto">Confirmar Senha <span class="obrigatorio">*</span></label>
                                    <input tabindex="7" type="password" class="inputgrande" name="confirmarSenhaUsuarioNovo" id="confirmarSenhaUsuarioNovo" title="Confirmar Senha" value="" />
                                </div>
                                <?=$msg;?>
                                <p class="formrevtitulo">Planos para Revendas</p>
                                <p class="formrevtexto"><label for="tipoPlanoRevendaNova">Escolha o tipo de Revenda:</label></p>
                                <div class="inputbloco">
                                    <select tabindex="9" class="selectmaior" name="tipoPlanoRevendaNova" id="tipoPlanoRevendaNova" title="Estado">
                                        <option value="">-</option>
                                        <option value="1">
                                            Revenda de Carros
                                        </option>
                                        <option value="2">
                                            Revenda de Motos
                                        </option>
                                        <option value="3">
                                            Revenda de Caminhões
                                        </option>
                                        <option value="4">
                                            Revenda Náutica
                                        </option>
                                       <? /*<option value="5">
                                            Outros
                                        </option> */?>
                                    </select>
                                </div>
                                <div class="inputbloco">
                                	<label style="width:92px; margin-bottom:-12px" for="termos">Termos de uso:</label>
                                </div>
                                <div class="inputbloco">
                                    <input style="margin-top:11px;" type="checkbox" name="termosUso" id="termosUso" title="Aceito termos de uso" />
                                    <label style="margin-top: 6px; text-align: left ! important; width: 280px; padding-left: 10px;" for="termosUso">
                                        Estou ciente e de acordo com os <a class="termos" href="http://<?=PROJECT_URL;?>/arquivos/documentos/termos-de-uso.pdf" target="_blank">Termos de Uso</a>
                                    </label>
                                </div>
                                <div class="identrevendaenviar">
                                    <input tabindex="10" type="submit" name="enviarCadastroNovo" id="enviarCadastroNovo" title="ESCOLHA SEU PLANO" value="ESCOLHA SEU PLANO" />
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