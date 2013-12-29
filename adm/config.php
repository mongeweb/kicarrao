<?php

/** Define o desenvolvedor da parte administrativa do projeto **/
define('ADMIN_DEV_NOME', 'Monge Web+Design');
define('ADMIN_DEV_SITE', 'www.monge.com.br');
define('ADMIN_DEV_EMAIL', 'programacao@monge.com.br');

/** Define as configurações para LOCALWEB **/
date_default_timezone_set('America/Sao_Paulo'); // Etc/GMT-3
//setlocale(LC_ALL, 'pt_BR');

/** define se esconde os erros do navegador **/
if (!defined('ADMIN_DEBUG')) {
    define('ADMIN_DEBUG', defined('PROJECT_DEBUG') && PROJECT_DEBUG ? PROJECT_DEBUG : false);
}

/** define se usa cookies */
if (!defined('ADMIN_COOK')) {
    define('ADMIN_COOK', false);
}

/** define o email do administrador **/
if (!defined('ADMIN_EMAIL')) {
    define('ADMIN_EMAIL', 'programacao@monge.com.br');
}

/** define o título curto da parte administrativa do projeto. **/
if (!defined('ADMIN_SHORT_TITLE')) {
    define('ADMIN_SHORT_TITLE', 'Monge Web+Design');
}

/** define o título da parte administrativa do projeto. **/
if (!defined('ADMIN_TITLE')) {
    define('ADMIN_TITLE', 'Kicarrão');
}

/** define o nome da sessão da parte administrativa do projeto. **/
if (!defined('ADMIN_SESSION_NAME')) {
    define('ADMIN_SESSION_NAME', 'kicarrao');
}

/** URL do diretório raiz do projeto. **/
if (!defined('PROJECT_URL')) {
    // SE NÃO ESTÁ DEFINIDA FICA NA RAIZ ADMINISTRATIVA

    /** URL da pasta da parte administrativa do projeto. **/
    if (!defined('ADMIN_URL')) {
        define('ADMIN_URL', SERVER_NAME . '/adm');
    }
    /** URL do diretório raiz do projeto. **/
    define('PROJECT_URL', ADMIN_URL);
} else {
    /** URL da pasta da parte administrativa do projeto. **/
    if (!defined('ADMIN_URL')) {
        define('ADMIN_URL', PROJECT_URL . '/adm');
    }
}

/** Caminho absoluto do diretório raiz do projeto. **/
if (!defined('PROJECT_PATH')) {
    // SE NÃO ESTÁ DEFINIDA FICA NA RAIZ ADMINISTRATIVA

    /** Caminho absoluto da pasta da parte administrativa do projeto. **/
    if (!defined('ADMIN_PATH')) {
        define('ADMIN_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    }
    /** Caminho absoluto do diretório raiz do projeto. **/
    define('PROJECT_PATH', ADMIN_PATH);
} else {
    /** Caminho absoluto da pasta da parte administrativa do projeto. **/
    if (!defined('ADMIN_PATH')) {
        define('ADMIN_PATH', PROJECT_PATH . 'adm' . DIRECTORY_SEPARATOR);
    }
}

/** URL do arquivo principal da parte administrativa do projeto depois de logado. **/
if (!defined('ADMIN_MAIN_URL')) {
    define('ADMIN_MAIN_URL', ADMIN_URL . '/principal.php');
}

/** Caminho absoluto do arquivo principal da parte administrativa do projeto depois de logado. **/
if (!defined('ADMIN_MAIN_PATH')) {
    define('ADMIN_MAIN_PATH', ADMIN_PATH . 'principal.php');
}

/** URL de login do projeto. **/
if (!defined('LOGIN_URL')) {
    define('LOGIN_URL', ADMIN_URL . '/index.php');
}

/** Caminho absoluto de login do projeto. */
if (!defined('LOGIN_PATH')) {
    define('LOGIN_PATH', ADMIN_PATH . 'index.php');
}

/** Caminho absoluto do diretório de classes do projeto. */
if (!defined('CLASS_PATH')) {
    define('CLASS_PATH', ADMIN_PATH . 'class' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de estilos do projeto. */
if (!defined('ADMIN_CSS_URL')) {
    define('ADMIN_CSS_URL', ADMIN_URL . '/css');
}

/** Caminho absoluto do diretório de estilos do projeto. */
if (!defined('ADMIN_CSS_PATH')) {
    define('ADMIN_CSS_PATH', ADMIN_PATH . DIRECTORY_SEPARATOR);
}

/** Caminho absoluto do diretório de funções do projeto. */
if (!defined('ADMIN_FUNC_PATH')) {
    define('ADMIN_FUNC_PATH', ADMIN_PATH . 'func' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de imagens do projeto. */
if (!defined('ADMIN_IMG_URL')) {
    define('ADMIN_IMG_URL', ADMIN_URL . '/img');
}

/** Caminho absoluto do diretório de imagens do projeto. */
if (!defined('ADMIN_IMG_PATH')) {
    define('ADMIN_IMG_PATH', ADMIN_PATH . 'img' . DIRECTORY_SEPARATOR);
}

/** Caminho absoluto do diretório de topos do projeto. */
if (!defined('ADMIN_INC_PATH')) {
    define('ADMIN_INC_PATH', ADMIN_PATH . 'inc' . DIRECTORY_SEPARATOR);
}

/** URL do diretório de scripts javascript do projeto. */
if (!defined('ADMIN_JS_URL')) {
    define('ADMIN_JS_URL', ADMIN_URL . '/js');
}

/** Caminho absoluto do diretório de scripts javascript do projeto. */
if (!defined('ADMIN_JS_PATH')) {
    define('ADMIN_JS_PATH', ADMIN_PATH . 'js' . DIRECTORY_SEPARATOR);
}

/** URL do arquivo temporário quando o banco está fora. */
if (!defined('ADMIN_OUT_URL')) {
    define('ADMIN_OUT_URL', ADMIN_URL . '/out.php');
}

/** Caminho absoluto do arquivo temporário quando o banco está fora. */
if (!defined('ADMIN_OUT_PATH')) {
    define('ADMIN_OUT_PATH', ADMIN_PATH . 'out.php');
}

/** URL absoluto do diretório de templates. */
if (!defined('ADMIN_TPL_URL')) {
    define('ADMIN_TPL_URL', ADMIN_URL . '/tpl/monge');
}

/** Caminho absoluto do diretório de templates. */
if (!defined('ADMIN_TPL_PATH')) {
    define('ADMIN_TPL_PATH', ADMIN_PATH . 'tpl' . DIRECTORY_SEPARATOR . 'monge' . DIRECTORY_SEPARATOR);
}

/** Caminho absoluto do diretório de topos do projeto. */
if (!defined('ADMIN_TOP_PATH')) {
    define('ADMIN_TOP_PATH', ADMIN_PATH . 'topos' . DIRECTORY_SEPARATOR);
}

if (is_dir(ADMIN_INC_PATH)) {
    // ** DEFINE AS CONSTANTES DE CONEXAO COM O BANCO DE DADOS ** //
    // ** DEFINE AS CONSTANTES DE CONEXAO COM O FTP ** //
    if (file_exists(ADMIN_INC_PATH . 'defineConnection.php')) {
        require_once ADMIN_INC_PATH . 'defineConnection.php';
    }
}
?>