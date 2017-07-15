<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" integrity="sha256-xrr4HH5eSY+cFz4SH7ja/LaAi9qcEdjMpeMP49/iOLs=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-language_tools.js" integrity="sha256-VXy+5X0l6hcmHLjFjR2k2jyrxSd7Ag0EBUn7LUIo9Es=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/theme-chrome.js" integrity="sha256-2jUy9rC6tFAo+szqQ4aLVd5dyICBOH+FBV8CUU8VyZs=" crossorigin="anonymous"></script>
	<script src="editor.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="useful.css">
</head>
<body>
<?php require_once 'nav.php'; ?>
<pre id="editor"></pre>
<div class="panel panel-info" id="setting_panel">
	<div class="panel-heading">
		<div class="panel-title">
			Editor Setting
		</div>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label for="theme_select" class="control-label">Theme</label>
			<select class="form-control" name="theme_select" id="theme_select" onchange="editor_set_theme();">
				<optgroup label="Bright">
					<option value="chrome" selected>Chrome</option>
					<option value="clouds">Clouds</option>
					<option value="crimson_editor">Crimson Editor</option>
					<option value="dawn">Dawn</option>
					<option value="dreamweaver">Dreamweaver</option>
					<option value="eclipse">Eclipse</option>
					<option value="github">GitHub</option>
					<option value="iplastic">IPlastic</option>
					<option value="solarized_light">Solarized Light</option>
					<option value="textmate">TextMate</option>
					<option value="tomorrow">Tomorrow</option>
					<option value="xcode">XCode</option>
					<option value="kuroir">Kuroir</option>
					<option value="katzenmilch">KatzenMilch</option>
					<option value="sqlserver">SQL Server</option>
				</optgroup>
				<optgroup label="Dark">
					<option value="ambiance">Ambiance</option>
					<option value="chaos">Chaos</option>
					<option value="clouds_midnight">Clouds Midnight</option>
					<option value="cobalt">Cobalt</option>
					<option value="gruvbox">Gruvbox</option>
					<option value="idle_fingers">idle Fingers</option>
					<option value="kr_theme">krTheme</option>
					<option value="merbivore">Merbivore</option>
					<option value="merbivore_soft">Merbivore Soft</option>
					<option value="mono_industrial">Mono Industrial</option>
					<option value="monokai">Monokai</option>
					<option value="pastel_on_dark">Pastel on dark</option>
					<option value="solarized_dark">Solarized Dark</option>
					<option value="terminal">Terminal</option>
					<option value="tomorrow_night">Tomorrow Night</option>
					<option value="tomorrow_night_blue">Tomorrow Night Blue</option>
					<option value="tomorrow_night_bright">Tomorrow Night Bright</option>
					<option value="tomorrow_night_eighties">Tomorrow Night 80s</option>
					<option value="twilight">Twilight</option>
					<option value="vibrant_ink">Vibrant Ink</option>
				</optgroup>
			</select>
		</div>

		<div class="form-group">
			<label for="mode_select" class="control-label">Language Mode</label>
			<select class="form-control" name="mode_select" id="mode_select" onchange="editor_set_mode();">
				<optgroup label="C family">
					<option value="c_cpp">C and C++</option>
			    	<option value="csharp">C#</option>
			    	<option value="objectivec">Objective-C</option>
				</optgroup>
				<optgroup label="Database">
					<option value="mysql">MySQL</option>
					<option value="pgsql">PostgreSQL</option>
					<option value="sql">SQL</option>
					<option value="sqlserver">SQL Server</option>
				</optgroup>
			    <optgroup label="Others">
			    	<option value="css">CSS</option>
				    <option value="gitignore">Gitignore</option>
				    <option value="golang">Go</option>
				    <option value="haskell">Haskell</option>
				    <option value="html">HTML</option>
				    <option value="html_ruby">HTML (Ruby)</option>
				    <option value="java">Java</option>
				    <option value="javascript" selected>JavaScript</option>
				    <option value="json">JSON</option>
				    <option value="latex">LaTeX</option>
				    <option value="markdown">Markdown</option>
				    <option value="matlab">MATLAB</option>
				    <option value="pascal">Pascal</option>
				    <option value="perl">Perl</option>
				    <option value="php">PHP</option>
				    <option value="powershell">Powershell</option>
				    <option value="python">Python</option>
				    <option value="r">R</option>
				    <option value="ruby">Ruby</option>
				    <option value="scala">Scala</option>
				    <option value="scheme">Scheme</option>
				    <option value="swift">Swift</option>
				    <option value="text">Plain Text</option
				    <option value="xml">XML</option>
				    <option value="django">Django</option></select>
			    </optgroup>
			</select>
		</div>

		<div class="form-group">
			<label for="font_size_select" class="control-label">Font Size</label>
			<select class="form-control" name="font_size_select" id="font_size_select" onchange="editor_set_font_size();">
				<option value="10px">10px</option>
				<option value="12px" selected>12px</option>
				<option value="14px">14px</option>
				<option value="16px">16px</option>
				<option value="18px">18px</option>
				<option value="20px">20px</option>
			</select>
		</div>

		<div class="form-group">
			<label for="tab_size_select" class="control-label">Tab size</label>
			<select class="form-control" name="tab_size_select" id="tab_size_select" onchange="editor_set_tab_size();">
				<option value="2">2</option>
				<option value="4" selected>4</option>
			</select>
		</div>

		<!-- Used to upload code from files in the local computer -->
		<div class="form-group hidden">
			<input type="file" name="file_upload" class="form-control" id="file_upload" onchange="read_upload_file();">
		</div>

		<div class="btn-toolbar" role="toolbar" aria-label="Tools for text editor">
			<button type="button" class="btn btn-success" aria-label="Evaluate the code in the editor">
				<span class="glyphicon glyphicon-play" aria-hidden="true"></span>
			</button>

			<button type="button" class="btn btn-primary" aria-label="Upload code" onclick="$('#file_upload').trigger('click');">
				<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
			</button>

			<button type="button" class="btn btn-warning" aria-label="Save code" onclick="save_code();">
				<span class="glyphicon glyphicon-save" aria-hidden="true"></span>
			</button>

			<button type="button" class="btn btn-info" aria-label="Clear the code in the editor" onclick="empty_content();">
				<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
			</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	editor_init();
</script>
</body>
</html>