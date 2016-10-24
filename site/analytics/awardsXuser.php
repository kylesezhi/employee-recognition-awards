<?php
function makeChart($first, $second, $mysqli) {
  $data = [];
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

    var data = google.visualization.arrayToDataTable([
      ['<?php echo $first ?>', '<?php echo $second ?>', { role: 'style' } ],
      <?php
      if(!($stmt = $mysqli->prepare("SELECT AU.first_name, AU.last_name, AU.email, COUNT(A.class_id) AS 'totalAwards' FROM award_user AU LEFT JOIN award A ON A.user_id = AU.id INNER JOIN act_type ACT ON ACT.id = AU.act_id GROUP BY AU.email ORDER BY AU.id LIMIT 15;"))){
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
      }
      if(!$stmt->execute()){
        echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }
      if(!$stmt->bind_result($first_name, $last_name, $email, $awards)){
        echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }
      while($stmt->fetch()){
        echo "['" . $first_name . " " . $last_name . "', " . $awards . ", 'color: #C02425'],";
      }
      $stmt->close();
      ?>
      // 
      // ['Los Angeles, CA', 3792000, 'color: #C02425'],
      // ['Chicago, IL', 2695000, 'color: #C02425'],
      // ['Houston, TX', 2099000, 'color: #C02425'],
      // ['Philadelphia, PA', 1526000, 'color: #C02425']
    ]);

    var options = {
      legend: { position: 'none' },
      hAxis: {
        title: '<?php echo $first ?>',
        minValue: 0
      },
      vAxis: {
        title: '<?php echo $second ?>'
      },
    };

    var chart = new google.visualization.BarChart(document.getElementById('container_div'));

    chart.draw(data, options);
  }
  
  var chart = new google.visualization.BarChart(container);
  </script>
<?php
}
?>
