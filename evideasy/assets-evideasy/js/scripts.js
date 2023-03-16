jQuery(document).ready(function($){	
	console.log("ready evid@easy");

	LANG = document.getElementsByTagName('html')[0].getAttribute('lang');
	if(LANG){
		LANG = LANG.substring(0, 2).toLowerCase();
	}
	else{
		LANG = "es";
	}

	ENDPOINT_API = "https://pesquisa.bvsalud.org/portal/wizard/evidence-informed";

	var is_labels_filled = false;
	var data = [];
	var step = 1;

	load_step(step);

	function load_step(step, parameters){	
		if(step < 3){
			get_option_list(step, parameters);
		}
		else{
			get_option_group(step, parameters);
		}
	}

	function get_option_list(step, parameters){
		$('#loader-spinner').show();

		var params = $.extend({}, {
		    "step": step,
		}, parameters);

		var url = build_url_api_step(params);

		$.getJSON( url, function( result ){
			$('#loader-spinner').hide();

	        if(result.option_list_step.length == 0){
	        	get_option_list(step, parameters);
	        }
	        else{
	        	data[step] = result;
	        	change_question(result);
	        	change_option_list(result);
	        	fill_text_labels(result.texts);
	        }	        
	    });
	}

	function fill_text_labels(labels){
		if(!is_labels_filled){
			is_labels_filled = true;

			$('.grid-content-search').find('.grid-buttons').find('#btn-reset').html(labels.CANCEL);
			$('.grid-content-search').find('.grid-buttons').find('#btn-search').html(labels.SEARCH_SUBMIT);
		}
	}

	function get_option_group(step, parameters){
		$('#loader-spinner').show();

		var params = $.extend({}, {
		    "step": step,
		}, parameters);

		var url = build_url_api_step(params);

		$.getJSON( url, function( result ){
			$('#loader-spinner').hide();			

	        if(result.option_list.length == 0){
	        	get_option_group(step, parameters);
	        }
	        else{
	        	data[step] = result;
	        	change_question(result);
	        	change_option_group(result);
	        }	        
	    });
	}

	function build_url_api_step(params){
		var esc = encodeURIComponent;
		var query = Object.keys(params)
		    .map(k => esc(k) + '=' + esc(params[k]))
		    .join('&');

	    var url = ENDPOINT_API+"?lang="+LANG+"&output=json&"+query;
	    return url;
	}

	function make_searching(query){
		$('#loader-spinner-search').show();
		var url = "https://pesquisa.bvsalud.org/portal/?lang="+LANG+"&fb=&q=&skfp=true&range_year_start=&range_year_end="+encodeURI(query);
		window.location.href = url;
	}

	function change_question(data){
		var question = null;
		if(LANG == 'es'){
			question = data.step_info.label;
		}
		else{
			var translations = data.step_info.translations;
			translations.forEach(function (translation, index) {
				var lang_item = translation.language;
				if(lang_item.toLowerCase() == 'pt-br'){
					lang_item = 'pt';
				}

				if(lang_item == LANG){
					question = translation.label;
				}	
			});
		}

    	var html = '<span class="number-question">'+ (step) +'</span><span class="text-question">'+ question +'</span>';
    	$('.grid-content-search').find('#main-question').html(html);
	}

	function change_option_list(data){
		var ul = $('.grid-content-search').find('.grid-options ul');
		$(ul).html('');

		var filter_name = data.step_info.filter_name;

		data.option_list_step.forEach(function (option, index) {
		  $(ul).append('<li data-filter="'+ filter_name +'" data-value="'+ option[0] +'">'+ option[2] +'</li>');
		});
	}

	function change_option_group(data){
		var ul = $('.grid-content-search').find('.grid-options ul');
		$(ul).html('');

		data.option_list.forEach(function (option, index) {
			var filter_name = null;	
			var filter_value = null;

			if(!option.filter_query){ //check if IS EMPTY
				filter_name = 'wizard_option_group';
				filter_value = option.group;
			}
			else{ //else IS NOT EMPTY
				filter_name = 'sub_query';
				filter_value = option.filter_query;
			}

			if(LANG == 'es'){
	  			$(ul).append('<li data-filter="'+ filter_name +'" data-value="'+ filter_value +'">'+ option.label +'</li>');
			}
			else{
				option.translations.forEach(function (translation, index) {
					var lang_item = translation.language;
					if(lang_item.toLowerCase() == 'pt-br'){
						lang_item = 'pt';
					}

					if(lang_item == LANG){
	  					$(ul).append('<li data-filter="'+ filter_name +'" data-value="'+ filter_value +'">'+ translation.label +'</li>');						
					}
				});
			}
		});
	}

	$('.grid-content-search .grid-options ul').on('click', 'li', function(){
		var answer = $(this).html();
		var value = $(this).attr('data-value');
		var filter = $(this).attr('data-filter');

		add_selected_option(answer, value, filter);
		update_question_and_options();
	});

	$('.grid-content-search .grid-selected-options ul').on('click', 'li', function(){
		var current_index = $(this).index();

		var ul = $('.grid-content-search').find('.grid-selected-options ul');
		var lis = $(ul).find('li');
		$(lis).each(function(index, elem){

			if(index >= current_index){
	        	$(elem).remove();				
			}
	    });

		if($(ul).find('li').length < 3){
	    	update_question_and_options();			
		}
		else if($(ul).find('li').length == 3){
			hide_search_buttons();
		}
	});

	function add_selected_option(answer, value, filter){
		var ul = $('.grid-content-search').find('.grid-selected-options ul');
		var quantity_selected = $(ul).find('li').length;

		if(quantity_selected < 4){
			var num_selected = '<span class="index-selection">'+ (quantity_selected+1) +'</span><span class="line-selection"></span>';
	  		$(ul).append('<li class="badge badge-pill badge-primary" data-filter="'+ filter +'" data-value="'+ value +'">'+num_selected+'<span title="'+ answer +'">'+ answer +'</span> <i class="fas fa-times-circle fa-lg"></i></li>');
		}
		else{
			var num_selected = '<span class="index-selection">4</span><span class="line-selection"></span>';
			$(ul).find('li:last-child').remove();
			$(ul).append('<li class="badge badge-pill badge-primary" data-filter="'+ filter +'" data-value="'+ value +'">'+num_selected+'<span title="'+ answer +'">'+ answer +'</span> <i class="fas fa-times-circle fa-lg"></i></li>');
		}
	}

	function update_question_and_options(){
		var ul = $('.grid-content-search').find('.grid-selected-options ul');
		var selections = $(ul).find('li').length;

		if(selections < 4){
			step = selections + 1;	
			hide_search_buttons();
		}
		else{
			step = 4;
			show_search_buttons();			
		}

		var childs = null;
		if(selections > 0 && selections < 4){
			var last_filter = $(ul).find('li:last-child').attr('data-filter');
			var last_value = $(ul).find('li:last-child').attr('data-value');

			var parameters = {
				'previous_filter_name': last_filter,
				'previous_filter_value': last_value
			}
			load_step(step, parameters);

			$('.grid-selected-options').find('label').show();
		}
		else if(selections == 0){
			change_question(data[1]);
			change_option_list(data[1]);
			$('.grid-selected-options').find('label').hide();
		}
	}

	function show_search_buttons(){
		$('.grid-content-search').find('.grid-buttons').show();
	}

	function hide_search_buttons(){
		$('.grid-content-search').find('.grid-buttons').hide();
	}

	function remove_all_selected_options(){
		var lis = $('.grid-content-search').find('.grid-selected-options ul').find('li');

		$(lis).each(function(){
	        $(this).remove();
	    });
	}

	function reset_search(){
        remove_all_selected_options();
        update_question_and_options();
        hide_search_buttons();
	}

	$('.grid-content-search').find('.grid-buttons').find('#btn-reset').click(function(){
    	reset_search();
    });

    $('.grid-content-search').find('.grid-buttons').find('#btn-search').click(function(){
    	var lis = $('.grid-content-search').find('.grid-selected-options ul').find('li');

    	var query = '';
		$(lis).each(function(index, item){
	        var filter = $(item).attr('data-filter');
	        var value = $(item).attr('data-value');

	        if(filter != 'wizard_option_group'){
	        	if(filter == 'sub_query'){
	        		var filter_array = value.split('|');
	        		filter_array.forEach(function (item, index) {
	        			if(item){
	        				var sub_item = item.split(':');
	        				query = query +'&filter['+ sub_item[0] +'][]='+ sub_item[1];
	        			}
	        		});
	        	}
	        	else{
	        		query = query +'&filter['+ filter +'][]='+ value;
	        	}
	        }
	    });

    	make_searching(query);
    });

    $(window).bind("pageshow", function(event) {
		$('#loader-spinner-search').hide();
	});
});