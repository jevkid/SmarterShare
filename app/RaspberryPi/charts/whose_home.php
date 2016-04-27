<meta http-equiv = "refresh" content="180" >
<html ng-app="homePage">
<head>
    <!--Google Fonts-->
        <link href='https://fonts.googleapis.com/css?family=Quicksand:400,700|Catamaran:400,700,100|Karla:400,700|Poiret+One|Open+Sans' rel='stylesheet' type='text/css'>
    <!--Stylesheets-->
    <link rel="stylesheet" href="/app/styles/style.css">
    <!--AngularJS-->
        <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.17/angular.min.js"></script>

    <!--Fusion Chart-->
	<script src="js/fusioncharts.js"></script>
        <script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
        <script type="text/javascript" src="http://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js?cacheBust=56"></script>
    <!--End Fusion Chart-->

    <title>SmarterShare</title>
</head>
<!--Main Container-->
<div class = "container">
    <!--Navigation-->
    <nav class = "navbar">
        <!--<div class = "logo"><img src = "/app/img/logo.png"></div>-->
        <ul class = "left">
            <li class = "title"><a href = "/app/index.html">Smarter Share</a></li>
        </ul>
        <ul class = "right">
            <li><a href = "/login.html">Login</a></li>
            <li><a href = "/signup.html">Sign Up</a></li>
        </ul>
    </nav>
    <!--End Navigation-->
    <!--Display Selected Chart-->
    <div class = "data-chart">
        <!--Data/Chart Options-->
        <div class = "chart-options-pi">
            <a class = "btn1" href = "multipleguage.html">All Data</a>
            <a class = "btn1" href = "tempchart.php">Temperature</a>
            <a class = "btn1" href = "carbonchart.php">CO2</a>
            <a class = "btn1" href = "humiditychart.php">Humidity</a>
            <a class = "btn1" href = "lightchart.php">Light</a>
            <a class = "btn1" href = "mq2chart.php">MQ2: Air Quality</a>
            <a class = "btn1" href = "mq135chart.php">MQ135: Air Quality</a>
            <a class = "btn1" href = "v1_3chart.php">V1: Air Quality</a>
            <a class = "btn2" href = "whose_home.php">Bluetooth: Who's Home?</a>
            <a class = "btn1" href = "pir.php">Motion Detection</a>
        </div>
        <!--End Data/Chart Options-->
<br><br>
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
    <!--End Display Selected Chart-->
</div>
<!--Footer-->
<footer>
    <div class = "foot">
        <center>
            <ul>
                <li>&#169;Smarter Share</li>
                <li><a href="https://github.com/jevkid/SmarterShare">Source code</a></li>
            </ul>
        </center>
    </div>
</footer>
<!--End Footer-->
</body>
</html>