<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    <?php
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    if(!empty($_POST['enviarContato']))
    {
        $captcha = isset($_SESSION['captchaDetalhe']) ? $_SESSION['captchaDetalhe'] : '';    
        if (trim($_POST['captcha']) == $captcha)
        {
    		$nomeRemetente = "KiCarrão";
    		$subject = 'Fale Conosco - KiCarrão';
    	    $campos = array();
    		$dados = array();
    		$campos[] = 'Nome';
    		$dados[] = isset($_REQUEST['nomeContato']) ? stripslashes($_REQUEST['nomeContato']) : '';
    		$nome = isset($_REQUEST['nomeContato']) ? $_REQUEST['nomeContato'] : '';
    		
            $campos[] = 'Telefone';
    		$dados[] = isset($_REQUEST['telefoneContato']) ? $_REQUEST['telefoneContato'] : '';
            
    		$campos[] = 'E-mail';
    		$dados[] = isset($_REQUEST['emailContato']) ? stripslashes($_REQUEST['emailContato']) : '';
    		$emailResposta  = isset($_REQUEST['emailContato']) ? $_REQUEST['emailContato'] : '';
    		
    		$campos[] = 'Setor';
    		$dados[] = isset($_REQUEST['setorContato']) ? $_REQUEST['setorContato'] : '';
    		
    		$campos[] = 'Mensagem';
    		$dados[] = isset($_REQUEST['mensagemContato']) ? stripslashes(nl2br($_REQUEST['mensagemContato'])) : '';
    	
    		$emailDestinatario = array('faleconosco@kicarrao.com.br'/*'artur@monge.com.br'*/);
    		$emailRemetente = 'noreply@kicarrao.com.br';
    		
    		$conf = enviarEmail($nomeRemetente, $emailRemetente, $emailDestinatario, $emailResposta, $subject, $campos, $dados);
    		$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/fale-conosco' : sslRedir().PROJECT_URL.'/fale-conosco.php';
    		if($conf)
    		{
				echo "<script type='text/javascript'>
    					alert('".$nome.", sua mensagem foi enviada com sucesso!');
						location.replace('".$link."');
					  </script>";
                      die(); 
    		}
    		else
    		{
				echo "<script type='text/javascript'>
					   alert(\"Erro ao enviar contato, tente novamente mais tarde.\");
                       location.replace('".$link."');
					 </script> \n";
                     die();
    		}
        }else{
            //$msg_erro .= 'Captcha';
            ?>
            <script>
                alert("Código de ativação incorreto! Tente novamente.");
                //location.replace ('contato.php');
            </script>
            <?php
        }
	}
	?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
</head>

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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Fale Conosco</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="fipebanner">
                    <?php
                    imprimeBannerSuperFaleConosco();
                    ?>
                </div>
                <div class="fipebloco">
                    <div class="contatoleft">
                        <form name="contatoForm" id="contatoForm" method="post" action="" enctype="multipart/form-data">
                            <div class="inputbloco">
                                <label for="nomeContato">Nome</label>
                                <input type="text" class="inputgrande" name="nomeContato" id="nomeContato" title="Nome" />
                            </div>
                            <div class="inputbloco">
                                <label for="telefoneContato">Telefone</label>
                                <input type="text" class="inputgrande" name="telefoneContato" id="telefoneContato" title="Telefone" />
                            </div>
                            <div class="inputbloco">
                                <label for="emailContato">E-mail</label>
                                <input type="text" class="inputgrande" name="emailContato" id="emailContato" title="E-mail" />
                            </div>
                            <div class="inputbloco">
                                <label for="setorContato">Setor</label>
                                <select class="selectgrande" name="setorContato" id="setorContato" title="Setor">                         
                                    <option value="">Escolha o Setor</option>
                                    <option value="Financeiro">Financeiro</option>
                                    <option value="Ouvidoria">Ouvidoria</option>
                                    <option value="SuporteLojista">Suporte ao Lojista</option>
                                    <option value="SuporteParticular">Suporte ao Particular</option>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="mensagemContato">Mensagem</label>
                                <textarea name="mensagemContato" id="mensagemContato" title="Mensagem"></textarea>
                            </div>
                            <div class="inputbloco">
                                <label for="captcha">&nbsp;</label>
                                <label for="captcha" style="width: auto;">Preencha o código de ativação abaixo:</label><br class="clear" />
                            </div>
                            <div class="inputbloco">
                                <label for="captcha">&nbsp;</label>
                                <img style="float: left;" src="<?=ssl().PROJECT_URL;?>/captcha.php" alt="" />
                                <input class="captcha" title="Código de Ativação" name="captcha" type="text" id="captcha" size="20" maxlength="8" />
                            </div>
                            
                            <div class="faleconoscosubmit">
                                <input type="submit" value="&nbsp;" title="Enviar" id="enviarContato" name="enviarContato" />
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript">
						//<![CDATA[
							objValidadorCadastro = new xform('#contatoForm');
							objValidadorCadastro . adicionar('#nomeContato', 'nome');
							objValidadorCadastro . adicionar('#telefoneContato','fone5');
                            objValidadorCadastro . adicionar('#emailContato', 'email');
							objValidadorCadastro . adicionar('#setorContato');
							objValidadorCadastro . adicionar('#mensagemContato');
                            objValidadorCadastro . adicionar('#captcha');
						//]]>
					</script>
                    <!--<div class="contatoright">
                        <p>
                            <b>Lorem ipsum dolor sit amet</b><br />
Consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nib.
                        </p>
                    </div>-->
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralFaleConosco();
                    imprimeBannerLateralPequenoFaleConosco();
                    ?>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>