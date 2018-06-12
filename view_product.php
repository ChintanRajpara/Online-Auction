<?php 
session_start();
include('db.php');

if(isset($_SESSION['user'])) {
    $row_c = $_SESSION['user'];
    //print_r($row_c);
}

if(!isset($_SESSION['user'])) {
    header("location:index.php");
}

if (!isset($_REQUEST['pro_id']) && isset($_SESSION['user'])) {
	header("location:user_home.php");
}

if (isset($_REQUEST['pro_id'])) {
	$pro_id = $_REQUEST['pro_id'];
	$query1 = "select * from tbl_product where pro_id = $pro_id;";
	$run_q1 = $con->query($query1);
	$row_q1 = $run_q1->fetch_object();
	//print_r($row_q1);
		
}




?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $row_q1->name; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<style>



/************************/
/* IMAGE POPUT STARTING */
/************************/



.myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 10; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.3s;
    animation-name: zoom;
    animation-duration: 0.3s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}

/**********************/
/* IMAGE POPUT ENDING */
/**********************/



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

.flex-container {
	display: flex;
	flex-direction: column;
}

.card-hover {
	width: 50%;
}

.card-header {
	width: 50%;
}

.card-hover:hover {
	background-color: rgba(127, 140, 141, .2);
}
</style>
<body>


	<nav class="navbar navbar-expand-sm navbar-dark bg-nav">
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
	</nav>


	
<br>
<br>

	<div class="container">


		

		<div class="card mt-5 mb-5">
			<div class="card-body">
				<h2 class="card-title"><?php echo $row_q1->name; ?></h2>
				<p class="card-text"><?php echo $row_q1->description; ?></p>
				<div class="container">
					<?php  
					$query4 = "select * from tbl_img where pro_id = $pro_id";
					$run_q4 = $con->query($query4);
					while ($row_q4 = $run_q4->fetch_object()) {
						$image_name = $row_q4->img_name;
						$image_destination = "product_images/".$image_name;
						?>



						<img class="img-fluid myImg" id="myImg<?php echo $image_name; ?>" src="<?php echo $image_destination; ?>" alt="Product Image" width="20%">
						<!-- The Modal -->
						<div id="myModal<?php echo $image_name; ?>" class="modal">
							<span class="close close<?php echo $image_name; ?>">&times;</span>
							<img class="modal-content" id="<?php echo $image_name; ?>">
							<div id="caption<?php echo $image_name; ?>"></div>
						</div>

						<script>
						// Get the modal
						var modal = document.getElementById('myModal<?php echo $image_name; ?>');

						// Get the image and insert it inside the modal - use its "alt" text as a caption
						var img = document.getElementById('myImg<?php echo $image_name; ?>');
						var modalImg = document.getElementById("<?php echo $image_name; ?>");
						var captionText = document.getElementById("caption<?php echo $image_name; ?>");
						img.onclick = function(){
						    modal.style.display = "block";
						    modalImg.src = this.src;
						    captionText.innerHTML = this.alt;
						}

						// Get the <span> element that closes the modal
						var span = document.getElementsByClassName("close<?php echo $image_name; ?>")[0];

						// When the user clicks on <span> (x), close the modal
						span.onclick = function() { 
						    modal.style.display = "none";
						}
						</script>







						<!-- <img class="img-fluid" src="<?php echo $image_destination; ?>" width="20%" alt="Product Image"> -->
						<?php
					}
					?>
				</div>
				<br>
				<h3 class="font-weight-light">Price: <?php echo $row_q1->price; ?></h3>
				<a href="buyer_bid.php?pro_id=<?php echo $row_q1->pro_id;?>" class="btn btn-secondary mt-3">Bid on this product</a>
			</div>
		</div>


		<?php
		$query2 = "select * from tbl_bid where pro_id = '$pro_id' ORDER BY bid_id DESC";
		$run_q2 = $con->query($query2);
		$total_bids = $run_q2->num_rows;
		?>

		<div class="flex-container m-5">
			<?php  
			if ($total_bids == 0) {
				?>
				<h4 class="card-header pb-3">There are no bids yet on this product</h4>
				<?php
			} else {
				?>
				<h4 class="card-header pb-3">People who bid on this product</h4>
				<?php
			}
			?>
			<?php
			while ($row_q2 = $run_q2->fetch_object()) {
			?>
				<div class="card card-hover">
					<div class="card-body p-2">
						<?php 
						$query3 = "select * from user where uid = $row_q2->uid;";
						$run_q3 = $con->query($query3);
						$row_q3 = $run_q3->fetch_object();
						//print_r($row_q3);
						?>
						<h5 class="card-title"><?php echo $row_q3->name." ".$row_q3->surname; ?></h5>
						<h5 class="font-weight-light">Bid Amount:&nbsp;&nbsp;<?php echo $row_q2->bid_amount; ?></h5>

						<?php
						?>

					</div>
				</div>
			<?php } ?>
		</div>


	</div>




	
	
	
</body>
</html>