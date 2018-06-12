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
$bids = false;
$products = true;

if (isset($_REQUEST['pro_id'])) {
    $pro_id = $_REQUEST['pro_id'];
    $status = $_REQUEST['status'];
    if ($status == "On Sale") {
        $status = "Disable";
    } elseif ($status == "Disable") {
        $status = "On Sale";        
    }
    $query4 = "update tbl_product set status = '$status' where pro_id = '$pro_id';";
    $con->query($query4);
    header("location:product.php");
}

if (isset($_REQUEST['bid_id'])) {
    $bid_id = $_REQUEST['bid_id'];
    $query1 = "insert into tbl_purchase (bid_id) values ($bid_id);";
    $con->query($query1);

    $query2 = "select * from tbl_bid where bid_id = '$bid_id'; ";
    $run_q2 = $con->query($query2);
    $row_q2 = $run_q2->fetch_object();
    print_r($row_q2);

    $query3 = "update tbl_product set status = 'Sold' where pro_id = '$row_q2->pro_id';";
    $con->query($query3);
    header("location:product.php");   
}

?>

<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>

<style>
body {/*
    background-image: url(1920x1200-data_out_12_164084632-blur-wallpapers.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;*/
    /*background-color: rgba(23, 162, 184, .3);*/
}

/*
.bg-nav {
    background-color: rgba(24, 44, 97, .6);
    background-color:  rgba(179, 55, 113, .6);
    background-color: #a9a9a9;
    background-color: rgba(87, 75, 144, .8);
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

.card-deck {
    flex-direction: column;
}

.align-corner {
    position: absolute;
    top: 0%;
    right: 0%;
}
/*
.card {
    background-color: transparent;
    border: none;
}*/

.card-body {
    /*background-color: rgba(207, 106, 135, .65);*/
    background-color: #ddd;
    /*color: #e5e5e5;*/
    border: none;
    border-radius: 5px;
}

.card-hover {
    background-color: #ddd;
}

.card-hover:hover {
    /*background-color: rgba(231, 76, 60, .5);*/
    background-color: #17a2b8;
}

.sold {
    background-color: none;
    opacity: .4;
}

.flex-container {
    display: flex;
    justify-content: space-between;
}

.btn-magenta {
  color: #fff;
  background-color: rgba(179, 55, 113,1.0);
  border-color: rgba(179, 55, 113,1.0);
}

.btn-magenta:hover {
  color: #fff;
  background-color: rgba(109, 33, 79,1.0);
  border-color: rgba(111, 30, 81,1.0);
}

.btn-magenta:focus,
.btn-magenta.focus {
  box-shadow: 0 0 0 0.2rem rgba(131, 52, 113, 0.5);
}

.btn-outline-magenta {
  color: #fff;
  background-color: transparent;
  background-image: none;
  border-color: rgba(179, 55, 113,1.0);
}

.btn-outline-magenta:hover {
  color: #fff;
  background-color: rgba(109, 33, 79,1.0);
  border-color: rgba(111, 30, 81,1.0);
}

.btn-outline-magenta:focus,
.btn-outline-magenta.focus {
  box-shadow: 0 0 0 0.2rem rgba(131, 52, 113, 0.5);
}

.card-header {
    position: relative;
}

.people-bid {
    border: 1px solid #17a2b8;
    padding-bottom: 20px;
    margin-top: 30px;
}

</style>

<body>

    <?php include 'nav.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="card-deck mt-5">
            <?php
            $query1 = "select * from tbl_product where uid = $row_c->uid ORDER BY pro_id DESC";
            $run_q1 = $con->query($query1);
            while ($row_q1 = $run_q1->fetch_object()) {
                $query2 = "select * from tbl_bid where pro_id = $row_q1->pro_id ORDER BY bid_amount DESC; ";
                $run_q2 = $con->query($query2);
                $bid_num = $run_q2->num_rows;?>
                <div class="card mt-5">
                    

                    <div class="card-body <?php if ($row_q1->status == 'Sold') { echo 'sold'; } ?>">
                        <div class="card-header mb-3 flex-container">
                            <div class="mr-3 ml-3 mt-1 mb-1">
                                <h5 class="font-weight-light">This Product is&nbsp;<?php echo $row_q1->status; ?></h5>
                            </div>
                            <div class="mr-3 ml-3 mt-1 mb-1">
                                <?php if ($row_q1->status != 'Sold') { ?>
                                    <a class="btn btn-info" href="?pro_id=<?php echo $row_q1->pro_id; ?>&status=<?php echo $row_q1->status; ?>">
                                        <?php 
                                        if ($row_q1->status == "On Sale") {
                                            echo "Disable this product";
                                        } elseif ($row_q1->status == "Disable") {
                                            echo "Enable this product";
                                        }
                                        ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                        <h3 class="card-title mt-4">Product&nbsp;Name:&nbsp;<?php echo $row_q1->name; ?></h3>
                        <div class="item"><h5 class="card-text mt-4 mr-5 font-weight-light">Product&nbsp;Description:&nbsp;<?php echo $row_q1->description; ?></h5></div>
                        <h1 class="card-text mt-4 mb-3 font-weight-light">Price:&nbsp;&#8377;&nbsp;<?php echo $row_q1->price; ?></h1>
                        
                        


                        <?php 
                        if ($bid_num > 0 && $row_q1->status != 'Sold' ) { 
                        ?>

                            <div class="people-bid">
                            <div class="card-deck mt-5 ml-5 mr-5">
                                <h4 align="center" class="card-text font-weight-light"><!--Total number of bids --><?php echo $bid_num; ?>&nbsp;People bid on this product</h4>
                                <?php
                                while ($row_q2 = $run_q2->fetch_object()) {
                                    $query3 = "select * from user where uid = $row_q2->uid; ";
                                    $run_q3 = $con->query($query3);
                                    $row_q3 = $run_q3->fetch_object();
                                ?>
                                <div class="card card-hover">
                                    <div class="card-body text-info">
                                        <!--<div class="flex-container">-->
                                        <div class="row">
                                            <div align="center" class="col-lg-4 col-sm-12">
                                                <div><h4 class="font-weight-light"><?php echo $row_q3->name." ".$row_q3->surname; ?></h4></div>
                                            </div>
                                            <div align="center" class="col-lg-4 col-sm-12">
                                                <div><h4 class="font-weight-light">Bid Amount:&nbsp;&nbsp;&#8377;&nbsp;<?php echo $row_q2->bid_amount;?></h4></div>
                                            </div>
                                            <div align="center" class="col-lg-4 col-sm-12">
                                                <div>
                                                    <a class="btn btn-outline-info" href="?bid_id=<?php  echo $row_q2->bid_id; ?>">
                                                        <?php 
                                                        if ($row_q3->gender == 'Male') {
                                                            echo "Sell Him";
                                                        } else {
                                                            echo "Sell Her";
                                                        } 
                                                        ?>
                                                    </a>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                } 
                                ?>
                            </div>
                        </div>
                            <?php 
                            } 
                        if ($bid_num == 0 ) {
                        ?>
                            <div class="card-footer text-danger">
                                <?php
                                echo "There are no bids yet on this product";
                                ?>
                            </div>
                        <?php
                    }
                        ?>

                    </div><!--End of card body-->
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>