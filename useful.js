// This function is used to fill in the hidden form in the homepage so as to trigger the PHP download function.
function fill_download_form(id) {
	$("input[name=file_id]").val(id);
	document.getElementById("download_form").submit();

	// This return statement is important, so as to avoid the href attribute from being executed.
	return false;
}