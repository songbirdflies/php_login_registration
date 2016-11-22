<?php
session_start();
require('new-connection.php');

	if(isset($_POST['action']) && $_POST['action'] == 'register')
	{
		register_user($_POST); //call to function, use of ACTUAL POST
	}

	elseif(isset($_POST['action']) && $_POST['action'] == 'login')
	{
		login_user($_POST); //call to function, use of ACTUAL POST
	}
	else // logging off
	{
		session_destroy();
		header('Location: index.php');
		die();
	}




	function register_user($post) // parameter called post
	//if this value doesn't work, do this
	{
		$_SESSION['errors'] = array();
		
		if(empty($post['first_name']))
		$_SESSION['errors'][] = "First name cannot be blank.";

		if(empty($post['last_name']))
		$_SESSION['errors'][] = "Last name cannot be blank.";

		if(empty($post['password']))
		$_SESSION['errors'][] = "Password field is required.";

		if($post['password'] !== $post['confirm_password'])
		$_SESSION['errors'][] = "Passwords do not match.";

		if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
		$_SESSION['errors'][] = "Email must be valid.";

	//--------------------------end of validation --------------------

		if(count($_SESSION['errors']) > 0)
		{
			header('Location: index.php');
			die();
		}
		else 
		{
			$query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at)
						VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$post['password']}', '{$post['email']}',
							NOW(), NOW())";
			
			run_mysql_query($query);
			
			$_SESSION['success_message'] = 'User successfully created! Please proceed to login.';
			header('Location: index.php');
			die();
		}
	}

	function login_user($post)
	{
		$query = "SELECT * FROM users WHERE users.password = '{$post['password']}'
					AND users.email = '{$post['email']}'";
		$user = fetch($query); // grab user with above credential
		
		if(count($user) > 0)
		{
			$_SESSION['user_id'] = $user[0]['id'];
			$_SESSION['first_name'] = $user[0]['first_name'];
			$_SESSION['logged_in'] = TRUE;
			header('Location: success.php');
			die();
		}
		else 
		{
			$_SESSION['errors'][] = "User not found. Please register.";
			header('Location: index.php');
			die();
		}
	}


?>