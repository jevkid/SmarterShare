<?php

header('Content-Type: application/javascript');

$con = mysqli_connect("localhost","testuser","test","testdb");

// Check connection
if (mysqli_connect_errno($con))
{
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
}else
{
    $data_points = array();
    
    $result = mysqli_query($con, "SELECT Timestamp,MQ135 FROM MCP3008 ORDER BY TIMESTAMP DESC LIMIT 1");
    
    while($row = mysqli_fetch_array($result))
    {        
        $point = array("Timestamp" => $row['Timestamp'] , "mq135" => (float) $row['MQ135']);
        
        array_push($data_points, $point);        
    }
    
    echo json_encode($data_points, JSON_NUMERIC_CHECK);
}
mysqli_close($con);

?>