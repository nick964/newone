<?php
/****************************************************
Name: 		login.php
Purpose: 	My-Tech Login

date		developer		comment
         	daniel vessal	created page
*****************************************************/
session_start();
$errtext = "";

if (isset($_POST['login']) === TRUE) 
{
	//look for a matching user name and password  	
	$_SESSION["LOGINOK"] = "NO";
	//open up the database
	$con = mysqli_connect('localhost','tue63367','gold3473','scratch');

	$txtUser = mysqli_real_escape_string($con,$_POST["username"]);
	$txtPass = md5(mysqli_real_escape_string($con,($_POST["password"])));
	$txtsql = "select username from users where username = '" . $txtUser . "' AND password = '" . $txtPass. "'";
		
	// $errtext = $txtsql; // just doing this to see what is being sent to the database
	
	$queryresult = mysqli_query($con,$txtsql);
	
	$array = mysqli_fetch_array($queryresult);

	//If I find at least one the LOGIN OK session will be set to "YES"
	if ($array !== NULL)
		{
		$_SESSION['user'] = $_POST["username"];
		$_SESSION['LOGINOK'] = "YES";
		}
	else
		{
		// if we got this far, then there was a form post, and also 
		// a username / password combination that did not exist in the database.
		// Put up an error message.
		$errtext = "User name and password not valid.  Please try again.";
		}
	//close the connection - i got what i needed.
	mysqli_close($con);
		
	if ($_SESSION['LOGINOK'] === "YES") 
	{
		header('Location: index.php');
	}	
}		
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset = "utf-8">
	<title> My-Tech Login </title>
	<link rel="stylesheet" type="text/css" href="css/mytechtheme.css" media="all">	
</head>
<body> 
	<div id ="header">
		<h1></h1>
		<hr>
		<h2> My-Tech Login</h2>
		<hr>
		</div>
	<div id="content">
		<form action="login.php" method="post">
		<label><strong>Employee Login:</strong></label>
		<br>
		<label for="password">Username: </label> <input type="text" name="username" id="username">
		<br>
		<label for="confirmpassword">Password:</label> <input type="password" name="password" id="password">
		<br>
		<input type="submit" value="Login>>" name="login" id="login" >
		<br>
		<?php echo $errtext; ?>
		</form>
		<hr>
		<form action="homepage/form.php" method="post">
			<h2><strong>Customer Portal:</strong></h2>
			<input type="submit" value="Help Desk Support" name="helpdesksupport" id="helpdesksupport" >
		</form>
	</div>
	<div id="footer">
		<hr>
		<em> My-Tech Support</em>
	</div>	
</body>
</html>