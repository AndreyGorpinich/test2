(function( $ ) {
  $.fn.ViewComment = function(params) {
	classC = this.attr('class');

	this.on('click','.nav > a',params,navigation_click);

	function navigation_click(event)
	{
		params = event.data;

		href = $(this).attr('href')+'&AJAX=Y';

		$.ajax({
		  url:href,
		  method: "GET",
		  dataType:'json',
		}).done(function( success ) {
			upList(success,params);
		});
		return false;
	}

	function upList(success,options){

		string_item = '';

		for(key in success.LIST)
			{
				DATE_CREATE = success.LIST[key].DATE_CREATE;
				FIO = success.LIST[key].FIO;
				PREVIEW_TEXT = success.LIST[key].PREVIEW_TEXT;
				DETAIL_TEXT = success.LIST[key].DETAIL_TEXT;

				string_item+='<div class="__item">';
						string_item+='<div class="__title">Комментарий написал '+FIO+' время создания ('+DATE_CREATE+')</div>';
								string_item+='<div class="__text">'+PREVIEW_TEXT;
								if(DETAIL_TEXT!='' & DETAIL_TEXT!=null)
								{
									string_item+='<div class="__textModer">'+DETAIL_TEXT+'</div>';
								}
						string_item+='</div>';
				string_item+='</div>';
			}

		NAV_STRING = success.NAV_STRING;
		string_item = string_item+NAV_STRING;
		$("."+classC).html(string_item);

	}



  };
})(jQuery);