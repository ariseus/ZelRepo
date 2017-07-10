<!-- START OF PHP LOGIC -->
<?php
session_start();
require_once('../mysql_connect.php');

$success = true;
$flag = 0;
$usertype = 2;
$username = "";
$sameuser = false;
$checkTIN = true;
$checkSameTIN = false;
$samemail = false;
$errmessage1 = "";
$errmessage2= "";
$errmessage3="";
$errmessage4="";
$errmessage5="";
$errmessage6="";
$errmessage7="";
$errmessage72="";
$errmessage8="";
$successmessage="";


if(isset($_POST['submitClient']))
{
	$message = NULL;
	$TIN = null;
	$checkTIN = true;
	
	if(empty($_POST['clientName']))
	{
		$clientName = false;
		$errmessage1="<p class='text-danger'>Please input your name!</p>";
		$success = false;
	}
	else
	{
		$clientName = $_POST['clientName'];
	}
	
	if(empty($_POST['email']))
	{
		$email = false;
		$errmessage2="<p class='text-danger'> Please input your email!";
		$success = false;
	}
	else
	{
		$email = $_POST['email'];
		$query="select email from client";
		$result=mysqli_query($dbc,$query);
		while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
		{//checks the db if match is true.
			
			if(strtolower($email) == strtolower($row['email']))
			{

				$samemail = true;
				$errmessage2="<p class='text-danger'>This email has already been taken! Please input new email!";
				$email = false;	
				$success = false;
				
			}
		}
		$query="select email from employee";
		$result=mysqli_query($dbc,$query);
		while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){
			if(strtolower($email) == strtolower($row['email']))
			{

				$samemail = true;
				$errmessage2="<p class='text-danger'>This email has already been taken! Please input new email!";
				$email = false;	
				$success = false;
				
			}
		}
	}
	
	if(empty($_POST['contactNumber']))
	{
		$contactNumber = false;
		$errmessage4="<p class='text-danger'> Please input your contact number!";
		$success = false;
	}
	else
	{
		$contactNumber = $_POST['contactNumber'];
	}
	
	
	
	if(empty($_POST['username']))
	{ // checks if user has no input 
		$username = false;
		$errmessage6="<p class='text-danger'>Username not found! Please input your username!";
		$success = false;
	}
	else
	{ // if user has input, checks if username is taken, sets $sameuser to true if it is taken.
		if(strlen($_POST['username']) >= 6 && strlen($_POST['username']) <= 24)
		{
			$username = $_POST['username'];
			$query="select username from user_account";
			$result=mysqli_query($dbc,$query);
			while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
			{//checks the db if match is true.
				
				if(strtolower($username) == strtolower($row['username']))
				{

					$sameuser = true;
					$errmessage6="<p class='text-danger'>This username has already been taken! Please input new username!";
					$success = false;
					$username = false;	
					
				}
			}
		}
		else
		{
			$errmessage6="<p class='text-danger'> Only 6 up to 24 characters allowed for username!";
			$success = false;
		}
	}	
	if(empty($_POST['password']))
	{
		$password = false;
		$errmessage7="<p class='text-danger'> Password not found! Please input password!";
		$success = false;
		
	}
	else
	{
		$password = $_POST['password'];
		$password = crypt($password, '$1$!@#OK$');		// encryption of password
		if(empty($_POST['rPassword']))
		{
			
			$errmessage7="<p class='text-danger'> Please re-enter your password!";
			$success = false;
		
		}
		else
		{
			
			$rPassword = $_POST['rPassword'];
			$rPassword = crypt($rPassword, '$1$!@#OK$');
			if($password != $rPassword)
			{
				$errmessage72="<p class='text-danger'> Both passwords do not match!";
				$success = false;
			}
		}
		
	}
	
	if($success)
	{
		$query2 = "insert into user_account(usertype, username, password) values(
		'{$usertype}','{$username}','{$password}')";
		$result = mysqli_query($dbc,$query2);
		
		
		$row=mysqli_fetch_array($result,MYSQL_ASSOC);
		
		$query3 = "insert into client(userID,clientName,contactNo,email) values
		((SELECT MAX(userID) FROM (user_account)),'{$clientName}','{$contactNumber}', '{$email}')";
		$result = mysqli_query($dbc,$query3);
		 if (isset($_POST['email']))  {
  
  //Email information
  $admin_email = "renzellbarros@gmail.com";
  $email = $_POST['email'];
  $subject = "All done!";
  $comment =  'Thank you for registering!';
  
  //send email
  mail($admin_email, "$subject", $comment, "From:" . $email);
  }
		$_SESSION['formCompleted'] = true; 	
		echo "<script>
				window.location = 'loginphp.php';
			  </script>";
		$successmessage='<div class="alert alert-success">Account created!</div>';

		
