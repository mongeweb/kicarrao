<?php
require_once 'configRoot.php';
require_once ADMIN_FUNC_PATH . 'verifica.php';

$md5 = new md5();
$usuario =  isset($_POST['emailUsuario']) ? $_POST['emailUsuario'] : '';
$senha =  isset($_POST['senhaUsuario']) ? $_POST['senhaUsuario'] : '';
$tipoLogin = isset($_POST['tipoLogin']) ? $_POST['tipoLogin'] : '';
$conexao = conexao();
$queryLogin = mysql_query("SELECT * FROM clientes WHERE email = '$usuario' LIMIT 1");
$linhas = mysql_num_rows($queryLogin);

if($linhas > 0)
{
    $tup = mysql_fetch_assoc($queryLogin);
    $senhadec = $md5->decode($tup['senha']);
    if($senhadec == $senha)
    {
        $restrita = 1;
        $_SESSION['restrita'] = $restrita;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['codCliente'] = $tup['cod'];
        $_SESSION['tipoAnuncio'] = $tup['tipoAnuncio'];
        $_SESSION['nome'] = $tup['razaoSocialNome'];
        $_SESSION['codPlanoRevenda'] = $tup['codPlanoRevenda'];
        $_SESSION['tipoRevenda'] = $tup['tipoRevenda'];
        
        unset($_SESSION['tipoLogin']);
		if($tipoLogin == 2)
		{
			$codAnuncio = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : '';
            if($_SESSION['tipoAnuncio'] == '1')
            {
				$codCliente = $_SESSION['codCliente'];
                $sqlAnuncio = "UPDATE clientesAnuncios SET
                                codCliente = '{$codCliente}'
                                WHERE cod = '{$codAnuncio}'";
				$queryAnuncio = mysql_query($sqlAnuncio);
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos-dev' : sslRedir().PROJECT_URL.'/anuncio-fotos-dev.php';
                printf("<script type='text/javascript'>
    						document . location . replace('%s');
    					</script>", $link);
		    }
            else
            {
                $apagaAnuncio = mysql_query("DELETE FROM clientesAnuncios WHERE cod = '{$codAnuncio}'");
                unset($_SESSION['id_anuncio']);
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
    			printf("<script type='text/javascript'>
                    alert('Revendedor!');
                </script>");
                printf("<script type='text/javascript'>
    						document.location.replace('".$link."');
    					</script>");
            }
        }
        else if($tipoLogin == 4){
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-finalizacao-revenda' : sslRedir().PROJECT_URL.'/anuncio-finalizacao-revenda.php';		  
			echo "<script type='text/javascript'>
                   location.replace('".$link."');
				 </script> \n";
        }
		else
		{
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
			printf("<script type='text/javascript'>
						document.location.replace('".$link."');
					</script>");	
		}
        exit();
    }
    else
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
        $_SESSION['restrita'] = 0;
        printf("<script type='text/javascript'>
                    alert('Senha inválida!');
                </script>");
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        exit();
    }
}
elseif ($linhas < 1)
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
    $_SESSION['restrita'] = 0;
    printf("<script type='text/javascript'>
                alert('Usuário não cadastrado!');
            </script>");
    printf("<script type='text/javascript'>
                document . location . replace('%s');
            </script>", $link);
    exit();
}
mysql_close();
?>
