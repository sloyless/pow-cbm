<?php
	require_once('../views/head.php');

	$last_series_id_query = "select series_id from series ORDER BY series_id DESC LIMIT 1";
	$series_query = "SELECT series_id, series_name FROM series";
	// $writer_query = "SELECT writer_name FROM writer_link LEFT JOIN writers ON (writers.writer_id = writer_link.writer_id) WHERE writer_link.comic_id = $_GET[comic_id]";
	$series_list = mysqli_query ( $connection, $series_query );
	$last_series_id = mysqli_query ( $connection, $last_series_id_query );
	// $writer = mysqli_query($connection,$writer_query);

	if (mysqli_num_rows ( $last_series_id ) > 0) {
		while ( $row = mysqli_fetch_assoc ( $last_series_id ) ) {
			$new_series_id = ++ $row ['series_id'];
		}
	} else {
		echo "0 results.";
	}

	if (mysqli_num_rows ( $series_list ) > 0) {
		$dropdown = "<select class=\"element select medium\" id=\"element_6\" name=\"series_name\">\n";
		$dropdown .= "<option value=\"\" selected=\"selected\"></option>\n";
		while ( $row = mysqli_fetch_assoc ( $series_list ) ) {
			$series_id = $row ['series_id'];
			$series_name = $row ['series_name'];
			$dropdown .= "<option value=\"$series_id\" >" . $series_name . "</option>\n";
		}
		$dropdown .= "</select>";
	} else {
		$dropdown = "<input id=\"element_6\" name=\"series_name\" class=\"element text medium\" type=\"text\" maxlength=\"255\" value=\"\"/>";
	}
	mysqli_close ( $connection );
?>
	<title>Admin</title>
</head>
<body>
<?php
	include(__ROOT__.'/views/header.php');
	if ($login->isUserLoggedIn () == false) {
		include(__ROOT__."/views/not_logged_in.php");
		die ();
	}
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<p>
				If the series had a regular monthly release, you may enter the published date of the first issue.
				<br/>
				Each entry will automatically have the month incremented.
				</p>
				<form id="input_select" method="post" action="multiaddprocess.php">
					<label for="series_name">Series</label>
				  <?php echo $dropdown; ?>
				  <br/>
				  <label for="first_issue">First Issue</label>
				  <input name="first_issue" type="text" maxlength="3" />
				  <br/>
					<label for="last_issue">Last Issue</label>
					<input name="last_issue" type="text" maxlength="3" />
					<br/>
					<label for="original_purchase">Purchased When Released:</label>
            		<input name="original_purchase" value="1" type="radio" />Yes
            		<input name="original_purchase" value="0" type="radio" />No
            		<br/>
            		<label for="release_date">First Comic's Published Date</label>
				  	<input name="release_date" type="text" maxlength="10" placeholder="YYYY-MM-DD"/>
				  	<br/>
					<input type="submit" name="submit" value="Submit" />
				</form>
			</div>
		</div>
	</div>
<?php include(__ROOT__.'/views/footer.php'); ?>
</html>