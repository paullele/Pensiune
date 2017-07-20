<?php

include('ConnectionController.php');
$db = ConnectionController::getConnection();
$handler = new PaymentUpdateHandler($db);
$handler->paymentUpdateHandler();

class PaymentUpdateHandler {

    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function paymentUpdateHandler() {

        $name = $_POST['name'];
        $id = $_POST['id'];

        $sql = "UPDATE stay_status SET paid = '1' WHERE id = '$id'";
        mysqli_query($this->db, $sql);

        header("Location: http://localhost/Pensiune/payment.php?name=".$name);
        die();
    }
}
