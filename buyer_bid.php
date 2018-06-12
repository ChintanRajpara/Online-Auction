<?php 
session_start();
include('db.php');

if(isset($_SESSION['user'])) {
    $row_c = $_SESSION['user'];
    //print_r($row_c);
}
$home = false;
$view = false;
$bids = false;
$products = false;

if (isset($_REQUEST['pro_id'])) {
	$pro_id = $_REQUEST['pro_id'];
	$query1 = "select * from tbl_product where pro_id = $pro_id; ";
	//echo $query1;
	$run_1 = $con->query($query1);
	$row_1 = $run_1->fetch_object();
}

$query3 = "SELECT * from tbl_bid WHERE pro_id = $pro_id ORDER BY bid_amount DESC LIMIT 1;";
$run_3 = $con->query($query3);
if ($run_3->num_rows === 1) {
	$row_3 = $run_3->fetch_object();
	echo $max_bid = $row_3->bid_amount;
} else {
	$max_bid = $row_1->price;
}

$errormessage = "Your Bid Amount Should be greater then ". ($max_bid + ($row_1->price * .05) - 1);


if (isset($_REQUEST['bid'])) {
	$bid_amount = $_REQUEST['bid_amount'];
	if ($bid_amount > ($max_bid + ($row_1->price * .05) - 1) ) {
		$query2 = "insert into tbl_bid 	(pro_id, uid, bid_amount) values ('$pro_id', '$row_c->uid', '$bid_amount');";
		$con->query($query2);
		header("location:view_product.php?pro_id=$pro_id");
	} else {
		
		echo "<script type='text/javascript'>alert('$errormessage');</script>";
	}
}

?>


<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>

<style>
.bg-nav {
    background-color: rgb(24, 44, 97) !important;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    z-index: 5;
}

.bg-darkblue {
    background-color: rgb(24, 44, 97) !important;
}
</style>

<body>

	<?php include 'nav.php'; ?>

<br>
<br>
<br>

	<form method="post">
		<table cellpadding="10">
			<tr>
				<th>Product Name</th>
				<td><?php echo $row_1->name; ?></td>
			</tr>
			<tr>
				<th>Product Price</th>
				<td><?php echo $row_1->price; ?></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php  
					echo $errormessage;
					?>
				</td>
			</tr>
			<tr>
				<th>Enter Your amount to Bid</th>
				<td><input type="number" name="bid_amount" required="required"></td>
			</tr>
			<tr>
				<td colspan="2"><input class="btn btn-primary" type="submit" name="bid" value="BID"></td>
			</tr>
		</table>
	</form>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>