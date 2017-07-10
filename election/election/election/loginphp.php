<!-- PHP Logic start -->
<?php
session_start();
$errmessage = "";
$errmessage1 = "";
$success = true;
$errmessage2 = "";
$successmessage = "";


if(isset($_SESSION['formCompleted']))
{
	if($_SESSION['formCompleted']==true)
	{
		$successmessage = '<div class="alert alert-dismissible alert-success">
											<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button>
											Account has been successfully created!</a>
										</div>';
		session_destroy();
		$_SESSION['formCompleted'] = false;
	}
}

if (isset($_POST['submit'])){
$message=NULL;
require_once('../mysql_connect.php');
$query="select username,password,userType,userID from user_account";
$result=mysqli_query($dbc,$query);
$username = "";
$password = "";
$flag = 0;
$login = "";
$userID ="";
$positionCode="";
$checkuser = true;
$checkpass = true;

 if (empty($_POST['username'])){
  $_POST['username']=FALSE;
  $errmessage1="<p class='text-danger'>Please input username</p>";
  $login = false;
  $checkuser = false;
 } 
 else{
	$username = $_POST['username'];	
 }
 if (empty($_POST['password'])){
  $_POST['password']=FALSE;
  $errmessage2="<p class='text-danger'>Please input password!</p>";
  $login = false;
  $checkpass= false;
 } else {
  $password = $_POST['password'];
 }

while( $row=mysqli_fetch_array($result,MYSQL_ASSOC)){ 
	if(strtolower($username) == strtolower($row['username']) && crypt($password, '$1$!@#OK$')== $row['password'])
	{
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		
		$usertype = $row['userType'];
		$_SESSION['userType'] = $usertype;
		$userID = $row['userID'];
		$_SESSION['userID'] = $userID;
		
		$login = true;
	}	
}

if($login == false && $checkuser == true && $checkpass == true){
	$errmessage="<div class='alert alert-danger'>
					<p>Username or password is incorrect!</p>
				</div>";
}

else if($login == true){	
	if($usertype == 1)
	{	
		$query="Select employeeID,userID, positionCode from employee";
		$result=mysqli_query($dbc,$query);
		while($row = mysqli_fetch_array($result,MYSQL_ASSOC))
		{
			if($_SESSION['userID'] == $row['userID'])
			{	
				$_SESSION['positionCode'] = $row['positionCode'];
				$positionCode = $row['positionCode'];
				$_SESSION['employeeID'] = $row['employeeID'];
			}
		}
		if($_SESSION['positionCode'] == 1) // Admin
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexAdmin.php");
		else if($_SESSION['positionCode'] == 2) // Company Head
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexHeads.php");
		else if($_SESSION['positionCode'] == 3) // Sales Manager
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexSalesManager.php");
		else if($_SESSION['positionCode'] == 4) // Sales Agent
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexAgent.php");
		else if($_SESSION['positionCode'] == 5) // Plant Manager
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexWarehouse.php");	
	}
	
	else if($usertype == 2) // client
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/indexClient.php");
	else if($usertype == 3) // Pending account
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/pending.php");
	else if($usertype == 4) // Inactive account
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/inactive.php");
}

}




?>

<!-- PHP Logic end-->

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>DLSU Student Database - Login</title>

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

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	
	<div class="login-page bk-img" style="background-color: #11111;">
		<div class="form-content">
			<div class="container">
				<div class ="row">

					<div class="col-md-8 col-md-offset-2 mt-2x">
						<img src="img/comp1.jpg" class="img-responsive" alt="">	
						<div class="col-md-9 col-md-offset-1">
							<div class="well row pb-1x bk-light">							
								<div class="form-group">
								<div class="col-md-5">
													
								<img src="img/login	.png" class="img-responsive" alt="">	
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
								<?php echo "$successmessage";?>
									
										
										<?php echo "$errmessage";?>

										<label for="" class="text-uppercase text-sm">Username</label>
										<input type="text" class="form-control mb" name="username" size="20" maxlength="30" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"\>
										<?php echo "$errmessage1";?>
										
										<label for="" class="text-uppercase text-sm">Password</label>
										<input type="password" class="form-control mb" name="password" size="20" maxlength="30"  value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"\>
										<?php echo "$errmessage2";?>
										
										<button class="btn btn-primary btn-block" name = "submit" type="submit">LOGIN</button>
										<div class="hr-dashed"></div>
										<div class="text-center"> New Client? <a href="registerClient.php"><strong>Register here.</strong></a>
										</div>
									</form>
									
									</div>
								</div>
							</div>
							
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