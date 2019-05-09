var Helper = {
    validate: {
        cpf: function (cpf) {	
            cpf = cpf.replace(/[^\d]+/g,'');	
            if(cpf == '') return false;	
            // Elimina CPFs invalidos conhecidos	
            if (cpf.length != 11 || 
                    cpf == "00000000000" || 
                    cpf == "11111111111" || 
                    cpf == "22222222222" || 
                    cpf == "33333333333" || 
                    cpf == "44444444444" || 
                    cpf == "55555555555" || 
                    cpf == "66666666666" || 
                    cpf == "77777777777" || 
                    cpf == "88888888888" || 
                    cpf == "99999999999")
                            return false;		
            // Valida 1o digito	
            add = 0;	
            for (i=0; i < 9; i ++)		
                    add += parseInt(cpf.charAt(i)) * (10 - i);	
                    rev = 11 - (add % 11);	
                    if (rev == 10 || rev == 11)		
                            rev = 0;	
                    if (rev != parseInt(cpf.charAt(9)))		
                            return false;		
            // Valida 2o digito	
            add = 0;	
            for (i = 0; i < 10; i ++)		
                    add += parseInt(cpf.charAt(i)) * (11 - i);	
            rev = 11 - (add % 11);	
            if (rev == 10 || rev == 11)	
                    rev = 0;	
            if (rev != parseInt(cpf.charAt(10)))
                    return false;		
            return true;   
        },
        cnpj: function (cnpj) {/*@TODO*/},
        date: function (date) {/*@TODO*/},
    },
    format: {
        
    },
    baseUrl: function () { return location.origin; },
    combo: {
        /* Ao criar o combo, cadastrar a FUNÇÃO na área restrita com grupo "Acesso Livre" */
        municipios: function(selectName, idUf, callback) { 
            Helper.ajaxGet(Helper.baseUrl() + '/municipio/combo/' + idUf, null, function(data) {
                Helper.addOptionsSelect(selectName, data);
                if(typeof callback === 'function') {
                    callback(data);
                }
            });
        }
    },
    mask: {
        cpf: function(name, clearIfNotMatch) {this._addMask(name, '000.000.000-00', clearIfNotMatch);},
        card_num: function(name, clearIfNotMatch) {this._addMask(name, '###0000000000000', clearIfNotMatch);},
        card_dt: function(name, clearIfNotMatch) {this._addMask(name, '00/0000', clearIfNotMatch);},
        card_cv: function(name, clearIfNotMatch) {this._addMask(name, '##00', clearIfNotMatch);},
        cep: function(name, clearIfNotMatch) {this._addMask(name, '00000-000', clearIfNotMatch);},
        data: function(name, clearIfNotMatch) {this._addMask(name, '00/00/0000', clearIfNotMatch);},
        telefone: function(name, clearIfNotMatch) {this._addMask(name, '#00000000', clearIfNotMatch);},
        dddTelefone: function(name, clearIfNotMatch) {this._addMask(name, '(00)000000000', clearIfNotMatch);},
        _addMask: function (inputName, format, clearIfNotMatch) {
            var nameArray = (!Array.isArray(inputName)) ? [inputName] : inputName,
                clear = !(clearIfNotMatch === false),
                inputByNames = [];
            for (var i in nameArray) {
                var inputByName = $('input[name=' + nameArray[i] + ']');
                if (inputByName.length) {
                    inputByName.mask(format, clear ? {clearIfNotMatch: true} : {});
                    // para retirar a mascara no submit
                    inputByNames.push(inputByName);
                } else {
                    var objById = $('#' + nameArray[i]);
                    objById.mask(format);
                }
            }
            // retira a mascara no event submit se o formulário passar pelo Validate
            var formMask = inputByName.closest('form');
            formMask.submit(function(){
                if (Helper.formValidEndMove($(this))) {
                    for (var i in inputByNames) {
                        var inp = inputByNames[i];
                        inp.val(inp.cleanVal());
                    }
                }
            });
        },
        money: function (inputName) {
            var nameArray = (!Array.isArray(inputName)) ? [inputName] : inputName;
            for (var i in nameArray) {
                $('input[name=' + nameArray[i] + ']').maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
            }

        }
    },
    formatNumber: function(num, n, x, s, c) {
        var num = typeof num != "number" ? parseInt(num) : num,
            re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = num.toFixed(Math.max(0, ~~n));
        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    },
    formValidEndMove: function(objForm) {
        var valid = objForm.valid();
        if (!valid) {
            firstError = objForm.find(':input.error')[0].name;
//            firstError = Object.keys(obj.invalid)[0];
            if (typeof firstError != 'undefined') {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('label[for=' + firstError + ']').offset().top
                }, 300);
            }
        }
        return valid;
    },
    block: function(status = true) {
        if(status){
            $("#loading.loader").addClass('is-active');
        } else {
            this.unBlock();
        }
    },
    unBlock: function() {
        $("#loading.loader").removeClass('is-active');
    },
    ajaxPost: function (url, param, callback, dataType) {
        this.ajax('POST', url, param, callback, dataType);
    },
    ajaxPatch: function (url, param, callback, dataType) {
        param = (!param || typeof param !== 'object') ? {} : param;
        param._method = 'PATCH';
        this.ajax('POST', url, param, callback, dataType);
    },
    ajaxGet: function (url, param, callback, dataType) {
        this.ajax('GET', url, param, callback, dataType);
    },
    ajax: function (method, url, param, callback, dataType) {
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        this.block();
        var fCallback = (typeof callback === 'function') ? callback : function(data) {Helper.alertSuccess(data)}, 
            ajax = $.ajax({
                url: url,
                type: method,
                data: param,
                dataType: (dataType || "json")
            });
        ajax.always(function (data, textStatus, jqXHR) {
            if (Helper.is_jqXHR(data)) {
                jqXHR = data;
                data = (data.responseJSON || {});
            }
            Helper.ajaxAlertException(data, fCallback, textStatus, jqXHR);
            Helper.unBlock();
        });
    },
    ajaxAlertException: function (data, fCallback, textStatus, jqXHR) {
        if (typeof data === 'object' && typeof data.exception !== 'undefined' && data.exception === 'Exception') {
            if (data.message) {
                Helper.alert(data.message, false, {type: 'danger'});
            } else {
                Helper.alertErrorInesperado();
            }
        } else {
            fCallback(data, textStatus, jqXHR);
        }
    },
    is_jqXHR: function (obj) {
        return !(typeof obj !== 'object' || !('abort' in obj) || !('always' in obj) || !('done' in obj));
    },
    addOptionsSelect: function (selectName, data) {
        var select = $('select[name=' + selectName + ']');
        select.find('option').remove();
        select.append($("<option></option>").attr("value", "").text('Selecione'));
        $.each(data, function (key, value) {
            select.append($("<option></option>").attr("value", key).text(value));
        });
    },
    getFormData: function (id, removeMask = true) {
        var $inputs = $('#' + id).find(':input'), data = {};
        $inputs.each(function (k, v) {
            if (v.name) {
                if (v.type === 'checkbox') {
                    if (typeof data[v.name] === 'undefined') {
                        data[v.name] = [];
                    }
                    if ($(this).is(':checked')) {
                        data[v.name].push(v.value);
                    }
                } else if (v.type === 'radio') {
                    if ($(this).is(':checked')) {
                        data[v.name] = v.value;
                    }
                } else {
                    dataValue = (removeMask && typeof $(v).data('mask') !== 'undefined') ? $(v).cleanVal() : v.value;
                    data[v.name] = dataValue;
                }
            }
        });
        return data;
    },
    setFormData: function (id, data) {
        var $inputs = $('#' + id).find(':input');
        $inputs.each(function (k, v) {
            nameCompare = v.name.replace('[', '').replace(']', '');
            if (typeof data[nameCompare] !== "undefined") {
                if (v.type !== 'file') {
                    if (v.type === 'checkbox' || v.type === 'radio') {
                        if (Object.prototype.toString.call(data[nameCompare]) === "[object Array]") {
                            for (var i in data[nameCompare]) {
                                if ($(this).val() == data[nameCompare][i]) {
                                    $(this).prop('checked', true);
                                }
                            }
                        } else {
                            if ($(this).val() == data[nameCompare]) {
                                $(this).prop('checked', true);
                            }
                        }
                    } else {
                        $(this).val(data[nameCompare]);
                    }
                }
            }
        });
    },
    autoComplete: function (idSelect, url, attrName, callbackSelectItem, option = {}){
        /**
         * option
         *      limit: 10
         *      minLength: 4
         *      msgEmpty: "Nenhum registro encontrado."
         */
        var option = (typeof option == 'object') ? option : {};

        var bloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            sufficient: 10,
            remote: {
                url: url + '?q=%QUERY%',
                wildcard: '%QUERY%'
            },
        });

        $('#' + idSelect).typeahead({
            hint: true,
            highlight: true,
            minLength: option.minLength || 4,
        }, {
            name: 'autocomplete' + idSelect,
            limit: option.limit || 10,
            source: bloodhound,
            display: function(data) {
                return data[attrName]
            },
            templates: {
                empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">' + (option.msgEmpty || "Nenhum registro encontrado.") + '</div></div>'],
                header: ['<div class="list-group search-results-dropdown">'],
                suggestion: function(data) {
                    return '<div class="list-group-item">' + data[attrName] + '</div>'
                }
            }
        });

        if (typeof callbackSelectItem == 'function') {
            $('#searchEscola').on('typeahead:selected', function (e, datum) {
                callbackSelectItem(datum);
            });
        }
    },
    printContent: function (id) {
        var restorepage = $('body').html();
        var printcontent = $('#' + id).clone();
        $('body').empty().append('<div class="row justify-content-center mt-5" id="main_print">').find('#main_print').html(printcontent);
//        $('body').empty().append('<div style="margin:auto!important">').html(printcontent);
        window.document.close(); // necessary for IE >= 10
        window.focus(); // necessary for IE >= 10*/
        window.print();
        window.close();
        $('body').html(restorepage);
    },
    alert: function(body, title, options){
        /** options
         *      type [primary, secondary, success, danger, warning, info, light, dark]
         *      btnName nome do botão, aceita html
         *      callback function que roda ao fechar o modal
         */
        var appModal = $('#appModal'),
            options = (typeof options == 'object') ? options : {},
            type = (options.type || 'primary'),
            btnName = (options.btnName || 'Fechar'),
            callback = (typeof options.callback == 'function') ? options.callback : function(){},
            appModalFooter = appModal.find('.modal-footer');

        
        // set title
        appModal.find('.modal-title').html((title || 'Aviso'));

        // set body
        appModal.find('.modal-body p').html(body);

        // set type
        appModal.find('.modal-header').attr('class', 'modal-header alert-' + type);
        
        // limpa Footer
        appModalFooter.text('');
        
        // cria botao no modal
        appModalFooter.append('<button type="button" class="btn btn-default" data-dismiss="modal">');
        
        // set name do botao
        appModalFooter.find('button').html(btnName);
        
        // exibe modal
        appModal.modal('show');

        // callback ao fechar o modal
        appModal.on('hidden.bs.modal', function (e) {
            appModal.off('hidden.bs.modal');
            callback();
        });
        
    },
    alertError: function(body, title, callback){
        this.alert(body, title, {type: 'danger', callback});
    },
    alertErrorInesperado: function(title, callback){
        this.alertError('Não foi possível realizar a operação, tente novamente.', title, callback);
    },
    alertSuccess: function(body, title, callback){
        this.alert((body || 'Operação realizada com sucesso.'), title, {type: 'success', callback});
    },
    modal: function(title, method, url, param, callback, btnName){
        var method = method || 'POST';
        this.ajax(method, url, param, function(data, textStatus, jqXHR){
            if (textStatus == 'error') {
                Helper.alertErrorInesperado(false, function(){$('#appModal').modal('hide')});
            } else {
                dataModal = (data.modal || data);
                Helper.confirm(dataModal, title, {
                    type: 'primary',
                    btnNameYes: (btnName || 'Salvar'),
                    btnNameNo: 'Fechar',
                    callbackYes: callback
    
                });
            }
        });
    },
    confirm: function(body, title, options){
        /** options
         *      type [primary, secondary, success, danger, warning, info, light, dark]
         *      btnNameYes nome do botão "Sim", aceita html
         *      btnNameNo nome do botão "Não", aceita html
         *      callbackYes function que roda ao clicar no botão "Sim"
         *      callbackNo function que roda ao clicar no botão "Não"
         */
        var appModal = $('#appModal'),
            options = (typeof options == 'object') ? options : {},
            type = (options.type || 'warning'),
            btnNameYes  = (options.btnNameYes || 'Sim'),
            btnNameNo   = (options.btnNameNo || 'Não'),
            callbackYes = (typeof options.callbackYes == 'function') ? options.callbackYes : function(){},
            callbackNo  = (typeof options.callbackNo == 'function') ? options.callbackNo : function(){},
            appModalFooter = appModal.find('.modal-footer');
        
        // set title
        appModal.find('.modal-title').html((title || 'Confirmação'));

        // set body
        appModal.find('.modal-body p').html(body);

        // set type
        appModal.find('.modal-header').attr('class', 'modal-header alert-' + type);

        // limpa Footer
        appModalFooter.text('');
        
        // cria botoes no modal
        appModalFooter.append('<button type="button" class="btn btn-primary buttonYes" data-dismiss="modal">');
        appModalFooter.append('<button type="button" class="btn btn-default buttonNo" data-dismiss="modal">');
        
        // set name e callback nos botoes ("Sim" e "Não") do modal
        appModalFooter.find('.buttonYes').html(btnNameYes).on('click', callbackYes);
        appModalFooter.find('.buttonNo').html(btnNameNo).on('click',callbackNo);
        
        // exibe modal
        appModal.modal('show');
    },
    copyElement: function ($element) {
        $element.select();
        this.copyText($element.val());
    },
    copyText: function (text) {
        var $tempInput = $("<textarea>");
        $("body").append($tempInput);
        $tempInput.val(text).select();
        document.execCommand("copy");
        $tempInput.remove();
    },
};