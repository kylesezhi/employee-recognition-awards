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
      ['New York City, NY', 8175000, 'color: #C02425'],
      ['Los Angeles, CA', 3792000, 'color: #C02425'],
      ['Chicago, IL', 2695000, 'color: #C02425'],
      ['Houston, TX', 2099000, 'color: #C02425'],
      ['Philadelphia, PA', 1526000, 'color: #C02425']
    ]);

    var options = {
      legend: { position: 'none' },
      hAxis: {
        title: '<?php echo $second ?>',
        minValue: 0
      },
      vAxis: {
        title: '<?php echo $first ?>'
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
