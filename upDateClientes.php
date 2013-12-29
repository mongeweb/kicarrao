<?php
require_once 'configRoot.php';
require_once ADMIN_FUNC_PATH."formatting.php";
$conexao = conexao();

$sql = mysql_query("SELECT * FROM clientes WHERE tipoAnuncio = '2' AND situacao = '1'");
$num = mysql_num_rows($sql);
for($x = 0;$x < $num;$x++)
{
    $tp = mysql_fetch_assoc($sql);
    $cleanTitulo = mg_substituirEspacosPorTreacos($tp['nomeFantasia']);
    $up = "UPDATE clientes SET cleanTitulo = '{$cleanTitulo}' WHERE cod = '{$tp['cod']}'"; 
    for($y = 0;$y < 5;$y++)
    {
        $date = mysql_query($up);
        if($date)
        {
            echo "OK<br />";
            break;   
        }
        else
        {
            echo "Erro <br />";
        }
    }
}
?>