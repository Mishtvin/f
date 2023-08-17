function textAreaAdjust(that) {
    console.dir(that);
    that.style.height = that.scrollHeight+"px";
}

jQuery(document).ready(function(){
    var ajaxurl = '/wp-admin/admin-ajax.php';

    if(!jQuery('.tab-content > .tab-item').length > 0){
        return;
    }

    function refreshCount(){
        var page_name = jQuery('.wrap').data('name');

        jQuery.post('/wp-admin/admin-ajax.php', {
            action: 'refresh_count',
            page_name: page_name
        },
        function (res) {           
            res = JSON.parse(res);

            jQuery('.subsubsub .new .count').text('(' + res['new'] + ')');
            jQuery('.subsubsub .processed .count').text('(' + res['processed'] + ')');
            jQuery('.subsubsub .deleted .count').text('(' + res['deleted'] + ')');
            jQuery('.block-title .count span').text(res['total']);

            jQuery('#toplevel_page_' + page_name + ' .awaiting-mod').text(res['new']);

            if(page_name == 'orders'){
                jQuery('#wp-admin-bar-admin_bar_order_count .awaiting-mod').text(res['new']);
            }

        });

    }

    //количество подгружаемых записей из бд
    var count = 10;
    //начиная с
    var begin = 1;

    function get_items(sort, refresh, empty){
        var items_width = {},
            page_name   = jQuery('.wrap').data('name'),
            status      = jQuery('.subsubsub a').index(jQuery('.subsubsub .active')),
            items_count = jQuery('.content > .item').length;      
            
        if(!empty){            
            var empty = 0;
        }

        jQuery('.labels-wrapper div').each(function(){
            var elem  = jQuery(this),
                width = elem.data('width'),
                name  = elem.data('name');

            items_width[name] = width;
        });

        jQuery.post('/wp-admin/admin-ajax.php', {
            action: 'output_items',
            items_width:    items_width,
            page_name:      page_name,
            status:         status,
            sort:           sort,
            refresh:        refresh ? refresh : 0,
            count:          refresh && refresh == 1 ? items_count : begin * count,
            empty:          empty,
            items_count:    items_count
        },
        function (res) {
            
            if(jQuery.trim(res) != ''){                
                var checked = [],
                    active = jQuery('.content > .item.active').data('id');                
            
                jQuery('.checkbox-input:checked').each(function(){
                    var id = jQuery(this).parents('.item').data('id');
                    checked.push(id);
                });

                jQuery('.table-content .preloader').fadeOut(300);
                jQuery('.table-content .content').html('');
                begin++;
            
                jQuery('.table-content .content').append(res);
                
                jQuery.each(checked, function(key, value){
                    var elem     = jQuery('.item[data-id="' + value + '"]'),
                        checkbox = elem.find('.checkbox-input');

                    checkbox.prop('checked', true);
                })
                
                if(active && refresh != 1){                    
                    var elem     = jQuery('.item[data-id="' + active + '"]'),
                        dropdown = elem.find('.dropdown');

                    elem.addClass('active');
                    dropdown.show();
                }
                
                //запуск функции при прокрутке
                jQuery(window).on("scroll", scrolling);
            }

        });
        

    }

    /* Загрузка контента ПАГИНАЦИЯ */

    function scrolling(){
        //считывание текущей высоты контейнера
        var wrapper = jQuery('.table-content'),
            currentHeight = (wrapper.height() + wrapper.offset().top) - 200,
            scrolled      = jQuery(window).scrollTop() + jQuery(window).height(),
            sortable      = jQuery('.labels-wrapper .active'),
            name          = sortable.data('name'),
            direction     = sortable.hasClass('decrease') ? 'DESC' : 'ASC';
            
        var ajax_sort = {
            'name'      : name,
            'direction' : direction
        };
        
        // проверка достежения конца прокрутки
        if( scrolled >= currentHeight ){
            
            /*отключение вызова функции прокрутки
            во избежание неоднократного вызова функции */
            jQuery(this).unbind("scroll");

            //функция реализующая следующие два этапа
            get_items(ajax_sort, 0, 1);
        }
    }

    var def_sort = {
        'name'      : 'id',
        'direction' : 'DESC'
    };

    get_items(def_sort);    

    // Стрелки у сортировки
    jQuery('.sortable').click(function(){
        var elem    = jQuery(this),
            name    = elem.data('name'),
            items   = jQuery('.sortable'),
            dir     = 'ASC';

        jQuery('.table-content .preloader').fadeIn(300);

        if(elem.hasClass('decrease')){
            items.removeClass('increase decrease active');
            elem.addClass('increase');
            elem.addClass('active');
        }else if(elem.hasClass('increase')){
            items.removeClass('increase decrease active');
            elem.addClass('decrease');
            elem.addClass('active');
            dir = 'DESC';
        }else{
            items.removeClass('increase decrease active');
            elem.addClass('increase');
            elem.addClass('active');
        }

        var data = {
            'name'      : name,
            'direction' : dir
        };

        get_items(data, 1);        

    })

    var lastChecked = null;
    
    // Запуск проверки чекбоксов
    jQuery(document).on('click', '.checkbox-input', function(e){
        var elem = jQuery(this);              

        if(!lastChecked) {
            lastChecked = elem;
        }        

        var parent              = jQuery(this).parents('.item'),
            lastCheckedParent   = lastChecked.parents('.item'),
            items               = jQuery('.content > .item'),
            checkboxes          = jQuery('.checkbox-input'),
            prop                = lastChecked.prop('checked'),
            del                 = jQuery('.del-selected'),
            prc                 = jQuery('.process-selected'); 
            rcv                 = jQuery('.recover-selected');

        if(e.shiftKey) {
            var start = items.index(parent),
                end   = items.index(lastCheckedParent),
                range = checkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1),
                check = 0;

            elem.prop('checked', prop);     

            range.each(function(){
                var elem = jQuery(this);
                
                if(elem.prop('checked') != prop){
                    check++;
                }

            })            

            if(check == 0 && range.length > 2){
                range.prop('checked', !prop);
            }else{
                range.prop('checked', prop);
            }

        }

        
        lastChecked = elem;
        
        var chekced = jQuery('.checkbox-input:checked');

        if(chekced.length > 0){
            del.removeAttr('disabled');
            prc.removeAttr('disabled');
            rcv.removeAttr('disabled');
        }else{
            del.attr('disabled', true);
            prc.attr('disabled', true);
            rcv.attr('disabled', true);
        }   
        
    });  

    jQuery('.close-alert').click(function(){
        jQuery(this).parents('.alert').slideUp(300);
    })
	
	// Удаление отмеченых
	jQuery(document).on('click', '.delete-btn, .trash-delete-btn', function () {
        var elem   = jQuery(this),
            action = elem.attr('name'),
            ids,
            items;

        if(elem.hasClass('del-selected')){
            var chekced = jQuery('.checkbox-input:checked'),
                parents = chekced.parents('.item');

            items = parents;
            ids = [];

            chekced.each(function(){
                var id = jQuery(this).parents('.item').attr('data-id');
                ids.push(id);            
            })

            ids = ids.join(',');
        }else{
            ids = elem.parents('.item').attr('data-id');

            var parent = elem.parents('.item');

            items = parent;
        }      

        // Данные для Ajax
        var data = {
            action: action,
            string_id: ids
        };

        var dropdown   = items.find('.dropdown'),
            del_screen = items.find('.delete-screen');
        
        items.removeClass('active');
        dropdown.slideUp(300);
        del_screen.addClass('delete');              

        jQuery('html, body').animate({ 
            scrollTop: items.last().offset().top - 100
        }, 300);

        setTimeout(function(){
            // Скрываем заявку
            items.css('transition', 'none');
            items.slideUp(400);

            setTimeout(function(){
                items.remove();
            }, 400);
        }, 750);

        jQuery.post(ajaxurl, data, function(){
            refreshCount();
        });        

    })
    
    jQuery(document).on('click', '.check-all', function(){
        var checkboxes = jQuery('.checkbox-input'),
            checked    = jQuery('.checkbox-input:checked'),
            del        = jQuery('.del-selected'),
            prc        = jQuery('.process-selected'),
            rcv        = jQuery('.recover-selected');

        if(checkboxes.length == checked.length){
            checkboxes.prop('checked', false);
        }else{
            checkboxes.prop('checked', true);
        }

        var chekced = jQuery('.checkbox-input:checked');

        if(chekced.length > 0){
            del.removeAttr('disabled');
            prc.removeAttr('disabled');
            rcv.removeAttr('disabled');
        }else{
            del.attr('disabled', true);
            prc.attr('disabled', true);
            rcv.attr('disabled', true);
        }  

    })
    
    // Обработка заявки
	jQuery(document).on('click', '.process-btn', function () {
        var elem   = jQuery(this),
            action = elem.attr('name'),
            ids,
            items;

        if(elem.hasClass('process-selected')){
            var chekced = jQuery('.checkbox-input:checked'),
                parents = chekced.parents('.item');

            items = parents;
            ids = [];

            chekced.each(function(){
                var id = jQuery(this).parents('.item').attr('data-id');
                ids.push(id);            
            })

            ids = ids.join(',');
        }else{
            ids = elem.parents('.item').attr('data-id');

            var parent = elem.parents('.item');

            items = parent;
        }

        // Данные для Ajax
        var data = {
            action: action,
            string_id: ids
        };

        var dropdown   = items.find('.dropdown'),
            success = items.find('.success-screen');
        
        items.removeClass('active');
        dropdown.slideUp(300);
        success.addClass('delete');        

        jQuery('html, body').animate({ 
            scrollTop: items.last().offset().top - 100
        }, 300);

        setTimeout(function(){
            // Скрываем заявку
            items.css('transition', 'none');
            items.slideUp(400);

            setTimeout(function(){
                items.remove();
            }, 400);
        }, 750);        

        jQuery.post(ajaxurl, data, function(){
            refreshCount();
        }); 
        
    });
    
    // Восстановление заявки
	jQuery(document).on('click', '.recover-btn', function () {
        var elem   = jQuery(this),
            action = elem.attr('name'),
            ids,
            items;

        if(elem.hasClass('recover-selected')){
            var chekced = jQuery('.checkbox-input:checked'),
                parents = chekced.parents('.item');

            items = parents;
            ids = [];

            chekced.each(function(){
                var id = jQuery(this).parents('.item').attr('data-id');
                ids.push(id);            
            })

            ids = ids.join(',');
        }else{
            ids = elem.parents('.item').attr('data-id');

            var parent = elem.parents('.item');

            items = parent;
        }      

        // Данные для Ajax
        var data = {
            action: action,
            string_id: ids
        };        

        var dropdown   = items.find('.dropdown'),
            success = items.find('.recover-screen');
        
        items.removeClass('active');
        dropdown.slideUp(300);
        success.addClass('delete');        

        jQuery('html, body').animate({ 
            scrollTop: items.last().offset().top - 100
        }, 300);

        setTimeout(function(){
            // Скрываем заявку
            items.css('transition', 'none');
            items.slideUp(400);

            setTimeout(function(){
                items.remove();
            }, 400);
        }, 750);

        jQuery.post(ajaxurl, data, function(){
            refreshCount();
        });  
	});

	jQuery(document).on('click', '.notice-close', function () {
        var parent = jQuery(this).parents('.notice');
        parent.removeClass('notice-visible');
        parent.addClass('notice-closed');
        parent.fadeOut(300);
        jQuery('.blackboard').fadeOut(300);
    });

    var available = 1;
    jQuery(document).on('click', '.table-content .content > .item .info', function(e){
        var prevent = jQuery('.prevent-open');

        if(!prevent.is(e.target) && prevent.has(e.target).length === 0){

            if(available == 1){
                var elem      = jQuery(this),
                    parent    = elem.parent(),
                    items     = jQuery('.content > .item'),
                    dropdown  = elem.next(),
                    dropdowns = jQuery('.content .item .dropdown');
    
                if(parent.hasClass('active')){
                    items.removeClass('active');
                    dropdowns.slideUp(300);
                }else{
                    items.removeClass('active');
                    dropdowns.slideUp(300);
                    dropdown.slideDown(300);
                    parent.addClass('active');
                }
    
                available = 0;
                setTimeout(function(){
                    available = 1;
                }, 300);
    
            } 

        }    
    });

    function dischargeChange(elem){
        elem.val(elem.attr('data-old'));
        elem.removeAttr('data-old');

        if(elem.hasClass('resizable')){
            textAreaAdjust(elem);
        }

    }

    function rejectChange(discharge){
        var items = jQuery('.field-wrapper'),
            active = jQuery('.field-wrapper.active'),
            active = active.find('.change-field'),
            inputs = items.find('input');

        if(discharge && active.length > 0){
            dischargeChange(active);
        } 
        items.removeClass('active');       
    }

    function accertChange(elem){
        var input = elem.find('.change-field');
        
        input.removeAttr('data-old');
        
        if(input.hasClass('changed')){
            input.removeClass('changed');

            var val = jQuery.trim(input.val()),
                field = input.data('field'),
                id = input.data('id');

            if(input.data('def') && val == ''){
               val = jQuery.trim(input.data('def'));
               input.val(val);
            }

            if(elem.hasClass('name')){
                elem.find('.avatar').text(val.charAt(0))
            }

            jQuery.post('/wp-admin/admin-ajax.php', {
                action: 'change_field',
                id: id,
                field: field,
                val: val
            });
        }

        rejectChange();
    }

    jQuery(document).on('focus', '.change-field', function(){
        var elem = jQuery(this),
            wrapper = elem.parent('.field-wrapper');

        rejectChange();

        elem.attr('data-old', elem.val());

        wrapper.addClass('active');

        elem.on('input', function(){
            elem.addClass('changed');
        });

        wrapper.find('.yes').click(function(){
            accertChange(wrapper);
        });
        wrapper.find('.no').click(function(){
            rejectChange(true);
        });

    });

    jQuery(document).click(function (e){
        items = jQuery('.field-wrapper');

        if (!items.is(e.target) && items.has(e.target).length === 0) {
            rejectChange();
        }
    });

    // jQuery(document).on('change', '.change-field', function(){
        // var elem = jQuery(this),
        //     val = elem.val(),
        //     field = elem.data('field'),
        //     id = elem.data('id');

        // jQuery.post('/wp-admin/admin-ajax.php', {
        //     action: 'change_field',
        //     id: id,
        //     field: field,
        //     val: val
        // });
    // });
});