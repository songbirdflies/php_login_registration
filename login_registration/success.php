<?php
session_start();
	
?>
<html>
	<head>
		<title>Login Successful</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	</head>

	<body>
		<div id="container">
			<h3><?php echo "Howdy {$_SESSION['first_name']}!"; ?></h3>
			<p>You have successfully logged in.</p>
			<a href="process.php">Log out</a>
		</div>
	</body>
</html>