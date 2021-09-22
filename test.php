<?php
$servername = "10.140.5.210";
$username = "root";
$password = "r00tme";


$conn = new mysqli($servername, $username, $password);

if ($conn->connect_errno) {
  die("Connection failed: ");
}
//$sql="select * from fxo where last_changed=1 order by fxo_line";
$sql="select * from fxo where last_changed=1 and patton in(1,2) order by fxo_line";

$result=$conn->query($sql);


    $res=[];
$result = $conn->query($sql);


    // output data of each row
    while($row =$result->fetch_assoc()) {
      $res[]=$row;
    }
    echo json_encode($res);
 

?>







