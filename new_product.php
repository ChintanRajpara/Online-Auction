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

if (isset($_REQUEST['insert_product'])) {
	$name = $_REQUEST['name'];
	$description = $_REQUEST['desc'];
	$price = $_REQUEST['price'];
	$query1 = "insert into tbl_product (name, price, description, uid) values ('$name', '$price', '$description', '$row_c->uid')";

	$file = $_FILES['img'];
	print_r($file);

	$true = false;


	for ($i=0; $i < count($_FILES['img']['name']); $i++) { 

		$fileName = $_FILES['img']['name'][$i];
		$fileTmpName = $_FILES['img']['tmp_name'][$i];
		$fileSize = $_FILES['img']['size'][$i];
		$fileError = $_FILES['img']['error'][$i];
		$fileType = $_FILES['img']['type'][$i];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array('jpg', 'jpeg', 'png');

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 1000000) {

					$true = true;

					/*
						VERIFIES ALL THE NECESSARY CONDITIONS FOR UPLOADING THE FILES
					*/

				} else {
					$true = false;
					$error_upload_size_message = $fileName.", this file is too big, file size should be less then 1 MB";
					echo "<script type='text/javascript'>alert('$error_upload_size_message');</script>";
				}
			} else {
				$true = false;
				$error_upload_message = "There was an error uploading your file ".$fileName;
				echo "<script type='text/javascript'>alert('$error_upload_message');</script>";
			}
		} else {
			$true = false;
			$error_upload_type_message = "For file ".$fileName.", You cannot upload file of this type (.".$fileActualExt.")" ;
			echo "<script type='text/javascript'>alert('$error_upload_type_message');</script>";
		}
	}



	if ($true) {
		$con->query($query1);


		for ($i=0; $i < count($_FILES['img']['name']); $i++) { 

			$fileName = $_FILES['img']['name'][$i];
			$fileTmpName = $_FILES['img']['tmp_name'][$i];
			$fileSize = $_FILES['img']['size'][$i];
			$fileError = $_FILES['img']['error'][$i];
			$fileType = $_FILES['img']['type'][$i];

			$fileExt = explode('.', $fileName);
			$fileActualExt = strtolower(end($fileExt));
			$fileNameNew = uniqid('', true).".".$fileActualExt;
			$fileDestination = "product_images/".$fileNameNew;
			$query2 = "select * from tbl_product ORDER BY pro_id DESC LIMIT 1";
			$run_2 = $con->query($query2);
			$row_2 = $run_2->fetch_object();
			$pro_id = $row_2->pro_id;
			$query3 = "insert into tbl_img (img_name, pro_id) values ('$fileNameNew', $pro_id);";
			/*echo $query3;
			echo "<script type='text/javascript'>alert('$query3');</script>";*/
			$con->query($query3);
			move_uploaded_file($fileTmpName, $fileDestination);
			//echo "<script type='text/javascript'>alert('$row_2->pro_id');</script>";
			header("location:user_home.php");
		}

	}







	

	
}

?>


<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>
<style>
body {
	background-color: #a29bfe;
	position: relative;
}
/*
.bg-nav {
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

.container {
	display: flex;
	justify-content: center;
}

.item {
	padding: 25px;
	background-color: rgb(108, 92, 231);
	border-radius: 5px;
	color: #fff;
}

table {
	
}
</style>
<body>

	<?php include 'nav.php'; ?>

	<!-- <nav class="navbar navbar-expand-sm navbar-dark bg-nav">
		<div class="container">
			<a style="color: #ffc107;" class="navbar-brand" href="index.php">
				<img style="max-width:50px; margin-top: -7px;" src="logo/auction.svg">&nbsp;Online Auction
			</a>
			<div align="center">
				<a class="btn btn-warning" href="new_product.php">Add A Product For Bid</a>
			</div>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle text-warning" data-toggle="dropdown"><?php echo $row_c->name." ".$row_c->surname;?></a>
					<div class="dropdown-menu bg-darkblue">
						<a href="view.php" class="text-warning dropdown-item">View Profile</a>
						<a href="bid.php" class="text-warning dropdown-item">Bids I made on Products</a>
						<a href="product.php" class="text-warning dropdown-item">Products I put for Sale</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link text-danger" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav> -->
<br>
<br>
	<form method="post" enctype="multipart/form-data">
		<div class="container mt-5 animated fadeIn"> 
			<div class="item">
				<table border="0" cellspacing="5" cellpadding="3">
					<tr>
						<th>Name</th>
						<td><input type="text" name="name" required="required"></td>
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea name="desc" cols="30" rows="5" required="required"></textarea></td>
						<!--<td><input type="text" name="desc"></td>-->
					</tr>
					<tr>
						<td>
							Put images for your product
						</td>
						<td>
					z		<!-- <input type="file" name="img"> -->
							<input type="file" name="img[]" required="required" multiple="multiple">
						</td>
					</tr>
					<tr>
						<th>Minimum Selling Price</th>
						<td><input type="number" name="price" required="required"></td>
					</tr>
					<tr align="center">
						<td colspan="2"><input class="btn btn-secondary" type="submit" name="insert_product" value="OK"></td>
					</tr>
				</table>
			</div>
		</div>
	</form>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>