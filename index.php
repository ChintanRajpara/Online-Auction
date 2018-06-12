<?php
session_start();
include 'db.php';

if (isset($_SESSION['user'])) {
    //header("location:view.php");
    header("location:user_home.php");
}


if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $query1 = "select * from user where email = BINARY '$email' and password = BINARY '$password'";
    $run_q1 = $con->query($query1);
    $row_login = $run_q1->fetch_object();
    $num_rows = $run_q1->num_rows;
    if ($num_rows == 1) {
        if ($row_login->status == "Disable") {
            $b = 1;
        }
        else {
            if (isset($_REQUEST['rem'])) {
                setcookie('email', $row_login->email, time()+60);
                setcookie('password', $row_login->password, time()+60);
            }

            $_SESSION['user']=$row_login;
            //header("location:view.php");
            header("location:user_home.php");
        }
    }
}

    

if (isset($_REQUEST['submit'])) {
    $name = $_REQUEST['name'];
    $surname = $_REQUEST['sname'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['pass'];
    $gender = $_REQUEST['gn'];
    $hobby = implode(", ", $_REQUEST['hb']);
    $country = $_REQUEST['cn'];
    $date = date('Y-m-d h:i:s');
    $ins = "insert into user (name, surname, email, password, gender, hobby, country, dor) values ('$name', '$surname', '$email', '$password', '$gender', '$hobby', '$country', '$date');";
    //echo $ins;
    $con->query($ins);
    header("location:registered.php");
}

if (isset($_REQUEST['admin_login'])) {
    header("location:admin_login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chintan Rajpara</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>


<style type="text/css">

body {
    background-image: url(2252.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}


.bg_danger {
    background-color: #ffc9ce;
}

.bg-nav {
    background-color: rgb(24, 44, 97) !important;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    z-index: 5;
}

.container_login {
    width: 70vw;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    justify-content: space-around;
}

.item {
    flex-grow: 1;
    color: #fff;
}

.item-1 {
    background-color: rgba(31, 71, 136, .55);/*rgb(179, 55, 113);rgb(231, 76, 60);/*/
}

.item-2 {
    background-color: rgba(52, 73, 94, .55);
}

.admin {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translate(-50%, -100%);
}

</style>



<body>

    <nav class="navbar navbar-expand-sm navbar-dark bg-nav">
        <div class="container">
          <a style="color: #ffc107;" class="navbar-brand" href="index.php">
                <img style="max-width:50px; margin-top: -7px;" src="logo/auction.svg">&nbsp;Online Auction
            </a>
              <!--<ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="about.php">About</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="contact.php">Contact</a>
                  </li>
              </ul>-->
          </div>
    </nav>
    

    <div class="container_login">

        <div class="item item-2 p-4">
            <h2 class="mb-5" align="center">Sign Up</h2>
            <form method="post">
                <table  align="center" cellspacing="0" cellpadding="5" width="500" >
                    <tr>
                        <th>Name</th>
                        <td><input class="form-control" type="text" name="name" required="required"></td>
                    </tr>
                    <tr>
                        <th>Surname</th>
                        <td><input class="form-control" type="text" name="sname" required="required"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><input class="form-control" type="email" name="email" required="required"></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input class="form-control" type="password" name="pass" required="required"></td>
                    </tr>
                    <!--<tr>
                        <th>Confirm Password</th>
                        <td><input type="password" name="pass" required="required"></td>
                    </tr>-->
                    <tr>
                        <th>Gender</th>
                        <td>
                            <label><input type="radio" name="gn" value="Male">Male</label>
                            <label><input type="radio" name="gn" value="Female">Female</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Hobby</th>
                        <td>
                            <label><input type="checkbox" name="hb[]" value="Running">Running</label>
                            <label><input type="checkbox" name="hb[]" value="Reading">Reading</label>
                            <label><input type="checkbox" name="hb[]" value="Singing">Singing</label>
                            <label><input type="checkbox" name="hb[]" value="Music">Music</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>
                            <select name="cn">
                                <option value="">-select-</option>
                                <?php 
                                $sel_c = "select * from country";
                                $res_c = $con->query($sel_c);
                                while ($row_c = $res_c->fetch_object()) {
                                    ?>
                                    <option value="<?php echo $row_c->cid; ?>"><?php echo $row_c->cname; ?></option> 
                                    <?php                                 
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" class="btn btn-secondary" name="submit" value="Sign Up"></td> 
                    </tr>
                </table>
            </form>
            
        </div>




        <div class="item item-1 p-4">
            <h2 class="mb-5" align="center">Login</h2>
            <form method="post">
                <table border="0" align="center" cellpadding="5" cellspacing="0">
                    <?php
                    if (isset($_REQUEST['login'])) {
                        if($num_rows != 1) {
                            ?>
                            <tr class="bg_danger text-danger" align="center">
                                <td colspan="2" ><?php echo "Entered wrong User Name or Password!";?></td>
                            </tr>
                            <?php
                        }
                    }
                    if (isset($_REQUEST['login'])) {
                        if($num_rows == 1) {
                            if ($b == 1) {
                                ?>
                                <tr class="bg_danger text-danger" align="center">
                                    <td colspan="2">You are blocked, GET OUT!!!&nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="index.php">OK</a></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                    <tr>
                        <th>Email</th>
                        <td><input class="form-control" type="email" name="email" required="required" value="<?php
                         if(isset($_COOKIE['email'])){
                            echo $_COOKIE['email'];
                         }
                        ?>"></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input class="form-control" type="Password" name="password" required="required" value="<?php
                        if(isset($_COOKIE['password'])){
                         echo $_COOKIE['password'];
                        }
                        ?>"></td>
                    </tr>
                    <tr align="center">
                        <td colspan="2">
                            <label><input type="checkbox" name="rem">Remember Me</label>
                        </td>
                    </tr>
                    
                    <tr align="center">
                        <td colspan="2" align="center"><input class="btn btn-light" type="submit" name="login" value="Login"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="admin">
        <form>    
            <table align="center">
                <tr align="center">
                    <td align="center"><input class="btn btn-danger" type="submit" name="admin_login" value="Admin Login"></td>
                </tr>
            </table>
        </form>
    </div>




    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>