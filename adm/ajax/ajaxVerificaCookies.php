<?php
require_once '../../configRoot.php';
require_once ADMIN_FUNC_PATH.'conexao.php';
require_once PROJECT_FUNC_PATH.'funcoes.php';
$conexao = conexao();
$dataHoje = date('Y-m-d');
$numeroDeCookiesArray = array();
$cookirFav = isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '' ? unserialize($_COOKIE['favoritos']) : array();
$numCookies = count($cookirFav);
foreach ($cookirFav as $key => $value)
{
    $sqlVerificaCookie = mysql_query("SELECT ca.cod, c.tipoAnuncio, ca.dataLiberacaoAnuncio, ca.dataValidadeAnuncio FROM clientesAnuncios AS ca 
                                      INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                      WHERE ca.cod = '{$value}' AND ca.status = 1 AND c.situacao = 1");
    $numVerificaCookie = mysql_num_rows($sqlVerificaCookie);
    
    if($numVerificaCookie == 0)
    {
        $numCookies = $numCookies - 1;
        $cookirFavNovo = unserialize($_COOKIE['favoritos']);
        $position = array_search($value,$cookirFavNovo);
        unset($cookirFavNovo[$position]);
        $cookirFavNovo = serialize($cookirFavNovo);
        setcookie('favoritos', $cookirFavNovo, time()+(60*60*24*30), '/', 'kicarrao.com.br');
    }
    else
    {
        $tpVerificaCookie = mysql_fetch_assoc($sqlVerificaCookie);
        if($tpVerificaCookie['tipoAnuncio'] == 1)
        {
            if(!($dataHoje >= $tpVerificaCookie['dataLiberacaoAnuncio']) || !($dataHoje < $tpVerificaCookie['dataValidadeAnuncio']))
            {
                $numCookies = $numCookies - 1;
                $cookirFavNovo = unserialize($_COOKIE['favoritos']);
                $position = array_search($value,$cookirFavNovo);
                unset($cookirFavNovo[$position]);
                $cookirFavNovo = serialize($cookirFavNovo);
                setcookie('favoritos', $cookirFavNovo, time()+(60*60*24*30), '/', 'kicarrao.com.br');
            }
        }
    }
}
$numeroDeCookiesArray['retorno'] = $numCookies;
echo json_encode($numeroDeCookiesArray);
mysql_close();
?>