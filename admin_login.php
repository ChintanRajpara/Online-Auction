<?php
session_start();
include 'db.php'; 

if (isset($_SESSION['admin_login'])) {
	header("location:admin_home.php");
}


if (isset($_REQUEST['login'])) {
	$uname = $_REQUEST['uname'];
	$password = $_REQUEST['password'];
	$query1 = "select * from admin where username = BINARY '$uname' and password = BINARY '$password'";
	$run_q1 = $con->query($query1);
	$row_login = $run_q1->fetch_object();
	$num_rows = $run_q1->num_rows;
	if ($num_rows == 1) {
		if (isset($_REQUEST['rem'])) {
			setcookie('username', $row_login->uname, time()+60);
			setcookie('password', $row_login->password, time()+60);
		}

		$_SESSION['admin_login']=$row_login;
		header("location:admin_home.php");  
	}
}

if (isset($_REQUEST['user_login'])) {
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<style type="text/css">
tr:nth-child(odd) {
	
	background: #b8daff;
}
tr:nth-child(even) {
	background: lightgray;
}
.mandatory {
	color: red;
	font-size: 18px;
}
</style>

<body>
	<h1  align="center" class="text-primary">ADMIN LOGIN</h1>
	<form method="post">
		<table border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" class="mandatory">fields with * are mandatory</td>
			</tr>
			<tr>
				<td><span class="mandatory">*</span>User Name</td>
				<td><input type="text" name="uname" required="required" value="<?php
				if(isset($_COOKIE['username'])){
					echo $_COOKIE['username'];
				}
				?>"></td>
			</tr>
			<tr>
				<td><span class="mandatory">*</span>Password</td>
				<td><input type="Password" name="password" required="required" value="<?php
				if(isset($_COOKIE['password'])){
					echo $_COOKIE['password'];
				}
				?>"></td>
			</tr>
			<tr align="center">
				<td colspan="2">
					<input type="checkbox" name="rem">Remember Me
				</td>
			</tr>
			<?php
			if (isset($_REQUEST['login'])) {
				if($num_rows != 1) {
					?>
					<tr align="center">
						<td colspan="2" ><?php echo "Entered wrong User Name or Password!";?></td>
					</tr>
					<?php
				}
			}
			if (isset($_REQUEST['login'])) {
				if($num_rows == 1) {
					if ($b == 1) {
						?>
						<tr align="center">
							<td><?php echo "You are blocked, GET OUT!!!";?></td>
							<td><a href="index.php"><button>OK</button></a></td>
						</tr>
						<?php
					}
				}
			}
			?>
			<tr align="center">
				<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="login" value="Login"></td>
			</tr>
		</table>
	</form>
	<form>    
        <table align="center">
            <tr align="center">
                <td align="center"><input class="btn btn-danger" type="submit" name="user_login" value="User Login"></td>
            </tr>
        </table>
    </form>
</body>
</html>