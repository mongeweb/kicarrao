<?php
if(!verifica_permissao($cod_user, $nivel_user, 'clientes'))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH."clientesAnuncios_topo.php";
$cod = isset($_GET['cod']) ? $_GET['cod'] : '';
       
$sqlAnuncios = mysql_query("SELECT * FROM clientesAnuncios WHERE cod = '$cod'");
$tpAnuncios = mysql_fetch_assoc($sqlAnuncios);

$cliente = $tpAnuncios['codCliente'];
$tipoVeiculo = $tpAnuncios['tipoVeiculo'];
$marca = $tpAnuncios['marca'];
$modelo = $tpAnuncios['modelo'];
$versao = $tpAnuncios['versao'];
$placa = $tpAnuncios['placa'];
$anoFabricacao = $tpAnuncios['anoFabricacao'];
$anoModelo = $tpAnuncios['anoModelo'];
$cor = $tpAnuncios['cor'];
$combustivel = $tpAnuncios['combustivel'];
$km = $tpAnuncios['km'];
$nPortas = $tpAnuncios['nPortas'];
$valor = $tpAnuncios['valor'];
$nParcelas = $tpAnuncios['nParcelas'];
$valorParcela = $tpAnuncios['valorParcela'];
$valorEntrada = $tpAnuncios['valorEntrada'];
$caractVeiculo = $tpAnuncios['caractVeiculo'];
$dataValidadeAnuncio = dataBr($tpAnuncios['dataValidadeAnuncio']);
$destaqueCapa = $tpAnuncios['destaqueHome'];
$destaqueLista = $tpAnuncios['destaqueLista'];
$nFotos = $tpAnuncios['nFotos'];
$video = $tpAnuncios['video'];
$linkVideo = $tpAnuncios['linkVideo'];
$mapa = $tpAnuncios['mapa'];
$linkMapa = $tpAnuncios['linkMapa'];
$plano = $tpAnuncios['plano'];

$sqlClientes = mysql_query("SELECT * FROM clientes WHERE cod = '$cliente'");
$tpClientes = mysql_fetch_assoc($sqlClientes);

