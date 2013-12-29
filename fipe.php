<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
    require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
	?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/number_format.js"></script>
<script>
function tipoBusca(_this,_val)
{
    _val = _val || '';
    if(_this.val())
        {
            $('#marcaFipe').hide();
            
            $.ajax(
            {
                type: "POST",
                async: false,
                url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxMarcaFipe.php",
                data:
                {
                    tipo: _this.val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">-</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '" '+(_val == j[i].cod ? 'selected="true"' : '')+'>' + j[i].marca + '</option>';
                    }	
                    $('#marcaFipe').html(options).show();
                    $('.carregandoMarca').hide();
                    $('#modeloFipe').html('<option value="">-</option>');
                    $('#anoModeloFipe').html('<option value="">-</option>');
                    $('#mostraResultadoFipe').html(' ');
                    
                }
            });              
        }
        else
        {
            $('#marcaFipe').html('<option value="">-</option>');
            $('#modeloFipe').html('<option value="">-</option>');
            $('#anoModeloFipe').html('<option value="">-</option>');
            $('#mostraResultadoFipe').html(' ');
            
        }
}

function marca(_this,_val)
{
    _val = _val || '';
    if(_this.val())
    {
        $('#modeloFipe').hide();
        
        $.ajax(
        {
            type: "POST",
            async: false,
            url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxModeloFipe.php",
            data:
            {
                cod: _this.val()
            
            },
            dataType: "json", 
            success: function(j)
            { 
                var options = '<option value="">-</option>';	
                for (var i = 0; i < j.length; i++) 
                {
                    options += '<option value="' + j[i].cod + '" '+(_val == j[i].cod ? 'selected="true"' : '')+'>' + j[i].modelo + '</option>';
                }	
                $('#modeloFipe').html(options).show();
                $('.carregandoModelo').hide();
                $('#anoModeloFipe').html('<option value="">-</option>');
                $('#mostraResultadoFipe').html(' ');
            }
        });              
    }
    else
    {
        $('#modeloFipe').html('<option value="">-</option>');
        $('#anoModeloFipe').html('<option value="">-</option>');
        $('#mostraResultadoFipe').html(' ');
    }
}

function anoModelo(_this,_val)
{
    _val = _val || '';
    if(_this.val())
    {        
        $.ajax(
        {
            type: "POST",
            async: false,
            url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxAnosModeloFipe.php",
            data:
            {
                cod: _this.val()
            
            },
            dataType: "json", 
            success: function(j)
            { 
                var options = '<option value="">-</option>';
                for (var i = 0; i < j.length; i++) 
                {
                    options += '<option value="' + j[i].valor + '" '+(_val == j[i].valor ? 'selected="true"' : '')+'>' + j[i].ano + '</option>';
                }	
                $('#anoModeloFipe').html(options).show();
                //$('#carregandoAnoModelo').hide();
            }
        });              
    }
    else
    {
        $('#anoModeloFipe').html('<option value="">-</option>');
        $('#mostraResultadoFipe').html(' ');
    }
}

