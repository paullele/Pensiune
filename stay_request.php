
<!DOCTYPE html>

<html>
    <head>
        <title>Stay Form Request</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="assets/css/main.css"/>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="assets/js/script.js"></script>
    </head>

    <body>
        <div class="page-wrap">

            <nav id="nav">
                <ul>
                    <li><a href="index.php"><span class="icon fa-home"></span></a></li>
                    <li><a href="stay_request.php" class="active"><span class="icon fa-file-text-o"></span></a></li>
                </ul>
            </nav>

            <!-- Main -->
            <section id="main">

                <!-- Section -->
                <section>
                    <div class="inner">

                        <h2>Rooms availability</h2>

                        <?php
                        include('assets/php/ConnectionController.php');
                        $db = ConnectionController::getConnection();

                       // get all rooms
                        $sql_rooms = "SELECT * FROM rooms";
                        $result = mysqli_query($db, $sql_rooms);

                        echo "<table>";

                        echo "<tr>
                                <th>Room</th>
                                <th>Availability</th>
                                </tr>";

                        while($row = mysqli_fetch_array($result)) {
                            if($row['vacant'] == 1) {
                                echo "<tr>
                                    <td>Room ".$row['id']."</td>
                                    <td>is available now</td>
                                    </tr>";
                            } else {

                                $room = $row['id'];

                                $sql_room = "SELECT * from stay_status WHERE room = '$room'
                                ORDER BY stay_status.stay_until ASC";
                                $room_results = mysqli_query($db, $sql_room);

                                $intervals = array();

                                class IntervalStructure {
                                    public $stay_from = null;
                                    public $stay_until = null;
                                }

                                while($room_row = mysqli_fetch_array($room_results)) {
                                    $interval = new IntervalStructure();
                                    $interval->stay_from = $room_row['stay_from'];
                                    $interval->stay_until = $room_row['stay_until'];
                                    array_push($intervals, $interval);
                                }

                                //every time the stay request is accessed,
                                //if current date is higher than highest booked date,
                                //the vacancy is updated, hence the room is not booked
                                if(date('m-d-Y') > end($intervals) -> stay_until) {
                                    echo "<tr>
                                    <td>Room ".$row['id']."</td>
                                    <td>is available now</td>
                                    </tr>";
                                    $sql = "UPDATE rooms SET vacant = '1' WHERE id = '$room'";
                                    mysqli_query($db, $sql);
                                } else {
                                    $entries = count($intervals);

                                    for($index = 0; $index < $entries - 1; $index++) {
                                        echo "<tr>
                                            <td>Room ".$row['id']."</td>
                                            <td>is available between ".$intervals[$index] -> stay_until
                                            ." and ".$intervals[$index+1] -> stay_from."</td>
                                            </tr>";
                                    }

                                    echo "<tr>
                                            <td>Room ".$row['id']."</td>
                                            <td>will be fully available starting ".end($intervals) -> stay_until."</td>
                                            </tr>";
                                }
                            }
                        }

                        echo "</table>";

                        ?>

                        <h2>Stay request</h2>

                        <form method="post" action="assets/php/StayRequestHandler.php">

                            <label for="name">Full Name</label>
                            <input name="name" id="name" type="text" placeholder="Full Name"><br>

                            <label for="phone">Phone</label>
                            <input name="phone" id="phone" type="text" placeholder="Phone"><br>

                            <label for="mail">Mail</label>
                            <input name="mail" id="mail" type="text" placeholder="Mail"><br>

                            <label for="room">Select room</label>
                            <input name="room" type="radio" value="1">Room 1<br>
                            <input name="room" type="radio" value="2">Room 2<br>
                            <input name="room" type="radio" value="3">Room 3<br>
                            <input name="room" type="radio" value="4">Room 4<br><br>

                            <label for="stay_from">Stay From</label>
                            <input name="stay_from" id="stay_from" type="date"><br><br>

                            <label for="stay_until">Stay Until</label>
                            <input name="stay_until" id="stay_until" type="date"><br><br>

                            <div>
                                <input type="submit" name="submit" value="Submit Request">
                            </div>
                        </form>
                    </div>

                </section>

                </section>

            </section>

        </div>

        <script src="assets/js/script.js"></script>
    </body>
</html>