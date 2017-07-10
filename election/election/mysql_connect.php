<?php
$dbc=mysqli_connect('localhost:3306','root','Philippians4:13','db-election');

if (!$dbc) {
 die('Could not connect: '.mysql_error());
}

?>