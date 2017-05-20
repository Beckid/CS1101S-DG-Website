// This function is used to fill in the hidden form in the homepage so as to trigger the PHP download function.
function fill_download_form(id) {
	$("input[name=file_id]").val(id);
	document.getElementById("download_form").submit();

	// This return statement is important, so as to avoid the href attribute from being executed.
	return false;
}

// This function is used to add the alert class so as to highlight the error information (if any).
function add_alert_class() {
	$("#error_message").addClass("alert alert-danger alert-dismissable");
}