<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="stylesheet2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
  </head>
  <body>
    <canvas id="myChart"></canvas>
    <script>
      <?php
     
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "cart_db";

        $connection = new mysqli($servername, $username, $password, $database);

        if ($connection->connect_error) {
          die("Connection failed: " . $connection->connect_error);
        }
        
        $sql = "SELECT name, sum(quantity) as total_qty FROM sales GROUP BY name ORDER BY quantity DESC LIMIT 5";
        $result = $connection->query($sql);

        if (!$result) {
          die("Invalid query: " . $connection->error);
        }
        
        $productname = array();
        $total_qty = array();
        while($row = $result->fetch_assoc()) {
          array_push($productname, $row["name"]);
          array_push($total_qty, $row["total_qty"]);
        }
      ?>
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($productname); ?>,
          datasets: [{
            label: 'Top 5 Highest Selling Products in the past month',
            data: <?php echo json_encode($total_qty); ?>,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });


     






      
    </script>
     <p align="left"><a href="admin_dashboard.php" class="btn" >Back</a></p>
  </body>
</html>