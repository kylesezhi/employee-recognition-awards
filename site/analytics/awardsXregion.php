<?php
function makeChart($first, $second, $mysqli) {
  $data = [];
  $data['Alabama'] = 0;
  $data['Alaska'] = 0;
  $data['Arizona'] = 0;
  $data['Arkansas'] = 0;
  $data['California'] = 0;
  $data['Colorado'] = 0;
  $data['Connecticut'] = 0;
  $data['Delaware'] = 0;
  $data['Florida'] = 0;
  $data['Georgia'] = 0;
  $data['Hawaii'] = 0;
  $data['Idaho'] = 0;
  $data['Illinois'] = 0;
  $data['Indiana'] = 0;
  $data['Iowa'] = 0;
  $data['Kansas'] = 0;
  $data['Kentucky'] = 0;
  $data['Louisiana'] = 0;
  $data['Maine'] = 0;
  $data['Maryland'] = 0;
  $data['Massachusetts'] = 0;
  $data['Michigan'] = 0;
  $data['Minnesota'] = 0;
  $data['Mississippi'] = 0;
  $data['Missouri'] = 0;
  $data['Montana'] = 0;
  $data['Nebraska'] = 0;
  $data['Nevada'] = 0;
  $data['New Hampshire'] = 0;
  $data['New Jersey'] = 0;
  $data['New Mexico'] = 0;
  $data['New York'] = 0;
  $data['North Carolina'] = 0;
  $data['North Dakota'] = 0;
  $data['Ohio'] = 0;
  $data['Oklahoma'] = 0;
  $data['Oregon'] = 0;
  $data['Pennsylvania'] = 0;
  $data['Rhode Island'] = 0;
  $data['South Carolina'] = 0;
  $data['South Dakota'] = 0;
  $data['Tennessee'] = 0;
  $data['Texas'] = 0;
  $data['Utah'] = 0;
  $data['Vermont'] = 0;
  $data['Virginia'] = 0;
  $data['Washington'] = 0;
  $data['West Virginia'] = 0;
  $data['Wisconsin'] = 0;
  $data['Wyoming'] = 0;
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('upcoming', {'packages': ['geochart']});
  google.charts.setOnLoadCallback(drawUSMap);
  
  function drawUSMap() {

    var data = google.visualization.arrayToDataTable([
      ['State','Awards'],
      <?php
      if(!($stmt = $mysqli->prepare("SELECT AU.state, COUNT(CL.id) AS 'AwardCount' FROM award_user AU INNER JOIN award A ON A.user_id = AU.id INNER JOIN class CL ON CL.id = A.class_id GROUP BY AU.state ORDER BY AU.state;"))){
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
      }
      if(!$stmt->execute()){
        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }
      if(!$stmt->bind_result($state, $awards)){
        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }
      while($stmt->fetch()){
        $data[$state] = $awards;
      }
      $stmt->close();
      foreach($data as $key => $value) {
        echo "['" . $key . "', " . $value . "],";
      }
      ?>
    ]);

    var options = {
      region: "US", 
      resolution: "provinces",
      colorAxis: {colors: ['#F0CB35', '#C02425']},
    };

    var chart = new google.visualization.GeoChart(document.getElementById('container_div'));
    chart.draw(data, options);
  }
  
  var chart = new google.visualization.GeoChart(container);
</script>
<?php
}
?>