function mostraResultado()
{      
    //$('#mostraResultadoFipe').html('<div class="fipetabela"><span><b>Código FIPE:</b> '+$('#modeloFipe').find("option:selected").val()+'</span><br /><span><b>Marca:</b> '+$('#marcaFipe').find("option:selected").text()+'</span><br /><span><b>Modelo:</b> '+$('#modeloFipe').find("option:selected").text()+'</span><br /><span><b>Ano Modelo:</b> '+$('#anoModeloFipe').find("option:selected").text()+'</span><br /><span><b>Preço Médio:</b> R$ '+number_format(parseFloat($('#anoModeloFipe').find("option:selected").val()),2,",",".")+'</span></div>'); 
    
    $.ajax(
        {
            type: "POST",
            async: false,
            url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxInsereMailingFipe.php",
            data:
            {
                nome: $("#nomeFipe").val(),
                email: $("#emailFipe").val(),
                codigoFipe: $('#modeloFipe').find("option:selected").val(),
                marca: $('#marcaFipe').find("option:selected").text(),
                modelo: $('#modeloFipe').find("option:selected").text(),
                anoModelo: $('#anoModeloFipe').find("option:selected").text(),
                valorMedio: $('#anoModeloFipe').find("option:selected").val()
            
            },
            dataType: "json", 
            success: function(j)
            { 
               /* $('#mostraResultadoFipe').html('<div class="fipetabela"><div class="fipetopo"><span>Veículo:</span> '+$('#marcaFipe').find("option:selected").text()+' - '+$('#modeloFipe').find("option:selected").text()+' '+$('#anoModeloFipe').find("option:selected").text()+
                    '</div><div class="fipelinha"><div class="fipeimg"><img src="http://<?=PROJECT_URL;?>/img/fipeimg.png" alt="" /></div><div class="fipetexto"><div class="fipepreco">Preço médio: &nbsp;&nbsp;&nbsp;&nbsp;R$ <span>'+
                    number_format(parseFloat($('#anoModeloFipe').find("option:selected").val()),2,",",".")+'</span></div>Código FIPE: '+$('#modeloFipe').find("option:selected").val()+
                    '</div></div><div class="fipeseparador">&nbsp;</div><div class="fipelinha"><div class="fipeimg"><img src="http://<?=PROJECT_URL;?>/img/kicarraoimg.png" alt="" /></div>'+
                    '<div class="fipetexto">Não existe(m) veículo(s) anunciado(s) com a mesma marca, modelo e ano.</div><div class="fipetexto"><div class="fipepreco">Preço médio: &nbsp;&nbsp;&nbsp;&nbsp;R$ <span>55.300,00</span></div>Menor R$ <span class="precomenor">18.900,00</span> &nbsp;&nbsp;&nbsp;&nbsp;Maior R$ <span class="precomenor">25.900,00</span><br />Número de veículos anunciados: 9</div></div></div>'); */     

                $('#mostraResultadoFipe').html('<div class="fipetabela"><div class="fipetopo"><span>Veículo:</span> '+$('#marcaFipe').find("option:selected").text()+' - '+$('#modeloFipe').find("option:selected").text()+' '+$('#anoModeloFipe').find("option:selected").text()+
                    '</div><div class="fipelinha"><div class="fipeimg"><img src="http://<?=PROJECT_URL;?>/img/fipeimg.png" alt="" /></div><div class="fipetexto"><div class="fipepreco">Preço médio: &nbsp;&nbsp;&nbsp;&nbsp;R$ <span>'+
                    number_format(parseFloat($('#anoModeloFipe').find("option:selected").val()),2,",",".")+'</span></div>Código FIPE: '+$('#modeloFipe').find("option:selected").val()+
                    '</div></div>');
            }
        });
}
$(document).ready(function()
{
    $('#veiculoFipe').change(function()
    {
        tipoBusca($(this));
    })
    $('#marcaFipe').change(function()
    {
        marca($(this));
    })
    
    $('#modeloFipe').change(function()
    {
        anoModelo($(this));
    })
    
    /*$('#anoModeloFipe').change(function()
    {
        mostraResultado($(this));
    })*/
    
    $('#avaliarFipe').click(function(){
        if($('#veiculoFipe').val() != '' && $('#marcaFipe').val() != '' && $('#modeloFipe').val() != '' && $('#anoModeloFipe').val() != '' && $('#nomeFipe').val() != '' && $('#emailFipe').val() != '')
        {
            mostraResultado();
            return false;
        }
        else
        {
            alert('Preencha todos os campos.')
            return false;
        }
    })
})
</script>
</head>

