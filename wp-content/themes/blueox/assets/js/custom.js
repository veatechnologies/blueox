$(document).ready(function () {
  $('.input_fields_wrap_about_video input').change(function(){
	 $('.input_fields_wrap_about_video input').prop('checked', false);
	 $(this).prop('checked', true);
	});


});

