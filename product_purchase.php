<?php 
session_start();
include('db.php');

if(isset($_SESSION['user'])) {
    $row_c = $_SESSION['user'];
    //print_r($row_c);
}

if (isset($_REQUEST['pro_id'])) {
	$pro_id = $_REQUEST['pro_id'];
	$purchase_quantity = 1;
	$query2 = "select * from product where pro_id = '$pro_id'";
	$run_q2 = $con->query($query2);
	$row_q2 = $run_q2->fetch_object();
	//echo $row_q2->quantity;
	if (($row_q2->quantity - $purchase_quantity)  >= 0) {
		$uid = $row_c->uid;
		$query3 = "insert into purchase (pro_id, uid, quantity) values ('$pro_id', '$uid', '$purchase_quantity')";
		$con->query($query3);
		$row_q2->quantity = $row_q2->quantity - $purchase_quantity;
		$query4 = "update product set quantity = '$row_q2->quantity' where pro_id = '$pro_id' ";
		$con->query($query4);
		header("location:product_purchase.php");
	} 

}

?>





<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<style>
/*
table {
	border: 5px solid red;
	border-radius: 50 !important;
}*/

tr:nth-child(odd) {
	background-color: lightgray;
	color: #6c757d;
}

tr:nth-child(even) {
	background-color: lightblue;
	color: #007bff;
}

tr:nth-child(1) {
	background-color: #007bff;
	background-color: #28a745;
	color: white;
}
.right {
	margin: 20px;
	position: absolute;
	top: 0;
	right: 0;
}
/*
.vl {
    border-right: 1px solid lightgray;
}

.hl {
	border-bottom: 1px solid black;
}*/
</style>

<body>

	<?php
    if (isset($_SESSION['user'])) {
        ?>
        <div>
            <h2>Welcome <?php echo $row_c->uname;?></h2>
            <a class="btn btn-warning" href="view.php">View Profile</a>
        </div>
        <div class="right">
        	<a class="btn btn-danger" href="logout.php">LOGOUT</a>
        </div>
        <?php
    }
    ?>

	<form>
		<table align="center" class="mt-5" cellspacing="0" cellpadding="5" width="75%">
			<tr class="hl" align="center">
				<th class="vl">Sr.no.</th>
				<th class="vl">Name</th>
				<th class="vl">Description</th>
				<th class="vl">Price</th>
				<th colspan="2">Purchase</th>
			</tr>
			<?php
			$n = 1;
			$query1 = "select * from product";
			$run_q1 = $con->query($query1);
			while ($row_q1 = $run_q1->fetch_object()) {
				if ($row_q1->status == 'Enable') { 
					if ($row_q1->quantity > 0) {
						?>
						<tr align="center">
							<td class="vl"><b><?php echo $n; ?></b></td>
							<td class="vl"><b><?php echo $row_q1->name; ?></b></td>
							<td class="vl"><b><?php echo $row_q1->description; ?></b></td>
							<td class="vl"><b><?php echo $row_q1->price; ?></b></td>
							<td><input type="number" name="qty" placeholder="Quantity"> </td>
							<td><a class="btn btn-success" href="?pro_id=<?php echo $row_q1->pro_id;?>">Buy</a></td>
							<!--<td><input class="btn btn-primary" type="submit" name="buy" value="Buy"></td>-->
						</tr>
					<?php
					$n++;
					}
				}
			}
			?>
		</table>
	</form>
</body>
</html>