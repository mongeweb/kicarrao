<?
require_once 'configRoot.php';
require_once ADMIN_FUNC_PATH . 'verifica.php';
$emailEsq = isset($_POST['emailEsqueciSenha']) ? $_POST['emailEsqueciSenha'] : '';

if(!empty($_POST['enviarEsqueciSenha']))
{
	$md5 = new md5();
	$conexao = conexao();
    $sqlEmailEsq = mysql_query("SELECT * FROM clientes WHERE email = '{$emailEsq}'");
	$linhasEmailEsq = mysql_num_rows($sqlEmailEsq);
	$tpEmailEsq = mysql_fetch_assoc($sqlEmailEsq);
    mysql_close();
	$senhaEsq = $md5->decode($tpEmailEsq['senha']);
	$nome = $tpEmailEsq['razaoSocialNome'];
	if($linhasEmailEsq > 0)
	{
		require_once PROJECT_FUNC_PATH . 'esqueciSenha.php';
		
    	$nomeRemetente = "Kicarrão";
    	$assunto = "Kicarrão - Recuperação de Senha";
    	$emailDestinatario = array($emailEsq);
    	$emailRemetente = 'noreply@kicarrao.com.br';
        $emailResposta  = 'noreply@kicarrao.com.br';
        $conteudoEmail = array(
            'usuario'    => $emailEsq,
            'nome'    => $nome,
            'senha'      => $senhaEsq
        );
        $twitter = '';
        $facebook = 'kicarrao';
    
        $conf = recuperarSenha($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);
	
		if($conf)
		{
				$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
                echo "<script type='text/javascript'>
						alert('Sua senha foi enviada com sucesso, para o email ".$emailEsq."');
						location.replace('".$link."');
					  </script>";
					  die(); 
		}
		else
		{
				$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
                echo "<script type='text/javascript'>
					   alert(\"Erro ao enviar email, tente novamente mais tarde\");
					   location.replace('".$link."');
					 </script> \n";
					 die();
		}
			
	}
	else
	{
		$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
        echo "<script type='text/javascript'>
				   alert(\"Email n\u00E3o cadastrado!\");
				   location.replace('".$link."');
				 </script> \n";
				 die();
		
	}
}	