<?php
session_start();
   include_once("cl_config/conn.php");
    
?>
<!DOCTYPE html>
<html lang="en-us">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title> Collaboration </title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    
	
</head>

<!-- #BODY -->
<body>
<!-- HEADER -->
<form id="collaboration_login" method="post" name="collaboration_login" action="">
<label>Email</label>
<input type="text" name="email_id" id="email_id" required />
<label>Password</label>
<input type="text" name="password" id="password" required />

<input type="submit" name="submit" id="submit" value="Login"/>
</form>

<?php
if(isset($_POST['submit']))
{
	$email_id=$_POST['email_id'];
	$password=$_POST['password'];
	
	$sql="SELECT * from users inner join userprofiles on users.id=userprofiles.userid where users.email = '$email_id' and password='$password';";
	$get_data = $conn_pdo->prepare($sql);
	$get_data ->execute();
        if ($get_data->rowCount() > 0) {
			$row_get_data=$get_data->fetch();
			
			$_SESSION['userid']=$row_get_data['userid'];
			$_SESSION['fullname']=$row_get_data['fullname'];
			$_SESSION['email']=$row_get_data['email'];
			$_SESSION['state']=$row_get_data['state'];
			$_SESSION['city']=$row_get_data['city'];
			$_SESSION['country']=$row_get_data['country'];
			$_SESSION['phonenumber']=$row_get_data['phonenumber'];
			$_SESSION['profileimage']=$row_get_data['profileimage'];
			
			//Start New Code
			$_SESSION['user_data'][$row_get_data['userid']] = [
                        'id'    =>  $row_get_data['userid'],
                        'name'  =>  $row_get_data['fullname'],
                        'profile'   =>  $row_get_data['profileimage']
                    ];
			//End New Code
				//header('location:collaboration.php');
			
			
			echo"<script>window.location.href='collaboration.php'</script>";
			
		}
		
		else{
			echo "wrong id pass";
		}
	
}
?>

</body>

</html>