/**
 * Saves the report field with the data of the passed form name.
 *
 * @return boolean
 */
function saveReportField(formName) {

	$.ajax({
	    type: "POST",
	    url: "?path=/reportField&method=save",
	    data: $('#' + formName).serialize(),
	    success: function(data) {
	        $('#' + formName).html(data);
	    }
    });
    
	return false;
}