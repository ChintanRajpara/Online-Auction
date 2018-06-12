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

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<style>
table {
    border-radius: 15px;
    background-color: darkgray;
    color: white;
    padding: 0px 0px;
    margin: 0px auto;
    /*border: 1px solid black;*/
}
th {
    color: #6c757d;
    background-color: #343a40;
}
th:nth-child(1) {
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
}
th:last-child { 
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
}

td:nth-child(1) {
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
}
td:last-child{
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
}

/*
tr:nth-child(even) {
    background-color: blue;
}
tr:nth-child(odd) {
    background-color: red;
}*/

/*
tr {
    padding: 0px 0px;
    margin: 0px auto;
    height: 100%;
}
td {
    padding: 0px 0px;
    margin: 0px auto;
    height: 100%;
}*/
</style>

<body>
    <table border="0" width="90%" align="center" cellpadding="10">
        <tr>
            <th>Sr no.</th>
            <th>Product Name</th>
            <th>Price by seller</th>
            <th>Description</th>
            <th>Total Bids</th>
            <!--
            <th>Name of Users who bid on your product</th>
            <th>Bid Amount</th>
            <th>Action</th>
        -->
        </tr>
        <?php  
        $query1 = "select * from tbl_product where uid = $row_c->uid";
        $run_q1 = $con->query($query1);
        $n = 1;
        while ($row_q1 = $run_q1->fetch_object()) {
            $query2 = "select * from tbl_bid where pro_id = $row_q1->pro_id; ";
            //echo "<br>"."<br>".$query2;
            $run_q2 = $con->query($query2);
            $bid_num = $run_q2->num_rows;
            ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row_q1->name; ?></td>
                <td><?php echo $row_q1->price; ?></td>
                <td><?php echo $row_q1->description; ?></td>
                <td><?php echo $bid_num; ?></td>

                <td colspan="3">
                    <?php 
                    if ($bid_num>0) {
                        ?>
                        <table style="background-color: gray;" border="0" width="100%" align="center" cellpadding="10">
                            <tr>
                                <th>Name of Users who bid on your product</th>
                                <th>Bid Amount</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            while ($row_q2 = $run_q2->fetch_object()) {
                                $query3 = "select * from user where uid = $row_q2->uid; ";
                                $run_q3 = $con->query($query3);
                                $row_q3 = $run_q3->fetch_object();
                                ?>
                                <tr>
                                    <td><?php echo $row_q3->name." ".$row_q3->surname;  ?></td>
                                    <td><?php echo $row_q2->bid_amount;  ?></td>
                                    <td>
                                        <a class="btn btn-secondary" href="purchase.php?<?php  echo $row_q2->bid_id; ?>">
                                            <?php 
                                            if ($row_q3->gender == 'Male') {
                                                echo "Sell Him";
                                            } else {
                                                echo "Sell Her";
                                            } 
                                            ?>        
                                        </a>
                                    </td>
                                </tr>
                                <?php    
                            }  
                            ?>
                        </table>
                        <?php
                    }
                    ?>
                </td>
                



            </tr>
            <?php
            $n++;
        }
        ?>
    </table>

    <a class="btn btn-primary" href="user_home.php">Go to User Home Page</a>
