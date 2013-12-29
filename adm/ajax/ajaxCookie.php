<?php
$codFavorito = isset($_POST['codFavorito']) ? (int)$_POST['codFavorito'] : '';
$marca = isset($_POST['marca']) ? $_POST['marca'] : '';
if(isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '')
{
    if($marca == '1')
    {
        $cookirFav = unserialize($_COOKIE['favoritos']);
        if(!in_array($codFavorito,$cookirFav))
        {
            $cookirFav[] = $codFavorito;
            $cookirFav = serialize($cookirFav);
            setcookie('favoritos', $cookirFav, time()+(60*60*24*30), '/', 'kicarrao.com.br');
        }
    }
    else
    {
        $cookirFav = unserialize($_COOKIE['favoritos']);
        $position = array_search($codFavorito,$cookirFav);
        unset($cookirFav[$position]);
        $cookirFav = serialize($cookirFav);
        setcookie('favoritos', $cookirFav, time()+(60*60*24*30), '/', 'kicarrao.com.br');
    }
}
else
{
    $favorito = array();
    $favorito[] = $codFavorito;
    $favorito = serialize($favorito);
    setcookie('favoritos', $favorito, time()+(60*60*24*30), '/', 'kicarrao.com.br');
}
$retorno = $_COOKIE['favoritos'];
echo json_encode($retorno);
?>