jQuery(document).ready(function(){
    
    jQuery('.show-dropdown').click(function(){
        var elem       = jQuery(this),
            indicator  = elem.find('.toggle-indicator'),
            indicators = jQuery('.toggle-indicator'),
            parent     = elem.parent(),
            dropdowns  = jQuery('.dropdown-product'),
            dropdown   = parent.next();

        if(indicator.hasClass('active')){
            indicators.removeClass('active');
            dropdowns.hide();
        }else{
            indicators.removeClass('active');
            dropdowns.hide();
            indicator.addClass('active');
            dropdown.show();
        }
    })

    var lastChecked = null;
    
    // Запуск проверки чекбоксов
    jQuery(document).on('click', '.dropdown td input[type="checkbox"]', function(e){
        var elem = jQuery(this);        

        if(!lastChecked) {
            lastChecked = elem;
        }        

        var parent              = jQuery(this).parents('.dropdown'),
            lastCheckedParent   = lastChecked.parents('.dropdown'),
            items               = jQuery('tbody .dropdown'),
            checkboxes          = jQuery('.dropdown td input[type="checkbox"]'),
            prop                = lastChecked.prop('checked');        

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
        
    });  

    // Поставить галочку на все чекбоксы
    jQuery('thead th input[type="checkbox"]').click(function(){
        var items   = jQuery('.dropdown td input[type="checkbox"]'),
            checked = jQuery('.dropdown td input[type="checkbox"]:checked');
        
        if(items.length == checked.length){
            items.prop('checked', false);
            jQuery(this).prop('checked', false);
        }else{
            items.prop('checked', true);
            jQuery(this).prop('checked', true);
        }        

    })
	
	// Удаление отмеченых
	jQuery('.del-selected').click(function () {

		var consent = confirm("Вы действительно хотите удалить заявки?");
		var action = jQuery(this).attr('name');

		if(consent){

			var stringID = "";

			jQuery("tbody input:checkbox").each(function () {
				if (jQuery(this).prop('checked')) {
					var idCheck = jQuery(this).val();
	
					// Добавляем id в нашу строку
					stringID += idCheck + ',';
	
				}
	
			});
	
			//Удаляем последнюю запятую (Для массива)
			stringID = stringID.slice(0, -1);
	
			// Создаем массив из строки ID
			arrayID = stringID.split(',').map(parseFloat);
	
			// Скрываем удаленные теги
			jQuery('.dropdown').each(function () {
				var dropdownID = parseInt(jQuery(this).data('id'));
	
				if (jQuery.inArray(dropdownID, arrayID) >= 0) {
					jQuery(this).fadeOut(700);
				}
	
			});            
	
			// Данные для Ajax
			var data = {
				action: action,
				string_id: stringID
			};
	
	
			jQuery.post(ajaxurl, data, function (response) {
	
				// Выводим уведомление
				jQuery(".notice-text").text(response);
	
				// Уведомление
				jQuery('.notice-info').removeClass('notice-closed');
				jQuery('.notice-info').addClass('notice-visible');
				jQuery('.notice-info').fadeIn(300);
				jQuery('.blackboard').fadeIn(300);
			});

			return false;

		} else {
			return false;
		}

	})

});