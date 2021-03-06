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

    // Add keyboard shortcut for evaluating JavaScript code.
    ace_editor.commands.addCommand({
        name: "evaluateJavaScriptCode",
        bindKey: { win: "Ctrl-Enter", mac: "Command-Enter" },
        exec: function(arg) {
            evaluate_code();
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

// To evaluate the code in the editor (only if the language is JavaScript).
function evaluate_code() {
    if ($("#mode_select").val() === "javascript") {
        eval(ace_editor.getValue());
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
    // Avoid potential compatibility problems among different browsers.
    url_class = window.URL || window.webkitURL;

    // Save the code to browser's localStorage at first.
    save_code();

    // Create the link <a> object.
    var link_object = document.createElement("a");
    // Change the value of download attribute to force the filename.
    link_object.download = "untitled." + get_extend_filename($("#mode_select").val());

    // Create Blob object to store the code inside.
    var blob_object = new Blob([ace_editor.getValue()], { type:"text/plain" });
    // Create the temporary URL object.
    var url_object = url_class.createObjectURL(blob_object);

    // Set the value of href attribute to the url object.
    link_object.href = url_object;
    // Trigger the click of the link <a> object.
    link_object.click();

    // Destroy the URL object for better performance.
    url_class.revokeObjectURL(url_object);
}

// To empty the content inside the Ace editor.
function empty_content() {
    ace_editor.setValue("");
}

/***********************************************************
* Helper functions
***********************************************************/
function get_extend_filename(language) {
    switch (language) {
        case "c_cpp":
            return "cpp";
        case "csharp":
            return "cs";
        case "objectivec":
            return "mm";
        case "mysql":
        case "pgsql":
        case "sql":
        case "sqlserver":
            return "sql";
        case "css":
            return "css";
        case "django":
            return "py";
        case "html":
            return "html";
        case "html_ruby":
            return "html.erb";
        case "javascript":
            return "js";
        case "php":
            return "php";
        case "xml":
            return "xml";
        case "gitignore":
            return "gitignore";
        case "golang":
            return "py";
        case "haskell":
            return "hs";
        case "java":
            return "java";
        case "json":
            return "json";
        case "latex":
            return "tex";
        case "markdown":
            return "md";
        case "matlab":
            return "m";
        case "pascal":
            return "pas";
        case "perl":
            return "pl";
        case "powershell":
            return "ps1";
        case "python":
            return "py";
        case "r":
            return "r";
        case "scala":
            return "scala";
        case "scheme":
            return "scm";
        case "swift":
            return "swift";
        case "text":
        default:
            return "txt";
    }
}