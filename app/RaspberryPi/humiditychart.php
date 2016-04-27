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

<html>
   <head>
  	<title>DHT22 - Area Humidity Chart - Data from a database</title>
	  <link  rel="stylesheet" type="text/css" href="css/style.css" />

	<!--  Include the `fusioncharts.js` file. This file is needed to render the chart. Ensure that the path to this JS file is correct. Otherwise, it may lead to JavaScript errors. -->

      <script src="js/fusioncharts.js"></script>
   </head>
   <body>
  	<?php

     	// Form the SQL query that returns the top 10 most populous countries
     	//$strQuery = "SELECT * FROM DHT22";
        $strQuery = "SELECT * FROM Humidity WHERE Timestamp > DATE_SUB(NOW(), INTERVAL 72 HOUR) AND Timestamp <= NOW()";

     	// Execute the query, or else return the error message.
     	$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

     	// If the query returns a valid response, prepare the JSON string
     	if ($result) {
        	// The `$arrData` array holds the chart attributes and data
        	$arrData = array(
        	    "chart" => array(
                  "caption" => "Humidity readings for the last 48 hours",
		  "xaxisname" => "Timestamp",
		  "yaxisname" => "Humidity(%)",
                  "paletteColors" => "#0075c2",
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
                "value" => $row["HUMIDITY"]
              	)
           	);
        	}
		
		//echo "array created";

        	/*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

        $jsonEncodedData = json_encode($arrData);



		//echo $jsonEncodedData;

        	/*Create an object for the column chart. Initialize this object using the FusionCharts PHP class constructor. The constructor is used to initialize the chart type, chart id, width, height, the div id of the chart container, the data format, and the data source. */
	
        $columnChart = new FusionCharts("area2d", "myFirstChart" , 600, 300, "chart-1", "json", $jsonEncodedData);
	
			

        	// Render the chart
        	$columnChart->render();

        	// Close the database connection
        	$dbhandle->close();

     	}

  	?>
  	<div id="chart-1"><!-- Fusion Charts will render here--></div>
   </body>
</html>