<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['table']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawTable);
      
    function drawTable() {
      var jsonData = $.ajax({
          url: "getUsers.php",
          dataType: "json",
          async: false
          }).responseText;
          
      var options = {
        width: '100%', 
        page: 'enable',
        pageSize: 20,
        allowHtml: true,
      };
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var table = new google.visualization.Table(document.getElementById('chart_div'));

      table.draw(data, options);
    }

    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>