$nomeCliente = $tpClientes['razaoSocialNome'];
$tipoAnuncio = $tpClientes['tipoAnuncio'];
$tipoRevenda = $tpClientes['tipoRevenda'];
?>
<div id="contentFormNovoEdita" style="width: 100%;">
    <form name="cadastro" id="cadastro" method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <legend>Visualizar Anúncio</legend>
        <div>
            <label for="cliente">Cliente: </label>
            <span><?=$nomeCliente;?></span>
        </div>
        <div>
            <label for="tipoVeiculo">Tipo de veiculo: </label>
                <?php
                	$qTipos = mysql_query("SELECT * FROM tipoVeiculo WHERE cod = '{$tipoVeiculo}'");
                    $nTipos = mysql_num_rows($qTipos);
                    if($nTipos > 0)
                    {
                        $tpTipos = mysql_fetch_assoc($qTipos);
                        echo "<span>".$tpTipos['tipoVeiculo']."</span>";
                	}
                    else
                    {
                        echo "<span> - </span>";
                    }
                ?>
        </div>
        <div>
            <label for="marca">Marca: </label>
                <?php
                	$sqlMarcas = mysql_query("SELECT * FROM veiculosMarcas WHERE cod = '{$marca}' ORDER BY marca");
                    $numMarcas = mysql_num_rows($sqlMarcas);
                    if($numMarcas > 0)
                    {
                        $tpMarcas = mysql_fetch_assoc($sqlMarcas);
                        echo "<span>".$tpMarcas['marca']."</span>";
                	}
                    else
                    {
                        echo "<span> - </span>";
                    }
                ?>
        </div>
        <div>
            <label for="modelo">Modelo: </label>
                <?php
                	$sqlModelos = mysql_query("SELECT * FROM veiculosModelos WHERE cod = '$modelo'");
                    $numModelos = mysql_num_rows($sqlModelos);
                    if($numModelos > 0)
                    {
                        $tpModelos = mysql_fetch_assoc($sqlModelos);
                        echo "<span>".$tpModelos['modelo']."</span>";
                	}
                    else
                    {
                        echo "<span> - </span>";
                    }
                ?>
        </div>
        <div>
            <label for="versao">Versão: </label>
                <?php
                	$sqlVersao = mysql_query("SELECT * FROM veiculosVersoes WHERE cod = '$versao'");
                    $numVersao = mysql_num_rows($sqlVersao);
                    if($numVersao > 0)
                    {
                        $tpVersao = mysql_fetch_assoc($sqlVersao);
                        echo "<span>".$tpVersao['versao']."</span>";
                	}
                    else
                    {
                        echo "<span> - </span>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="placa">Placa: </label>
            <span><?=$placa;?></span>
        </div>
        <div>
            <label for="anoFabricacao">Ano fabricação: </label>
            <span><?=$anoFabricacao;?></span>
        </div>
        <div>
            <label for="anoModelo">Ano modelo: </label>
            <span><?=$anoModelo;?></span>
        </div>
        <div>
            <label for="cor">Cor: </label>
            <span><?=$cor;?></span>
        </div>
        <div>
            <label for="combustivel">Combustível: </label>
            <span><?=$combustivel;?></span>
        </div>
        <div>
            <label for="km">Km: </label>
            <span><?=$km;?></span>
        </div>
        <div>
            <label for="nPortas">Número de portas: </label>
            <span><?=$nPortas;?></span>
        </div>
        <div>
            <label for="valor">Preço: </label>
            <span><?=number_format((float)$valor,2,',','.');?></span>
        </div>
        <div>
            <label for="nParcelas">Número de parcelas: </label>
            <span><?=$nParcelas;?></span>
        </div>
        <div>
            <label for="valorParcela">Valor parcela: </label>
            <span><?=number_format((float)$valorParcela,2,',','.');?></span>
        </div>
        <div>
            <label for="valorEntrada">Valor Entrada: </label>
            <span><?=number_format((float)$valorEntrada,2,',','.');?></span>
        </div>
        <div>
            <label for="caractVeiculo">Características do veículo: </label>
            <div style="width:600px; margin-left:186px"><?=nl2br($caractVeiculo);?></div>
        </div>
        <div>
            <label for="dataValidadeAnuncio">Validade do anúncio: </label>
            <span><?=$dataValidadeAnuncio;?></span>
        </div>
        <div>
            <label for="destaqueCapa">Destaque capa: </label>
            <span><?=$destaqueCapa == '1' ? 'Sim' : 'Não';?></span>
        </div>
        <div>
            <label for="destaqueLista">Destaque lista: </label>
            <span><?=$destaqueLista == '1' ? 'Sim' : 'Não';?></span>
        </div>
        <div>
            <label for="nFotos">Número de fotos: </label>
            <span><?=$nFotos;?></span>
        </div>
        <fieldset style="margin-top: 15px;">
            <legend>Fotos</legend>
        <?php
        $qFotos = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$cod' AND tipo = '2' AND referencia = 'clientesAnuncios' ORDER BY cod ASC");
        $nFotos = mysql_num_rows($qFotos);
        if ($nFotos > 0)
        {
            for ($d = 0; $d < $nFotos; $d++)
            {
                $tpFotos = mysql_fetch_assoc($qFotos);
        ?>
                <div class="contentEditor" style="margin-left: -10px;">
                    <label>Foto <?=($d + 1);?>: </label>
                    <img style="width:250px" src="http://<?=PROJECT_URL.'/arquivos/clientesAnuncios/'.remEscape($tpFotos['arquivo']);?>" title="<?=remEscape($tpFotos['legenda']);?>" />
                </div>
        <?php
            }
        }
        else
        {
            echo "Nenhuma foto cadastrada.";
        }
        ?>
        </fieldset>
        <div style="color:#F00; float:right; width:170px;">* Campos Obrigatórios</div>
    </fieldset>
    </form>
</div>