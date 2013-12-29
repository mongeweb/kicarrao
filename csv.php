<?php
require_once 'configRoot.php';
if($restrita == 1)
{
    $codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : 0;
    $conexao = conexao();
    $q = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '$codCliente'");
    $n = mysql_num_rows($q);
    $csv = "CODIGO;TIPO-DE-VEICULO;PLACA;ANO-FABRICACAO;ANO-MODELO;COR;COMBUSTIVEL;KM;NUMERO-DE-PORTAS;VALOR;NUMERO-DE-PARCELAS;VALOR-DA-PARCELA;VALOR-DA-ENTRADA;CARACTERISTICAS\n";
    $pasta = PROJECT_PATH."csv".DIRECTORY_SEPARATOR;
    $arquivo = "importacao-anuncios.csv";
    if($n > 0)
    {
        while($tp = mysql_fetch_assoc($q))
        {
            $csv .= "{$tp['codigo']};{$tp['tipoVeiculo']};{$tp['placa']};{$tp['anoFabricacao']};{$tp['anoModelo']};{$tp['cor']};".((int)$tp['combustivel']==0 ? 1 : (int)$tp['combustivel']).";{$tp['km']};{$tp['nPortas']};{$tp['valor']};{$tp['nParcelas']};{$tp['valorParcela']};{$tp['valorEntrada']};{$tp['caractVeiculo']}\n";
        }
    }
    mysql_close();
    header("Content-Type: text/csv" );
    header("Content-Disposition: attachment; filename=\"" . basename($arquivo) . "\";" );
    echo $csv;
    die();
}
else
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL."/home" : sslRedir().PROJECT_URL."/home.php";
    header("Location: $link");
    die();
}

?>
