<?php

include("ConnectionController.php");

$db = ConnectionController::getConnection();
$handler = new MailHandler($db);
$handler->mailHandler();

class MailHandler {

    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function mailHandler() {

        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $message = $_POST['message'];

        if($name && $mail && $message) {
            $sql = "INSERT INTO mails (name, mail, message) VALUES ('$name', '$mail', '$message')";
            mysqli_query($this->db, $sql);

            header("Location: http://localhost/Pensiune/index.php?message=Email sent successfully");
            die();
        } else {
            header("Location: http://localhost/Pensiune/index.php?message=Please complete all necessary fields");
            die();
        }

    }

} 