</body>
</html>






    <table width="90%" align="center" cellpadding="10">
        <tr align="center">
            <th>Sr no.</th>
            <th>Product Name</th>
            <th>Price by seller</th>
            <th>Description</th>
            <th>Total Bids</th>
            <th>Status</th>
            <th>Change Status</th>
            <th>Name of Users who bid</th>
            <th>Bid Amount</th>
            <th>Action</th>
        </tr>
        <?php  
        $query1 = "select * from tbl_product where uid = $row_c->uid";
        $run_q1 = $con->query($query1);
        $n = 1;
        $background_color = true;
        while ($row_q1 = $run_q1->fetch_object()) {
            $query2 = "select * from tbl_bid where pro_id = $row_q1->pro_id; ";
            //echo "<br>"."<br>".$query2;
            $run_q2 = $con->query($query2);
            $bid_num = $run_q2->num_rows;
            ?>
            <tr class="<?php 
                        if ($background_color) { 
                            $print_bg = 'odd'; $background_color = false;
                        } else {
                            $print_bg = 'even'; $background_color = true;
                        }
                        echo $print_bg;
                        ?>" align="center">
                <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>"><?php echo $n; ?></td>
                <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>"><?php echo $row_q1->name; ?></td>
                <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>"><?php echo $row_q1->price; ?></td>
                <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>">
                    <textarea readonly style="background: transparent; border: none; color: #fff; text-align: center;" cols="30" rows="4"><?php echo $row_q1->description; ?></textarea></td>
                <!--<td  rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>"><p><?php echo $row_q1->description; ?></p></td>-->
                <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>"><?php echo $bid_num; ?></td>
                <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>"><?php echo $row_q1->status; ?></td>
                <?php 
                if ($row_q1->status == "On Sale" || $row_q1->status == "Disable") {
                    ?>
                    <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>">
                        <a class="btn btn-secondary" href="?pro_id=<?php echo $row_q1->pro_id; ?>&status=<?php echo $row_q1->status; ?>">
                            <?php 
                            if ($row_q1->status == "On Sale") {
                                echo "Disable";
                            } elseif ($row_q1->status == "Disable") {
                                echo "Enable";
                            }
                            ?>
                        </a>
                    </td>
                    <?php 
                    } else { 
                    ?>
                    <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>">---</td>
                    <?php 
                    } 
                ?>
                <?php
                $print = 1;

                if ($bid_num > 0) {
                    while ($row_q2 = $run_q2->fetch_object()) {
                        $query3 = "select * from user where uid = $row_q2->uid; ";
                        $run_q3 = $con->query($query3);
                        $row_q3 = $run_q3->fetch_object();
                        if ($print == 1) {
                            ?>
                            <td><?php echo $row_q3->name." ".$row_q3->surname; ?></td>
                            <td><?php echo $row_q2->bid_amount; ?></td>
                            <?php if ($row_q1->status == "On Sale" || $row_q1->status == "Disable") {?>
                            <td>
                                <a class="btn btn-secondary" href="purchase.php?bid_id=<?php  echo $row_q2->bid_id; ?>">
                                    <?php 
                                    if ($row_q3->gender == 'Male') {
                                        echo "Sell Him";
                                    } else {
                                        echo "Sell Her";
                                    } 
                                    ?>        
                                </a>
                            </td>
                            
                            <?php } else if ($row_q1->status == "Sold" || $row_q1->status == "Disable"){ ?>
                            
                            <td rowspan="<?php if ($bid_num == 0) { echo 1; } else { echo $bid_num; }; ?>">---</td>
                            <?php }?>
                            <?php
                            $print++;
                        }
                    }
                    ?>
                </tr>
                <?php
                if ($print != 1) {
                    $not_print = 1;
                    $run_q2 = $con->query($query2);
                    while ($row_q2 = $run_q2->fetch_object()) {
                        $query3 = "select * from user where uid = $row_q2->uid; ";
                        $run_q3 = $con->query($query3);
                        $row_q3 = $run_q3->fetch_object();
                        if ($not_print == 1) {
                            $not_print++;
                        } else {
                        ?>
                        <tr class="<?php echo $print_bg; ?>" align="center">
                            <td><?php echo $row_q3->name." ".$row_q3->surname; ?></td>
                            <td><?php echo $row_q2->bid_amount; ?></td>
                            <?php if ($row_q1->status == "On Sale") {?>
                            <td>
                                <a class="btn btn-secondary" href="purchase.php?bid_id=<?php  echo $row_q2->bid_id; ?>">
                                    <?php 
                                    if ($row_q3->gender == 'Male') {
                                        echo "Sell Him";
                                    } else {
                                        echo "Sell Her";
                                    } 
                                    ?>        
                                </a>
                            </td>
                            <?php } else { ?>
                            <?php }?>
                        </tr>

                        <?php
                        }
                    }
                }
            } else {
                ?>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <?php
            }
            $n++;
        }
        ?>
    </table>
 