<?php include('connect.php');

if(isset($_REQUEST['submit']))
{
	if(!empty($_REQUEST['title']) & !empty($_REQUEST['date']))
	{
		if($_REQUEST['date']<=date('Y-m-d'))
		{
		$flag = '0';
		}
		else
		{
		$flag = '1';
		}
		
		$title = addslashes(ucwords($_REQUEST['title']));
		$desc = addslashes(ucfirst($_REQUEST['description']));	
		$Contact=($_REQUEST['contact']);
		$email=($_REQUEST['email']);
	$sql->dbQuery("update reminders set title='$title',description='$desc',contact='$Contact',email='$email',date='$_REQUEST[date]',flag='$flag' where id = '$_GET[id]'");
	$Status_message = 'Updated!';
	}
	else {
	$Status_message = 'Updation unsuccesful, Title or date missing!';
	}

}
$result = $sql->dbQuery("select * from reminders where id = '$_GET[id]'");
$row = $sql->dbFetchAssoc($result);
$sql->dbFreeResult($result);?>

<!DOCTYPE html>
<html>
<head>
<meta content="charset=UTF-8" />
<title>Edit Reminder</title>
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
<body style="background-color: #e5a3ad;">
<div id="Container">	
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Detail</a></li>
			<li><a href="#tabs-2">Modify Reminder</a></li>
			<li style="float:right;"><a href="#tabs-3"><a href="index.php">Back</a></li>			
		</ul>
		<a style="float:right; text-decoration: none; font-size:20px; color: red; margin-right: 20px;padding-top: 10px;" href="logout.php">Logout</a>
		<div id="tabs-1">
		<div id="message"><?php if(isset($Status_message)){ echo $Status_message;}?></div>

			<p>Title : <?php echo $row['title']?></p><br/>
			<p>Description : <?php echo $row['description']?></p><br/>
			<p>Email : <?php echo $row['email']?></p><br/>
			<p>Contact : <?php echo $row['contact']?></p><br/>
			<p>Date : <?php echo $row['date']?></p><br/>
			<p><a text-decoration: none; font-size:20px; color: red; href="delete.php?id=<?php echo $row['id'];?>" onClick="return confirm('Are you sure you want to delete reminder?')" style="color:#FF9900;">Delete Reminder</a></p>
		</div>
		
		<div id="tabs-2">
		
		<form name="edit_reminder" action="" method="post">
		<table width="50%" border="0">
		
	  <tr>
		<td width="32%">Title</td>
		<td><input type="text" name="title" value="<?php echo $row['title']?>" ></td>
	  </tr>
	  <tr>
		<td width="32%">Description</td>
		<td><textarea name="description" cols="30" rows="5" id="description"><?php echo $row['description']?></textarea></td>
	  </tr>
	  <tr>

	  	 <tr>
		<td width="32%">E-mail</td>
		<td><input type="email" name="email" value="<?php echo $row['email']?>" ></td>
	  </tr>
	  <tr>

	  	 <tr>
		<td width="32%">contact</td>
		<td><input type="number" name="contact" value="<?php echo $row['contact']?>" ></td>
	  </tr>
	  <tr>

		<td>Remind me Date</td>
		<td><input type="text" id="date" name="date" value="<?php echo $row['date']?>"></td>
		</tr>
	 
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="update" name="submit" /></td>
	  </tr>
	</table>
	</form>
		</div>
	
	</div>
</div>
</body>
</html>
