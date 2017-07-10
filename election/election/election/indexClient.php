<link rel="shortcut icon" type="image/png" href="img/favicon.ico">
<?php
session_start();
require_once('../mysql_connect.php');
if ($_SESSION['userType']!=2) 
       header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/loginphp.php");
else{
$username = $_SESSION["username"];

}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Client Menu</title>

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
	<div class="brand clearfix">
		<a href="indexClient.php" class="logo"><img src="img/logo.jpg" class="img-responsive" alt="" width="230" height="100"></a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li class="ts-account">
				<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""><?php echo "$username"; ?> <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>		
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>

	<div class="ts-main-content">
		<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
				<li class="ts-label">Menu</li>
				<li class="open"><a href="indexClient.php"><i class="fa fa-home"></i>Home</a></li>
				

				<!-- Account from above -->
				<ul class="ts-profile-nav">
					<li><a href="#">Help</a></li>
					<li><a href="#">Settings</a></li>
					<li class="ts-account">
						<a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
							<li><a href="#">My Account</a></li>
							<li><a href="#">Edit Account</a></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>

			</ul>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Welcome, <?php echo $username;?>!</h2>

						

					</div>
				</div>

			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Election Results</h2>
						<div class="panel panel-default">
							<div class="panel-heading"></div>
							<div class="panel-body">
								<form action="indexClient.php" method = "POST">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th style="text-align:center">Location</th>
											<th style="text-align:center">Position</th>
											<th style="text-align:center">Fullname</th>
											<th style="text-align:center">Nickname</th>
											<th style="text-align:center">Party</th>
											<th style="text-align:center">Votes</th>
										</tr>
									</thead>
									<tbody>
									
									<?php 
									
									$query="SELECT * FROM election_data";
									$result=mysqli_query($dbc,$query);
							
									 while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){
									echo "<tr>
									<td>{$row['location']}</td>
									<td>{$row['position']}</td>
									<td>{$row['fullname']}</td>
									<td>{$row['nickname']}</td>
									<td>{$row['party']}</td>
									<td>{$row['votes']}</td>
									</tr>";
									}
																	
									
									?>

									</tbody>
								</table>
							</div>
							<div class="form-group">
								<div class = "col-md-12" align="right" >
									<div class = "col-sm-6">
									<button class="btn btn-primary" type="submit" name = "updateCart">Update</button>
									<p>
									</div>
								</div>
							</div>
							</form>
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