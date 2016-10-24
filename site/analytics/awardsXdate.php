<?php
function makeChart($first, $second, $mysqli) {
  $data = [];
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', '<?php echo $second ?>');
      data.addColumn('number', '<?php echo $first ?>');

      data.addRows([
        <?php
        if(!($stmt = $mysqli->prepare("SELECT A.award_date, COUNT(A.class_id) as 'totalAwards' FROM award_user AU INNER JOIN award A ON A.user_id = AU.id GROUP BY A.award_date LIMIT 15;"))){
          echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
        }
        if(!$stmt->execute()){
          echo "Execute failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        if(!$stmt->bind_result($date, $awards)){
          echo "Bind failed: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
        }
        while($stmt->fetch()){
          $dateParts = explode("-", $date);
          echo "[new Date(" . $dateParts[0] . ", " . $dateParts[1] . ", " . $dateParts[2] . "), " . $awards . "],";
        }
        $stmt->close();
        ?>

        // [new Date(1980,2,19), 1],
        // [new Date(1980,2,20), 2],
      ]);

      var options = {
      legend: { position: 'none' },
      hAxis: {
        title: 'Date',
      },
      vAxis: {
        title: 'Awards',
      },
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('container_div'));

      chart.draw(data, options);
    }
  
  var chart = new google.visualization.BarChart(container);
  </script>
<?php
}
?>
