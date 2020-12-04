$(document).ready(function() {

  // get the name of uploaded file
	$('input[type="file"]').change(function(){

		var value = $("input[type='file']").val();
		var filenameWithExtension = value.replace(/^.*[\\\/]/, '');
		$('.js-value').text(filenameWithExtension);

	});

});
