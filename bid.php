<?php 
session_start();
include('db.php');

if(isset($_SESSION['user'])) {
    $row_c = $_SESSION['user'];
    //print_r($row_c);
}

if (!isset($_SESSION['user'])) {
	header("location:index.php");
}

$home = false;
$view = false;
$bids = true;
$products = false;

?>

<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>
<style>
/*.bg-nav {
    background-color: rgba(24, 44, 97, .6);
    background-color:  rgba(179, 55, 113, .6);
    background-color: rgba(87, 75, 144, .6);
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    z-index: 5;
}*/

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

<br><br>
	<div class="mt-5 container">
		<?php  

		$query1 = "select * from tbl_bid where uid = '$row_c->uid';";
			$run_q1 = $con->query($query1);
			$bid_numbers = $run_q1->num_rows;
			?>
			<h1 align="center" class="font-weight-light text-warning">You&nbsp;Made&nbsp;Total&nbsp;<?php echo $bid_numbers; if($bid_numbers>1) { echo " Bids"; } else { echo " Bid"; } ?></h1>
			<?php
			//echo $bid_numbers;
			$n = 1;
			?>
			<div class="row">
				<?php
				while ($row_q1 = $run_q1->fetch_object()) {
					$query2 = "select * from tbl_product where pro_id = '$row_q1->pro_id';";
					$run_q2 = $con->query($query2);
					$row_q2 = $run_q2->fetch_object();
					/*
					echo "<br>";
					print_r($row_q2);
					*/
					?>
					<div class="col-12 mt-4">
						<div class="card">
							<div class="card-body">
								<a class="text-dark" href="view_product.php?pro_id=<?php echo $row_q2->pro_id; ?>"><h3 class="card-title mt-4">Product&nbsp;Name:&nbsp;<?php echo $row_q2->name; ?></h3></a>
								<h3 class="card-text font-weight-light">Price:&nbsp;&#8377;&nbsp;<?php echo $row_q2->price; ?></h3>
								<h3 class="card-text font-weight-light">Bid&nbsp;you&nbsp;made&nbsp;for&nbsp;this&nbsp;Product:&nbsp;&#8377;&nbsp;<?php echo $row_q1->bid_amount; ?></h3>
								<?php $n++; ?>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>



<!--
	<table class="mt-5" border="1">
		<tr>
			<th>Sr no.</th>
			<th>Product Name</th>
			<th>Price by Seller</th>
			<th>Description</th>
			<th>Your Bidding amount</th>
		</tr>
		<?php
		$query1 = "select * from tbl_bid where uid = '$row_c->uid';";
		$run_q1 = $con->query($query1);
		$n = 1;
		while ($row_q1 = $run_q1->fetch_object()) {
			
			/*
			echo "<br>";
			echo "<br>";
			print_r($row_q1);*/
			$query2 = "select * from tbl_product where pro_id = '$row_q1->pro_id';";
			$run_q2 = $con->query($query2);
			$row_q2 = $run_q2->fetch_object();
			/*
			echo "<br>";
			print_r($row_q2);*/
			if ($row_q2->status == 'On Sale') {
				?>
				<tr>
					<td><?php echo $n; ?></td>
					<td><?php echo $row_q2->name; ?></td>
					<td><?php echo $row_q2->price; ?></td>
					<td><?php echo $row_q2->description; ?></td>
					<td><?php echo $row_q1->bid_amount; ?></td>
				</tr>

				<?php
				$n++;
			}
		}
		?>
	</table>-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>