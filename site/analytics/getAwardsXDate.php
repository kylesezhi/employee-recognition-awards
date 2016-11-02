<?php 

require_once("../dbconfig.php");

//Turn on error reporting
ini_set('display_errors', 'On');

//Connects to the database
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$result = mysqli_query($mysqli, "SELECT A.award_date, COUNT(A.class_id) as 'totalAwards' FROM award_user AU INNER JOIN award A ON A.user_id = AU.id GROUP BY A.award_date;");
$output = ["cols" => [
	["id" => "", "label" => "Date", "pattern" => "", "type" => "date"],
	["id" => "", "label" => "Awards", "pattern" => "", "type" => "number"],
]];
$rows = array();
while($r = mysqli_fetch_assoc($result)) {
	$item = array();
	 foreach ($r as $key => $value) {
		 if ($key === 'totalAwards') {
			$item[] = ["v" => intval($value), "f" => null];
		 } else {
			 $dateparts = explode("-", $value);
			 $date = date_create($value);
			 $m = intval($dateparts[1]) - 1; // january is 00
			 $month_str = sprintf("%02d", $m);
			 $item[] = ["v" => "Date($dateparts[0], $month_str, $dateparts[2])", "f" => date_format($date, 'F jS, Y')];
		 }
	 }
	 $rows[] = ["c" => $item ];
 }
$output["rows"] = $rows;
print json_encode($output);
$result->close();

?>
