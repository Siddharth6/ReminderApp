<?php
	class connectionMNGR
	{
		public function connect()
		{
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "reminder";
			$dbConn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$dbConn) {
			    die("Connection failed: " . mysqli_connect_error());
			}

		}
	}

	class SQL
	{
			function dbQuery($sql)
			{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reminder";
$dbConn  = mysqli_connect($servername, $username, $password, $dbname);

				$result = mysqli_query($dbConn  , $sql) or die(mysqli_error());
				
				return $result;
			}
			
			function dbFetchAssoc($result)
			{
				return mysqli_fetch_assoc($result);
			}
						
			function dbFreeResult($result)
			{
				return mysqli_free_result($result);
			}
			
			function dbNumRows($result)
			{
				return mysqli_num_rows($result);
			}
			
			
			
	} // class SQL ends			
?>