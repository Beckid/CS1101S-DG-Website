<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'nav.php';

// Only admin users can upload files.
if (!logged_in() || $_SESSION['usertype'] != "admin") {
	header("location: index.php");
} else if ($_POST) {
	
}
?>

<h1>Delete Files<small> (For Admin only)</small></h1>
<br><br><br>

<div class="container">
	<form role="form" method="post" action="delete.php">
		<table class="table table-responive table-striped">
			<caption><i style="color: #FF4000;">
				Notice: These files are sorted according to their upload time from the most to the least recently.
			</i></caption>
			<thead>
				<th>File Name</th>
				<th>Author</th>
				<th>Upload Time</th>
				<th>Description</th>
				<th>Delete</th>
			</thead>
			<?php
			$all_files = get_all_files();
			for ($i=0; $i < count($all_files); $i++) {
			?>
			<tr>
				<td><?php echo $all_files[$i]['Filename']; ?></td>
				<td><?php echo $all_files[$i]['Author']; ?></td>
				<td><?php echo $all_files[$i]['UploadTime']; ?></td>
				<td><?php echo $all_files[$i]['Description']; ?></td>
				<td></td>
			</tr>
			<?php
			}
			?>
		</table>

		<!-- A pop-up window will be shown to confirm the user wants to delete the selected file. -->
		<button type="submit" class="btn btn-success">Submit</button>

		<button class="btn btn-primary" onclick="window.location.href='index.php'">Cancel</button>
	</form>
</div>
<br><br><br><br>

<?php
require_once 'footer.php';
?>
</body>
</html>