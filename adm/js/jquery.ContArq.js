(function($)
{
    $.fn.ContArq = function(options)
    {
        var options = $.extend({
            cont_ini: 0
            ,cont_min: 0
            ,cont_max: 999

            ,res_cont: 'input.num'
            ,btn_plus: '.mais'
            ,btn_minus: '.menos'

            ,callback: function() {}
        }, options);

        return this.each(function(objParent)
        {
            objParent = $(this);

            objParent.Contador = {
                contador : options.cont_ini
                , valorMinimo : options.cont_min
                , valorMaximo : options.cont_max
        
            	, atualiza : function ()
                {
                    return this . contador;
                }
        
                , setNum : function (num)
                {
                    if (num >= this.valorMinimo && num <= this.valorMaximo) {
                        this . contador = num;
                    }
                    return this . atualiza();
                }
        
                , aumenta : function ()
                {
                    if (!this . testeValorMaximo()) {
                        this . contador++;
                    }
                    return this . atualiza();
                }
        
                , diminui : function ()
                {
                    if (!this . testeValorMinimo()) {
                        this . contador--;
                    }
                    return this . atualiza();
                }
        
                , testeValorMinimo : function ()
                {
                    if (this . contador <= this . valorMinimo) {
                        return true;
                    } else {
                        return false;
                    }
                }
        
                , testeValorMaximo : function ()
                {
                    if (this . contador >= this . valorMaximo) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }

            objParent
            .find(options.res_cont)
                .val(objParent.Contador.atualiza())
                .keyup(function()
                {
                    var obj = $(this);
                    if(window.ContArq_delay) {
                        window.clearTimeout(window.ContArq_delay);
                    }
        
                    window.ContArq_delay = window.setTimeout(function()
                    {
                        var num = obj.val();
                        obj.val(objParent.Contador.setNum(num));
                        options.callback(objParent.Contador.contador);
                    }, 700);
                })
            .end()
            .find(options.btn_plus)
                .click(function()
                {
            		var num = objParent.Contador.aumenta();
                    $(options.res_cont).val(num);
                    options.callback(objParent.Contador.contador);
            	})
            .end()
            .find(options.btn_minus)
                .click(function()
                {
            		var num = objParent.Contador.diminui();
                    $(options.res_cont).val(num);
                    options.callback(objParent.Contador.contador);
            	});

             options.callback(objParent.Contador.contador);
        });
    };
})(jQuery);