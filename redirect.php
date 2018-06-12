<?php 
include('db.php');
 
if (isset($_REQUEST['eid'])) {
	$eid = $_REQUEST['eid'];
 	$edit = "select * from user where uid = '$eid' ";
 	$run_e = $con->query($edit);
 	$row_e = $run_e->fetch_object();
	//print_r($row_e);
}


if (isset($_REQUEST['update'])) {
	$name = $_REQUEST['name'];
	$surname = $_REQUEST['surname'];
	$password = $_REQUEST['password'];
	$gender = $_REQUEST['gn'];
 	$hobby = implode(",", $_REQUEST['hb']);
 	$country = $_REQUEST['cn'];
 	$update = "update user set name='$name', surname='$surname', password='$password', gender='$gender', hobby='$hobby', country='$country' where uid = '$eid' ";
 	$con->query($update);
 	header("location:view.php");
}

?>		

<!DOCTYPE html>
<html>
<head>
	<title>Chintan Rajpara</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<style>
tr:nth-child(odd) {
	background-color: lightgray;
}

tr:nth-child(even) {
	background-color: lightblue;
}
</style>
<body>
	<h1  align="center" class="text-primary">Edit Profile</h1>
 	<form method="post">
 		<table  align="center" cellspacing="0" cellpadding="5" width="500" >
 			<tr>
 				<th>Email</th>
 				<td>
 					<?php echo $row_e->email; ?>
 				</td>
 			</tr>
 			<tr>
 				<th>Name</th>
 				<td><input type="text" name="name" required="required" value="<?php 
 					
 						echo $row_e->name;
 					?>">
 				</td>
 			</tr>

 			<tr>
 				<th>Surame</th>
 				<td><input type="text" name="surname" required="required" value="<?php 
 					
 						echo $row_e->surname;
 					?>">
 				</td>
 			</tr>
 			<tr>
 			<th>Password</th>
 				<td><input type="password" name="password" required="required" value="<?php 
					
						echo $row_e->password;
					?>">
 				</td>
 			</tr>
 			<tr>
 				<th>Gender</th>
 				<td>
 								<label><input type="radio" name="gn" value="Male" <?php if ($row_e->gender=="Male") {echo "checked='checked'";} ?> >Male</label>
 								<label><input type="radio" name="gn" <?php if ($row_e->gender=="Female") {echo "checked='checked'";} ?> value="Female">Female</label>			
 								
 				</td>
 			</tr>
 			<tr>
 				<th>Hobby</th>
 				<td>
 					<?php 
 								$hbb = explode(", ", $row_e->hobby);
 								
								?>
						<label><input type="checkbox" name="hb[]" <?php if (in_array("Running", $hbb)) { echo "checked='checked'"; }?> value="Running">Running</label>
						<label><input type="checkbox" name="hb[]" <?php if (in_array("Reading", $hbb)) { echo "checked='checked'"; }?> value="Reading">Reading</label>
						<label><input type="checkbox" name="hb[]" <?php if (in_array("Singing", $hbb)) { echo "checked='checked'"; }?> value="Singing">Singing</label>
						<label><input type="checkbox" name="hb[]" <?php if (in_array("Music", $hbb)) { echo "checked='checked'"; }?> value="Music">Music</label>		
						<?php		
							
					?>	
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
							
								if ($row_e->country == $row_c->cid) {
									?>
									<option selected="selected" value="<?php echo $row_c->cid; ?>"><?php echo $row_c->cname; ?></option>
									<?php
								} 
								else{
								?>
								<option value="<?php echo $row_c->cid; ?>"><?php echo $row_c->cname;?></option>	
								<?php	
								}
							 								
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" class="btn btn-success" name="update" value="UPDATE"></td>
					
				
	 		</tr>
		</table>
	</form>
	<table align="center">
		<tr align="center">
			<td>
				<a href="view.php" class="btn btn-danger">Cancel</a>
			</td>
		</tr>
	</table>
	
</body>
</html>