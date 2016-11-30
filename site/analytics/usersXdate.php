<!--Load the AJAX API-->
<script type="text/javascript" src="analytics/DataTableToCSV.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  // Load the Visualization API and the controls package.
  google.charts.load('current', {'packages':['corechart', 'calendar', 'controls']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawDashboard);

  // Callback that creates and populates a data table,
  // instantiates a dashboard, a range slider and a pie chart,
  // passes in the data and draws it.
  var csv = "";
  function drawDashboard() {

    // Prepare the data
    var jsonData = $.ajax({
        url: "analytics/getUsersXDate.php",
        dataType: "json",
        async: false
        }).responseText;
    
    var data = new google.visualization.DataTable(jsonData);
    csv = dataTableToCSV(data);

    // Create a dashboard.
    var dashboard = new google.visualization.Dashboard(
        document.getElementById('dashboard_div'));


    var chart = new google.visualization.ChartWrapper({
      'chartType': 'Calendar',
      'containerId': 'chart_div',
      'options': {
        'legend': {'position': 'none'},
        'height': 400,
        // noDataPattern: {
        //    backgroundColor: '#C02425',
        //    color: '#F0CB35'
        //  }
      },
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
    var usersRangeSlider = new google.visualization.ControlWrapper({
      'controlType': 'NumberRangeFilter',
      'containerId': 'filter_div3',
      'options': {
        'filterColumnLabel': 'Users',
        'ui': {
          format: { pattern: "###,###0" }
        },
      }
    });
    
    var dateRangeSlider = new google.visualization.ControlWrapper({
      'controlType': 'DateRangeFilter',
      'containerId': 'filter_div1',
      'options': {
        filterColumnLabel: 'Date',
        'ui': {
          format: { pattern: "MMM d, yyyyy" }
        }
      }
    });

    // Establish dependencies, declaring that 'filter' drives 'chart',
    // so that the pie chart will only display entries that are let through
    // given the chosen slider range.
    dashboard.bind([dateRangeSlider, usersRangeSlider], table);
    dashboard.bind([dateRangeSlider, usersRangeSlider], chart);

    // Draw the dashboard.
    dashboard.draw(data);
  }
</script>
