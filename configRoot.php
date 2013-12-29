<?php
session_start();
if($_SERVER['REMOTE_ADDR'] != "177.97.93.251")
    //header("Location: http://www.kicarrao.com.br/index-manutencao.htm");
/** Define o desenvolvedor do projeto **/
define('PROJECT_DEV_NOME', 'Monge Web+Design');
define('PROJECT_DEV_SITE', 'www.monge.com.br');
define('PROJECT_DEV_EMAIL', 'artur@monge.com.br');

/** Define as configurações para LOCALWEB **/
date_default_timezone_set('America/Sao_Paulo'); // Etc/GMT-3
setlocale(LC_ALL, 'pt_BR');
setlocale(LC_NUMERIC, 'en_US'); // setting the numeric locale to
setlocale(LC_MONETARY, 'en_US'); // setting the monetary locale to

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'kO9cRfGrMs');
define('BD', 'kicarrao');

/** define se esconde os erros do navegadorr **/
if (!defined('PROJECT_DEBUG')) {
    define('PROJECT_DEBUG', false);
}

/** Domínio com WWW **/
if (!defined('SERVER_NAME')) {
    //define('SERVER_NAME', 'clarissimatemp.web695.uni5.net');
    define('SERVER_NAME', 'kicarrao.jelasticlw.com.br');
}

/** define o email de contato **/
if (!defined('PROJECT_EMAIL')) {
    define('PROJECT_EMAIL', 'artur@monge.com.br');
}

/** define o título curto do projeto. **/
if (!defined('PROJECT_SHORT_TITLE')) {
    define('PROJECT_SHORT_TITLE', '');
}

/** define o título do projeto. **/
if (!defined('PROJECT_TITLE')) {
    define('PROJECT_TITLE', ' ');
}

/** URL do diretório raiz do projeto. **/
if (!defined('PROJECT_URL')) {
    define('PROJECT_URL', SERVER_NAME);
}

/** Caminho absoluto do diretório raiz do projeto. **/
if (!defined('PROJECT_PATH')) {
    define('PROJECT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}



/** URL do arquivo principal do projeto. **/
if (!defined('INDEX_URL')) {
    define('INDEX_URL', PROJECT_URL . '/home');
}

/** Caminho absoluto do arquivo principal do projeto. **/
if (!defined('INDEX_PATH')) {
    define('INDEX_PATH', PROJECT_PATH . 'home.php');
}

/** URL do diretório de estilos do projeto. */
if (!defined('PROJECT_CSS_URL')) {
    define('PROJECT_CSS_URL', PROJECT_URL . '/css');
}

/** Caminho absoluto do diretório de estilos do projeto. */
if (!defined('PROJECT_CSS_PATH')) {
    define('PROJECT_CSS_PATH', PROJECT_PATH . 'css' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de estilos do funções do projeto. */
if (!defined('PROJECT_FUNC_URL')) {
    define('PROJECT_FUNC_URL', PROJECT_URL . '/func');
}

/** Caminho absoluto do diretório de funções do projeto. */
if (!defined('PROJECT_FUNC_PATH')) {
    define('PROJECT_FUNC_PATH', PROJECT_PATH . 'func' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de imagens do projeto. */
if (!defined('PROJECT_IMG_URL')) {
    define('PROJECT_IMG_URL', PROJECT_URL . '/img');
}

/** Caminho absoluto do diretório de imagens do projeto. */
if (!defined('PROJECT_IMG_PATH')) {
    define('PROJECT_IMG_PATH', PROJECT_PATH . 'img' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de includes do projeto. */
if (!defined('PROJECT_INC_URL')) {
    define('PROJECT_INC_URL', PROJECT_URL . '/inc');
}

/** Caminho absoluto do diretório de includes do projeto. */
if (!defined('PROJECT_INC_PATH')) {
    define('PROJECT_INC_PATH', PROJECT_PATH . 'inc' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de scripts javascript do projeto. */
if (!defined('PROJECT_JS_URL')) {
    define('PROJECT_JS_URL', PROJECT_URL . '/js');
}

/** Caminho absoluto do diretório de scripts javascript do projeto. */
if (!defined('PROJECT_JS_PATH')) {
    define('PROJECT_JS_PATH', PROJECT_PATH . 'js' . DIRECTORY_SEPARATOR);
}

/** URL do arquivo temporário quando o banco está fora. */
if (!defined('PROJECT_OUT_URL')) {
    define('PROJECT_OUT_URL', PROJECT_URL . '/out.php');
}

/** Caminho absoluto do arquivo temporário quando o banco está fora. */
if (!defined('PROJECT_OUT_PATH')) {
    define('PROJECT_OUT_PATH', PROJECT_PATH . 'out.php');
}

/** URL do diretório de scripts flash do projeto. */
if (!defined('PROJECT_SWF_URL')) {
    define('PROJECT_SWF_URL', PROJECT_URL . '/swf');
}

/** Caminho absoluto do diretório de scripts flash do projeto. */
if (!defined('PROJECT_SWF_PATH')) {
    define('PROJECT_SWF_PATH', PROJECT_PATH . 'swf' . DIRECTORY_SEPARATOR);
}

if (!defined('PROJECT_TEMPLATE_URL')) {
    define('PROJECT_TEMPLATE_URL', PROJECT_URL . '/templates');
}

if (!defined('PROJECT_TEMPLATE_PATH')) {
    define('PROJECT_TEMPLATE_PATH', PROJECT_PATH . 'templates' . DIRECTORY_SEPARATOR);
}



$admin_project = isset($admin_project) ? $admin_project : '';
switch ($admin_project) {
    /* case 'modelo':
        require_once PROJECT_PATH . 'modelo' . DIRECTORY_SEPARATOR . 'config.php';
        break;*/

    case 'adm':
    default:
        require_once PROJECT_PATH . 'adm' . DIRECTORY_SEPARATOR . 'config.php';
}

try {
    include_once PROJECT_PATH . 'configModulos.php';
}
catch (exception $e) {
    die('Mensagem: configModulos.php');
}

error_reporting(E_ALL | E_STRICT);
if ($modulo['AdmDisplayErrors']['ativo'])
{
    /** modo desenvolvimento **/
    ini_set('display_errors', 'On');
    ini_set('log_errors', 'Off');
} else {
    /** modo produção **/
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', PROJECT_PATH . 'log.log');
}

//mod_rewrite Settings
$MG_MR_Settings = array(
    'active' => true,
    'pagUriIndex' => 0
);
//require_once "configFrete.php";
require_once PROJECT_FUNC_PATH."funcoes.php";
$restrita = isset($_SESSION['restrita']) ? $_SESSION['restrita'] : 0;
if($_SERVER['SERVER_NAME'] != SERVER_NAME)
{
    //redireciona
    header("Location: ".ssl().PROJECT_URL.(isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
    die();
}
require_once ADMIN_FUNC_PATH.'conexao.php';
$conexao = conexao();
$tipoPessoa = isset($_SESSION['tipoPessoa']) ? $_SESSION['tipoPessoa'] : 'f';
$_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'Pt';
?>