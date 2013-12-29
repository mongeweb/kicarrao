<?
ini_set('session.cache_expire', 60);
ini_set('session.cookie_httponly', true);
ini_set('session.use_only_cookie', true);

// Se for tentado alguma SID, destruímos a sessão e geramos outra.
if(strpos(strtolower($_SERVER['REQUEST_URI']), 'phpsessid') !== false)
{
	session_destroy();
	session_start();
	session_regenerate_id();
}
$endereco = $_SERVER['QUERY_STRING'];
$pato = strip_tags($_SERVER['QUERY_STRING']);
if($endereco != $pato){
	session_destroy();
	redireciona1("index.php?erro=1");
	//echo "1";
    die();
}

if(!isset($_SESSION[ADMIN_SESSION_NAME.'_user']) || ($_SESSION[ADMIN_SESSION_NAME.'_user'] == ""))
{	
	session_destroy();
	redireciona1("index.php?erro=1");
	//echo "2";
    die();
}

if(!isset($_SESSION[ADMIN_SESSION_NAME.'_monge']) || ($_SESSION[ADMIN_SESSION_NAME.'_monge'] != date('d-m-Y')))
{
	session_destroy();
	redireciona1("index.php?erro=1");
	//echo "3";
    die();
}

require_once ADMIN_FUNC_PATH.'permissoes.php';
?>