<?php
// Set the default timezone to be Singapore local time.
// Noitce this setting only applies to the current script.
date_default_timezone_set('Asia/Singapore');

$themes = array(
	array("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css",
		  "sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css",
		  "sha384-zF4BRsG/fLiTGfR9QL82DrilZxrwgY/+du4p/c7J72zZj+FLYq4zY00RylP9ZjiT"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css",
		  "sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cyborg/bootstrap.min.css",
		  "sha384-D9XILkoivXN+bcvB2kSOowkIvIcBbNdoDQvfBNsxYAIieZbx8/SI4NeUvrRGCpDi"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/darkly/bootstrap.min.css",
		  "sha384-S7YMK1xjUjSpEnF4P8hPUcgjXYLZKK3fQW1j5ObLSl787II9p8RO9XUGehRmKsxd"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css",
		  "sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/journal/bootstrap.min.css",
		  "sha384-1L94saFXWAvEw88RkpRz8r28eQMvt7kG9ux3DdCqya/P3CfLNtgqzMnyaUa49Pl2"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css",
		  "sha384-gv0oNvwnqzF6ULI9TVsSmnULNb3zasNysvWwfT/s4l8k5I+g6oFz9dye0wg3rQ2Q"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css",
		  "sha384-awusxf8AUojygHf2+joICySzB780jVvQaVCAt1clU3QsyAitLGul28Qxb2r1e5g+"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/readable/bootstrap.min.css",
		  "sha384-Li5uVfY2bSkD3WQyiHX8tJd0aMF91rMrQP5aAewFkHkVSTT2TmD2PehZeMmm7aiL"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/sandstone/bootstrap.min.css",
		  "sha384-G3G7OsJCbOk1USkOY4RfeX1z27YaWrZ1YuaQ5tbuawed9IoreRDpWpTkZLXQfPm3"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/simplex/bootstrap.min.css",
		  "sha384-C0X5qw1DlkeV0RDunhmi4cUBUkPDTvUqzElcNWm1NI2T4k8tKMZ+wRPQOhZfSJ9N"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/slate/bootstrap.min.css",
		  "sha384-RpX8okQqCyUNG7PlOYNybyJXYTtGQH+7rIKiVvg1DLg6jahLEk47VvpUyS+E2/uJ"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/solar/bootstrap.min.css",
		  "sha384-GC77SCz5O11gVtXl0sSfbQYEWSSznn1wPDHgL1BGUTFU9iEoUrG4IOJa5CBVY8kR"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/spacelab/bootstrap.min.css",
		  "sha384-L/tgI3wSsbb3f/nW9V6Yqlaw3Gj7mpE56LWrhew/c8MIhAYWZ/FNirA64AVkB5pI"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/superhero/bootstrap.min.css",
		  "sha384-Xqcy5ttufkC3rBa8EdiAyA1VgOGrmel2Y+wxm4K3kI3fcjTWlDWrlnxyD6hOi3PF"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/united/bootstrap.min.css",
		  "sha384-pVJelSCJ58Og1XDc2E95RVYHZDPb9AVyXsI8NoVpB2xmtxoZKJePbMfE4mlXw7BJ"),
	array("https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/yeti/bootstrap.min.css",
		  "sha384-HzUaiJdCTIY/RL2vDPRGdEQHHahjzwoJJzGUkYjHVzTwXFQ2QN/nVgX7tzoMW3Ov"));

function get_current_theme_num() {
	global $themes;
	// Hacky here: no need for data type conversion.
	return date('j') % count($themes);
}

function get_theme_link() {
	global $themes;
	return $themes[get_current_theme_num()][0];
}

function get_theme_integrity() {
	global $themes;
	return $themes[get_current_theme_num()][1];
}
?>