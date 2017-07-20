<?php

include("ConnectionController.php");

$db = ConnectionController::getConnection();
$handler = new StayRequestHandler($db);
$handler->stayRequestHandler();

class StayRequestHandler {

    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function stayRequestHandler() {

        //client
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];

        //stay
        $room = (int)$_POST['room'];
        $stay_from = $_POST['stay_from'];
        $stay_until = $_POST['stay_until'];

        $sql = "SELECT * FROM clients WHERE mail = '$mail'";
        $result = mysqli_query($this->db, $sql);

        if(mysqli_num_rows($result) == 0) {
            //add new client if does not exist
            if($name && $mail && $phone && $room && $stay_from && $stay_until) {
                $sql = "INSERT INTO clients (name, phone, mail) VALUES ('$name', '$phone', '$mail')";
                mysqli_query($this->db, $sql);

                //register stay time
                $sql = "SELECT id FROM CLIENTS WHERE mail = '$mail'";
                $result = mysqli_query($this->db, $sql);
                $client = mysqli_fetch_array($result);

                $this->roomAndStayHandler($client[0], $room, $stay_from, $stay_until);

            } else {
                header("Location: http://localhost/Pensiune/index.php?message=Please complete all necessary fields");
                die();
            }
        } else {
            //do not add new client if exists
            //register stay time
            $sql = "SELECT id FROM CLIENTS WHERE mail = '$mail'";
            $result = mysqli_query($this->db, $sql);
            $client = mysqli_fetch_array($result);

            $this->roomAndStayHandler($client[0], $room, $stay_from, $stay_until);
        }
    }

    private function roomAndStayHandler($client, $room, $stay_from, $stay_until) {

        $sql = "INSERT INTO stay_status (client, room, stay_from, stay_until) values ('$client', '$room',
                STR_TO_DATE('$stay_from', '%m/%d/%Y'), STR_TO_DATE('$stay_until', '%m/%d/%Y'))";
        mysqli_query($this->db, $sql);

        $sql = "UPDATE rooms SET vacant = '0' WHERE id = '$room'";
        mysqli_query($this->db, $sql);

        header("Location: http://localhost/Pensiune/index.php?message=Request sent successfully");
        die();
    }
}