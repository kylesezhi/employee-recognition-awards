<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  // Load the Visualization API and the controls package.
  google.charts.load('current', {'packages':['corechart', 'controls']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawDashboard);

  // Callback that creates and populates a data table,
  // instantiates a dashboard, a range slider and a pie chart,
  // passes in the data and draws it.
  function drawDashboard() {

    // Prepare the data
    var jsonData = $.ajax({
        url: "analytics/getAwardsXDate.php",
        dataType: "json",
        async: false
        }).responseText;
    
    var data = new google.visualization.DataTable(jsonData);

    // Create a dashboard.
    var dashboard = new google.visualization.Dashboard(
        document.getElementById('dashboard_div'));


    var chart = new google.visualization.ChartWrapper({
      'chartType': 'LineChart',
      'containerId': 'chart_div',
      'options': {
        'legend': {'position': 'none'},
        'height': 400,
      },
      // 'view': {'columns': [2, 4]}, // TODO
    });
    
    // Options for table
    var options = {
      width: '100%', 
      page: 'enable',
      pageSize: 5,
      allowHtml: true,
    };
    
    var table = new google.visualization.ChartWrapper({
        chartType: 'Table',
        containerId: 'table_div',
        options,
        // 'view': {'columns': [0, 1, 3, 4]},
    });

    // Create a range slider, passing some options
    var awardsRangeSlider = new google.visualization.ControlWrapper({
      'controlType': 'NumberRangeFilter',
      'containerId': 'filter_div3',
      'options': {
        'filterColumnLabel': 'Awards'
      }
    });
    
    var dateRangeSlider = new google.visualization.ControlWrapper({
      'controlType': 'DateRangeFilter',
      'containerId': 'filter_div1',
      'options': {
        filterColumnLabel: 'Date',
        ui: {
            format: 'F Y', // TODO
        }
      }
    });

    // Establish dependencies, declaring that 'filter' drives 'chart',
    // so that the pie chart will only display entries that are let through
    // given the chosen slider range.
    dashboard.bind([awardsRangeSlider, dateRangeSlider], table);
    dashboard.bind([awardsRangeSlider, dateRangeSlider], chart);

    // Draw the dashboard.
    dashboard.draw(data);
  }
</script>
