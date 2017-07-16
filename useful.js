// This function is used to fill in the hidden form in the homepage so as to trigger the PHP download function.
function fill_download_form(id) {
	$("input[name=file_id]").val(id);
	$("#download_form").submit();

	// Helpful to prevent the default behaviour of the download link.
	return false;
}

// This function is used to add the alert class so as to highlight the error information (if any).
function add_alert_class() {
	$("#error_message").addClass("alert alert-danger alert-dismissable");
}

// This function is used to add the sucess class so as to notify the user that the file has been deleted (if so).
function add_success_class() {
	$("#error_message").addClass("alert alert-success alert-dismissable");
}

// This function is used to dispaly a pop-up window when the user wants to delete one file.
function submit_delete_form() {
	$("#delete_form").submit();
}

// This function is used to get the name of the file which is selected to delete.
function get_selected_file_name() {
	var selected_checkbox = $("input:checked");

	if (selected_checkbox.length > 0) {
		var selected_file_name = $(selected_checkbox[0]).parents("tr").find("td:first").text();

		for (var i = 1; i < selected_checkbox.length; i++) {
			selected_file_name += ", " + $(selected_checkbox[i]).parents("tr").find("td:first").text();
		}

		$("#modal_file_name").text(selected_file_name);
		$("#delete_form_submit").removeAttr('disabled');
	} else {
		$("#delete_form_submit").attr('disabled', 'disabled');
	}
}

// This function is used to verify the file name in the popup modal window.
function verify_name() {
	var input_name = $("#file_name_verify").val();
	var correct_name = $("#modal_file_name").text();

	if (input_name == correct_name) {
		$("#confirm_submit").removeAttr('disabled');
	} else {
		$("#confirm_submit").attr('disabled', 'disabled');
	}
}

// This function prompts a confirm window when the admin tries to create new users.
function confirm_new_user() {
	var user_name = $("#username").val();
	var message = "You are going to create a new user with the username \"" + user_name + "\". Are you sure to do so?";

	if (confirm(message)) {
		return true;
	} else {
		event.preventDefault();
		return false;
	}
}

// This function checks whether to generate random password when the admin tries to create new users.
function generate_random_password() {
	if ($("#random").is(":checked")) {
		$("#manual-password-group").addClass("hidden");
		$("#password").val("");
		$("#confirm").val("");
		$("#password").removeAttr("required");
		$("#confirm").removeAttr("required");
	} else {
		$("#manual-password-group").removeClass("hidden");
	}
}