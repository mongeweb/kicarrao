<?php
    require_once 'configRoot.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    
    <script type="text/javascript" src="js/validador1.4.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    
	<?php
    require_once 'func/enviarEmail.php';
    if(!empty($_POST['contatoEspEnviar']))
    {
		$nomeRemetente = "Kicarrão - Contato";
		$subject = 'Contato do site - Kicarrão';
	    $campos = array();
		$dados = array();
		
		$campos[] = 'Nome';
		$dados[] = isset($_REQUEST['contatoEspNome']) ? stripslashes($_REQUEST['contatoEspNome']) : '';
		$nome = isset($_REQUEST['contatoEspNome']) ? $_REQUEST['contatoEspNome'] : '';
		
		$campos[] = 'E-mail';
		$dados[] = isset($_REQUEST['contatoEspEmail']) ? stripslashes($_REQUEST['contatoEspEmail']) : '';
		$emailResposta  = isset($_REQUEST['contatoEspEmail']) ? $_REQUEST['contatoEspEmail'] : '';
		
		$campos[] = 'Telefone';
		$dados[] = isset($_REQUEST['contatoEspTelefone']) ? stripslashes($_REQUEST['contatoEspTelefone']) : '';
		
		$campos[] = 'Setor';
		$dados[] = isset($_REQUEST['contatoEspSetor']) ? stripslashes($_REQUEST['contatoEspSetor']) : '';
	
		$campos[] = 'Mensagem';
		$dados[] = isset($_REQUEST['contatoEspMensagem']) ? stripslashes(nl2br($_REQUEST['contatoEspMensagem'])) : '';
	
		$emailDestinatario = array('faleconosco@kicarrao.com.br'/*,'diego@monge.com.br','ammbalestro@gmail.com'*/);
		$emailRemetente = 'noreply@kicarrao.com.br';
		
		$conf = enviarEmail($nomeRemetente, $emailRemetente, $emailDestinatario, $emailResposta, $subject, $campos, $dados);
		
		if($conf)
		{
				echo "<script type='text/javascript'>
    					alert('".$nome.", sua mensagem foi enviada com sucesso!');
						location.replace('index.php');
					  </script>";
                      die(); 
		}
		else
		{
				echo "<script type='text/javascript'>
					   alert(\"Erro ao enviar contato, tente novamente mais tarde.\");
                       location.replace('index.php');
					 </script> \n";
                     die();
		}
	}
    ?>
</head>

<body class="espera">
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<div class="mestreespera">
	<div class="topoespera">
        <div class="topoinside">
            <div class="logo"><a href="#"><img src="img/logo.png" alt="Kicarrão" /></a></div>
        </div>
    </div>
    <div class="centroespera">
        <div class="centroesperainside">
            <p class="esperatitulo">
                O nosso website está em reformulação e voltará em breve.
                <br /><br />
                Para mais informações, envie-nos uma mensagem:
            </p>
            <div class="esperaesq">
                <form name="contatoEspera" id="contatoEspera" action="" method="post" enctype="multipart/form-data">
                    <label for="contatoEspNome">Nome</label>
                    <input type="text" name="contatoEspNome" id="contatoEspNome" title="Nome" />
                    
                    <label for="contatoEspEmail">E-mail</label>
                    <input type="text" name="contatoEspEmail" id="contatoEspEmail" title="E-mail" />
                    
                    <label for="contatoEspTelefone">Telefone</label>
                    <input type="text" name="contatoEspTelefone" id="contatoEspTelefone" title="Telefone" />
                    
                    <label for="contatoEspSetor">Setor</label>
                    <select name="contatoEspSetor" id="contatoEspSetor" title="Setor">
                        <option value="">Selecione</option>
                        <option value="Revendas">Revendas</option>
                        <option value="Serviços">Serviços</option>
                        <option value="Particulares">Particulares</option>
                    </select>
                    
                    <label for="contatoEspMensagem">Mensagem</label>
                    <textarea name="contatoEspMensagem" id="contatoEspMensagem" title="Mensagem"></textarea>
                    
                    <input type="submit" name="contatoEspEnviar" id="contatoEspEnviar" title="Enviar" value="Enviar" />
                </form>
            </div>
            <script type="text/javascript">
						//<![CDATA[
							objValidadorCadastro = new xform('#contatoEspera');
							objValidadorCadastro . adicionar('#contatoEspNome', 'nome');
							objValidadorCadastro . adicionar('#contatoEspEmail', 'email');
							objValidadorCadastro . adicionar('#contatoEspTelefone','fone5');
							objValidadorCadastro . adicionar('#contatoEspSetor');
							objValidadorCadastro . adicionar('#contatoEspMensagem');
						//]]>
					</script>
            <div class="esperadir">
                <p>
                    Ou entre em contato pelos telefones:<br />
                    <span>(51) 8480.2943 | (51) 3084.7230</span><br />
                    <br />
                    E pelo e-mail:<br />
                    <span>faleconosco@kicarrao.com.br</span>
                </p>
                <div class="fb-like" data-href="https://www.facebook.com/kicarrao" data-send="true" data-width="290" data-show-faces="true" data-colorscheme="dark"></div>
            </div> 
        </div>
    </div>
    <div class="rodapebloco">
        <div class="rodapeespera">
            <div class="rodapeinside">
                <div class="copyright">© 2013 Kicarrão - <a href="http://www.monge.com.br" target="_blank">Monge Web + Design</a>.</div>
                <div class="rodapelogo"><a href="#"><img src="img/logofooter.png" alt="Kicarrão" /></a></div>
            </div>
        </div>
    </div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40864118-1', 'kicarrao.com.br');
  ga('send', 'pageview');

</script>
</body>
</html>