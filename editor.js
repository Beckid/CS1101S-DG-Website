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

    // Add keyboard shortcut for uploading and editing local files.
    ace_editor.commands.addCommand({
    	name: "editLocalFile",
    	bindKey: { win: "Ctrl-O", mac: "Command-O" },
    	exec: function(arg) {
    		$('#file_upload').trigger('click');
    	}
    });

    // Add keyboard shortcut for displaying the keyboard shortcut list.
    ace_editor.commands.addCommand({
        name: "showKeyboardShortcuts",
        bindKey: { win: "Ctrl-Alt-h", mac: "Command-Alt-h" },
        exec: function(arg) {
            ace.config.loadModule("ace/ext/keybinding_menu", function(module) {
                module.init(arg);
                ace_editor.showKeyboardShortcuts();
            });
        }
    });

    // Add keyboard shortcut for saving code to the browser's localStorage.
    ace_editor.commands.addCommand({
    	name: "saveCodeToLocalStorage",
    	bindKey: { win: "Ctrl-S", mac: "Command-S" },
    	exec: function(arg) {
    		save_code();
    	}
    });

    // To load the code in localStorage saved from last time.
    get_saved_code();
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

// To empty the content inside the Ace editor.
function empty_content() {
	ace_editor.setValue("");
}

// To save the code to browser's localStorage.
function save_code() {
	var code = ace_editor.getValue();

	localStorage.setItem("ace_cs1101s_dg", code);
}

// To auto-load the code saved from last time by the user on the same browser.
function get_saved_code() {
	var code = localStorage.getItem("ace_cs1101s_dg");

	if (code != null) {
		ace_editor.setValue(code);
	}
}

// To read the content of the files uploaded from local computer as plain text.
function read_upload_file() {
	// Trigger the upload of local files.
	$('#file_upload').trigger('click');

	// Notice: use DOM instead of jQuery object here.
	var file_to_read = document.getElementById("file_upload").files[0];

	var reader = new FileReader();
	reader.onload = function(load_event) {
	  ace_editor.setValue(load_event.target.result);
	};

	reader.readAsText(file_to_read, "UTF-8");
}

// To download the code to the local computer.
function download_code() {
    save_code();
}