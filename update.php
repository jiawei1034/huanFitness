<?php
$detailsID= isset($_POST["detailsID"])?$_POST["detailsID"]:"";

$routine=empty($_POST["routine"])?"":$_POST["routine"];
$rdate=empty($_POST["rdate"])?"":$_POST["rdate"];
$stime=empty($_POST["stime"])?"":$_POST["stime"];
$duration=empty($_POST["duration"])?"":$_POST["duration"];
$sets=empty($_POST["sets"])?"":$_POST["sets"];

if(isset($_POST["level"]))
	$level=$_POST["level"];
else
	$level="";

$weight=empty($_POST["weight"])?"":$_POST["weight"];
$watercon=empty($_POST["watercon"])?"":$_POST["watercon"];

$record = date_create($rdate);
$date = date_format($record,"Y-m-d"); 

require 'connect.php';

$sql = "UPDATE details SET 
    routine=?, 
    rdate=?, 
    stime=?, 
    duration=?, 
    sets=?, 
    level=?, 
    weight=?, 
    watercon=? 
WHERE detailsID=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssssiii',$routine, $date, $stime, $duration, $sets, $level, $weight, $watercon, $detailsID);

if ($stmt->execute()) {
  header("Location: home.php");
  exit;
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>