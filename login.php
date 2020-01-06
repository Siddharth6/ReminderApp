<?php
session_start();
include('connect.php');
if(isset($_POST['submit'])){
$con= mysqli_connect('localhost','root','','reminder');


	$username =$_POST['username'];
	$password=$_POST['password'];
	$sql="select * from users where name ='$username' && password ='$password' ";

	 $reuslt= mysqli_query($con , $sql);
 
 $num= mysqli_num_rows($reuslt);
 
 if ($num ==1){
	
	$_SESSION['username']=$username;
	header('location:index.php');
}else{
	echo "login field";
}
}


?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.forms{
                  margin-top: 300px;
                  margin-left: 500px;

		}

		input{
			border: solid 1px;
                  
            border-color: red;
		}
    

	</style>
	<title>Reminder</title>
</head>
<body>

  <form action="" method="post"class="forms">
  	<input type="text" name="username" placeholder="username" required  /><br/><br/>
  	<input type="password" name="password" placeholder="password" required/><br/><br/>
  	<button type="submit" name="submit">submit</button>

  </form>
</body>
</html>