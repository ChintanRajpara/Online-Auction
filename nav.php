<nav class="navbar navbar-expand-sm navbar-dark bg-nav animated fadeInDown">
		<div class="container">

			<a style="color: #ffc107;" class="navbar-brand" href="index.php">
				<img style="max-width:50px; margin-top: -7px;" src="logo/auction.svg">&nbsp;Online Auction
			</a>
			<div align="center">
				<a class="btn btn-warning" href="new_product.php">Add A Product For Bid</a>
			</div>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link <?php if ($home == true) { echo 'active'; }?>" href="index.php">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle text-warning" data-toggle="dropdown"><?php echo $row_c->name." ".$row_c->surname;?></a>
					<div class="dropdown-menu bg-darkblue">
						<a href="view.php" class="text-warning dropdown-item <?php if ($view == true) { echo 'active'; }?>">View Profile</a>
						<a href="bid.php" class="text-warning dropdown-item <?php if ($bids == true) { echo 'active'; }?>">Bids I made on Products</a>
						<a href="product.php" class="text-warning dropdown-item <?php if ($products == true) { echo 'active'; }?>">Products I put for Sale</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link text-danger" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>