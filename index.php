<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
	<script type="text/javascript" src="useful.js"></script>
</head>
<body>
<?php
require_once 'nav.php';
?>
<div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
	<h2>
		Welcome to CS1101S Discussion Group Website 2017!<br>
		<small>Brought to you by your Avenger Niu Yunpeng.</small>
	</h2>
</div>

<?php
if (!logged_in()) {
?>
<br><br><br>
<div class="container">
	<h3>You have not logged in. You can only view the materials after logging into this website.</h3>
</div>

<?php
} else {
?>
<form method="post" action="download.php" name="download_form" id="download_form">
	<input type="hidden" name="file_id" id="file_id" value="">
</form>
<br><br>

<div class="container">
	<table class="table table-responive table-striped">
		<caption><i style="color: #FF4000;">Notice: These files are sorted according to their upload time from the most to the least recently.</i></caption>
		<thead>
			<th>File Name</th>
			<th>Author</th>
			<th>Upload Time</th>
			<th>Description</th>
			<th>Download</th>
		</thead>
		<?php
		$all_files = get_all_files();
		for ($i=0; $i < count($all_files); $i++) {
			$saveAsName = $all_files[$i]['Filename'] . ".pdf";
		?>
		<tr>
			<td><?php echo $all_files[$i]['Filename']; ?></td>
			<td><?php echo $all_files[$i]['Author']; ?></td>
			<td><?php echo $all_files[$i]['UploadTime']; ?></td>
			<td><?php echo $all_files[$i]['Description']; ?></td>
			<td><a href="javascript:void(0);" download="<?php echo $saveAsName; ?>" onclick="fill_download_form(<?php echo $all_files[$i]['Id']; ?>);">Click here</a></td>
		</tr>
		<?php
		}
		?>
	</table>
</div>
<?php
}
?>

<br><br><br><br>
<?php require_once 'footer.php'; ?>
</body>
</html>