<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    ?>
</head>
<body>
    <?php
    $codAnuncioSes = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : 0;
    $codAnuncio = isset($cod) && $cod != '' ? (int)base64_decode($cod) : $codAnuncioSes;
    $codAnuncio = isset($_GET['cod']) ? (int)base64_decode($_GET['cod']) : $codAnuncio;
    $_SESSION['id_anuncio'] = $codAnuncio;
    $codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : 0;
    //echo $codAnuncio;
    $sqlVerificaBoleto = mysql_query("SELECT cod FROM boletos WHERE codAnuncio = '$codAnuncio' AND codCliente = '$codCliente' ORDER BY cod DESC LIMIT 1");
    $numVerificaBoleto = mysql_num_rows($sqlVerificaBoleto);
    if($numVerificaBoleto > 0)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
        printf("<script type='text/javascript'>
                    alert('O pagamento já foi gerado para este anúncio!');
                    document . location . replace('%s');
                </script>", $link);
        die();
    }
    else
    {
        $sqlVerificaCartao = mysql_query("SELECT cod FROM pagamentos WHERE codAnuncio = '$codAnuncio' AND codCliente = '$codCliente' ORDER BY cod DESC LIMIT 1");
        $numVerificaCartao = mysql_num_rows($sqlVerificaCartao);
        if($numVerificaCartao > 0)
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
            printf("<script type='text/javascript'>
                        alert('O pagamento já foi gerado para este anúncio!');
                        document . location . replace('%s');
                    </script>", $link);
            die();
        }
    }
    
    $boleto = isset($_SESSION['boleto']) ? $_SESSION['boleto'] : 0;
    $submit = isset($_POST['enviarBoleto']) ? $_POST['enviarBoleto'] : '';
    $valorPlano = 0;
    $codBoleto = 0;
    
    if($boleto > 0 || $codCliente < 1 || $codAnuncio < 1)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        die();
    }
    //echo $tipoAnuncio."".$codAnuncio;
    if($boleto < 1 && $submit != '')
    {
        $conexao = conexao();
        $n = 0;
        if($codAnuncio > 0)
        {
            $q = mysql_query("SELECT ca.cod,ca.planoValor FROM clientesAnuncios AS ca
                              INNER JOIN clientes AS c ON c.cod = ca.codCliente
                              WHERE ca.cod = '$codAnuncio' AND c.cod = '$codCliente' AND c.tipoAnuncio = '1'");
            //echo mysql_error();
            $n = mysql_num_rows($q);
        }
            
        if($n > 0)
        {
            $tp = mysql_fetch_assoc($q);
            $valorPlano = $tp['planoValor'];
            if($valorPlano > 0)
            {
                $query = mysql_query("SHOW TABLE STATUS LIKE 'boletos'");
                $row = mysql_fetch_array($query);
                $cod = $row['Auto_increment'] ;
                $dataHoje = date("Y-m-d");
                $nDoc = str_pad($cod,15,0,STR_PAD_LEFT);
                $dataVencimento = "0000-00-00";
                
                
                $sBol = "INSERT INTO boletos (dataCadastro, codBoleto, codAnuncio, codCliente, nDoc, dataProcessamento, dataVencimento, valor)
                        VALUES('$dataHoje','$cod','$codAnuncio','$codCliente','$nDoc','$dataHoje','$dataVencimento','$valorPlano')";
                for($a=0;$a<5;$a++)
                {
                    $qBol = mysql_query($sBol);
                    if($qBol)
                    {
                        unset($_SESSION['id_anuncio']);
                        $_SESSION['boleto'] = 1;
                        $codBoleto = mysql_insert_id();
                        $boleto = sslRedir().PROJECT_URL."/boleto/visualizar.php?menu=1&b=".base64_encode($codBoleto);
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
                        echo " <script> \n";
                        echo " alert(\"Boleto gerado com sucesso!\");\n";
                        //echo " window.open('$boleto','_blank');";
                        echo " document.location.replace('$boleto');";
                    	echo " </script> \n";
                        die();
                        //break;
                    }    
                }
                
            }
                
        }
        mysql_close();
    }
    
    $qAnuncio = mysql_query("SELECT plano, planoValor FROM clientesAnuncios WHERE cod = '$codAnuncio' LIMIT 1");
    $nAnuncio = mysql_num_rows($qAnuncio);
    if($nAnuncio < 1)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        die();
    }
    else
    {
        $tpPlano = mysql_fetch_assoc($qAnuncio);
        $plano = $tpPlano['plano'];
        $valorPlano = $tpPlano['planoValor'];
        if($valorPlano > 0)
        {
            $_SESSION['planoValorPagamento'] = $valorPlano;
        }
        else
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-confirmacao' : sslRedir().PROJECT_URL.'/anuncio-confirmacao.php';
            printf("<script type='text/javascript'>
                        document . location . replace('%s');
                    </script>", $link);
            die();
        }
    }
    if(isset($_GET['debug']))
        $_SESSION['planoValorPagamento'] = 1;
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <script type="text/javascript">
    function openLoad()
    {
        $(".cartaofechar").hide();
        $(".cartaobloco").hide();
        $(".carregandobloco").show();
        
    }
    function closeLoad()
    {
        $(".cartaofechar").show();
        $(".cartaobloco").show();
        $(".carregandobloco").hide();
    }
    function pagamento()
    {
        openLoad();
        _numeroCartao = $('#numeroCartao').val();
    	_codigo = $('#codigoCartao').val();
    	_dataValidade = $('#mesCartao').val()+"/"+$('#anoCartao').val();
        _acao = $("#acao").val();
        $.ajax(
        {
            type: "POST",
            //async: false,
            url: "<?=sslRedir().PROJECT_URL;?>/ajaxAnuncioFinalizacao.php",
            dataType: "json",
            data:
            {
                "acao": _acao,
                "numeroCartao": _numeroCartao,
            	"codigo": _codigo,
            	"dataValidade": _dataValidade
                 
            }
        })
        .done(function(json)
        {
            if(json.erro == 0)
            {
                if(json.xml.status == 150)
                {
                    $("body").append("<form style='display: none;' id='formDebito' name='downloadForm' action='"+json.xml.acs_url+"' method='post'>"+ 
                                        "<textarea name='PaReq'>"+
                                            json.xml.pareq_message+
                                        "</textarea>"+
                                        "<input type='text' name='TermUrl' value='https://www.kicarrao.com.br/anuncio-confirmacao.php'>"+
                                        "<input type='text' name='MD' value='"+json.xml.merchantReference+"'>"+
                                     "</form>").find("form#formDebito").submit();
                }
                else
                {
                    //alert(json.msg);
                    document.location.replace('<?=$MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-confirmacao' : sslRedir().PROJECT_URL.'/anuncio-confirmacao.php';?>')
                    //closeLoad();
                }
            }
            else
            {
                if(json.erro == 2)
                {
                    alert(json.msg);
                    document.location.replace('<?=$MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';?>')
                }
                else
                {
                    alert(json.msg);
                }
                closeLoad();
            }
        })
        .fail(function()
        {
            alert("Erro ao finalizar transação!\nVerifique se os dados do cartão estão corretos ou tente novamente mais tarde.");
            closeLoad();
        });
    }
    //_tipoTransacao = '';
    $(document).ready(function()
    {
        objValidadorCadastro = new xform('#formCartao',
        {
            "callbackTrue": function()
            {
                pagamento();
                return false;
            }
        });
    	objValidadorCadastro . adicionar('#numeroCartao');
    	objValidadorCadastro . adicionar('#mesCartao','(2,2)');
        objValidadorCadastro . adicionar('#anoCartao','(2,2)');
    	//objValidadorCadastro . adicionar('#codigoCartao','(3,3)');
        $(".debitomenuitem, .creditomenuitem").click(function()
        {
            _rel = $(this).attr("rel");
            $("#acao").val(_rel);
            objValidadorCadastro . remover('#codigoCartao');
            if(_rel == "credito")
            {
                objValidadorCadastro . adicionar('#codigoCartao','(3,3)');
            }
            else
            {
                objValidadorCadastro . adicionar('#codigoCartao','(3,3)',true);
            }
        })
        $("div.creditomenuitem").click(function()
        {
            $("div.creditomenuitem").removeClass("cartaohover");
            $(this).addClass("cartaohover");
            $("div.boxConfirmacao").show();
            _imgCartao = $(this).find("a > img").attr("src");
            //console.log(_imgCartao);
            $("div.cartaoimg").find("img").attr("src",_imgCartao);
            
            $("div.creditofundo").show();
            $(this).find("div.creditofundo").hide();
            
            $("div.pagamentofundo").show();
            $(this).parent().parent().find("div.pagamentofundo").hide();
            /*$("div.pagamentobloco").css({'opacity':'0.5'});
            $(this).parent().parent().css({'opacity':'1'});*/
            
            $("a.cartaofechar").click(function()
            {
                $("div.creditomenuitem").removeClass("cartaohover");
                $("div.boxConfirmacao").hide();
                $("div.pagamentofundo").hide();
                $("div.creditofundo").hide();
            })
        });
        
        $("div.debitomenuitem").click(function()
        {
            $("div.debitomenuitem").removeClass("cartaohover");
            $(this).addClass("cartaohover");
            
            $("div.boxConfirmacao").show();
            _imgCartao = $(this).find("a > img").attr("src");
            //console.log(_imgCartao);
            $("div.cartaoimg").find("img").attr("src",_imgCartao);
            
            $("div.debitofundo").show();
            $(this).find("div.debitofundo").hide();
            
            $("div.pagamentofundo").show();
            $(this).parent().parent().find("div.pagamentofundo").hide();
            /*$("div.pagamentobloco").css({'opacity':'0.5'});
            $(this).parent().parent().css({'opacity':'1'});*/
            
            $("a.cartaofechar").click(function()
            {
                $("div.debitomenuitem").removeClass("cartaohover");
                $("div.boxConfirmacao").hide();
                $("div.pagamentofundo").hide();
                $("div.debitofundo").hide();
            })
        })
        
        $("input#enviarCartao").submit(function()
        {
            $("div.cartaobloco").hide();
            $("div.carregandobloco").show();
        });
        
    });
    </script>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <?php
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
                ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Finalização</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="anunciewrap">
                    <div class="anunciedadosbloco">
                        <div class="anunciefinalbloco">
                            <?php
                            if($codAnuncioSes > 0)
                            {
                            ?>
                                <p class="anunciefinaltitulo">Seu anúncio foi cadastrado com sucesso!</p>
                            <?php
                            }
                            ?>
                            <p style="margin-top: 22px !important;">Seu anúncio será publicado após a confirmação do <b>Pagamento</b>.</p>
                            <p style="margin-top:5px;"><span class="vermelho"><b>Plano <?=$plano;?></b></span> - R$ <?=number_format($valorPlano,2,",",".");?></p>
                            
                            <div class="boxConfirmacao">
                                <a class="cartaofechar">Fechar</a>
                                <div class="cartaobloco">
                                    <div class="cartaoimg"><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/visa.jpg" alt="Visa" /></div>
                                    <div class="cartaotexto">
                                        <span>Dados do seu cartão</span>
                                        Complete as informações abaixo e clique em Confirmar compra.
                                    </div>
                                    <div class="cartaoform">
                                        <form name="formCartao" id="formCartao" method="post" action="" autocomplete="off" onsubmit="return false;">
                                            <input type="hidden" id="acao" value=""/>
                                            <label for="numeroCartao">Número do seu Cartão</label>
                                            <input type="text" name="numeroCartao" id="numeroCartao" title="Número do seu Cartão" onkeypress="return verificaNumero(event)" />
                                            <br class="clear" />
                                            <label>Data de validade</label>
                                            <label for="mesCartao" class="campomenor">Mês</label>
                                            <input type="text" name="mesCartao" id="mesCartao" title="Mês" type="Mês" onkeypress="return verificaNumero(event)"  />
                                            <label for="anoCartao" class="campomenor">Ano</label>
                                            <input type="text" name="anoCartao" id="anoCartao" title="Ano" type="Ano" onkeypress="return verificaNumero(event)"  />
                                            <br class="clear" />
                                            <label for="codigoCartao">Código verificador (três dígitos no verso do seu cartão)</label>
                                            <input type="text" name="codigoCartao" id="codigoCartao" title="Código verificador" onkeypress="return verificaNumero(event)" />
                                            <br class="clear" />
                                            <div class="cartaosubmit">
                                                <input type="submit" name="enviarCartao" id="enviarCartao" title="CONFIRMAR COMPRA" value="&nbsp;" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="carregandobloco">
                                    <div class="carregando">
                                        <img src="<?=sslRedir().PROJECT_URL;?>/img/ajax-load-finalizacao.gif" />
                                        <p>Carregando pagamento...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="pagamentowrap">
                                <div class="pagamentobloco" id="debito">
                                    <div class="pagamentofundo">&nbsp;</div>
                                    <p class="pagamentotexto">
                                        <span class="pagamentotitulo">Débito</span>
                                        Pague com cartão de débito, confira as bandeiras aceitas:
                                    </p>
                                    <div class="debitomenu">
                                        <div class="debitomenuitem" id="deb1" rel="debito">
                                            <div class="debitofundo">&nbsp;</div>
                                            <a><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/visa.jpg" alt="Visa" /></a>
                                        </div>
                                        <div class="debitomenuitem" id="deb2" rel="debito">
                                            <div class="debitofundo">&nbsp;</div>    
                                            <a><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/mastercard.jpg" alt="MasterCard" /></a>
                                        </div>
                                    </div>
                                    <div class="pagamentoimg">
                                        <a href="#"><img src="<?=sslRedir().PROJECT_URL;?>/img/setadebito.jpg" alt="Pagamento em Débito" /></a>
                                    </div>
                                </div>
                                <div class="pagamentobloco" id="credito">
                                    <div class="pagamentofundo">&nbsp;</div>
                                    <p class="pagamentotexto">
                                        <span class="pagamentotitulo">Crédito</span>
                                        Pague na próxima fatura, confira as bandeiras aceitas:
                                    </p>
                                    <div class="creditomenu">
                                        <div class="creditomenuitem" id="cred1" rel="credito">
                                            <div class="creditofundo">&nbsp;</div>
                                            <a><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/mastercard.jpg" alt="MasterCard" /></a>
                                        </div>
                                        <div class="creditomenuitem" id="cred2" rel="credito">
                                            <div class="creditofundo">&nbsp;</div>
                                            <a><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/visa.jpg" alt="Visa" /></a>
                                        </div>
                                        <div class="creditomenuitem" id="cred3" rel="credito">
                                            <div class="creditofundo">&nbsp;</div>
                                            <a><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/hipercard.jpg" alt="Hipercard" /></a>
                                        </div>
                                        <div class="creditomenuitem" id="cred4" rel="credito">
                                            <div class="creditofundo">&nbsp;</div>
                                            <a><img src="<?=sslRedir().PROJECT_URL;?>/img/cartoes/dinersclub.jpg" alt="Diners Club" /></a>
                                        </div>
                                    </div>
                                    <div class="pagamentoimg">
                                        <a href="#"><img src="<?=sslRedir().PROJECT_URL;?>/img/setacredito.jpg" alt="Pagamento em Crédito" /></a>
                                    </div>
                                </div>
                                
                                <div class="pagamentobloco" id="boleto">
                                    <div class="pagamentofundo">&nbsp;</div>
                                    <p class="pagamentotexto">
                                        <span class="pagamentotitulo">Boleto Bancário</span>
                                        Um boleto on-line é emitido.
                                    </p>
                                    <div class="imprimirboleto">
                                        <form method="post" action="" >
                                            <input type="submit" name="enviarBoleto" value="Imprimir Boleto" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <br class="clear" /> 
                            <p class="anunciefinaltexto">
                                Prezado(a) usuário(a),<br />
                                <span>Leia com atenção as informações abaixo:</span><br />
                                <br />
                                <span>Existem três formas de pagamento para seu anúncio:</span><br />
                                <span>1)</span> Por <b>Cartão de Crédito</b> o anúncio é liberado assim que o pagamento for confirmado pelo emissor.
                                <br />
                                <span>2)</span> Por <b>Cartão de Débito</b> o anúncio é liberado assim que o pagamento for confirmado pelo emissor.
                                <br />
                                <span>3)</span> Por <b>Boleto Bancário</b> o anúncio é liberado em até 12 horas úteis da realização do pagamento, através do site ou em uma agência da Caixa. Para pagamento nos demais bancos o anúncio é liberado em até 24 horas úteis da realização do pagamento.
                            </p>
                            <p class="anunciefinalrodape">Obrigado por anunciar no Kicarrão!</p>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>