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
							
							
							
							<form action="indexClient.php" method="post">
            <fieldset style="width:570px">
                <legend><b> FILTER OPTIONS </b></legend>
       
           
		   
		   
        <table border="0">
            
			
		
			
            <tr>
            <td><label class="col-sm-2 control-label">University</label></td>
            <td>
			
			<?php

				$query = ("SELECT DISTINCT ed.university as 'UniversityList' FROM election_data ed");
            
				$result = mysqli_query($dbc,$query);	

				echo "<select multiple size='8' name='university[]' id='universityDropdown'>";
				echo "<option selected value ='default'> ALL UNIVERSITIES </option>";
				while ($row = $result->fetch_assoc()) {
					unset($university);
					$university = $row['UniversityList']; 
					echo '<option value="'.$university.'">'.$university.'</option>';
				}

				echo "</select>";

			?> 
				 
            
            <tr>
                <td><label class="col-sm-2 control-label">Youngest</label></td>
                <td align="left"><input class="form-control" type="number" name="startAge" min="0" max ="99" /></td>
            </tr>
            
            <tr>
                <td><label class="col-sm-2 control-label">Oldest</label></td>
                <td align="left"><input class="form-control" type="number" name="endAge" min="0" max ="99"/></td>
            </tr>
			
            
            <tr>  
                <td colspan="2" align="right"><input type="submit" class="btn btn-primary" name = "filter" value="F i l t e r"/></td>
            </tr>
            
        </table>
            </fieldset>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th style="text-align:center">Surname</th>
											<th style="text-align:center">Name</th>
											<th style="text-align:center">Birthday</th>
											<th style="text-align:center">University</th>
										</tr>
									</thead>
									<tbody>
									

				

								<?php
									
									
									if ($_SERVER['REQUEST_METHOD'] == 'POST') {
									
										$university = implode("','", $_POST['university']);
									}
									
									
									
									if(isset($_POST['filter']) && ($_POST['startAge'] < $_POST['endAge'])){
										$dateone = $_POST['startAge'];
										$datetwo = $_POST['endAge'];
										
										if($university !="default"){
											
											$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university' FROM election_data WHERE UNIVERSITY in ('$university') AND TIMESTAMPDIFF(YEAR,birthday,CURDATE()) BETWEEN '{$dateone}' AND '{$datetwo}'";
											
											$result=mysqli_query($dbc,$query);
											makeTable($result);	
										}
										else{
											
											$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university'
												FROM ELECTION_DATA
												WHERE TIMESTAMPDIFF(YEAR,birthday,CURDATE()) BETWEEN '{$dateone}' AND '{$datetwo}'";
											$result=mysqli_query($dbc,$query);
											
											makeTable($result);
										}
										
									}else if(isset($_POST['filter']) && ($_POST['startAge'] > $_POST['endAge'])){
										
										$mystring = '<span style="color: red;">PLEASE ENTER VALID AGE RANGE!</span>';
										echo $mystring;
										
									}
									else if(isset($_POST['filter']) && ($_POST['startAge'] == '' || $_POST['endAge']=='')){
										
										if($university !="default"){
											
												$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university' FROM election_data WHERE UNIVERSITY in ('$university')";
												$result=mysqli_query($dbc,$query);
												makeTable($result);	
										}
										else{
											
											$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university'
												FROM ELECTION_DATA;";
											$result=mysqli_query($dbc,$query);
											
											makeTable($result);
										}
									
									}
									else if(isset($_POST['filter']) && ($_POST['startAge']==$_POST['endAge']) && ($_POST['startAge']>=0 || $_POST['endAge']>=0)){
										
										$dateone = $_POST['startAge'];
										$datetwo = $_POST['endAge'];
										
										if($university !="default"){
											
												$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university' 
												FROM election_data WHERE UNIVERSITY in ('$university')
												AND TIMESTAMPDIFF(YEAR,birthday,CURDATE()) = '{$dateone}'";
												$result=mysqli_query($dbc,$query);
												makeTable($result);	
										}
										else{
											
											$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university'
												FROM ELECTION_DATA 
												WHERE TIMESTAMPDIFF(YEAR,birthday,CURDATE()) = '{$dateone}'";
											$result=mysqli_query($dbc,$query);
											
											makeTable($result);
										}
										
										
										
									}
									else{
											$query="SELECT NAME as 'name', SURNAME as 'surname', DATE(BIRTHDAY) as 'birthday', UNIVERSITY as 'university'
											FROM ELECTION_DATA;";
											$result=mysqli_query($dbc,$query);
											
											makeTable($result);
										
									}
									
				
									function makeTable($result) {
    
										while($row=mysqli_fetch_array($result,MYSQL_ASSOC)){
										echo "<tr>
										<td>{$row['surname']}</td>
										<td>{$row['name']}</td>
										<td>{$row['birthday']}</td>
										<td>{$row['university']}</td>
										</tr>";
										}
										 echo '</tbody>';
										 echo '</table>';
										 
									}

	
									

								?>
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