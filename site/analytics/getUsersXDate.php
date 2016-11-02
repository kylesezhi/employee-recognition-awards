<?php 

require_once("../dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$result = mysqli_query($mysqli, "SELECT AU.created, COUNT(AU.email) as 'Users' FROM award_user AU GROUP BY DATE(AU.created);");
$output = ["cols" => [
	["id" => "", "label" => "Date", "pattern" => "", "type" => "date"],
	["id" => "", "label" => "Users", "pattern" => "", "type" => "number"],
]];
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
	$item = array();
	 foreach ($r as $key => $value) {
		 if ($key === 'created') {
			 $dateparts = date_parse($value);
			 $date = date_create($value);
			 $m = intval($dateparts['month']) - 1; // january is 00
			 $month_str = sprintf("%02d", $m);
			 $item[] = ["v" => "Date($dateparts[year], $month_str, $dateparts[day])", "f" => date_format($date, 'F jS, Y')];
		 } else {
			 $item[] = ["v" => intval($value), "f" => null];
		 }
	 }
	 $rows[] = ["c" => $item ];
 }
$output["rows"] = $rows;
print json_encode($output);
$result->close();

?>
