<?php require_once '../configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    
    ?>
    <script type="text/javascript">
    function openLoad()
    {
        $(".cartaobloco").hide();
        $(".carregandobloco").show();
        
    }
    function closeLoad()
    {
        $(".cartaobloco").show();
        $(".carregandobloco").hide();
    }
    function pagamento()
    {
        openLoad();
        $(".cartaofechar").hide();
        _numeroCartao = $('#numeroCartao').val();
    	_codigo = $('#codigoCartao').val();
    	_dataValidade = $('#mesCartao').val()+"/"+$('#anoCartao').val();
        _acao = $("#acao").val();
        $.ajax(
        {
            type: "POST",
            //async: false,
            url: "<?=sslRedir().PROJECT_URL;?>/redecard/ajaxAnuncioFinalizacao.php",
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
            console.log(json);
            if(json.erro == 0)
            {
                if(json.xml.status == 150)
                {
                    _teste = $("body").append("<form id='formDebito' name='downloadForm' action='"+json.xml.acs_url+"' method='post'>"+ 
                                                "<textarea name='PaReq'>"+
                                                json.xml.pareq_message+
                                                "</textarea>"+
                                                "<input type='text' name='TermUrl' value='https://www.kicarrao.com.br/redecard/anuncio-confirmacao.php'>"+
                                                "<input type='text' name='MD' value='"+json.xml.merchantReference+"'>"+
                                             "</form>").find("form#formDebito").submit();
                }
                else
                {
                    alert(json.msg);
                    //document.location.replace('<?=$MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-confirmacao' : sslRedir().PROJECT_URL.'/anuncio-confirmacao.php';?>')
                    //closeLoad();
                }
            }
            else
            {
                if(json.erro == 2)
                {
                    alert(json.msg);
                    //document.location.replace('<?=$MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';?>')
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
        $(".debitomenuitem, .creditomenuitem").click(function()
        {
            $("#acao").val($(this).attr("rel"));
        })
        
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
		objValidadorCadastro . adicionar('#codigoCartao','(3,3)');
        
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
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
</head>

<body>
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
                            <p class="anunciefinaltitulo">Seu anúncio foi cadastrado com sucesso!</p>
                            <p style="margin-top: 22px !important;">Seu anúncio será publicado após a confirmação do <b>Pagamento</b>.</p>
                            
                            <p style="margin-top:5px;"><span class="vermelho"><b>Plano teste</b></span> - R$ 10,00</p>
                            
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