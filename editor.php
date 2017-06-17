<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" integrity="sha256-xrr4HH5eSY+cFz4SH7ja/LaAi9qcEdjMpeMP49/iOLs=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-language_tools.js" integrity="sha256-VXy+5X0l6hcmHLjFjR2k2jyrxSd7Ag0EBUn7LUIo9Es=" crossorigin="anonymous"></script>
	<script src="useful.js" type="text/javascript"></script>
	<style type="text/css">
		#editor {
		    margin: 0;
		    position: absolute;
		    width: 500px;
		    height: 90%;
		}
	</style>
</head>
<body>
<?php require_once 'nav.php'; ?>
<pre id="editor"></pre>
<script type="text/javascript">
	init_editor();
</script>
</body>
</html>