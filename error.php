<?php session_start (); ?>
<!DOCTYPE html>
<html>
	<head>
			<meta charset="ISO-8859-1">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
			<title>Wavyleaf Map Signup</title>
			<link rel="stylesheet" type="text/css" href="inc/css/bootstrap.min.css">
			<script language="javascript" type="text/javascript" src="inc/js/jquery-2.1.4.min.js"></script>
			<script language="javascript" type="text/javascript" src="inc/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<br>
			<div class="panel panel-danger">
				<div class="panel-heading"><h3 id="title" class="panel-title">Error! <?php echo $_SESSION['error_title']; ?></h3></div>
				<div class="panel-body">
					Error message:<br>
					<blockquote><?php echo $_SESSION['error']; ?></blockquote>
				</div>
			</div>
		</div>
	</body>
</html>