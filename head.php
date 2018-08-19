	<?php require_once 'theme.php'; ?>
	<title>CS1101S Studio Website 2018</title>

	<!-- Character setting, icon setting and mobile compatibility -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="favicon.ico" >

	<!-- Information for search engine -->
	<meta name="description" content="CS1101S Studio Website 2018"/>
	<meta name="keywords" content="Niu,Yunpeng,NUS,SoC,SOC,CS,CS1101S,JavaScript,Teaching">
	<meta name="author" content="Niu Yunpeng">

	<!-- Compatibility for browsers older than IE9, which do not support HTML5 new features. -->
	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<!-- Notice: we will dynamically load it here. It may vary based on the time of visiting this website. -->
	<link rel="stylesheet" href="<?php echo get_theme_link(); ?>" integrity="<?php echo get_theme_integrity(); ?>" crossorigin="anonymous">

	<!-- jQuery file, must be put before Bootstrap javascript file -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<!-- Scripts for Google Analytics -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-92228484-3', 'auto');
		ga('send', 'pageview');
	</script>

	<!-- Re-direct to HTTPS protocol automatically, for a secured better web. -->
	<?php
	if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
	    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    header('HTTP/1.1 301 Moved Permanently');
	    header("Location: $redirect_url");
	    exit();
	}
	?>