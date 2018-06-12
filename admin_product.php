<?php 
session_start();
include('db.php');



if(isset($_SESSION['admin_login'])) {
    $row_c = $_SESSION['admin_login'];
    //print_r($row_c);
}


if (isset($_REQUEST['sid'])) {
  	$sid = $_REQUEST['sid'];
  	$status = $_REQUEST['status'];
  	$pro_id = $_REQUEST['pro_id'];
  	if ($status == "Enable") {
  		$update = "Disable";
  	} else {
  		$update = "Enable";
  	}
  	$query2 = "update tbl_product set status = '$update' where pro_id = '$pro_id' ";
  	$con->query($query2);
  	header("location:product.php");
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>admin product</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<style>
	
tr:nth-child(odd) {
	background-color: lightgray;
}

tr:nth-child(even) {
	background-color: lightblue;
}

tr:nth-child(1) {
	background-color: #007bff;
	color: white;
}
.right {
    margin: 20px;
    position: absolute;
    top: 0;
    right: 0;
}
</style>
<body>
	<?php
    if (isset($_SESSION['admin_login'])) {
        ?>
        <div>
            <h2>Welcome <?php echo $row_c->name." ".$row_c->surname;?></h2>
            
        </div>
        <div class="right">
          <a class="btn btn-danger" href="logout.php">LOGOUT</a>
        </div>
        <?php
    }
    ?>
	<form method="post">
		<table class="mt-5 mb-3" align="center" cellspacing="0" cellpadding="5" width="65%">
			<tr align="center">
				<th>Product ID</th>
				<th>Name</th>
				<th>Price by Seller</th>
                <th>Total Bids</th>
				<th>Description</th>
				<th>Status</th>
                <th>Selling Price</th>
				<!--<th>Action</th>-->
			</tr>
			<?php
            $query1 = "select * from tbl_product";
            $run_q1 = $con->query($query1);
            while ($row_q1 = $run_q1->fetch_object()) {
            ?>		
 			<tr align="center">
 				<td><?php echo $row_q1->pro_id; ?></td>

 				<td><?php echo $row_q1->name; ?></td>
 				<td><?php echo $row_q1->price; ?></td>

                <?php
                $query3 = "select * from tbl_bid where pro_id = $row_q1->pro_id";
                $run_q3 = $con->query($query3);
                $row_q3 = $run_q3->fetch_object();
                ?>

                <td><?php echo $num_rows = $run_q3->num_rows; ?></td>
 				<td><?php echo $row_q1->description; ?></td>
                <td><?php echo $row_q1->status; ?></td>
 				<!--<td><a class="btn btn-primary" href="?sid=<?php echo $row_q1->pro_id; ?>&status=<?php echo $row_q1->status; ?>&pro_id=<?php echo $row_q1->pro_id; ?>">Change Status</a></td>-->
                <td></td>
 			</tr>
            <?php 
            }
            ?>
		</table>
	</form>
    <?php
    if (isset($_SESSION['admin_login'])) {
        ?>
        <div>
            <a class="btn btn-primary" href="admin_home.php">Go to Admin Home Page</a>
        </div>
        <?php
    }
    ?>
</body>
</html>