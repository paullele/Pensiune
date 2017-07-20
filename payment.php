<!DOCTYPE HTML>
<html>
<head>
    <title>Payment</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../templated-snapshot/assets/css/main.css" />
</head>
<body>
<div class="page-wrap">
    <!-- Main -->
    <section id="main">

        <!-- Section -->
        <section>
            <div class="inner">

                <?php

                include('assets/php/ConnectionController.php');
                $db = ConnectionController::getConnection();

                $name = $_GET['name'];

                if($name) {

                    $sql_client = "SELECT id FROM clients WHERE  name = '$name'";
                    $client_results = mysqli_query($db, $sql_client);


                    if(mysqli_num_rows($client_results)) {

                        $client_row = mysqli_fetch_array($client_results);
                        $client_id = $client_row['id'];

                        $sql_status = "SELECT * FROM stay_status WHERE client = '$client_id'";
                        $status_results = mysqli_query($db, $sql_status);

                        $paid = null;

                        echo "<table>";

                        echo "<tr>
                                <th>Name</th>
                                <th>Room</th>
                                <th>Paid</th>
                                <th>Stay From</th>
                                <th>Stay Until</th>
                                <th>Payment</th>
                                </tr>";

                        while($status_row = mysqli_fetch_array($status_results)) {

                            if($status_row['paid']) {
                                $paid = "Yes";
                            } else {
                                $paid = "No";
                            }

                            echo "<tr>
                                    <td>".$name."</td>
                                    <td>".$status_row['room']."</td>
                                    <td>".$paid."</td>
                                    <td>".$status_row['stay_from']."</td>
                                    <td>".$status_row['stay_until']."</td>";

                            if(!$status_row['paid']) {
                                $id = $status_row['id'];
                                echo "<td><form action='assets/php/PaymentUpdateHandler.php' method='post'>
                                    <input type='hidden' name=id value='$id'>
                                    <input type='hidden' name=name value='$name'>
                                    <input type='submit' value='Pay'>
                                    </form></td>
                                    </tr>";
                            } else {
                                echo "<td></td>";
                            }
                        }

                        echo "</table>";

                    } else {
                        echo "Client not found";
                    }

                } else {
                    header("Location: http://localhost/Pensiune/admin.php");
                }

                ?>

            </div>

        </section>

    </section>
</div>

</body>
</html>


