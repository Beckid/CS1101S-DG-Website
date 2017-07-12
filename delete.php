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

// To represent the type of the error.
$result = -1;

// Only admin users can delete files.
if (!logged_in() || $_SESSION['usertype'] != "admin") {
	header("location: index.php");
} else if ($_POST) {
	$checked = $_POST['select_file'];

	if (count($checked) != 1) {
		$result = 1;
	} else {
		$selected = $checked[0];

		if (!is_numeric($selected)) {
			$result = 2;
		} else if(!file_delete($selected)) {
			$result = 3;
		} else {
			// Record that the delete is successful.
			$result = 0;
		}
	}
}
?>

<h1>Delete Files<small> (For Admin only)</small></h1>
<br><br>

<div class="container">
	<form role="form" id="delete_form" method="post" action="delete.php">
		<div id="error_message" class="">
			<?php
			if ($result > 0) {
			?>
				<script type="text/javascript">add_alert_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php
				if ($result == 1) {
					echo "Input error: You should select <i>only <b>one</b></i> file to delete.";
				} else if ($result == 2) {
					echo "Input error: Please use the given button to submit the form.";
				} elseif ($result == 3) {
					echo "Server error: The selected file could not be deleted. Please contact the system admin.";
				} else {
					echo "Unknown error: Please contact the system admin.";
				}
			} else if ($result == 0) {
			?>
				<script type="text/javascript">add_success_class();</script>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?php
				echo "Successful: You have deleted the selected file.";
			}
			?>
		</div>
		<br>

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
			for ($i = 0; $i < count($all_files); $i++) {
			?>
			<tr>
				<td><?php echo $all_files[$i]['file_name']; ?></td>
				<td><?php echo $all_files[$i]['author']; ?></td>
				<td><?php echo $all_files[$i]['uploaded_at']; ?></td>
				<td><?php echo $all_files[$i]['description']; ?></td>
				<td><input type="checkbox" name="select_file[]" value="<?php echo $i; ?>" onchange="get_selected_file_name();"></td>
			</tr>
			<?php
			}
			?>
		</table>

		<!-- A pop-up modal will be shown to confirm the user wants to delete the selected file. -->
		<button type="button" class="btn btn-success" id="delete_form_submit" data-toggle="modal" data-target="#submit_modal">Submit</button>
		<button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Cancel</button>
		<script type="text/javascript">get_selected_file_name();</script>
	</form>
</div>

<!-- Below is the code for Bootstrap modal popup window. -->
<div class="modal" id="submit_modal" tabindex="-1" role="dialog" aria-labelledby="submit_modal_label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="submit_modal_label">Confirmation: Are you <i>absolutely</i> sure to do this?</h4>
			</div>

			<div class="modal-body">
				<p>Are you sure to delete the selected file "<mark id="modal_file_name">_file_name_</mark>"? This action <b>CANNOT be undone</b>. If you are willing to do so and understand all the consequences of your action, please type (<i>copy-and-paste has been disabled.</i>) the name of the selected file in the field below:</p>

				<input type="text" id="file_name_verify" class="form-control" placeholder="Type the name of the file" onpaste="return false;"
				 onchange="verify_name();" oninput="verify_name();">
			</div>

			<div class="modal-footer">
				<button type="button" id="confirm_submit" class="btn btn-danger" onclick="submit_delete_form();">Delete</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" autofocus>Cancel</button>
				<script type="text/javascript">verify_name();</script>
			</div>
		</div>
	</div>
</div>
<br><br><br><br>

<?php
require_once 'footer.php';
?>
</body>
</html>