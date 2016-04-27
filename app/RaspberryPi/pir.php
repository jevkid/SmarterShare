
<?php
   $dbhost = 'localhost';
   $dbuser = 'testuser';
   $dbpass = 'test';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'SELECT * FROM PIR
	 WHERE Timestamp > DATE_SUB(NOW(), INTERVAL 64 HOUR) AND Timestamp <= NOW()';
   mysql_select_db('testdb');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
      echo "Timestamp :{$row['Timestamp']}  <br> ".
         "Motion Type : {$row['MOTION']} <br> ".
         
         "--------------------------------<br>";
   }
   
   echo "Fetched data successfully\n";
   
   mysql_close($conn);
?>