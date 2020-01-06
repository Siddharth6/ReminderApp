<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['username'])){//check user session
	header('location:login.php');
}

require_once('connect.php'); // import page
require_once('checkreminder.php'); // import reminder checker

if(isset($_REQUEST['submit']))
{
	if(!empty($_REQUEST['title']) & !empty($_REQUEST['date']))
	{
		if($_REQUEST['date']<=date('Y-m-d')) // if selected is in future or not?
		{
		$flag = '0'; // if it is today or before, make it expired.
		$Status_message = "Reminder is set expired.";
		}
		else
		{
		$flag = '1'; 
		}
		$title = addslashes(ucwords($_REQUEST['title']));
		$desc = addslashes(ucfirst($_REQUEST['description']));

		$Contact=($_REQUEST['contact']);
		$email=($_REQUEST['email']);
	
		$sql->dbQuery("insert into reminders (title,description,email,contact,date,flag)values('$title','$desc','$email','$Contact','$_REQUEST[date]','$flag')"); // add reminder
	}
	else
	{
	$Status_message = "Title or date missing, no reminder added";
	}
}
$Result = $sql->dbQuery("select * from reminders order by id desc");
$Reminder_Result = $sql->dbQuery("SELECT * FROM `reminders` WHERE flag = '1' "); // select expired reminders
?>
<!DOCTYPE html >
<html>
<head>
<meta content="charset=UTF-8" />
<title>Reminder Application</title>
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.18.custom.css">
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="js/jquery.ui.datepicker.js"></script>
<script src="js/jquery.ui.tabs.js"></script>
<script>			
		$(function() {
		   $( "#tabs" ).tabs();
		});
		$(function() {
		  $( "#date" ).datepicker();
	   });
</script>
</head>
<body>
<div id="Container" >
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Reminders</a></li>
			<li><a href="#tabs-2">Set Reminder</a></li>
			<li><a href="#tabs-3">View your Reminders</a></li>
			
		</ul>
		<a style="float:right; text-decoration: none; font-size:20px; color: red; margin-right: 20px;padding-top: 10px;" href="logout.php">Logout</a>

		<center><p style="margin-top: 10px; font-size: 30px;"> welcome <?php echo $_SESSION['username']; ?></p></center>
		<div id="tabs-1">
		<?php if(isset($Status_message)){?><div id="message"><?php echo $Status_message;?></div><?php }
		
			$numRows = $sql->dbNumRows($Reminder_Result);
			if($numRows > 0)
			{	
				while($Reminder = $sql->dbFetchAssoc($Reminder_Result)){?>
				<div id="reminder"  >
				<a href="edit.php?id=<?php echo $Reminder['id']?>"><?php echo $Reminder['title'];?></a>
				<p ><?php echo "set on ".$Reminder['date'];?></p>
				
				</div>
				<?php 	}
			}
			else{
			echo "There are no Reminders set";
			}
			$sql->dbFreeResult($Reminder_Result);?>
		</div>	
		
			
		<div id="tabs-2">		
				<form name="add_reminder" action="" method="post">
					<table width="60%" border="0">
					<tr>
					<td colspan="2" align="center" id="message" autocomplete="off"></td>
					</tr>
				  <tr>
					<td width="32%">Title</td>
					<td><input type="text" name="title" autocomplete="off" ></td>
				  </tr>

				  

				  <tr>
					<td>Description</td>
					<td><textarea name="description" cols="30" rows="5" id="description"autocomplete="off"></textarea></td>
					</tr>
				  <tr>

				  	 <tr>
					<td>Contact No</td>
					<td><input type="number" name="contact" autocomplete="off"></td>
					</tr>


					<tr>
						<td width="32%">E-Mail ID</td>
						<td><input type="email" name="email"autocomplete="off" ></td>
				  </tr>

				  <tr>


					<td>Remind me Date</td>
					<td><input type="text" id="date" name="date" autocomplete="off"></td>
					</tr>
				  <tr>

					<td>&nbsp;</td><br>
					<td><input type="submit" value="Save Reminder" name="submit" /></td>
				  </tr>
				</table>
				</form>
		</div>
		
		<div id="tabs-3">
					<?php 					
			while($row = $sql->dbFetchAssoc($Result)){?>
			<div id="reminder"  >
			<a href="edit.php?id=<?php echo $row['id'];?>" <?php if($row['flag']== 0){?>style="color:#999999;" <?php }?>>
			<?php echo $row['title'];?>
			</a>
			
			<p <?php if($row['flag']== 0){?>style="color:#999999;" <?php }?>>
			<?php if($row['flag']== 1){echo "set on ".$row['date'];}else{ echo "expired on ".$row['date'];}?>
			</p>
			
			</div>
			<?php }
			$sql->dbFreeResult($Result); ?>		
		</div>				
		
	</div>
</div>
</body>
</html>