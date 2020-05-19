(function( $ ) {
  $.fn.addComment = function(options) {

	this.bind('submit',options,sbmitForm);

	function sbmitForm(event)
	{
		options = event.data;

		data = $(this).serialize()+'&AJAX=Y';

		$.ajax({
		  method: "POST",
		  data:data,
		  dataType:'json',
		}).done(function( success ) {
			successForm(success,options);
		});

		return false;
	}

	  function successForm(success,options)
	{
		if(success.ERROR)
		{
			for(key in success.ERROR)
			{
				alert(options.lang['MESS_ERROR_'+success.ERROR[key]]);
			}
		}
		else
		{
			alert(options.lang['MESS_SUCCESS_ADD']);
		}
	}


  };
})(jQuery);