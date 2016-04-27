<?php
   $dbhost = 'localhost';
   $dbuser = 'testuser';
   $dbpass = 'test';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'SELECT * FROM WHOSE_HOME
	 WHERE Timestamp > DATE_SUB(NOW(), INTERVAL 24 HOUR) AND Timestamp <= NOW()';
   mysql_select_db('testdb');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
      echo "Timestamp :{$row['Timestamp']}  <br> ".
         "whose device : {$row['PERSON']} <br> ".
         
         "--------------------------------<br>";
   }
   
   echo "Fetched data successfully\n";
   
   mysql_close($conn);
?>