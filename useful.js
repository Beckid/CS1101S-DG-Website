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

/*********************************************************************
Functions below are used by Ace Editor setting.
*********************************************************************/
// Needs to set this variable as global.
var ace_editor;

// Set the default configuration for Ace Editor.
function editor_init() {
	// Bind the editor to the textarea.
    ace_editor = ace.edit("editor");

    // Set the theme of the editor.
    editor_set_theme();

    // Set the default language mode for the editor.
    editor_set_mode();

    // Enable extra options for the editor: auto-complete and snippets.
    ace_editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: false,
        enableLiveAutocompletion: true
    });
}

// Set the theme for Ace editor.
function editor_set_theme() {
	var selected_theme = $("#theme_select").val();
	var theme = "ace/theme/" + selected_theme;

	ace_editor.setTheme(theme);
}

// Set the language mode for Ace editor.
function editor_set_mode() {
	var selected_mode = $("#mode_select").val();
	var theme = "ace/mode/" + selected_mode;

	ace_editor.session.setMode(theme);
}

// Set the font size for Ace editor.
function editor_set_font_size() {
	var selected_font_size = $("#font_size_select").val();

	document.getElementById('editor').style.fontSize = selected_font_size;
}

// Set the tab size for Ace editor.
function editor_set_tab_size() {
	// Notice that the selected value is a string, need type conversion here.
	var selected_tab_size = parseInt($("#tab_size_select").val(), 10);

	ace_editor.session.setTabSize(selected_tab_size);
}

function empty_content() {
	
}