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
            <a class = "btn2" href = "v1_3chart.php">V1: Air Quality</a>
            <a class = "btn1" href = "whose_home.php">Bluetooth: Who's Home?</a>
            <a class = "btn1" href = "pir.php">Motion Detection</a>
        </div>
        <!--End Data/Chart Options-->
<br><br>
<?php

/*Include the `fusioncharts.php` file that contains functions
	to embed the charts.
*/
  include("fusioncharts.php");

  /* The following 4 code lines contain the database connection information. Alternatively, you can move these code lines to a separate file and include the file here. You can also modify this code based on your database connection.   */

   $hostdb = "localhost";  // MySQl host
   $userdb = "testuser";  // MySQL username
   $passdb = "test";  // MySQL password
   $namedb = "testdb";  // MySQL database name

   // Establish a connection to the database
   $dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);

   // Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect
   if ($dbhandle->connect_error) {
  	exit("There was an error with your connection: ".$dbhandle->connect_error);
   }

?>
  	<?php

     	// Form the SQL query that returns the top 10 most populous countries
     	//$strQuery = "SELECT * FROM DHT22";
        $strQuery = "SELECT Timestamp,V1_3 FROM MCP3008 WHERE Timestamp > DATE_SUB(NOW(), INTERVAL 200 HOUR) AND Timestamp <= NOW()";

     	// Execute the query, or else return the error message.
     	$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

     	// If the query returns a valid response, prepare the JSON string
     	if ($result) {
        	// The `$arrData` array holds the chart attributes and data
        	$arrData = array(
        	    "chart" => array(
                  "caption" => "V1_3 readings for the last 48 hours",
		  "xaxisname" => "Timestamp",
		  "yaxisname" => "V1_3(PPM)",
                  "paletteColors" => "#00FFFF",
                  "bgColor" => "#ffffff",
                  "borderAlpha"=> "20",
                  "canvasBorderAlpha"=> "0",
                  "usePlotGradientColor"=> "30",
                  "plotBorderAlpha"=> "10",
                  "showXAxisLine"=> "1",
                  "xAxisLineColor" => "#999999",
                  "showValues" => "0",
                  "divlineColor" => "#999999",
                  "divLineIsDashed" => "1",
                  "showAlternateHGridColor" => "0"
              	)
           	);


        	$arrData["data"] = array();

	// Push the data into the array

        	while($row = mysqli_fetch_array($result)) {
           	array_push($arrData["data"], array(
                "label" => (string) $row["Timestamp"],
                "value" => $row["V1_3"]
              	)
           	);
        	}
		
		//echo "array created";

        	/*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

        $jsonEncodedData = json_encode($arrData);



		//echo $jsonEncodedData;

        	/*Create an object for the column chart. Initialize this object using the FusionCharts PHP class constructor. The constructor is used to initialize the chart type, chart id, width, height, the div id of the chart container, the data format, and the data source. */
	
        $columnChart = new FusionCharts("line", "myFirstChart" , 600, 300, "chart-1", "json", $jsonEncodedData);
	
			

        	// Render the chart
        	$columnChart->render();

        	// Close the database connection
        	$dbhandle->close();

     	}

  	?>
  	<div id="chart-1"></div>
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
