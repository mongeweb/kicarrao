/*
 * --------------------------------------------------------------------------------------------------------
 * Versão......: 01
 * Programaor....: Felipe
 * Data........: 05/06/13
 * Finalidade..: Criar letreiro campo busca rapida.
 * --------------------------------------------------------------------------------------------------------
 * Alterações
 * --------------------------------------------------------------------------------------------------------
 * Data       Hora  Programador    Descrição
 * --------------------------------------------------------------------------------------------------------
 * ??/??/???? ??:?? Nome        Texto
 *
 * --------------------------------------------------------------------------------------------------------
 */

var time = 70; // Tempo de digitação em mili segundos
var atual = 0; // indice atual do bloco de texto
var qtd; 
var sto;
var lista = new Array()
var digitando = false;
var stoR = null;
var si = null;

lista[0] = 'Digite aqui sua pesquisa';
lista[1] = 'Ex.: palio azul';
lista[2] = 'Ex.: palio, celta, uno';
lista[3] = 'Ex.: palio azul, verde, vermelho';

$(function(){       

    qtd = lista.length; 

    if($('#buscar').val() == ''){
        sto = setTimeout('digitaTexto('+atual+')',500);            
    } else {
        $("#letreiro").val('f');
    }
    $('#buscar').focusout(function(e){
        if($('#buscar').val() == ''){
            $("#letreiro").val('t');
            sto = setTimeout('digitaTexto('+atual+')',500);
        }
    });      
    
    $('#r').focus(function(e){
        clearTimeout(sto);
        clearTimeout(stoR);
        clearInterval(si);
        $("#letreiro").val('f');
        for (i=0; i<3; i++){
            //console.log($('#busca').val() +"=="+ lista[i] +"||"+ digitando);
            if($('#buscar').val() == lista[i] || digitando){
                $('#buscar').val('');
                //console.log('333');
                break;
            }            
        }
        digitando = false;
    });
});   

function digitaTexto(item){
    //console.log('fff333');
    $('#buscar').val('');            
    objItem = lista[item]; 
    texto = objItem;       
    stringItem = new String(texto);
    
    sto = setTimeout('efeitoDigita(stringItem,0)',time); 
    //clearInterval(si);
} 

function efeitoDigita(stringItem,n){       
    
    qtdLetras = stringItem.length;
	
    $('#buscar').val($('#buscar').val()+stringItem.split("")[n]); 
    
    if((n+1) < qtdLetras){ 
        sto = setTimeout('efeitoDigita(stringItem,'+(n+1)+')',time);  
        digitando = true;
    }else{           
        if((atual+1) < qtd){               
            retiraTexto(atual);
            atual++;          
            sto = setTimeout('digitaTexto('+atual+')',3000);
            
        }else{   
            retiraTexto(atual);
            atual = 0;
            sto = setTimeout('digitaTexto('+atual+')',3000);
        }  
    }          
}

function retiraTexto(item){     
    objItem = lista[item]; 
    texto = objItem;       
    stringItem = new String(texto); 
    si = setInterval('efeitoRetiraTexto(stringItem,1)',1000); 
} 


function efeitoRetiraTexto(){
    var str = $('#buscar').val();
    digitando = true;
    str = str.substring(0,(str.length - 1))
    $('#buscar').val(str);
    
    if((str.length) > 0){ 
        stoR = setTimeout(function(){     
                            efeitoRetiraTexto();
                            }, 50);
    } else {
        clearInterval(si);  
    }
}