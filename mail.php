
<!DOCTYPE html>

<html>
<head>
    <title>Emails</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
</head>

<body>
<div class="page-wrap">

    <nav id="nav">
        <ul>
            <li><a href="admin.php" ><span class="icon fa-home"></span></a></li>
            <li><a href="mail.php" class="active"><span class="fa fa-envelope"></span></a></li>
        </ul>
    </nav>

    <!-- Main -->
    <section id="main">

        <!-- Section -->
        <section>
            <div class="inner">

                <?php

                if(!empty($_GET['message'])) {
                    $message = $_GET['message'];

                    echo $message;
                }

                ?>

                <p>Your Emails</p>
                <br>

                <?php

                include('assets/php/ConnectionController.php');
                $db = ConnectionController::getConnection();

                $sql = "SELECT * FROM mails";
                $result = mysqli_query($db, $sql);
                while($row = mysqli_fetch_array($result)) {
                    echo "<p>From: ".$row['name']."<br>Address: ".$row['mail']."</p>";
                    echo "<p>Message: <br>".$row['message']."</p>";
                }

                ?>

            </div>
        </section>
    </section>

</div>

</body>
</html>