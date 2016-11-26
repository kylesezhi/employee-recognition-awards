<!--Load the AJAX API-->
<script type="text/javascript" src="analytics/DataTableToCSV.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  // Load the Visualization API and the controls package.
  google.charts.load('current', {'packages':['geochart', 'controls']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawDashboard);

  // Callback that creates and populates a data table,
  // instantiates a dashboard, a range slider and a pie chart,
  // passes in the data and draws it.
  var csv = "";
  function drawDashboard() {

    // Prepare the data
    var jsonData = $.ajax({
        url: "analytics/getAwardsXRegion.php",
        dataType: "json",
        async: false
        }).responseText;
    
    var data = new google.visualization.DataTable(jsonData);
    csv = dataTableToCSV(data);

    // Create a dashboard.
    var dashboard = new google.visualization.Dashboard(
        document.getElementById('dashboard_div'));

    // Create a category filter, passing some options
    var stateFilter = new google.visualization.ControlWrapper({
      'controlType': 'CategoryFilter',
      'containerId': 'filter_div1',
      'options': {
        'filterColumnLabel': 'State',
        'filterColumnIndex': 0,
            'ui': {
              'caption': 'Choose a state ...',
              'allowTyping': false,
              'selectedValuesLayout': 'below',
              // 'cssClass': 'form-control',
            }
      }
    });

    // Create a pie chart, passing some options
    var chart = new google.visualization.ChartWrapper({
      'chartType': 'GeoChart',
      'containerId': 'chart_div',
      'options': {
        'region': 'US',
        'resolution': 'provinces',
        'height': 400,
        'colorAxis': {'colors': ['#F0CB35', '#C02425']},
      }
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
    });

    // Create a range slider, passing some options
    var awardsRangeSlider = new google.visualization.ControlWrapper({
      'controlType': 'NumberRangeFilter',
      'containerId': 'filter_div2',
      'options': {
        'filterColumnLabel': 'Awards',
        'ui': {
          format: { pattern: "###,###0" }
        },
      }
    });

    // Establish dependencies, declaring that 'filter' drives 'chart',
    // so that the pie chart will only display entries that are let through
    // given the chosen slider range.
    dashboard.bind([awardsRangeSlider, stateFilter], table);
    dashboard.bind([awardsRangeSlider, stateFilter], chart);

    // Draw the dashboard.
    dashboard.draw(data);
  }
</script>