<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <a href="home.php">Home</a>&nbsp; &gt; &nbsp;<span>FIPE</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="fipebanner">
                    <?php
                    imprimeBannerSuperFipe();
                    ?>
                </div>
                <div class="fipebloco">
                    <div class="fipeleft">
                        <div class="fipetitulo">Tabela FIPE</div>
                        <div class="fipelegenda">*campos obrigatórios</div>
                        <form name="fipeForm" id="fipeForm" method="post" action="" enctype="multipart/form-data">
                            <div class="inputbloco">
                                <label for="veiculoFipe">Tipo de Veículo*</label>
                                <select class="selectgrandebusca" name="veiculoFipe" id="veiculoFipe" title="Tipo de Veículo">
                                    <option value="">-</option>
                                    <option value="caminhao">Caminhão</option>
                                    <option value="carro">Carro</option>
                                    <option value="moto">Moto</option>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="marcaFipe">Marca*</label>
                                <select class="selectgrandebusca" name="marcaFipe" id="marcaFipe" title="Marca">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="modeloFipe">Modelo*</label>
                                <select class="selectgrandebusca" name="modeloFipe" id="modeloFipe" title="Modelo">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="anoModeloFipe">Ano Modelo*</label>
                                <select class="selectgrandebusca" name="anoModeloFipe" id="anoModeloFipe" title="Ano Modelo">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <br class="clear" /><br class="clear" />
                            <div class="inputbloco">
                                <label for="nomeFipe">Nome</label>
                                <input class="inputgrandebusca" name="nomeFipe" id="nomeFipe" title="Nome" />
                            </div>
                            <div class="inputbloco">
                                <label for="emailFipe">E-mail</label>
                                <input class="inputgrandebusca" name="emailFipe" id="emailFipe" title="Cidade" />
                            </div>
                            <div class="fipesubmit">
                                <input type="submit" value="&nbsp;" title="Avaliar" id="avaliarFipe" name="avaliarFipe" />
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript">
						//<![CDATA[
							objValidadorCadastro = new xform('#fipeForm');
                            objValidadorCadastro . adicionar('#veiculoFipe');
                            objValidadorCadastro . adicionar('#marcaFipe');
							objValidadorCadastro . adicionar('#modeloFipe');
                            objValidadorCadastro . adicionar('#anoModeloFipe');
                            objValidadorCadastro . adicionar('#nomeFipe');
                            objValidadorCadastro . adicionar('#emailFipe');
						//]]>
					</script>
                    <div class="fiperight">
                        <div id="mostraResultadoFipe"></div>
                        <!--<div id="mostraResultadoFipe">
                            <div class="fipetabela">
                                <div class="fipetopo"><span>Veículo:</span> Honda - FIT Twist 1.5 Flex 16V 5p Aut. 2013</div>
                                <div class="fipelinha">
                                    <div class="fipeimg"><img src="http://<?=PROJECT_URL;?>/img/fipeimg.png" alt="" /></div>
                                    <div class="fipetexto">
                                        <div class="fipepreco">Preço médio: &nbsp;&nbsp;&nbsp;&nbsp;R$ <span>52.945,00</span></div>
                                        Código FIPE: 014073-2
                                    </div>
                                </div>
                                <div class="fipeseparador">&nbsp;</div>
                                <div class="fipelinha">
                                    <div class="fipeimg"><img src="http://<?=PROJECT_URL;?>/img/kicarraoimg.png" alt="" /></div>
                                    <div class="fipetexto">
                                        Não existe(m) veículo(s) anunciado(s) com a mesma marca, modelo e ano.
                                    </div>
                                    <div class="fipetexto">
                                        <div class="fipepreco">Preço médio: &nbsp;&nbsp;&nbsp;&nbsp;R$ <span>55.300,00</span></div>
                                        Menor R$ <span class="precomenor">18.900,00</span> &nbsp;&nbsp;&nbsp;&nbsp;
                                        Maior R$ <span class="precomenor">25.900,00</span><br />
                                        Número de veículos anunciados: 9
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="bannerfipeinferior">
                            <a href="http://<?=PROJECT_URL;?>/planos">
                                <img src="http://<?=PROJECT_URL;?>/img/bannerfipeinferior.jpg" alt="Anuncie seu Veículo" />
                            </a>
                        </div>
                        <div class="fipeinfo">
                            <span>1)</span> A Tabela FIPE expressa preços de reposição médios de mercado efetivamente praticados, base nacional. Há, portanto, transações que ocorrem acima ou abaixo dos preços divulgados. Quem quer que utilize a tabela para compra ( Inclusive junto à lojas e concessionárias ) e para venda (Inclusive junto a seguradoras, em caso de roubo ou perda total ), deve fazê-lo, tomando-a como parâmetro de negociação. No caso de cobrança de IPVA, a FIPE recomenda que as Secretarias Estaduais da Fazenda levem em consideração os dados divulgados.<br />
                            <br />
                            <span>2)</span> Para a obtenção do valor médio de mercado foram considerados preços de veículos das várias regiões do País e com diferentes características, tais como estado de conservação, cor, tipo de pintura e ítens acessórios ou opcionais, sendo desconsiderados, para efeito de cálculo, aqueles excessivamente distantes da média.<br />
                            <br />
                            <span>3)</span> Como qualquer índice de preços, a tabela FIPE pode ser utilizada livre e voluntariamente, em contratos.<br />
                            <br />
                            <span>4)</span> A versão integral dessa tabela é publicada no Jornal Valor Econômico.<br />
                            <br />
                            <span>5)</span> No sentido do aperfeiçoamento desse trabalho, a FIPE receberá com satisfação suas críticas e sugestões pelo e-mail veiculos@fipe.com.
                        </div>
                    </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralFipe();
                    imprimeBannerLateralPequenoFipe();
                    ?>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>