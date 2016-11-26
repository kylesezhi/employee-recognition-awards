<!--Load the AJAX API-->
<script type="text/javascript" src="analytics/DataTableToCSV.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  // Load the Visualization API and the controls package.
  google.charts.load('current', {'packages':['corechart', 'controls']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawDashboard);

  // Callback that creates and populates a data table,
  // instantiates a dashboard, a range slider and a pie chart,
  // passes in the data and draws it.
  var csv = "";
  function drawDashboard() {

    // Prepare the data
    var jsonData = $.ajax({
        url: "analytics/getAwardsXUser.php",
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
      'containerId': 'filter_div4',
      'options': {
        'filterColumnLabel': 'State',
        'filterColumnIndex': 4,
            'ui': {
              'caption': 'Choose a state...',
              'allowTyping': false,
              'selectedValuesLayout': 'below',
              // 'cssClass': 'form-control',
            }
      }
    });

    var chart = new google.visualization.ChartWrapper({
      'chartType': 'ColumnChart',
      'containerId': 'chart_div',
      'options': {
        'legend': {'position': 'none'},
        'height': 400,
        'colors': ['#C02425'],
        'hAxis': {'textPosition': 'none'},
      },
      'view': {'columns': [2, 5]},
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
        'view': {'columns': [0, 1, 3, 4, 5]},
    });
    
    // create a list of columns for the dashboard
    var columns = [{
        // this column aggregates all of the data into one column
        // for use with the string filter
        type: 'string',
        calc: function (dt, row) {
            for (var i = 0, vals = [], cols = dt.getNumberOfColumns(); i < cols; i++) {
                vals.push(dt.getFormattedValue(row, i));
            }
            return vals.join('\n');
        }
    }];
    
    for (var i = 0, cols = data.getNumberOfColumns(); i < cols; i++) {
        columns.push(i);
    }
    
    // Define a string filter for all columns
    var searchFilter = new google.visualization.ControlWrapper({
        controlType: 'StringFilter',
        containerId: 'filter_div1',
        options: {
            filterColumnIndex: 0,
            matchType: 'any',
            caseSensitive: false,
            ui: {
                label: 'Search'
            }
        },
        view: {
            columns: columns
        }
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
    dashboard.bind([awardsRangeSlider, searchFilter, stateFilter], table);
    dashboard.bind([awardsRangeSlider, searchFilter, stateFilter], chart);

    // Draw the dashboard.
    dashboard.draw(data);
  }
</script>