//if "email" variable is filled out, send email
 
		$flag = 1;
	}
	
}// end of submit condition



?>
<!-- END OF PHP LOGIC -->


<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Registration</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Font Style -->
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet"> 

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	
</head>

<body>
	
	<div class="login-page bk-img" style="background-image: url(img/register.jpg);">
		<div class="form-content">
			<div class="container">
					<div class ="row">
						<div class ="col-md-12">
							<h1 class="text-center  text-light mt-4x" style ="font-family: 'Oswald';">S T U D E N T  &nbsp; D A T A B A S E</h1>
							<h4 class="text-center text-light" style ="font-family: 'HelveticaThin';  "> D e v e l o p e d &nbsp; b y &nbsp; C.M Dev Solutions</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<h2 class="text-center text-bold text-light " style ="font-family: 'Titillium Web', sans-serif;">Sign up</h2>
							<div class="well row pt-x pb-3x bk-dark">
								<div class="col-md-10 col-md-offset-2">
									<!-- FORM STARTS HERE -->
									<form method="post" class="form-horizontal" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
											<?php echo "$successmessage";?>
											
											<div class="hr-dashed"></div>

											<div class="form-group">
												<label class="col-sm-2 control-label text-light">Full Name</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name = "clientName" value = "<?php if (isset($_POST['clientName']) && !$flag) echo $_POST['clientName']; ?>">

													<?php echo "$errmessage1";?>
												</div>
											</div>
											<div class="hr-dashed"></div>

											<form method="post" class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-2 control-label text-light">E-mail</label>
												<div class="col-sm-8">
													<input type="text" name="email" class="form-control" value = "<?php if (isset($_POST['email']) && !$flag) echo $_POST['email']; ?>">
													<?php echo "$errmessage2";?>
												</div>
											</div>
											<div class="hr-dashed"></div>

											<form method="post" class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-2 control-label text-light">Username</label>
												<div class="col-sm-8">
													<input type="text" name = "username" class="form-control" value = "<?php if (isset($_POST['username']) && !$flag) echo $_POST['username']; ?>">
													<?php echo "$errmessage6";?>
												</div>
											</div>
											<div class="hr-dashed"></div>

											<div class="form-group">
												<label class="col-sm-2 control-label text-light">Password</label>
												<div class="col-sm-8">
													<input type="password" name="password" class="form-control" name="password" value = "<?php if (isset($_POST['password']) && !$flag) echo $_POST['password']; ?>">
													<?php echo "$errmessage7";?>
												</div>
											</div>
<div class="hr-dashed"></div>
											<div class="form-group">
												<label class="col-sm-2 control-label text-light">Re-enter Password</label>
												<div class="col-sm-8">
													<input type="password" class="form-control" name="rPassword" value = "<?php if (isset($_POST['rPassword']) && !$flag) echo $_POST['rPassword']; ?>">
													<?php echo "$errmessage72";?>
												</div>
											</div>

											
<div class="hr-dashed"></div>
											<form method="get" class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-2 control-label text-light">Contact Number</label>
												<div class="col-sm-8">
													<input type="text" name ="contactNumber" class="form-control" value = "<?php if (isset($_POST['contactNumber']) && !$flag) echo $_POST['contactNumber']; ?>">
													<input type="hidden" name ="formCompleted" value = "false">
													<?php echo "$errmessage4";?>
												</div>
											</div>
											

											
									<div class="hr-dashed"></div>
									<div class="col-sm-8 col-sm-offset-4">
											
											<button class="btn btn-primary" name="submitClient" type="submit">Submit</button>
											<a href = "loginphp.php" class="btn btn-primary" name="back" type="submit">Back</a>
											
											
										</div>





									</form>

									<!-- FORM ENDS HERE -->
								</div>
							</div>
							<div class="text-center text-light">
								New Client? <a href="#" class="text-light">Register here.</a>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
	
	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</body>

</html>