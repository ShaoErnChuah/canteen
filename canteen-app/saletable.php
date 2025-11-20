<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sales</title>
   <link rel="stylesheet" href="stylesheet2.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body style="margin: 50px;">

    <h1>Sales Report</h1>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price(RM)</th>
                <th>Total(RM)</th>
                <th>User_ID</th>
            </tr>
        </thead>

        </tbody>

        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "cart_db";
    

            $connection = new mysqli($servername, $username, $password, $database);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql = "SELECT * FROM sales";
            $result = $connection->query($sql);

            if (!$result) {
                die("Invalid query: " . $connection->error);
            }

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["ID"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["quantity"] . "</td>
                <td>" . $row["price"] . "</td>
                <td>" . $row["total"] . "</td>
                <td>" . $row["username"] . "</td>
                </tr>";
            }

                ?>
        </tbody>
    </table>

    <p align="left"><a href="admin_dashboard.php" class="btn" >Back</a></p>
</body>
</html>
