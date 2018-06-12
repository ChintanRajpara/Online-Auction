<?php 
session_start();
include('db.php');



if(isset($_SESSION['admin_login'])) {
    $row_c = $_SESSION['admin_login'];
    print_r($row_c);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<style type="text/css">
.right {
    margin: 20px;
    position: absolute;
    top: 0;
    right: 0;
}
</style>
<body>
	<div class="right">
    	<a class="btn btn-danger" href="logout.php">LOGOUT</a>
    </div>

	<div>
		<a class="btn btn-primary btn-lg btn-block mt-5" href="view.php">View All Users</a>
		<a class="btn btn-primary btn-lg btn-block mt-5" href="admin_product.php">View All Product</a>
	</div>
	
</body>
</html>